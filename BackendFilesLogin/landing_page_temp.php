<?php
// Start the session (if not already started)
session_start();
// Check if a login error message exists
if (isset($_SESSION['login_error'])) {
    $login_error_message = $_SESSION['login_error'];

    // Clear the error message from the session
    unset($_SESSION['login_error']);
}
if (isset($_SESSION['signup_error'])) {
    $signup_error_message = $_SESSION['signup_error'];

    // Clear the error message from the session
    unset($_SESSION['signup_error']);
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

            <?php if (isset($login_error_message)) { ?>
                <p><?php echo $login_error_message; ?></p>
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

            <!-- Add a button to open the signup modal -->
            <button id="signupButton">Signup</button>
        </div>
    </div>

    <!-- The signup modal (hidden by default) -->
    <div id="signupModal" class="modal" style="display: none;">
        <div class="modal-content">
            <span class="close" id="closeSignupButton">&times;</span>
            <h2>Signup</h2>

            <!-- Display the error message if it exists -->

            <?php if (isset($signup_error_message)) { ?>
                <p><?php echo $signup_error_message; ?></p>
                <?php echo '<script>signupModal.style.display = "block";</script>'; ?>
            <?php } ?>

            <!-- Example signup form -->
            <form id="signupForm" action="signup.php" method="POST">
                <!-- Signup form fields -->
                <label for="newUsername">Username:</label>
                <input type="text" id="newUsername" name="newUsername" required><br>
                <label for="newPassword">Password:</label>
                <input type="password" id="newPassword" name="newPassword" required><br>
                <input type="submit" value="Signup">
            </form>
        </div>
    </div>

    <!-- Your existing JavaScript code -->

    <script src="login_signup_modal_script.js"></script>
</body>

</html>