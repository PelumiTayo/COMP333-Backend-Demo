<?php
    require_once "config.php";

    session_start();
    session_regenerate_id(true);

    if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
        header("location: login.php");
        exit;
    }

    $rating_id = htmlspecialchars($_GET["id"]);
    // Echo the username.
    echo "You are logged in as user: " . $_SESSION["username"];
    if ($result = $link->query("SELECT * FROM ratings_table WHERE id = $rating_id")) {
        if ($result->num_rows > 0) {
            $rating = mysqli_fetch_row($result);
            }
            else {
                header("location: userView.php");
            }
    }
    else {
        echo "Something went wrong, please try again later";
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- <title>Document</title> -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
    <style>
        strong {
            margin-bottom:1em;
        }
    </style>
</head>
<body>
    <h1>View Rating</h1>
    <p>username</p>
    <?="<strong>".$rating[1]."</strong>"?>
    <p>artist</p>
    <?="<strong>".$rating[2]."</strong>"?>
    <p>song</p>
    <?="<strong>".$rating[3]."</strong>"?>
    <p>rating</p>
    <?="<strong>".$rating[4]."</strong>"?>
    <a style="display:block;" href="/userView.php">Back</a>
</body>
</html>
