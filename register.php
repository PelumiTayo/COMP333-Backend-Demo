<?php
    // import server configuration file
    require_once "config.php";

    // Initialize variables as empty
    $username = $password = $confirm_password = "";
    $username_err = $password_err = $confirm_password_err = "";

    // listens for post requests 
    if( $_SERVER["REQUEST_METHOD"] == "POST" ) {
        $username = trim($_POST["username"]);
        $password = trim($_POST["password"]);
        $confirm_password = trim($_POST["confirm-password"]);

        // validates username against alphanumeric values, length of 4 to 25, and checks if username is taken
        if(preg_match('/[\w]{4,25}/', $username)) {
            $sql = "SELECT id FROM users_table WHERE username = ?";
            
            if($stmt = mysqli_prepare($link, $sql)) {
                mysqli_stmt_bind_param($stmt, "s", $param_username);
                $param_username = $username;
                
                if(mysqli_stmt_execute($stmt)) {
                    mysqli_stmt_store_result($stmt);

                    if(mysqli_stmt_num_rows($stmt) != 0) {
                        $username_err = "This username is already taken.";
                    } 
                } 
                else {
                    echo "Oops! Something went wrong. Please try again later.";
                }
            }
            mysqli_stmt_close($stmt);
        } 

        // if validation fails, set username error to prompt the user to use alphanumeric values
        else {
            $username_err = "Please enter a username with alphabets and numbers";
        }

        // validates password against alphanumeric values, length of 4 to 25
        if (!preg_match('/[\w]{4,25}/', $password)) {
            $password_err = "Please enter a password.";
        }

        // checks if password and confirm-password match
        if ($confirm_password != $password) {
            $confirm_password_err = "passwords do not match";
        }
        
        // none of the error messages were raised
        if ( empty($username_err) && empty($password_err) && empty($confirm_password_err) ) {
            $sql = "INSERT INTO users_table (username, password) VALUES (?, ?)";
        if ( $stmt = mysqli_prepare($link, $sql) ) {
            mysqli_stmt_bind_param($stmt, "ss", $param_username, $param_password);
            $param_username = $username;
            $param_password = password_hash($password, PASSWORD_DEFAULT); // hash password
            if( mysqli_stmt_execute($stmt) ) {
                header("location: login.php");
            } else{
                echo "Something went wrong. Please try again later.";
            }
        }
        mysqli_stmt_close($stmt);
    }
    mysqli_close($link);
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Backend_Demo</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
</head>
<body>
    <h1>Welcome to Music DB!</h1>
    <p>Please fill this form to create an account</p>
    <form method="POST" action="<?=htmlspecialchars($_SERVER["PHP_SELF"]);?>">
        <div>
            <label for="username">Username</label>
            <input type="text" id="username" name="username">
            <span class="help-block"><?= $username_err; ?></span>
        </div>
        <div>
            <label for="password">Password</label>
            <input type="password" id="password" name="password">
            <span class="help-block"><?= $password_err; ?></span>
        </div>
        <div>
            <label for="confirm-password">Confirm Password</label>
            <input type="password" id="confirm-password" name="confirm-password">
            <span class="help-block"><?= $confirm_password_err; ?></span>
        </div>
        <button type="submit">Submit</button>
        <button type="reset">Reset</button>
    </form>
    <p>Already have an account? <a href="login.php">Login here</a>.</p>
</body>
</html>