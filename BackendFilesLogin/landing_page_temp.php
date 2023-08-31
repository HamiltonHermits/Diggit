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

    <script src="script.js"></script>
</body>

</html>