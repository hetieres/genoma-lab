<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class createPassword extends Notification
{
    use Queueable;

    public $username;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($token, $username, $email)
    {
        $this->token    = $token;
        $this->username = $username;
        $this->email    = $email;
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
    public function toMail($notifiable)
    {
        if (null===env("MAIL_STATUS") || (null!==env("MAIL_STATUS") && env('MAIL_STATUS')===true)) {
            return (new MailMessage)
                        ->subject('Definir Senha')
                        ->greeting('Olá ' . $this->username . ',')
                        ->line('Seja bem-vindo(a) ao ' . config('app.site') . '!')
                        ->line('Você acaba de ser cadastrado e clicando no email abaixo você poderá definir sua senha de acesso.')
                        ->action('Definir Senha', route('auth-create-password-form', ['token' => $this->token]))
                        ->line('Se você não solicitou esse cadastro ou desconhece o site do ' . config('app.site') . ', por favor ignore este e-mail.')
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
