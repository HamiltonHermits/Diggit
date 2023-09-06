<?php
session_start(); // Start the session

if (isset($_SESSION['authenticated']) && $_SESSION['authenticated'] === true) {
    // Unset all session variables
    $_SESSION = array();
    // Destroy the session
    session_destroy();
    // Redirect the user to a logout confirmation page or login page
    header("Location: ../IndexPage/index.php");
    exit(); // Important to stop further execution
}