<?php

session_start();

include '../control/enableConnection.php';

$session_timeout = 600; 
$max_login_attempts = 4;
$block_duration = 1800; 

if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
    header("Location: logout.php?reason=Invalid%20csrf%20token");
    die();
}

$_SESSION['user_status'] = false;

$dbc = Database::getInstance();
$conn = $dbc->getConnection();

$error = "";

if (isset($_POST['username'], $_POST['password'])) {
    $username = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_FULL_SPECIAL_CHARS);

    if (empty($username) || empty($password)) {
        $error = "empty%20username%20or%20password%20field";
        header("Location: ../view/loginPage.php?error=$error");
    } else {

        $block_start_time = time() - $block_duration;

        $stmt = $conn->prepare("SELECT COUNT(*) AS attempts FROM login_attempts WHERE username = :username AND timestamp >= :block_start_time");
        $stmt->execute(array(':username' => $username, ':block_start_time' => date('Y-m-d H:i:s', $block_start_time)));
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        $login_attempts = $result['attempts'];

        if ($login_attempts >= $max_login_attempts) {
            $error = "Too%20many%20login%20attempts.%20Please%20try%20again%20later.";
            header("Location: ../view/loginPage.php?error=$error");
            die();
        }

        $stmt = $conn->prepare("SELECT id, password_hash, session_id, last_activity FROM utenti WHERE username = :username LIMIT 1");
        $stmt->execute(array(':username' => $username));
        $stmt->errorInfo();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        $user_id = $row['id'];
        $hash = $row['password_hash'];
        $stored_session_id = $row['session_id'];
        $last_activity = $row['last_activity'];

        if (password_verify($password, $hash)) {

            if (!empty($stored_session_id) && $stored_session_id !== session_id() && (time() - strtotime($row['last_activity'])) < $session_timeout) {
                header("Location: logout.php?reason=User%20already%20logged%20in%20on%20another%20browser%20or%20device");
                die();
            }

            $stmt = $conn->prepare("UPDATE utenti SET session_id = :session_id, last_activity = NOW() WHERE id = :user_id");
            $stmt->execute(array(':session_id' => session_id(), ':user_id' => $user_id));

            $stmt = $conn->prepare("DELETE FROM login_attempts WHERE username = :username");
            $stmt->execute(array(':username' => $username));

            $dbc->closeConnection();
            $conn = null;

            $_SESSION['user_status'] = true;
            $_SESSION['user_info'] = array("user_id" => $user_id, "username" => $username);

            header("Location: ../view/homePage.php");

        } else {
            $stmt = $conn->prepare("INSERT INTO login_attempts (username) VALUES (:username)");
            $stmt->execute(array(':username' => $username));

            $error = "wrong%20username%20or%20password";
            header("Location: ../view/loginPage.php?error=$error");
            die();
        }
    }
}
?>