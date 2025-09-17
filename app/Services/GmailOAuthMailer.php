<?php

namespace App\Services;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\OAuth;
use League\OAuth2\Client\Provider\Google;

class GmailOAuthMailer
{
    protected PHPMailer $mail;

    public function __construct()
    {
        $provider = new Google([
            'clientId' => env('GOOGLE_CLIENT_ID'),
            'clientSecret' => env('GOOGLE_CLIENT_SECRET'),
        ]);

        $this->mail = new PHPMailer(true);
        $this->mail->isSMTP();
        $this->mail->Host = env('MAIL_HOST', 'smtp.gmail.com');
        $this->mail->Port = env('MAIL_PORT', 587);
        $this->mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $this->mail->SMTPAuth = true;
        $this->mail->AuthType = 'XOAUTH2';

        $this->mail->setOAuth(new OAuth([
            'provider' => $provider,
            'clientId' => env('GOOGLE_CLIENT_ID'),
            'clientSecret' => env('GOOGLE_CLIENT_SECRET'),
            'refreshToken' => env('GOOGLE_REFRESH_TOKEN'),
            'userName' => env('MAIL_FROM_ADDRESS'),
        ]));

        $this->mail->setFrom(env('MAIL_FROM_ADDRESS'), env('MAIL_FROM_NAME'));
        
        // Set charset to UTF-8 for proper character encoding
        $this->mail->CharSet = 'UTF-8';
        $this->mail->Encoding = 'base64';
    }

    public function send(string $toEmail, string $toName, string $subject, string $viewName, array $data = [])
    {
        $this->mail->clearAllRecipients();
        $this->mail->addAddress($toEmail, $toName);
        $this->mail->Subject = $subject;
        
        // Render the view with data
        $body = view($viewName)->with($data)->render();
        
        $this->mail->Body = $body;
        $this->mail->isHTML(true);
        //dd($this->mail);
        return $this->mail->send();
    }
}
