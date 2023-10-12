<?php
    // import server configuration file
    require_once "config.php";

    $request = $_SERVER['REQUEST_URI'];

    switch ($request) {
        case '/':
            header('Location: register.php');
            break;

    }
?>