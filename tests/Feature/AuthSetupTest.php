<?php

namespace Tests\Feature;

use App\Models\User;
use App\Notifications\VerifyPendingEmail;
use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Password;
use Tests\TestCase;

class AuthSetupTest extends TestCase
{
    use RefreshDatabase;

    public function test_spa_pages_and_fallback_are_served(): void
    {
        $this->get('/')->assertOk();
        $this->get('/dashboard')->assertOk();
        $this->get('/settings')->assertOk();
        $this->get('/settings/profile')->assertOk();
        $this->get('/settings/security')->assertOk();
        $this->get('/forgot-password')->assertOk();
        $this->get('/reset-password/example-token')->assertOk();
        $this->get('/unknown-front-end-page')->assertOk();
    }

    public function test_reserved_routes_are_not_stolen_by_spa_fallback(): void
    {
        $this->get('/api/not-real')->assertNotFound();
        $this->get('/admin/not-real')->assertNotFound();
        $this->get('/sanctum/csrf-cookie')->assertNoContent();
    }

    public function test_user_can_register_and_fetch_current_user(): void
    {
        $this->withHeader('Origin', 'http://localhost:8000')->postJson('/api/register', [
            'name' => 'Example User',
            'email' => ' User@Example.COM ',
            'password' => 'password',
            'password_confirmation' => 'password',
        ])
            ->assertCreated()
            ->assertJsonPath('user.email', 'user@example.com')
            ->assertJsonMissingPath('user.password')
            ->assertJsonMissingPath('user.remember_token')
            ->assertJsonMissingPath('user.pending_email_token')
            ->assertJsonStructure([
                'user' => ['id', 'name', 'email', 'is_admin', 'created_at'],
            ]);

        $this->assertDatabaseHas('users', [
            'email' => 'user@example.com',
        ]);

        $this->withHeader('Origin', 'http://localhost:8000')->getJson('/api/user')
            ->assertOk()
            ->assertJsonPath('user.email', 'user@example.com')
            ->assertJsonMissingPath('user.password')
            ->assertJsonMissingPath('user.remember_token')
            ->assertJsonMissingPath('user.pending_email_token');
    }

    public function test_user_can_login_and_logout(): void
    {
        User::factory()->create([
            'email' => 'user@example.com',
            'password' => bcrypt('new-password'),
        ]);

        $this->withHeader('Origin', 'http://localhost:8000')->postJson('/api/login', [
            'email' => ' USER@Example.COM ',
            'password' => 'new-password',
            'remember' => true,
        ])
            ->assertOk()
            ->assertJsonPath('user.email', 'user@example.com');

        $this->assertAuthenticated();
        $this->withHeader('Origin', 'http://localhost:8000')->postJson('/api/logout')->assertOk();
        $this->assertGuest();
    }

    public function test_user_can_request_and_complete_password_reset(): void
    {
        Notification::fake();

        $user = User::factory()->create([
            'email' => 'user@example.com',
            'password' => bcrypt('old-password'),
        ]);

        $this->withHeader('Origin', 'http://localhost:8000')->postJson('/api/forgot-password', [
            'email' => 'user@example.com',
        ])->assertOk();

        Notification::assertSentTo($user, ResetPassword::class);

        $token = Password::broker()->createToken($user);

        $this->withHeader('Origin', 'http://localhost:8000')->postJson('/api/reset-password', [
            'token' => $token,
            'email' => 'user@example.com',
            'password' => 'new-password',
            'password_confirmation' => 'new-password',
        ])->assertOk();

        $this->assertTrue(Hash::check('new-password', $user->fresh()->password));
    }

    public function test_authenticated_user_can_update_profile_name(): void
    {
        $user = User::factory()->create([
            'email' => 'user@example.com',
            'password' => bcrypt('old-password'),
        ]);

        $this->actingAs($user)
            ->withHeader('Origin', 'http://localhost:8000')
            ->patchJson('/api/user/profile', [
                'name' => 'Updated User',
            ])
            ->assertOk()
            ->assertJsonPath('user.name', 'Updated User');

        $this->assertSame('user@example.com', $user->fresh()->email);
    }

    public function test_profile_name_rejects_html_like_or_control_characters(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user)
            ->withHeader('Origin', 'http://localhost:8000')
            ->patchJson('/api/user/profile', [
                'name' => '<script>',
            ])
            ->assertUnprocessable()
            ->assertJsonValidationErrors('name');
    }

    public function test_email_update_requires_current_password(): void
    {
        $user = User::factory()->create([
            'email' => 'user@example.com',
            'password' => bcrypt('old-password'),
        ]);

        $this->actingAs($user)
            ->withHeader('Origin', 'http://localhost:8000')
            ->patchJson('/api/user/email', [
                'email' => 'updated@example.com',
            ])
            ->assertUnprocessable()
            ->assertJsonValidationErrors('current_password');

        $this->actingAs($user)
            ->withHeader('Origin', 'http://localhost:8000')
            ->patchJson('/api/user/email', [
                'email' => 'updated@example.com',
                'current_password' => 'wrong-password',
            ])
            ->assertUnprocessable()
            ->assertJsonValidationErrors('current_password');
    }

    public function test_authenticated_user_can_request_email_change_with_current_password(): void
    {
        Notification::fake();

        $user = User::factory()->create([
            'email' => 'user@example.com',
            'email_verified_at' => now(),
            'password' => bcrypt('old-password'),
            'remember_token' => 'old-token',
        ]);

        $this->actingAs($user)
            ->withHeader('Origin', 'http://localhost:8000')
            ->patchJson('/api/user/email', [
                'email' => ' Updated@Example.COM ',
                'current_password' => 'old-password',
            ])
            ->assertOk()
            ->assertJsonPath('user.email', 'user@example.com')
            ->assertJsonPath('user.pending_email', 'updated@example.com');

        $user->refresh();

        $this->assertSame('user@example.com', $user->email);
        $this->assertSame('updated@example.com', $user->pending_email);
        $this->assertNotNull($user->email_verified_at);
        $this->assertNotSame('old-token', $user->remember_token);

        Notification::assertSentOnDemand(VerifyPendingEmail::class);
    }

    public function test_email_update_to_current_email_does_not_send_verification(): void
    {
        Notification::fake();

        $user = User::factory()->create([
            'email' => 'user@example.com',
            'password' => bcrypt('old-password'),
        ]);

        $this->actingAs($user)
            ->withHeader('Origin', 'http://localhost:8000')
            ->patchJson('/api/user/email', [
                'email' => ' USER@example.com ',
                'current_password' => 'old-password',
            ])
            ->assertOk()
            ->assertJsonPath('message', 'Email address unchanged.')
            ->assertJsonPath('user.pending_email', null);

        Notification::assertNothingSent();
    }

    public function test_pending_email_verification_applies_new_email(): void
    {
        Notification::fake();

        $user = User::factory()->create([
            'email' => 'user@example.com',
            'email_verified_at' => now(),
            'password' => bcrypt('old-password'),
        ]);

        $verificationUrl = null;

        $this->actingAs($user)
            ->withHeader('Origin', 'http://localhost:8000')
            ->patchJson('/api/user/email', [
                'email' => 'updated@example.com',
                'current_password' => 'old-password',
            ])
            ->assertOk();

        Notification::assertSentOnDemand(VerifyPendingEmail::class, function (VerifyPendingEmail $notification) use (&$verificationUrl) {
            $verificationUrl = $notification->verificationUrl();

            return true;
        });

        $this->get($verificationUrl)
            ->assertRedirect('/settings/security?email=verified');

        $user->refresh();

        $this->assertSame('updated@example.com', $user->email);
        $this->assertNotNull($user->email_verified_at);
        $this->assertNull($user->pending_email);
        $this->assertNull($user->pending_email_token);
    }

    public function test_authenticated_user_can_update_password_and_rotate_remember_token(): void
    {
        $user = User::factory()->create([
            'email' => 'user@example.com',
            'password' => bcrypt('old-password'),
            'remember_token' => 'old-token',
        ]);

        $this->actingAs($user)
            ->withHeader('Origin', 'http://localhost:8000')
            ->putJson('/api/user/password', [
                'current_password' => 'old-password',
                'password' => 'new-password',
                'password_confirmation' => 'new-password',
            ])
            ->assertOk();

        $user->refresh();

        $this->assertTrue(Hash::check('new-password', $user->password));
        $this->assertNotSame('old-token', $user->remember_token);
    }

    public function test_password_update_requires_current_password(): void
    {
        $user = User::factory()->create([
            'password' => bcrypt('old-password'),
        ]);

        $this->actingAs($user)
            ->withHeader('Origin', 'http://localhost:8000')
            ->putJson('/api/user/password', [
                'current_password' => 'wrong-password',
                'password' => 'new-password',
                'password_confirmation' => 'new-password',
            ])
            ->assertUnprocessable()
            ->assertJsonValidationErrors('current_password');
    }

    public function test_login_is_rate_limited(): void
    {
        for ($i = 0; $i < 5; $i++) {
            $this->withHeader('Origin', 'http://localhost:8000')->postJson('/api/login', [
                'email' => 'missing@example.com',
                'password' => 'wrong-password',
            ])->assertUnprocessable();
        }

        $this->withHeader('Origin', 'http://localhost:8000')->postJson('/api/login', [
            'email' => 'missing@example.com',
            'password' => 'wrong-password',
        ])->assertTooManyRequests();
    }
}
