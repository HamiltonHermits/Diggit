<?php
// code to authenticate the user with the database
include_once('config.php');
include_once('database_connect.php'); // Include the database connection

function authenticateUser($username, $password) {
    global $conn;

    // Prepare and execute the database query
    $sql = "SELECT user_id, username, password FROM login_testing WHERE username = ?";
    //ignore
    $stmt = $conn->prepare($sql);
    if (!$stmt) {
        die("Error in SQL query: " . $conn->error);
    }

    $stmt->bind_param("s", $username);
    $stmt->execute();

    if ($stmt->error) {
        die("Error in SQL execution: " . $stmt->error);
    }

    $stmt->bind_result($user_id, $db_username, $db_password);
    $stmt->fetch();
    $stmt->close();

    // Verify the password (assuming you use password_hash)
    //job for cameron - do hashing password_verify($password, $db_password)
    if ($password == $db_password) {
        // Password is correct, user is authenticated
        return [
            'authenticated' => true,
            'user_id' => $user_id,
            'username' => $db_username,
        ];
    } else {
        // Password is incorrect, authentication failed
        return [
            'authenticated' => false,
            'error' => 'Invalid username or password.',
        ];
    }
}
