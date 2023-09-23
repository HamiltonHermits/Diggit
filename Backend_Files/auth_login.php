<?php
include_once('database_connect.php');
/**
 * Authenticate a user using their provided username and password.
 *
 * @param string $username The username provided by the user.
 * @param string $password The password provided by the user.
 *
 * @return array An associative array indicating the authentication result.
 *   - 'authenticated': A boolean indicating whether the authentication was successful.
 *   - 'user_id': The user's ID if authenticated.
 *   - 'username': The user's username if authenticated.
 *   - 'error': An error message if authentication failed.
 *
 * Note: Prepared statements should be used to prevent SQL injection.
 */

function authenticateUser($username, $password)
{
    global $conn;

    // Sanitize the username to prevent potential SQL injection
    $username = mysqli_real_escape_string($conn, $username);

    // Retrieve the hashed password from the database for the given username
    $getHashedPasswordQuery = "SELECT user_id, username, first_name, last_name, email ,is_admin , is_agent, password, is_deleted FROM usertbl WHERE username = '$username'";
    //querry the database
    $result = mysqli_query($conn, $getHashedPasswordQuery);

    if (!$result) {
        die("Error in SQL query: " . mysqli_error($conn));
    }

    if (mysqli_num_rows($result) === 1) {
        
        // User found, retrieve the hashed password from the result
        $row = mysqli_fetch_assoc($result);
        $user_id = $row['user_id'];
        $db_username = $row['username'];
        $hashedPasswordFromDB = $row['password'];
        $name = $row['first_name']." ". $row['last_name'];
        $email = $row['email'];
        //agent information
        $isAgent = $row['is_agent'];
        $agentPhone = $row['agent_phone'];
        $agentCompany = $row['agemt_company'];

        //if the user previously had an account with us
        $isDeleted = $row['is_deleted'];

        if ($isDeleted){
            return [
                'authenticated' => false,
                'error' => 'Invalid username or password.',
            ];
        }
        
        // Use password_verify to check if the provided password matches the stored hashed password
        if (password_verify($password, $hashedPasswordFromDB)) {
            if($isAgent){
                return [
                    'authenticated' => true,
                    'user_id' => $user_id,
                    'username' => $db_username,
                    'fullName' => $name,
                    'email' => $email,
                    'isAgent' => true,
                    'agentPhone' => $agentPhone,
                    'agentCompany' => $agentCompany,
                    
                ]; // Passwords match, user authenticated
            }
            return [
                'authenticated' => true,
                'user_id' => $user_id,
                'username' => $db_username,
                'fullName' => $name,
                'email' => $email,
                
            ]; // Passwords match, user authenticated
        }
    }

    // Password is incorrect, authentication failed
    return [
        'authenticated' => false,
        'error' => 'Invalid username or password.',
    ]; // Authentication failed
}
