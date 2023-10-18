<?php
require_once("config.php");

session_start();
if (isset($_GET['id'])) {
    $_SESSION['id'] = $_GET['id'];
}


$artist_field = $song_field = $rating_field = '';



if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $artist = trim($_POST["artist"]);
    $song = trim($_POST["song"]);
    $rating = trim($_POST["rating"]);
    // $id = $_SESSION['id'];

    //checks if artist, song, and rating pass the conditions
    if (preg_match('/[\w]{1,50}/', $artist) && preg_match('/[\w]{1,25}/', $song) && preg_match('/^[1-5]$/', $rating)) {

        $sql = "UPDATE ratings_table SET artist = ?, song = ?, rating = ? WHERE id = ? ";

        if ($stmt = mysqli_prepare($link, $sql)) {
            mysqli_stmt_bind_param($stmt, "ssii", $param_artist, $param_song, $param_rating, $param_id);
            $param_artist = $artist;
            $param_song = $song;
            $param_rating = $rating;
            $param_id = $_SESSION['id'];
            if (mysqli_stmt_execute($stmt)) {

                header("location: ../userView.php");
                exit();
            } else {
                echo "Oops! Something went wrong. Please try again later.";
            }
        }
        mysqli_stmt_close($stmt);

    } else {
        header("location: ../update.php/?id={$_SESSION['id']}");
    }
} else {
    //prepopulates the fields with the information retrieved from the database. 
    $sql = "SELECT artist, song, rating FROM ratings_table WHERE id = ?";

    if ($stmt = mysqli_prepare($link, $sql)) {
        mysqli_stmt_bind_param($stmt, "i", $param_id);
        $param_id = $_SESSION['id'];

        if (mysqli_stmt_execute($stmt)) {

            mysqli_stmt_bind_result($stmt, $artist_field, $song_field, $rating_field);
            mysqli_stmt_fetch($stmt);
        } else {
            echo "Error executing the statement: " . mysqli_error($link);
        }
    }
    mysqli_stmt_close($stmt);
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
    You are logged in as user:
    <?= $_SESSION['username'] ?>
    <br>
    <a href=""> Log Out</a>
    <h1>Update Rating</h1>

    <p>Here you can update your ratings.</p>

    <form method="POST" id="myForm" action="<?= htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        <div>
            <label for="username">Username:</label>
            <span>
                <?= $_SESSION['username'] ?>
            </span>
        </div>
        <div>
            <label for="Artist">Artist:</label>
            <input type="text" id="artist" name="artist" value="<?= $artist_field; ?>">
            <br>


        </div>
        <div>
            <label for="Artist">Song:</label>
            <input type="text" id="song" name="song" value="<?= $song_field; ?>">
            <br>
        </div>
        <div>
            <label for="Artist">Rating:</label>
            <input type="text" id="rating" name="rating" value="<?= $rating_field; ?>">
            <br>

        </div>
        <!-- <input type="hidden" name="id" value="<?= $id ?>"> -->
        <button type="submit">Submit</button>
        <a href="../userView.php">Cancel</a>
    </form>

</body>



</html>