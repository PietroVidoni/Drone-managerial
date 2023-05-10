<?php
session_start();

include '../control/enableConnection.php';

if (!isset($_SESSION['user_status']) || $_SESSION['user_status'] === false) {
    header('Location: ../view/loginPage.php');
    die();
}

$user_id = $_SESSION['user_info']['user_id'];

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="assets/stylesheet/style.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <title>DronePage</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="../control/scripts.js"></script>
    <script src="../control/sortList.js"></script>
</head>

<body>
    <header>
        <!-- Navbar start -->
        <?php include 'navbar.php'; ?>
        <!-- Navbar end -->
    </header>
    <section id="dynamic-list-section">
        <?php
        if (isset($_GET['page'])) {
            $page = $_GET['page'];

            if (file_exists("../view/" . $page . ".php")) {
                include "$page.php";
            } else {
                include "404.php";
            }
        } else {
            include "dronePage.php";
        }
        ?>
    </section>
</body>

<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>

</html>