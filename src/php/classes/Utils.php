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

    public static function sendReservationEmail($email, $firstName, $bookTitle, $pickUpDate, $expirationDate, $libraryName, $libraryAddress)
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

            $phpmailer->setFrom('biblioteca@example.com', $libraryName);
            $phpmailer->addAddress($email, $firstName);

            $phpmailer->CharSet = 'UTF-8';
            $phpmailer->isHTML(true);
            $phpmailer->Subject = '📚 Confirmação de Reserva - ' . $bookTitle;

            $phpmailer->Body = '
        <!DOCTYPE html>
        <html lang="pt">
        <head>
            <meta charset="UTF-8">
            <style>
                body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; max-width: 600px; margin: 0 auto; padding: 20px; }
                .header { background-color: #f8f1e9; padding: 20px; text-align: center; border-radius: 5px 5px 0 0; }
                .content { padding: 20px; background-color: #fff; border-left: 1px solid #eee; border-right: 1px solid #eee; }
                .footer { padding: 20px; text-align: center; font-size: 12px; color: #777; background-color: #f8f1e9; border-radius: 0 0 5px 5px; }
                .button { background-color: #4a6fa5; color: white; padding: 10px 20px; text-decoration: none; border-radius: 5px; display: inline-block; margin: 10px 0; }
                .highlight { background-color: #fff8e1; padding: 15px; border-left: 4px solid #ffc107; margin: 15px 0; }
                .details { margin: 15px 0; }
                .details div { margin-bottom: 8px; }
            </style>
        </head>
        <body>
            <div class="header">
                <h2 style="color: #4a6fa5; margin: 0;"> ' . htmlspecialchars($libraryName) . '</h2>
                <p style="margin: 5px 0 0;">Sua reserva foi confirmada</p>
            </div>
            
            <div class="content">
                <h3 style="color: #4a6fa5;">Olá, ' . htmlspecialchars($firstName) . '!</h3>
                
                <p>Agradecemos por utilizar os nossos serviços. Aqui estão os detalhes da sua reserva:</p>
                
                <div class="highlight">
                    <h4 style="margin-top: 0;">' . htmlspecialchars($bookTitle) . '</h4>
                    <div class="details">
                        <div><strong>📅 Data para levantamento:</strong> ' . htmlspecialchars($pickUpDate) . '</div>
                        <div><strong>🏢 Biblioteca:</strong> ' . htmlspecialchars($libraryName) . '</div>
                        <div><strong>🏢 Morada:</strong> ' . htmlspecialchars($libraryAddress) . '</div>
                        <div><strong>⏱️ Validade da reserva:</strong> ' . htmlspecialchars($expirationDate) . '</div>
                    </div>
                </div>
                
                <p><strong>Importante:</strong> Você tem até a data de levantamento para retirar o livro. Após essa data, a reserva expirará automaticamente.</p>
                
                <p style="text-align: center;">
                    <a href="https://exemplo.com/minhas-reservas" class="button">Ver Minhas Reservas</a>
                </p>
            </div>
            
            <div class="footer">
                <p>© ' . date('Y') . ' ' . htmlspecialchars($libraryName) . ' Todos os direitos reservados.</p>
                <p>Este é um e-mail automático, por favor não responda.</p>
            </div>
        </body>
        </html>';

            $phpmailer->AltBody = "Olá $firstName,\n\n" .
                "Sua reserva do livro '$bookTitle' foi confirmada.\n\n" .
                "Data para levantamento: $pickUpDate\n" .
                "Biblioteca: $libraryName\n" .
                "Validade da reserva: $expirationDate\n\n" .
                "Você tem até a data de levantamento para retirar o livro.\n\n" .
                "Atenciosamente,\n" .
                htmlspecialchars($libraryName);


            return $phpmailer->send();
        } catch (Exception $e) {
            error_log("Erro ao enviar e-mail: " . $e->getMessage());
            return false;
        }
    }
}
