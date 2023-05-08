<?php
require_once '../../config/config.php';

require '../../vendor/autoload.php';
require '../../vendor/phpmailer/phpmailer/src/PHPMailer.php';
require '../../vendor/phpmailer/phpmailer/src/SMTP.php';

include '../control/enableConnection.php';

use PHPMailer\PHPMailer\PHPMailer;

if (isset($_POST['email'])) {

    $email = $_POST['email'];

    $dbc = Database::getInstance();
    $conn = $dbc->getConnection();

    $stmt = $conn->prepare("SELECT COUNT(*) FROM utenti WHERE email = :email");
    $stmt->execute(array(':email' => $email));
    $count = $stmt->fetchColumn();

    if ($count != 1) {
        header("Location: ../view/genericErrorPage.php?error=Indirizzo%20email%20non%20trovato"); //TODO FIXME 
        exit();
    } else {
        try {
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
                echo 'Message could not be sent.';
                echo 'Mailer Error: ' . $mail->ErrorInfo;
            } else {
                header("Location: forgotPasswordPage.php");
            }
        } catch (Exception $e) {
            header("Location: ../view/genericErrorPage.php?error=".$e->getMessage());
            exit();
        }
    }
} else {
    header("Location: ../view/genericErrorPage.php?error=Session%20Lost"); //TODO FIXME 
    exit();
}
?>