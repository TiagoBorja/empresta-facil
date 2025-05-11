<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../../../vendor/autoload.php'; // Adjust based on your installation method

// SMTP Configuration
$phpmailer = new PHPMailer();
$phpmailer->isSMTP();
$phpmailer->Host = 'sandbox.smtp.mailtrap.io';
$phpmailer->SMTPAuth = true;
$phpmailer->Port = 2525;
$phpmailer->Username = 'cd897272b85f0b';
$phpmailer->Password = '8e715910c11cab';

// Sender and recipient settings
$phpmailer->setFrom('from@example.com', 'From Name');
$phpmailer->addAddress('recipient@example.com', 'Recipient Name');

// Email content
$phpmailer->isHTML(true); // Set email format to HTML
$phpmailer->Subject = "PHPMailer SMTP test";
$phpmailer->Body = '<h1>Send HTML Email using SMTP in PHP</h1><p>This is a test email I\'m sending using SMTP mail server with PHPMailer.</p>'; // Example HTML body
$phpmailer->AltBody = 'This is the plain text version of the email content';

// Send the email
if (!$phpmailer->send()) {
    echo 'Message could not be sent. Mailer Error: ' . $phpmailer->ErrorInfo;
} else {
    echo 'Message has been sent';
}