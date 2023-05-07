<?php

session_start();

include 'enableConnection.php';

$dbc = Database::getInstance();
$conn = $dbc->getConnection();

$stmt = $conn->prepare("UPDATE utenti SET session_id = NULL WHERE id = :user_id");
$stmt->execute(array(':user_id' => $_SESSION['user_info']['user_id']));
$stmt->errorInfo();

//removing all the session cookie 

if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000,
        $params["path"], $params["domain"],
        $params["secure"], $params["httponly"]
    );
} 

session_unset();   
session_destroy();

$dbc->closeConnection();

if(isset($_GET['reason'])){
    header("Location: loginPage.php?reason=".$_GET['reason']);
}else{
    header("Location: loginPage.php");
}
?>