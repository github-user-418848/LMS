<?php

    require_once $_SERVER['DOCUMENT_ROOT'] . "/" . basename(dirname(__FILE__)) . "/config/init.php";

    $user = new User();
    $user -> Logout();

    Redirect(location: BASE_URL);