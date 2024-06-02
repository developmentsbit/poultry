<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class WelcomeEmail extends Notification
{
    use Queueable;

    private string $subject;
    private string $description;
    private string $action_text;
    private string $action_url;
    private string $thank_message;

    public $data;

    /**
     * Create a new notification instance.
     */
    public function __construct($data)
    {
        $this->data = $data;

        $this->subject = "Welcome";
        $this->description = "Please use Username:";
        $this->action_text = "Login";
        $this->action_url = route('login');
        $this->thank_message = 'Thank you for using our application!';
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject($this->subject)
            ->line($this->description)
            ->action($this->action_text, $this->action_url)
            ->line($this->thank_message)
            ->view('welcome_mail', ['user' => $notifiable, 'data' => $this->data]);
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }
}
