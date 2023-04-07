<?php

include 'enableConnection.php';

session_start();

$_SESSION['user_status'] = false;

$dbc = Database::getInstance();
$conn = $dbc->getConnection();

$error = "";

if (isset($_POST['username'], $_POST['password'])) {
    $username = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_FULL_SPECIAL_CHARS);

    if (empty($username) || empty($password)) {
        $error = "empty username or password field";
        header("Location: loginPage.php?error=$error");
    } else {

        $stmt = $conn->prepare("SELECT id, password_hash FROM utenti WHERE username = :username LIMIT 1");
        $stmt->execute(array(':username' => $username));
        $stmt->errorInfo();
        
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        $user_id = $row['id'];
        $hash = $row['password_hash'];

        if (password_verify($password, $hash)) {
            $dbc->closeConnection();
            $conn = null;
            $_SESSION['user_status'] = true;
            $_SESSION['user_id'] = $user_id;
            
            header("Location: dronePage.php");
           
        } else {
            $error = "wrong username or password";
            header("Location: loginPage.php?error=$error"); 
        }
    }
}
?>