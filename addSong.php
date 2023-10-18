<?php

session_start();
// import server configuration file

require_once "config.php";
$artist = $song = $rating = "";
$artist_err = $song_err = $rating_err = "";


// listens for post requests 
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $artist = trim($_POST["artist"]);
    $song = trim($_POST["song"]);
    $rating = trim($_POST["rating"]);

    //checks if artist, song, and rating pass the conditions
    if (preg_match('/[\w]{1,50}/', $artist) && preg_match('/[\w]{1,25}/', $song) && preg_match('/^[1-5]$/', $rating)) {
        $sql = "INSERT into ratings_table (artist, username, song, rating) VALUES (?, ?, ?, ?)";

        if ($stmt = mysqli_prepare($link, $sql)) {
            mysqli_stmt_bind_param($stmt, "sssi", $param_artist, $param_username, $param_song, $param_rating);
            $param_artist = $artist;
            $param_username = $_SESSION['username'];
            $param_song = $song;
            $param_rating = $rating;

            if (mysqli_stmt_execute($stmt)) {

                echo "added to the database";
                header("location: userView.php");
            } else {
                echo "Oops! Something went wrong. Please try again later.";
            }
        }
        mysqli_stmt_close($stmt);

    }
    //error handling. 
    else {
        if (!preg_match('/[\w]{1,50}/', $artist)) {
            $artist_err = "Please input a valid artist.";
        } elseif (!preg_match('/[\w]{1,25}/', $song)) {
            $song_err = "Please input a valid song.";
        } else {
            $rating_err = "Please input a rating between 1 and 5.";
        }
    }
}
?>



<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    You are logged in as user: <?=$_SESSION['username']?>
    <br>
    <a href=""> Log Out</a>
    <h1>Please input a Song Rating</h1>

    <form method="POST" action="<?= htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        <div>
            <label for="username">Username:</label>
            <span>
                <?= $_SESSION['username'] ?>
            </span>
        </div>
        <div>
            <label for="Artist">Artist:</label>
            <input type="text" id="artist" name="artist">
            <br>
            <span style="color:red" class="help-block">
                <?= $artist_err; ?>
            </span>

        </div>
        <div>
            <label for="Artist">Song:</label>
            <input type="text" id="song" name="song">
            <br>
            <span style="color:red" class="help-block">
                <?= $song_err; ?>
            </span>

        </div>
        <div>
            <label for="Artist">Rating:</label>
            <input type="text" id="rating" name="rating">
            <br>
            <span style="color:red" class="help-block">
                <?= $rating_err; ?>
            </span>

        </div>
        <button type="submit">Submit</button>
        <a href="userView.php">Cancel</a>
    </form>

</body>

</html>