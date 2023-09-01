<?php
// code to authenticate the user with the database
include_once('database_connect.php'); // Include the database connection

function authenticateUser($username, $password) {
    global $conn;

    // Prepare and execute the database query
    $sql = "SELECT id, username, password FROM login_testing WHERE username = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $username);
    $stmt->execute();
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
