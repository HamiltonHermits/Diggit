<?php

// Include necessary files (similar to login.php)
include_once('config.php');
include_once('database_connect.php');
include_once('auth_signup.php'); 

// You'll need to create this file for user registration

/**
 * Server-side PHP script for processing user registration
 *
 * @param $registrationResult An associative array with registration status and user information.
 */

// Check if the registration form was submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    error_log("we got into signup");
    // Check if the required form fields exist in $_POST
    if (isset($_POST["newUsername"]) && isset($_POST["newPassword"])) {
       
        // Retrieve user input (e.g., username and password)
        $username = $_POST["newUsername"];
        $password = $_POST["newPassword"];


        // Perform user registration using a function (auth_signup) similar to authentication
        $registrationResult = registerUser($username, $password);

        // Validate the registration result (you would perform actual validation)
        if ($registrationResult['registered']) {
            // Registration successful, set up a session or handle as needed
            session_start();
            $_SESSION["user_id"] = $registrationResult['user_id'];
            $_SESSION["username"] = $registrationResult['username'];
            $_SESSION["authenticated"] = true;

            // Redirect to a secure page (e.g., user profile)
            header("Location: logged_in_page.php");
            exit();
        } else {
            // Registration failed, provide an error message
            session_start();
            $_SESSION["authenticated"] = false;
            $_SESSION['signup_error'] = $registrationResult['error'];
            header("Location: landing_page_temp.php"); // Redirect to the signup page
            exit;
        }
    } else {
        // Required fields not provided in the form
        session_start();
        $_SESSION["authenticated"] = false;
        $_SESSION['signup_error'] = "Username and password are required.";
        header("Location: landing_page_temp.php"); // Redirect to the signup page
        exit;
    }
} else {
    // Invalid request method
    session_start();
    $_SESSION["authenticated"] = false;
    $_SESSION['signup_error'] = "Invalid request method.";
    header("Location: landing_page_temp.php"); // Redirect to the signup page
    exit;
}
?>