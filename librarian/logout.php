<?php

    session_start();
    require($_SERVER['DOCUMENT_ROOT'] . "/" . basename(dirname(dirname(__FILE__))) . "/config/db_connect.php");

    Security::Headers();

    $auth = new Auth("librarian");
    $auth -> Logout("login.php");