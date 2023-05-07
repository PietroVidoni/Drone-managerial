<?php

    $page = isset($_GET['page']) ? $_GET['page'] : 'index';

    if(!file_exists("app/view/". $page . ".php")){
        include 'app/view/404.php';
    }else{
        include "app/view/loginPage.php";
    }
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <title>index</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>