<?php

namespace App\Service;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
class MailService
{
    private $mailer;

    public function __construct()
    {
        $this->mailer = new PHPMailer(true);
        $this->mailer->isSMTP();
        $this->mailer->Host = 'smtp.gmail.com';
        $this->mailer->SMTPAuth = true;
        $this->mailer->Username = 'victoriogdlp@gmail.com';
        $this->mailer->Password = 'mrar aboe seln ccdt';
        $this->mailer->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $this->mailer->Port = 587;
    }

    public function sendEmail($to, $subject, $body)
    {
        try {
            // Définir les paramètres de l'email
            $this->mailer->setFrom('victoriogdlp@gmail.com', 'Mailer');
            $this->mailer->addAddress($to);
            $this->mailer->isHTML(true);
            $this->mailer->Subject = $subject;
            $this->mailer->Body    = $body;
            $this->mailer->AltBody = strip_tags($body);

            // Envoyer l'email
            $this->mailer->send();
        } catch (Exception $e) {
            throw new \Exception("Message could not be sent. Mailer Error: {$this->mailer->ErrorInfo}");
        }
    }
}