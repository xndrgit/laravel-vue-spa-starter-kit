<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminSetupTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_dashboard_requires_login(): void
    {
        $this->get('/admin/dashboard')
            ->assertRedirect('/admin/login');
    }

    public function test_normal_user_is_denied_admin_dashboard(): void
    {
        $user = User::factory()->create(['is_admin' => false]);

        $this->actingAs($user)
            ->get('/admin/dashboard')
            ->assertForbidden();
    }

    public function test_admin_can_login_and_logout(): void
    {
        User::factory()->create([
            'email' => 'admin@example.com',
            'password' => bcrypt('password'),
            'is_admin' => true,
        ]);

        $this->post('/admin/login', [
            'email' => 'admin@example.com',
            'password' => 'password',
            'remember' => '1',
        ])->assertRedirect('/admin/dashboard');

        $this->get('/admin/dashboard')->assertOk();
        $this->get('/admin/users')->assertOk();
        $this->get('/admin/settings')->assertOk();
        $this->get('/admin/system')->assertOk();

        $this->post('/admin/logout')
            ->assertRedirect('/admin/login');

        $this->get('/admin/dashboard')
            ->assertRedirect('/admin/login');
    }

    public function test_non_admin_login_to_admin_is_rejected_and_logged_out(): void
    {
        User::factory()->create([
            'email' => 'normal@example.com',
            'password' => bcrypt('password'),
            'is_admin' => false,
        ]);

        $this->post('/admin/login', [
            'email' => 'normal@example.com',
            'password' => 'password',
        ])->assertForbidden();

        $this->assertGuest();
    }

    public function test_admin_pages_require_admin_access(): void
    {
        $user = User::factory()->create(['is_admin' => false]);

        foreach (['/admin/users', '/admin/settings', '/admin/system'] as $path) {
            $this->actingAs($user)->get($path)->assertForbidden();
        }
    }
}
