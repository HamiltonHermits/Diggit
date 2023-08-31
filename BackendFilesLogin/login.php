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
        $_SESSION["authenticated"] = true;


        // Redirect to a secure page (e.g., whatever page they were on)
        header("Location: Logged_In_Page.php");
        exit();
    } else {
        session_start();
        // Invalid credentials, sends through error message in the session
        
        $_SESSION["authenticated"] = false;
        $_SESSION['login_error'] = "Invalid username or password.";
        header("Location: landing_page_temp.php");
        
        exit;
    }
}
