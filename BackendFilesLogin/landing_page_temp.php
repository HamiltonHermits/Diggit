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
    <h1>Welcome to the Home Page</h1>

    <!-- Login button -->
    <button id="loginButton">Login</button>

    <!-- The login modal -->
    <div id="loginModal" class="modal">
        <div class="modal-content">
            <span class="close" id="closeButton">&times;</span>
            <h2>Login</h2>

            <!-- Display the error message if it exists -->

            <?php if (isset($error_message)) { ?>
                <p><?php echo $error_message; ?></p>
                <?php echo '<script>loginModal.style.display = "block";</script>'; ?>
            <?php } ?>

            <form id="loginForm" action="login.php" method="POST">
                <!-- Login form fields -->
                <label for="username">Username or Email:</label>
                <input type="text" id="username" name="username" required><br>
                <label for="password">Password:</label>
                <input type="password" id="password" name="password" required><br>
                <input type="submit" value="Login">
            </form>
        </div>
    </div>

    <script src="login_modal_script.js"></script>
</body>

</html>