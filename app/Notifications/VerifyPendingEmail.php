<?php

namespace App\Notifications;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\URL;

class VerifyPendingEmail extends Notification
{
    use Queueable;

    public function __construct(
        private readonly User $user,
        private readonly string $token,
    ) {}

    /**
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('Verify your new email address')
            ->line('Confirm this email address to finish changing the email on your account.')
            ->action('Verify email address', $this->verificationUrl())
            ->line('If you did not request this change, you can ignore this message.');
    }

    public function verificationUrl(): string
    {
        return URL::temporarySignedRoute(
            'email-change.verify',
            now()->addMinutes(60),
            [
                'user' => $this->user->id,
                'token' => $this->token,
            ],
        );
    }
}
