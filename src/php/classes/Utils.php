<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require __DIR__ . '/../../../vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../../../');
$dotenv->load();

class Utils
{
    public static function uploadImage(string $targetDir, string $fileInputName): ?string
    {
        $dir = __DIR__ . '/' . trim($targetDir, '/'); // Caminho absoluto
        $uniqueName = uniqid() . "_" . basename($_FILES[$fileInputName]["name"]);
        $targetFile = $dir . "/" . $uniqueName;

        if (!file_exists($dir)) {
            mkdir($dir, 0777, true);
        }

        if (move_uploaded_file($_FILES[$fileInputName]["tmp_name"], $targetFile)) {
            return $uniqueName;
        }

        return null;
    }

    public static function sendConfirmationEmail($email, $firstName, $code, $libraryData = [])
    {
        try {
            $phpmailer = new PHPMailer();
            $phpmailer->isSMTP();
            $phpmailer->Host = $_ENV['MAIL_HOST'];
            $phpmailer->Port = $_ENV['MAIL_PORT'];
            $phpmailer->SMTPAuth = true;
            $phpmailer->SMTPSecure = $_ENV['MAIL_ENCRYPTION'];
            $phpmailer->Username = $_ENV['MAIL_USERNAME'];
            $phpmailer->Password = $_ENV['MAIL_PASSWORD'];

            $phpmailer->setFrom($_ENV['MAIL_FROM_ADDRESS'], 'EmprestaFacil');
            $phpmailer->addAddress($email, $firstName);

            $phpmailer->CharSet = 'UTF-8';
            $phpmailer->isHTML(true);
            $phpmailer->Subject = '📌 Código de Validação da Submissão';

            $librariesHtml = '';
            if (!empty($libraryData)) {
                $librariesHtml .= '<div class="highlight">';
                $librariesHtml .= '<h4>Apresente o código numa das bibliotecas abaixo:</h4><div class="details">';
                foreach ($libraryData as $library) {
                    $name = $library['nome'] ?? 'Sem nome';
                    $address = $library['morada'] ?? 'Sem morada';
                    $librariesHtml .= "<div><strong>🏢 Biblioteca:</strong> " . htmlspecialchars($name) . "</div>";
                    $librariesHtml .= "<div><strong>📍 Morada:</strong> " . htmlspecialchars($address) . "</div><br>";
                }
                $librariesHtml .= '</div></div>';
            }

            $phpmailer->Body = '
        <!DOCTYPE html>
        <html lang="pt">
        <head>
            <meta charset="UTF-8">
            <style>
                body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; max-width: 600px; margin: 0 auto; padding: 20px; }
                .header { background-color: #f0f4f8; padding: 20px; text-align: center; border-radius: 5px 5px 0 0; }
                .content { padding: 20px; background-color: #fff; border-left: 1px solid #eee; border-right: 1px solid #eee; }
                .footer { padding: 20px; text-align: center; font-size: 12px; color: #777; background-color: #f0f4f8; border-radius: 0 0 5px 5px; }
                .highlight { background-color: #fff8e1; padding: 15px; border-left: 4px solid #ffc107; margin: 15px 0; }
                .details div { margin-bottom: 8px; }
            </style>
        </head>
        <body>
            <div class="header">
                <h2 style="color: #4a6fa5; margin: 0;">Portal da Biblioteca</h2>
                <p style="margin: 5px 0 0;">Submissão Recebida</p>
            </div>

            <div class="content">
                <h3 style="color: #4a6fa5;">Olá, ' . htmlspecialchars($firstName) . '!</h3>
                <p>A sua submissão foi recebida com sucesso.</p>
                <p><strong>O seu código de validação é:</strong> <code>' . htmlspecialchars($code) . '</code></p>

                ' . $librariesHtml . '
            </div>

            <div class="footer">
                <p>© ' . date('Y') . ' Portal da Biblioteca. Todos os direitos reservados.</p>
                <p>Este é um e-mail automático. Não responda a esta mensagem.</p>
            </div>
        </body>
        </html>';

            return $phpmailer->send()
                ? json_encode(['status' => 200, 'message' => 'Email enviado com sucesso para ' . $email])
                : json_encode(['status' => 500, 'message' => 'Erro ao enviar email: ' . $phpmailer->ErrorInfo]);
        } catch (Exception $e) {
            return json_encode([
                'status' => 500,
                'message' => "Erro ao realizar o envio do email! " . $e->getMessage(),
            ]);
        }
    }
    public static function sendReservationEmail($email, $firstName, $bookTitle, $pickUpDate, $expirationDate, $libraryName, $libraryAddress)
    {
        try {
            date_default_timezone_set('Europe/Lisbon');

            $phpmailer = new PHPMailer();
            $phpmailer->isSMTP();
            $phpmailer->Host = $_ENV['MAIL_HOST'];
            $phpmailer->Port = $_ENV['MAIL_PORT'];
            $phpmailer->SMTPAuth = true;
            $phpmailer->SMTPSecure = $_ENV['MAIL_ENCRYPTION'];
            $phpmailer->Username = $_ENV['MAIL_USERNAME'];
            $phpmailer->Password = $_ENV['MAIL_PASSWORD'];

            $phpmailer->setFrom($_ENV['MAIL_FROM_ADDRESS'], $libraryName);
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
            </div>
            
            <div class="footer">
                <p>© ' . date_default_timezone_set('Europe/Lisbon');
            date('d-m-Y') . ' ' . htmlspecialchars($libraryName) . ' Todos os direitos reservados.</p>
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


            return json_encode([
                'status' => $phpmailer->send() ? 200 : 500,
                'message' => $phpmailer->ErrorInfo
            ]);
        } catch (Exception $e) {
            error_log("Erro ao enviar e-mail: " . $e->getMessage());
            return false;
        }
    }

    public static function sendLoanEmail($email, $firstName, $bookTitle, $pickUpDate, $libraryName, $libraryAddress)
    {
        try {
            date_default_timezone_set('Europe/Lisbon');

            $phpmailer = new PHPMailer();
            $phpmailer->isSMTP();
            $phpmailer->Host = $_ENV['MAIL_HOST'];
            $phpmailer->Port = $_ENV['MAIL_PORT'];
            $phpmailer->SMTPAuth = true;
            $phpmailer->SMTPSecure = $_ENV['MAIL_ENCRYPTION'];
            $phpmailer->Username = $_ENV['MAIL_USERNAME'];
            $phpmailer->Password = $_ENV['MAIL_PASSWORD'];

            $phpmailer->setFrom($_ENV['MAIL_FROM_ADDRESS'], $libraryName);
            $phpmailer->addAddress($email, $firstName);

            $phpmailer->CharSet = 'UTF-8';
            $phpmailer->isHTML(true);
            $phpmailer->Subject = '📚 Confirmação de Empréstimo';

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
                <p style="margin: 5px 0 0;">Sua levantamento foi confirmada</p>
            </div>
            
            <div class="content">
                <h3 style="color: #4a6fa5;">Olá, ' . htmlspecialchars($firstName) . '!</h3>
                
                <p>Agradecemos por utilizar os nossos serviços. Aqui estão os detalhes do seu empréstimo:</p>
                
                <div class="highlight">
                    <h4 style="margin-top: 0;">Livro(s)' . htmlspecialchars($bookTitle) . '</h4>
                    <div class="details">
                        <div><strong>📅 Data de Devolução:</strong> ' . htmlspecialchars($pickUpDate) . '</div>
                        <div><strong>🏢 Biblioteca:</strong> ' . htmlspecialchars($libraryName) . '</div>
                        <div><strong>🏠 Morada:</strong> ' . htmlspecialchars($libraryAddress) . '</div>
                    </div>
                </div>
                
                <p><strong>Importante:</strong> Você tem até a data de devolução para devolver o livro. Após essa data, será aplicado uma penalidade</p>
            </div>
            
            <div class="footer">
                <p>© ' . date_default_timezone_set('Europe/Lisbon');
            date('d-m-Y') . ' ' . htmlspecialchars($libraryName) . ' Todos os direitos reservados.</p>
                <p>Este é um e-mail automático, por favor não responda.</p>
            </div>
        </body>
        </html>';

            $phpmailer->AltBody = "Olá $firstName,\n\n" .
                "Sua reserva do livro '$bookTitle' foi confirmado.\n\n" .
                "Data para levantamento: $pickUpDate\n" .
                "Biblioteca: $libraryName\n" .
                "Você tem até a data de levantamento para retirar o livro.\n\n" .
                "Atenciosamente,\n" .
                htmlspecialchars($libraryName);


            return json_encode([
                'status' => $phpmailer->send() ? 200 : 500,
                'message' => $phpmailer->ErrorInfo
            ]);
        } catch (Exception $e) {
            error_log("Erro ao enviar e-mail: " . $e->getMessage());
            return false;
        }
    }
    public static function notifyLoanExpiration($email, $firstName, $bookTitle, $libraryName, $libraryAddress)
    {
        try {
            date_default_timezone_set('Europe/Lisbon');

            $phpmailer = new PHPMailer();
            $phpmailer->isSMTP();
            $phpmailer->Host = $_ENV['MAIL_HOST'];
            $phpmailer->Port = $_ENV['MAIL_PORT'];
            $phpmailer->SMTPAuth = true;
            $phpmailer->SMTPSecure = $_ENV['MAIL_ENCRYPTION'];
            $phpmailer->Username = $_ENV['MAIL_USERNAME'];
            $phpmailer->Password = $_ENV['MAIL_PASSWORD'];

            $phpmailer->setFrom($_ENV['MAIL_FROM_ADDRESS'], $libraryName);
            $phpmailer->addAddress($email, $firstName);

            $phpmailer->CharSet = 'UTF-8';
            $phpmailer->isHTML(true);
            $phpmailer->Subject = '📚 Notificação do Empréstimo';

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
            .highlight { background-color: #fff8e1; padding: 15px; border-left: 4px solid #ffc107; margin: 15px 0; }
            .details { margin: 15px 0; }
            .details div { margin-bottom: 8px; }
        </style>
    </head>
    <body>
        <div class="header">
            <h2 style="color: #4a6fa5; margin: 0;">' . htmlspecialchars($libraryName) . '</h2>
            <p style="margin: 5px 0 0;">O seu empréstimo está em atraso</p>
        </div>
        
        <div class="content">
            <h3 style="color: #4a6fa5;">Olá, ' . htmlspecialchars($firstName) . '!</h3>
            
            <p>Informamos que o empréstimo do livro <strong>' . htmlspecialchars($bookTitle) . '</strong> ultrapassou a data de devolução.</p>
            <p>Por favor, proceda à devolução o mais rapidamente possível para evitar penalizações.</p>
            
            <div class="highlight">
                <div class="details">
                    <div><strong>🏢 Biblioteca:</strong> ' . htmlspecialchars($libraryName) . '</div>
                    <div><strong>🏠 Morada:</strong> ' . htmlspecialchars($libraryAddress) . '</div>
                </div>
            </div>
        </div>
        
        <div class="footer">
            <p>© ' . date('d-m-Y') . ' ' . htmlspecialchars($libraryName) . ' - Todos os direitos reservados.</p>
            <p>Este é um e-mail automático, por favor não responda.</p>
        </div>
    </body>
    </html>';

            $phpmailer->AltBody = "Olá $firstName,\n\n" .
                "Informamos que o empréstimo do livro '$bookTitle' ultrapassou a data de devolução.\n" .
                "Por favor, proceda à devolução o mais rapidamente possível para evitar penalizações.\n\n" .
                "Biblioteca: $libraryName\n" .
                "Morada: $libraryAddress\n" .
                "Atenciosamente,\n" .
                $libraryName;

            return json_encode([
                'status' => $phpmailer->send() ? 200 : 500,
                'message' => $phpmailer->ErrorInfo
            ]);
        } catch (Exception $e) {
            error_log("Erro ao enviar e-mail: " . $e->getMessage());
            return false;
        }
    }
    public static function notifyUpcomingLoanExpiration($email, $firstName, $bookTitle, $libraryName, $libraryAddress)
    {
        try {
            date_default_timezone_set('Europe/Lisbon');

            $phpmailer = new PHPMailer();
            $phpmailer->isSMTP();
            $phpmailer->Host = $_ENV['MAIL_HOST'];
            $phpmailer->Port = $_ENV['MAIL_PORT'];
            $phpmailer->SMTPAuth = true;
            $phpmailer->SMTPSecure = $_ENV['MAIL_ENCRYPTION'];
            $phpmailer->Username = $_ENV['MAIL_USERNAME'];
            $phpmailer->Password = $_ENV['MAIL_PASSWORD'];

            $phpmailer->setFrom($_ENV['MAIL_FROM_ADDRESS'], $libraryName);
            $phpmailer->addAddress($email, $firstName);

            $phpmailer->CharSet = 'UTF-8';
            $phpmailer->isHTML(true);
            $phpmailer->Subject = '📚 Alerta: Empréstimo a Expirar';

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
        .highlight { background-color: #fff8e1; padding: 15px; border-left: 4px solid #ffc107; margin: 15px 0; }
        .details { margin: 15px 0; }
        .details div { margin-bottom: 8px; }
    </style>
</head>
<body>
    <div class="header">
        <h2 style="color: #4a6fa5; margin: 0;">' . htmlspecialchars($libraryName) . '</h2>
        <p style="margin: 5px 0 0;">O seu empréstimo está prestes a expirar</p>
    </div>
    
    <div class="content">
        <h3 style="color: #4a6fa5;">Olá, ' . htmlspecialchars($firstName) . '!</h3>
        
        <p>Este é um lembrete de que o empréstimo do livro <strong>' . htmlspecialchars($bookTitle) . '</strong> está prestes a expirar.</p>
        <p>Por favor, organize-se para devolvê-lo a tempo ou proceda à renovação, se aplicável.</p>
        
        <div class="highlight">
            <div class="details">
                <div><strong>🏢 Biblioteca:</strong> ' . htmlspecialchars($libraryName) . '</div>
                <div><strong>🏠 Morada:</strong> ' . htmlspecialchars($libraryAddress) . '</div>
            </div>
        </div>
    </div>
    
    <div class="footer">
        <p>© ' . date('d-m-Y') . ' ' . htmlspecialchars($libraryName) . ' - Todos os direitos reservados.</p>
        <p>Este é um e-mail automático, por favor não responda.</p>
    </div>
</body>
</html>';

            $phpmailer->AltBody = "Olá $firstName,\n\n" .
                "Este é um lembrete de que o empréstimo do livro '$bookTitle' está prestes a expirar.\n" .
                "Por favor, devolva-o a tempo ou renove-o para evitar penalizações.\n\n" .
                "Biblioteca: $libraryName\n" .
                "Morada: $libraryAddress\n" .
                "Atenciosamente,\n" .
                $libraryName;

            return json_encode([
                'status' => $phpmailer->send() ? 200 : 500,
                'message' => $phpmailer->ErrorInfo
            ]);
        } catch (Exception $e) {
            error_log("Erro ao enviar e-mail: " . $e->getMessage());
            return false;
        }
    }


    public static function generateRandomCode($size = 6)
    {
        $char = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
        $code = '';

        for ($i = 0; $i < $size; $i++) {
            $index = rand(0, strlen($char) - 1);
            $code .= $char[$index];
        }

        return $code;
    }


    private static function getRoleLevel(string $role): int
    {
        $levels = [
            'Administrador' => 3,
            'Gestor' => 2,
            'Funcionário' => 1,
        ];

        return $levels[$role] ?? 0;
    }

    public static function hasAccessLevel(array $user, string $requiredRole): bool
    {
        if (!isset($user['tipo']) || $user['tipo'] === 'Utilizador Comum') {
            return false;
        }

        $userLevel = self::getRoleLevel($user['tipo']);
        $requiredLevel = self::getRoleLevel($requiredRole);

        return $userLevel >= $requiredLevel;
    }
    public static function isAdmin(array $user): bool
    {
        return ($user['tipo'] ?? '') === 'Administrador';
    }

    public static function isManagerOrHigher(array $user): bool
    {
        return self::hasAccessLevel($user, 'Gestor');
    }

    public static function isEmployeeOrHigher(array $user): bool
    {
        return self::hasAccessLevel($user, 'Funcionario');
    }
}
