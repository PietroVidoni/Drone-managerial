<?php

    include 'enableConnection.php';

    session_start();

    $dbc = Database::getInstance();
    $conn = $dbc->getConnection();

    if(isset($_SESSION['LAST_ACTIVITY']) && (time() - $_SESSION['LAST_ACTIVITY'] > 600)) {
        header("Location: ../model/logout.php?hearBeatError"); 
    }
    
    $stmt = $conn->prepare("UPDATE utenti SET last_activity = NOW() WHERE id = :user_id");
    $stmt->execute(array(':user_id' => $_SESSION['user_info']['user_id']));
    $stmt->errorInfo();
?>