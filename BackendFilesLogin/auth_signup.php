<?php
// Include necessary files and configurations (similar to other scripts)
include_once('config.php');
include_once('database_connect.php');
include_once('password_check.php');
/**
 * Register a new user in the database.
 *
 * @param string $username The username provided by the user.
 * @param string $password The password provided by the user.
 *
 * @return array An associative array with registration status and user information.
 */
function registerUser($username, $password)
{
    global $conn; // Assuming you have a database connection in database_connect.php
    
    // Sanitize the username to prevent potential SQL injection
    $username = mysqli_real_escape_string($conn, $username);

    // Check if the username already exists
    $checkUsernameQuery = "SELECT * FROM login_testing WHERE username = ?";
    $stmt = $conn->prepare($checkUsernameQuery);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Username already exists, return an error
        return array('registered' => false, 'error' => 'Username already exists.');
    }

    //Perform password strength test using function isPasswordStrong($password) whcih returns an array with true and false and erro message 
    $pStrengthCheck = isPasswordStrong($password);

    if(!$pStrengthCheck['strong_password']){
        return array('registered' => false, 'error' => $pStrengthCheck['error']);
    }

    // Hash the password
    //$hashedPassword = password_hash($password, PASSWORD_BCRYPT);

    // Insert the new user into the database
    $insertUserQuery = "INSERT INTO login_testing (username, password) VALUES (?, ?)";

    $stmt = $conn->prepare($insertUserQuery);
    $stmt->bind_param("ss", $username, $password);
    
    if ($stmt->execute()) {
        // Registration successful, return user information
        $user_id = $stmt->insert_id;
        return array('registered' => true, 'user_id' => $user_id, 'username' => $username);
    } else {
        // Registration failed, return an error
        return array('registered' => false, 'error' => 'Registration failed.');
    }
    
}
