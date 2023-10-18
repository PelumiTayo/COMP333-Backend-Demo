<?php
    require_once("config.php");
    $ratings;

    session_start();
    session_regenerate_id(true);

    if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
        header("location: login.php");
        exit;
    }
    // Echo the username.
    echo "You are logged in as user: " . $_SESSION["username"];

    if ($results = $link->query("SELECT * FROM ratings_table")) {
        $rows = mysqli_fetch_all($results);
    }
    else {
        echo "Something went wrong, please try at another time";
    }
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- <title>Document</title> -->
    <style>
        table {
            width:100%;
            text-align: center;
        }
        a {
            margin:2px;
        }
    </style>
</head>
<body>
    <br>
    <a href="logout.php"> Log Out</a>
    <h1>Song Ratings</h1>
    <a href="addSong.php">Add New Song Rating</a> <br>
    <table>
        <tr>
            <th>ID</th>
            <th>Username</th>
            <th>Artist</th>
            <th>Song</th>
            <th>Rating</th>
            <th>Action</th>
        </tr>
        <tbody>
            <?php 
                foreach ($rows as $row) {
                    echo "<tr>";
                    echo "<td>{$row[0]}</td>";
                    echo "<td>{$row[1]}</td>";
                    echo "<td>{$row[2]}</td>";
                    echo "<td>{$row[3]}</td>";
                    echo "<td>{$row[4]}</td>";
                    echo "<td>";
                    echo "<a href='view.php/?id={$row[0]}'>View</a>";
                    if ($row[1] == $_SESSION["username"]) {
                        echo "<a href='update.php/?id={$row[0]}'>Update</a>";  
                        echo "<a href='delete.php/?id={$row[0]}'>Delete</a>";  
                    }
                    echo "</td>";
                    echo "</tr>";
                }
            ?>
        </tbody>
    </table>
</body>
</html>