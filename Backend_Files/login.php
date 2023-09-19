<?php
include_once('auth_login.php');
/**
 * Server-side PHP script for user login processing.
 *
 * Variables Used:
 *   - $_SERVER: Superglobal array containing server environment and request info.
 *   - $_POST: Superglobal array containing data from HTTP POST request.
 *   - $username: User-provided username from the login form.
 *   - $password: User-provided password from the login form.
 *   - $authResult: Associative array with authentication status.
 *
 * Variables Assigned:
 *   - $_SESSION: Superglobal array for storing user session data.
 */
// Check if the login form was submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if the 'username' and 'password' keys exist in $_POST
    if (isset($_POST["username"]) && isset($_POST["password"])) {

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
            $_SESSION["fullName"] = $authResult['fullName'];
            $_SESSION["email"] = $authResult['email'];


            $_SESSION["authenticated"] = true;


            // Redirect to a secure page (e.g., whatever page they were on)
            header("Location: ../IndexPage/index.php");
            exit();
        } else {
            session_start();
            // Invalid credentials, sends through error message in the session

            $_SESSION["authenticated"] = false;
            $_SESSION['login_error'] = $authResult['error'];
            header("Location: ../IndexPage/index.php");

            exit;
        }
    } else {
        // 'username' or 'password' not provided in the form
        $_SESSION["authenticated"] = false;
        $_SESSION['login_error'] = "Username and password are required.";
        header("Location: ../IndexPage/index.php");
        exit;
    }
} else {
    // Invalid request method
    $_SESSION["authenticated"] = false;
    $_SESSION['login_error'] = "Invalid request method.";
    header("Location: ../IndexPage/index.php");
    exit;
}
