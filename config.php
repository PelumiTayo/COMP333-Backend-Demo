<?php
/* Database credentials */
define('DB_SERVER', 'sql203.infinityfree.com');
define('DB_USERNAME', 'if0_35198511');
define('DB_PASSWORD', 'fBqgF0Ok3iL');
define('DB_NAME', 'if0_35198511_my_db');

/* Attempt to connect to MySQL database */
$link = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);

// Check connection
if($link === false){
    die("ERROR: Could not connect. " . mysqli_connect_error());
}
?>