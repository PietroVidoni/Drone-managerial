<?php

    $page = isset($_GET['page']) ? $_GET['page'] : 'index';

    if(!file_exists("view/". $page . ".php")){
        include 'view/404.php';
    }else{
        include "view/loginPage.php";
    }
?>