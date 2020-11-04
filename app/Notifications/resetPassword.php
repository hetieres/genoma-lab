<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class resetPassword extends Notification
{
    use Queueable;

    public $username;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($token, $username)
    {
        $this->token    = $token;
        $this->username = $username;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable) {
        if (null===env("MAIL_STATUS") || (null!==env("MAIL_STATUS") && env('MAIL_STATUS')===true)) {
            return (new MailMessage)
                        ->subject('Redefinir Senha')
                        ->greeting('Olá ' . $this->username . ',')
                        ->line('Você está recebendo este e-mail porque nós recebemos uma requisição para sua conta!')
                        ->line('Alguém solicitou um link para alterar a senha da sua conta, você pode fazer isso através do botão abaixo.')
                        ->action('Redefinir Senha', route('password.reset', $this->token))
                        ->line('Se você não realizou essa solicitação, por favor ignore este e-mail. Sua senha não será alterada até que você acesse o link acima e crie um novo.')
                        ->markdown('emails.password');
        }

        return false;
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
