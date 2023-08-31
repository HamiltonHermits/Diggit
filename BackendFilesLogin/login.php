<?php

// Server-side PHP script for processing login
include_once('config.php');
include_once('database_connect.php');
include_once('auth.php');

// Check if the login form was submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve user input (e.g., username and password)
    $username = $_POST["username"];
    $password = $_POST["password"];

    //authenticate the user with your db 
    $authResult = authenticateUser($username, $password);

    // Validate user credentials (you would perform actual validation)
    if ($authResult['authenticated']) {
        // Valid credentials, set up a session or store user information in cookies
        session_start();
        $_SESSION["user_id"] = $authResult['user_id'];
        $_SESSION["username"] = $authResult['username'];
        
        // Redirect to a secure page (e.g., whatever page they were on)
        header("Location: landing_page_temp.php");
        exit();
    } else {
        // Invalid credentials, display an error message
        $error_message = $authResult['error'];
    }
}
?>

<!-- HTML for displaying the login form (you can customize the form here) -->
<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
    <link rel="stylesheet" type="text/css" href="styles.css">
</head>
<body>
    <h1>Login</h1>
    <?php if (isset($error_message)) { ?>
        <p><?php echo $error_message; ?></p>
    <?php } ?>
    <form id="loginForm" action="login.php" method="POST">
        <!-- Login form fields -->
        <label for="username">Username or Email:</label>
        <input type="text" id="username" name="username" required><br>
        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required><br>
        <input type="submit" value="Login">
    </form>
</body>
</html>