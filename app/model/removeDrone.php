<?php

session_start();

include '../control/enableConnection.php';

if (isset($_POST['droneID'])) {
    $droneID = $_POST['droneID'];

    $dbc = Database::getInstance();
    $conn = $dbc->getConnection();

    $sql_delete = "DELETE FROM droni WHERE id = :removeDroneID";
    $stmt_delete = $conn->prepare($sql_delete);
    $stmt_delete->bindParam(':removeDroneID', $droneID);

    try {
        $stmt_delete->execute();
        $stmt_delete = null;
        $conn = null;
        header("Location: ../view/homePage.php?page=dronePage");
        exit();
    } catch (PDOException $e) {
        header("Location: ../view/errors/internalErrorPage.php?error=".$e->getMessage());
        exit();
    }
}


?>