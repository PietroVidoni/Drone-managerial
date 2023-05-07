<?php 
    include '../control/enableConnection.php';

    session_start();

    $dbc = Database::getInstance();
    $conn = $dbc->getConnection();

    $error = "";

    $_username =  $_POST['username'];
    $_name =  $_POST['name'];
    $_surname =  $_POST['surname'];
    $_password = $_POST['password1'];
    $_password2 = $_POST['password2'];
    $_email = $_POST['email'];

    var_dump($_name  ); 

    if ($_password !== $_password2) {
        $error = "Passwords do not match";
        header("Location: ../view/registerPage.php?error=$error");
        exit();
    }
    
    if ($_password === $_username) {
        $error = "Username and password can't match";
        header("Location: ../view/registerPage.php?error=$error");
        exit();
    }

    $stmt = $conn->prepare("SELECT COUNT(*) FROM utenti WHERE username = :username");
    $stmt->execute(array(':username' => $_username));
    $count = $stmt->fetchColumn();
    
    if ($count > 0) {
        $error = "Username already in use";
        header("Location: ../view/registerPage.php?error=$error");
        exit();
    }

    $stmt = $conn->prepare("SELECT COUNT(*) FROM utenti WHERE email = :email");
    $stmt->execute(array(':email' => $_email));
    $count = $stmt->fetchColumn();
    
    if ($count > 0) {
        $error = "Email already in use";
        header("Location: ../view/registerPage.php?error=$error");
        exit();
    }

    $hashed_password = password_hash($_password, PASSWORD_DEFAULT);
    
    $stmt = $conn->prepare("INSERT INTO utenti (username, password_hash, email, nome, cognome) VALUES (:username, :password, :email, :nome, :cognome)");
    $stmt->bindParam(':username', $_username);
    $stmt->bindParam(':password', $hashed_password);
    $stmt->bindParam(':email', $_email);
    $stmt->bindParam(':nome', $_name);
    $stmt->bindParam(':cognome', $_surname);
        
    if ($stmt->execute()) {
        echo "Nuovo record inserito con successo";
        header("Location: ../view/loginPage.php");
    } else {
        echo "Errore nell'inserimento del record: " . $stmt->errorInfo();
    }
?>