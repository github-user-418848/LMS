<?php

    require_once $_SERVER['DOCUMENT_ROOT'] . "/" . basename(dirname(dirname(__FILE__))) . "/config/init.php";
    
    $user = new User();

    if (!$user -> Is_Logged_in() || !$user -> Is_Admin()) {
        Redirect(location: BASE_URL);
    }
    
    require_once($_SERVER['DOCUMENT_ROOT'] . "/" .  basename(dirname(dirname(__FILE__)))  . "/snippets/header.php");