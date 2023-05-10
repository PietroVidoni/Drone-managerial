<?php
require_once '../../config/config.php';

require '../control/enableConnection.php';

require '../../vendor/autoload.php';
require '../../vendor/phpmailer/phpmailer/src/PHPMailer.php';
require '../../vendor/phpmailer/phpmailer/src/SMTP.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

if (isset($_POST['email'])) {
    $email = $_POST['email'];

    try {
        $dbc = Database::getInstance();
        $conn = $dbc->getConnection();

        $stmt = $conn->prepare("SELECT COUNT(*) FROM utenti WHERE email = :email");
        $stmt->execute(array(':email' => $email));
        $count = $stmt->fetchColumn();

        if ($count != 1) {
            throw new Exception("Indirizzo email non trovato");
        }

        $token = bin2hex(random_bytes(16));
        $timestamp = date('Y-m-d H:i:s');

        $stmt = $conn->prepare("UPDATE utenti SET token = :token, timestamp = :timestamp WHERE email = :email");
        $stmt->bindParam(':token', $token);
        $stmt->bindParam(':timestamp', $timestamp);
        $stmt->bindParam(':email', $email);
        $stmt->execute();

        $mail = new PHPMailer(true);
        $mail->IsSMTP();
        $mail->Host = MAIL_HOST;
        $mail->SMTPAuth = true;
        $mail->Username = MAIL_USERNAME;
        $mail->Password = MAIL_PASSWORD;
        $mail->Port = MAIL_PORT;
        $mail->SMTPSecure = 'tls';

        $mail->setFrom(MAIL_USERNAME);
        $mail->addAddress($email);

        $mail->isHTML(true);
        $mail->Subject = 'Reset password (PHP Project)';
        $mail->Body = 'Reset Account password by using this link: http://localhost:8080/resetPasswordPage.php?token=' . $token;
        $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

        if (!$mail->send()) {
            throw new Exception('Message could not be sent. Mailer Error: ' . $mail->ErrorInfo);
        }

        header("Location: ../view/forgotPasswordPage.php");
        die();
    } catch (Exception $e) {
        header("Location: ../view/errors/genericErrorPage.php?error=" . urlencode($e->getMessage()));
        die();
    }
} else {
    header("Location: ../view/errors/genericErrorPage.php?error=Session%20Lost");
    die();
}
?>
