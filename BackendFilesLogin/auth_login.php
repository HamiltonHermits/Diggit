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

      // Sanitize the username to prevent potential SQL injection
      $username = mysqli_real_escape_string($conn, $username);

      // Retrieve the hashed password from the database for the given username
      $getHashedPasswordQuery = "SELECT password FROM login_testing WHERE username = ?";
      $stmt = $conn->prepare($getHashedPasswordQuery);
      $stmt->bind_param("s", $username);
      $stmt->execute();
      $result = $stmt->get_result();
  
      if ($result->num_rows === 1) {
          // User found, retrieve the hashed password from the result
          $row = $result->fetch_assoc();
          $hashedPasswordFromDB = $row['password'];
  
          // Use password_verify to check if the provided password matches the stored hashed password
          if (password_verify($password, $hashedPasswordFromDB)) {
            return [
                'authenticated' => true,
                'user_id' => $user_id,
                'username' => $db_username,
            ]; // Passwords match, user authenticated
          }
      }
  
      // Password is incorrect, authentication failed
      return [
        'authenticated' => false,
        'error' => 'Invalid username or password.',
    ]; // Authentication failed
  }
    
?>
