<?php
    // import server configuration file
    require_once "config.php";

    // Initialize variables as empty
    $username = $password = "";
    $username_err = $password_err = "";

    // listens for post requests 
    if( $_SERVER["REQUEST_METHOD"] == "POST" ) {
        $username = trim($_POST["username"]);
        $password = trim($_POST["password"]);

        // validates username against alphanumeric values, length of 4 to 25, and checks if username is taken
        if(preg_match('/[\w]{4,25}/', $username)) {
            $sql = "SELECT id FROM users_table WHERE username = ?";
            
            if($stmt = mysqli_prepare($link, $sql)) {
                mysqli_stmt_bind_param($stmt, "s", $param_username);
                $param_username = $username;
                
                if(mysqli_stmt_execute($stmt)) {
                    mysqli_stmt_store_result($stmt);

                    if(mysqli_stmt_num_rows($stmt) == 0) {
                        $username_err = "You do not have an account, please register.";
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
            $password_err = "Please enter a valid password.";
        }
        
        // none of the error messages were raised
        if (empty($username_err) && empty($password_err)) {
            $sql = "SELECT password FROM users_table WHERE username = ?";
            // "INSERT INTO users_table (username, password) VALUES (?, ?)";
        if ( $stmt = mysqli_prepare($link, $sql) ) {
            mysqli_stmt_bind_param($stmt, "s", $param_username);
            $param_username = $username;
            // $param_password = password_hash($password, PASSWORD_DEFAULT); // hash password
            if (mysqli_stmt_execute($stmt) ) {
                mysqli_stmt_store_result($stmt);
            
                // Bind the result variable
                mysqli_stmt_bind_result($stmt, $db_password);

                if (mysqli_stmt_fetch($stmt) && password_verify($password, $db_password)) {
                    echo "Login successful";
                }
                else{
                    echo "Login unsuccessful";
                    $password_err = "Password incorrect, please try again.";
                }
            } 
            else{
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
    <title>Login: Music DB</title>
</head>
<body>
    <h1>Welcome back to Music DB!</h1>
    <p>Please input your username and password to login!</p>
    <form method="POST" action="<?=htmlspecialchars($_SERVER["PHP_SELF"]);?>">
        <div>
            <label for="username">Username</label>
            <input type="text" id="username" name="username">
            <br>
            <span class="help-block"><?= $username_err; ?></span>
        </div>
        <div>
            <label for="password">Password</label>
            <input type="password" id="password" name="password">
            <br>
            <span class="help-block"><?= $password_err; ?></span>
        </div>
        <button type="submit">Submit</button>
        <button type="reset">Reset</button>
    </form>
    <p>Need to create an Account? <a href="register.php">Register here</a>.</p>
</body>
</html>