<?php
session_start();

$password = $_POST['password1'];
$password2 = $_POST['password2'];

$token = $_SESSION['reset_token'];
$_SESSION['reset_token'] = null;

$stmt = $conn->prepare("SELECT id, token FROM utenti WHERE token = :token");
$stmt->execute(array(':token' => $token));
$user = $stmt->fetch(PDO::FETCH_ASSOC);

$valid = true;
$errorMessage = '';

if (!$user) {
    $valid = false;
    $errorMessage .= "Invalid or expired token.";
}

if ($password != $password2) {
    $valid = false;
    $errorMessage .= " Passwords do not match.";
}

$_SESSION['valid'] = $valid;

if ($valid) {
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
    
    $stmt = $conn->prepare("UPDATE utenti SET password = :password, token = NULL WHERE id = :id");
    $stmt->execute(array(':password' => $hashedPassword, ':id' => $user['id']));

    header("Location: loginPage.php");
    die();
} else {
    header("Location: resetPasswordPage.php?token=".$token."&valid=".$errorMessage);
    die();
}
?>
