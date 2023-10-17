<?php
    session_start()
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <h1>Please input a Song Rating</h1>

    <form action="">
        <div>
            <label for="username">Username:</label>
            <span><?=$_SESSION['username']?></span>
        </div>
    <div>

            <label for="Artist">Artist</label>
            <input type="text" id="artist" name="artist">
        </div>
        <div>
            <label for="Artist">Song</label>
            <input type="text" id="song" name="song">
        </div> <div>
            <label for="Artist">Rating</label>
            <input type="text" id="rating" name="rating">
        </div>
        <button>Submit</button>
        <a href="userView.php">Cancel</a>
    </form>
    
</body>
</html>