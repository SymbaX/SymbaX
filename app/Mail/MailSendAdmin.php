<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;

use Illuminate\Queue\SerializesModels;

class MailSendAdmin extends Mailable
{
    use Queueable, SerializesModels;


    public function changeEmail($name, $email)
    {
        return $this->markdown('emails.email-change')
            ->subject('メールアドレスが変更されました')
            ->with([
                'name' => $name,
                'email' => $email,
            ]);
    }

    public function sendEmail($subject, $body)
    {
        return $this->markdown('emails.admin-send')
            ->subject($subject)
            ->with([
                'title' => $subject,
                'body' => $body,
            ]);
    }
}
