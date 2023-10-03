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
 
     $username = mysqli_real_escape_string($conn, $username);
 
     $stmt = mysqli_prepare($conn, "SELECT user_id, username, first_name, last_name, email, is_admin, is_agent, password, is_deleted, agent_phone, agent_company FROM usertbl WHERE username = ?");
     mysqli_stmt_bind_param($stmt, "s", $username);
     mysqli_stmt_execute($stmt);
     $result = mysqli_stmt_get_result($stmt);
 
     if (!$result) {
         return [
             'authenticated' => false,
             'error' => 'Database error.',
         ];
     }
 
     if (mysqli_num_rows($result) === 1) {
         $row = mysqli_fetch_assoc($result);
         $hashedPasswordFromDB = $row['password'];
 
         if ($row['is_deleted']) {
             return [
                 'authenticated' => false,
                 'error' => 'Invalid username or password.',
             ];
         }
 
         if (password_verify($password, $hashedPasswordFromDB)) {
             $userData = [
                 'authenticated' => true,
                 'user_id' => $row['user_id'],
                 'username' => $row['username'],
                 'fullName' => $row['first_name'] . " " . $row['last_name'],
                 'email' => $row['email'],
             ];
 
             if ($row['is_agent']) {
                 $userData['isAgent'] = true;
                 $userData['agentPhone'] = $row['agent_phone'];
                 $userData['agentCompany'] = $row['agent_company'];
             }
             if($row['is_admin']){
                $userData['isAdmin'] = true;
             }
 
             return $userData;
         }
     }
 
     return [
         'authenticated' => false,
         'error' => 'Invalid username or password.',
     ];
 }
 