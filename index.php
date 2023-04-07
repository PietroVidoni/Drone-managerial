<?php
    include "enableConnection.php";
    session_start();

    $page = isset($_GET['page']) ? $_GET['page'] : 'index';

    if(!file_exists($page.".php")){
        include '404.php';
    }else{
        include "loginPage.php";
    }
?>