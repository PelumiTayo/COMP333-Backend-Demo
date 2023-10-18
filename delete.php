<?php
require_once("config.php");

session_start();
session_regenerate_id(true);

if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: login.php");
    exit;
}

$rating_id = htmlspecialchars($_GET["id"]);


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $rating_id = $_POST["id"];
    if ($result = $link->query("SELECT * FROM ratings_table WHERE id = $rating_id")) {
        if ($result->num_rows > 0) {
            if ($link->query("DELETE FROM ratings_table WHERE id = $rating_id")) {
                header("location: ../userView.php");
            }
            else {
                echo "Something went wrong, please try again later";
            }
        }
        else {
            header("location:../userView.php");
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
    <h1>Delete Rating</h1>
    <p>Are you sure you want to delete this rating?</p>
    <form method= "POST" action="<?=htmlspecialchars($_SERVER["PHP_SELF"])?>">
        <input type="hidden" name="id" value="<?=$rating_id?>">
        <button>Submit</button>
        <a href="/userView.php">Cancel</a>
    </form>
</body>
</html>
