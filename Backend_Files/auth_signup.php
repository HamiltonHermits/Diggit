<?php
include_once('database_connect.php');
include_once('password_check.php');
/**
 * Server side function that registered the user with the database
 * 
 * Variables Used:
 *   - $conn: The database connection object (assuming you have a database connection in database_connect.php).
 *   - $checkUsernameQuery: SQL query to check if the username already exists.
 *   - $result: The result of executing the username check query.
 *   - $pStrengthCheck: Result of the password strength check using the isPasswordStrong function.
 *   - $hashedPassword: The hashed password to be stored in the database.
 *   - $insertUserQuery: SQL query to insert the new user into the database.
 *   - $user_id: The ID of the newly registered user.
 * 
 * @return array An associative array with registration status and user information.
 */

function registerUser($username, $password)
{
    global $conn; // Assuming you have a database connection in database_connect.php

    // Sanitize the username to prevent potential SQL injection
    $username = mysqli_real_escape_string($conn, $username);

    // Check if the username already exists
    $checkUsernameQuery = "SELECT * FROM login_testing WHERE username = '$username'";
    $result = mysqli_query($conn, $checkUsernameQuery);

    if (!$result) {
        // Error occurred during query execution
        return array('registered' => false, 'error' => 'Database error.');
    }

    if (mysqli_num_rows($result) > 0) {
        // Username already exists, return an error
        return array('registered' => false, 'error' => 'Username already exists.');
    }

    // Perform password strength test using function isPasswordStrong($password)
    $pStrengthCheck = isPasswordStrong($password);

    if (!$pStrengthCheck['strong_password']) {
        return array('registered' => false, 'error' => $pStrengthCheck['error']);
    }

    // Hash the password securely
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    // Insert the new user into the database
    $insertUserQuery = "INSERT INTO login_testing (username, password) VALUES ('$username', '$hashedPassword')";

    if (mysqli_query($conn, $insertUserQuery)) {
        // Registration successful, return user information
        $user_id = mysqli_insert_id($conn);
        return array('registered' => true, 'user_id' => $user_id, 'username' => $username);
    } else {
        // Registration failed, return an error
        return array('registered' => false, 'error' => 'Registration failed.');
    }
}
?>
