<?php
// Start the session (if not already started)
session_start();
// Check if a login error message exists
if (isset($_SESSION['login_error'])) {
    $error_message = $_SESSION['login_error'];
    // Clear the error message from the session
    unset($_SESSION['login_error']);
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>Home Page</title>
    <link rel="stylesheet" type="text/css" href="styles.css">
</head>

<body>
    <h1>Logged In</h1>
</body>

</html>