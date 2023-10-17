<?php
    session_start();
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <style>
        .row {
            display: flex; /* Set the display property to flex */
            flex-direction: row;
            justify-content: space-around;
            font-weight: bolder;
        }
    </style>
    You are logged in as user: <?=$_SESSION['username']?>
    <br>
    <a href=""> Log Out</a>
    <h1>Song Ratings</h1>
    <a href="addSong.php">Add New Song Rating</a>
    <div id="ratedSongs">
        <div class="row">
            <p>ID</p>
            <p>Username</p>
            <p>Artist</p>
            <p>Song</p>
            <p>Rating</p>
            <p>Action</p>
        </div>
    </div>
</body>
</html>