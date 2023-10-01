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


function registerUser($username, $password, $email, $firstname, $lastname)
{
    global $conn;

    // Sanitize and validate input
    $username = mysqli_real_escape_string($conn, $username);
    $email = mysqli_real_escape_string($conn, $email);

    // Check if the username or email already exists
    $checkUsernameQuery = "SELECT * FROM usertbl WHERE username = ? OR email = ?";
    $stmt = mysqli_prepare($conn, $checkUsernameQuery);
    mysqli_stmt_bind_param($stmt, "ss", $username, $email);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if (!$result) {
        return array('registered' => false, 'error' => 'Database error: ' . mysqli_error($conn));
    }

    if (mysqli_num_rows($result) > 0) {
        return array('registered' => false, 'error' => 'Username or email already exists.');
    }

    // Perform password strength test using function isPasswordStrong($password)
    $pStrengthCheck = isPasswordStrong($password);

    if (!$pStrengthCheck['strong_password']) {
        return array('registered' => false, 'error' => $pStrengthCheck['error']);
    }

    // Hash the password securely
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    // Insert the new user into the database using prepared statement
    $insertUserQuery = "INSERT INTO usertbl (username, password, first_name, last_name, is_admin, is_agent, email, is_deleted) 
     VALUES (?, ?, ?, ?, '0', '0', ?, '0')";
    $stmt = mysqli_prepare($conn, $insertUserQuery);
    mysqli_stmt_bind_param($stmt, "sssss", $username, $hashedPassword, $firstname, $lastname, $email);
    $result = mysqli_stmt_execute($stmt);

    if ($result) {
        $user_id = mysqli_insert_id($conn);
        return array(
            'registered' => true,
            'user_id' => $user_id,
            'username' => $username,
            'fullName' => $firstname . " " . $lastname,
            'email' => $email
        );
    } else {
        return array('registered' => false, 'error' => 'Registration failed: ' . mysqli_error($conn));
    }
}

function reRegisterUser($user_id, $username, $password, $email, $firstname, $lastname)
{
    global $conn;

    // Sanitize and validate input
    $username = mysqli_real_escape_string($conn, $username);
    $email = mysqli_real_escape_string($conn, $email);

    // Perform password strength test using function isPasswordStrong($password)
    $pStrengthCheck = isPasswordStrong($password);

    if (!$pStrengthCheck['strong_password']) {
        return array('registered' => false, 'error' => $pStrengthCheck['error']);
    }

    // Hash the password securely
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    // Update the user information using prepared statement
    $updateQuery = "UPDATE usertbl
        SET 
        username = ?,
        password = ?,
        first_name = ?,
        last_name = ?,
        is_admin = '0',
        is_agent = '0',
        email = ?,
        is_deleted = '0'
        WHERE
        user_id = ?";

    $stmt = mysqli_prepare($conn, $updateQuery);
    mysqli_stmt_bind_param($stmt, "sssssi", $username, $hashedPassword, $firstname, $lastname, $email, $user_id);
    $result = mysqli_stmt_execute($stmt);

    if ($result) {
        return array(
            'registered' => true,
            'user_id' => $user_id,
            'username' => $username,
            'fullName' => $firstname . " " . $lastname,
            'email' => $email
        );
    } else {
        return array('registered' => false, 'error' => 'Update failed: ' . mysqli_error($conn));
    }
}
