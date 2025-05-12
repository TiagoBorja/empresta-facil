<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../../../vendor/autoload.php';

class Utils
{
    public static function uploadImage(string $targetDir, string $fileInputName): ?string
    {
        $dir = rtrim($targetDir, '/');
        $uniqueName = uniqid() . "_" . basename($_FILES[$fileInputName]["name"]);
        $targetFile = $dir . "/" . $uniqueName;

        if (!file_exists($dir)) {
            mkdir($dir, 0777, true); // Cria a pasta se não existir
        }

        if (move_uploaded_file($_FILES[$fileInputName]["tmp_name"], $targetFile)) {
            // Caminho relativo para uso no HTML
            return basename($dir) . "/" . $uniqueName;
        }

        return null;
    }

    public static function sendConfirmationEmail($email, $firstName)
    {
        try {

            $phpmailer = new PHPMailer();
            $phpmailer->isSMTP();
            $phpmailer->Host = 'sandbox.smtp.mailtrap.io';
            $phpmailer->Port = 2525;
            $phpmailer->SMTPAuth = true;
            $phpmailer->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $phpmailer->Username = 'cd897272b85f0b';
            $phpmailer->Password = '8e715910c11cab';

            $phpmailer->setFrom('from@example.com', 'From Name');
            $phpmailer->addAddress('recipient@example.com', 'Recipient Name');

            // Conteúdo do e-mail
            $phpmailer->CharSet = 'UTF-8';
            $phpmailer->isHTML(true);
            $phpmailer->Subject = 'Código de Validação';

            $phpmailer->Body = '<h1>Olá ' . $firstName . ',</h1>';
            $phpmailer->Body .= '<p>A sua submissão foi recebida com sucesso!</p>';

            if (!$phpmailer->send()) {
                return json_encode([
                    'status' => 500,
                    'message' => 'Erro ao enviar email: ' . $phpmailer->ErrorInfo
                ]);
            }

            return json_encode([
                'status' => 200,
                'message' => 'Email enviado com sucesso para ' . $email,
            ]);

        } catch (Exception $e) {
            return json_encode([
                'status' => 500,
                'message' => "Erro ao realizar o envio do email!" . $e->getMessage(),
            ]);
        }
    }
}
