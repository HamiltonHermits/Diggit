<?php
// Start the session (if not already started)
session_start();

$login_username_value = "";
$signup_username_value = "";
$signup_email_value = "";

$isAuthenticated = false;
// Check if a login error message exists
if (isset($_SESSION['login_error'])) {
    $login_error_message = $_SESSION['login_error'];

    $login_username_value = isset($_SESSION['username']) ? $_SESSION['username'] : "";
    // Clear the error message from the session
    unset($_SESSION['login_error']);
}
if (isset($_SESSION['signup_error'])) {
    $signup_error_message = $_SESSION['signup_error'];
    $signup_username_value = isset($_SESSION['username']) ? $_SESSION['username'] : "";
    $signup_email_value = isset($_SESSION['email']) ? $_SESSION['email'] : "";
    // Clear the error message from the session
    unset($_SESSION['signup_error']);
}
if (isset($_SESSION['authenticated']) && $_SESSION['authenticated'] === true) {
    // User is authenticated, show authenticated content
    $isAuthenticated = true;
}

if (isset($_SESSION['changePasswordError'])) {
    $changePasswordError = $_SESSION['changePasswordError'];
    unset($_SESSION['changePasswordError']);
}
if (isset($_SESSION['profileMessage'])) {
    $profileMessage = $_SESSION['profileMessage'];
    unset($_SESSION['changePasswordError']);
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DiggIt</title>
    <link rel="stylesheet" href="stylesIndex.css">
    <script defer src="index.js"></script>
</head>
<nav class="nav" id="nav">
    <div class="navContainer" id="navContainer">
        <div class="dash" id="dash"><svg viewBox="0 0 61 50" fill="none" xmlns="http://www.w3.org/2000/svg">
                <mask id="mask0_30_602" style="mask-type:alpha" maskUnits="userSpaceOnUse" x="0" y="0" width="61" height="50">
                    <rect width="61" height="50" fill="#D9D9D9" />
                </mask>
                <g mask="url(#mask0_30_602)">
                    <path d="M10.1665 31.25V27.0833H50.8332V31.25H10.1665ZM10.1665 22.9167V18.75H50.8332V22.9167H10.1665Z" fill="#E96B09" fill-opacity="0.7" />
                </g>
            </svg>
        </div>
        <!-- Personalised Search page if authenticated-->
        <?php if ($isAuthenticated) : ?>

            <div class="profileContainer" id="profile">
                <button id="openModalBtn">Open Profile Modal</button>
            </div>

        <?php else : ?>

            <div class="loginContainer" id="login">
                <button type="menu" class="loginButton" id="loginButton">Log in</button>
            </div>

        <?php endif; ?>
    </div>
</nav>

<body>
    <div class="mainContainer" id="mainContainer">
        <div class="logoContainer" id="logoContainer">
            <img class="mainLogoImage" id="mainLogoImage" src="./ImagesIndex/mainLogo.png">
        </div>
        <div class="searchBarContainer" id="searchBarContainer">
            <div class="borderSearchBar" id="borderSearchBar">
                <button type="submit" class="searchButton" id="searchButton">
                    <svg class="svgSearch" viewBox="0 0 28 28" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M19.6705 16.5218L19.6773 16.5121L19.6837 16.5021C20.709 14.8889 21.3112 12.9735 21.3112 10.9149C21.3112 5.16412 16.6544 0.499512 10.9089 0.499512C5.15702 0.499512 0.5 5.1639 0.5 10.9149C0.5 16.6656 5.15681 21.3302 10.9023 21.3302C12.9878 21.3302 14.9306 20.7146 16.5581 19.6615L16.5651 19.6569L16.572 19.6522L16.6779 19.5785L23.4524 26.3531L23.8091 26.7098L24.1626 26.3499L26.3567 24.1169L26.7038 23.7635L26.3537 23.413L19.5871 16.6402L19.6705 16.5218ZM16.1022 5.72806C17.4862 7.1121 18.2474 8.95104 18.2474 10.9084C18.2474 12.8657 17.4862 14.7046 16.1022 16.0887C14.7181 17.4727 12.8792 18.2339 10.9219 18.2339C8.96454 18.2339 7.1256 17.4727 5.74157 16.0887C4.35754 14.7046 3.59635 12.8657 3.59635 10.9084C3.59635 8.95104 4.35754 7.1121 5.74157 5.72806C7.1256 4.34403 8.96455 3.58284 10.9219 3.58284C12.8792 3.58284 14.7181 4.34403 16.1022 5.72806Z" fill="#AD5511" stroke="#AD5511" />
                    </svg>
                </button>
                <input id="searchbar" type="text" class="searchTerm" spellcheck="false" placeholder="Find your Digs..">
            </div>
            <div id="dropdown" class="dropdown-content"></div>
        </div>

        <!-- The login modal -->
        <div id="loginModal" class="modal" style="display:none;">
            <div class="modal-content">
                <span class="close" id="closeButton">&times;</span>
                <h2 class="modalLabel">Login</h2>

                <!-- Display the error message if it exists -->

                <?php if (isset($login_error_message)) { ?>
                    <p><?php echo $login_error_message; ?></p>
                    <?php echo '<script>loginModal.style.display = "block";</script>'; ?>
                <?php } ?>

                <form id="loginForm" action="../Backend_Files/login.php" method="POST">
                    <!-- Login form fields -->
                    <label for="username" class="modalLabel">Username:</label>
                    <input type="text" id="username" name="username" value="<?php echo htmlspecialchars($login_username_value); ?>" placeholder="Username" required><br>
                    <label for="password" class="modalLabel">Password:</label>
                    <input type="password" id="password" name="password" placeholder="Password" required><br>
                    <input type="submit" id="submitLogin" value="Login">
                </form>

                <!-- Add a button to open the signup modal -->
                <button id="signupButton">Signup</button>
            </div>
        </div>

        <!-- The signup modal (hidden by default) -->
        <div id="signupModal" class="modal" style="display: none;">

            <div class="modal-content">
                <span class="close" id="closeSignupButton">&times;</span>
                <h2 class="modalLabel">Signup</h2>

                <!-- Display the error message if it exists -->

                <?php if (isset($signup_error_message)) { ?>
                    <p><?php echo $signup_error_message; ?></p>
                    <?php echo '<script>signupModal.style.display = "block";</script>'; ?>
                <?php } ?>

                <!-- Signup form fields -->
                <form id="signupForm" action="../Backend_Files/signUp.php" method="POST">
                    <!-- Signup form fields -->
                    <label for="newUsername" class="modalLabel">Username:</label>
                    <input type="text" id="newUsername" name="newUsername" value="<?php echo htmlspecialchars($signup_username_value); ?>" placeholder="Username" required><br>
                    <label for="newEmail" class="modalLabel">Email:</label>
                    <input type="email" id="newEmail" name="newEmail" value="<?php echo htmlspecialchars($signup_email_value); ?>" placeholder="example@gmail.com" required><br>

                    <label for="firstName" class="modalLabel">First Name:</label>
                    <input type="text" id="firstName" name="firstName" placeholder="e.g: Klark" required><br>
                    <label for="lastName" class="modalLabel">Last Name:</label>
                    <input type="text" id="lastName" name="lastName" placeholder="e.g: Kent" required><br>

                    <label for="newPassword" class="modalLabel">Password:</label>
                    <input type="password" id="newPassword" name="newPassword" placeholder="Password" required><br>
                    <label for="passwordConfirm" class="modalLabel">Confirm Password:</label>
                    <input type="password" id="passwordConfirm" name="passwordConfirm" placeholder="Confirm Password" required><br>
                    <input type="submit" id="submitSignup" value="Signup">
                </form>
            </div>
        </div>

        <!-- The profile modal (hidden by default) -->
        <div id="profileModal" class="modal">
            <div class="modal-content">

                <?php if (isset($$profileMessage)) { ?>
                    <p><?php echo $$profileMessage; ?></p>
                    <?php echo '<script>profileModal.style.display = "block";</script>'; ?>
                <?php } ?>

                <span class="close" id="closeModalBtn">&times;</span>
                <img id="profileImage" style="max-width: 10vh;" src="ImagesIndex/User.png" alt="Profile Picture">
                <h2 id="username"><?php if (isset($_SESSION['username'])) echo $_SESSION['username']; ?></h2>
                <p id="fullName"><?php if (isset($_SESSION['fullName'])) echo $_SESSION['fullName']; ?></p>
                <p id="email"><?php if (isset($_SESSION['email'])) echo $_SESSION['email']; ?></p>

                <button id="changePasswordBtn">Change Password</button>

                <button id="deleteProfileBtn">Delete Profile</button>

                <form action="../Backend_Files/logout.php" method="post">
                    <button type="submit" class="loginButton">Logout</button>
                </form>
            </div>
        </div>

        <!-- Change Password Modal -->
        <div id="changePasswordModal" class="modal">
            <div class="modal-content">

                <?php if (isset($changePasswordError)) { ?>
                    <p><?php echo $changePasswordError; ?></p>
                    <?php echo '<script>changePasswordModal.style.display = "block";</script>'; ?>
                <?php } ?>

                <span class="close" id="closeChangePasswordModalBtn">&times;</span>
                <h2>Change Password</h2>
                <form id="changePasswordForm" action="../Backend_Files/change_password.php" method="post">
                    <label for="currentPassword">Current Password:</label>
                    <input type="password" id="currentPassword" name="currentPassword" required>

                    <label for="changeNewPassword">New Password:</label>
                    <input type="password" id="changeNewPassword" name="changeNewPassword" required>

                    <label for="confirmPassword">Confirm New Password:</label>
                    <input type="password" id="confirmPassword" name="confirmPassword" required>

                    <button type="submit">Change Password</button>
                </form>
            </div>
        </div>
        <!-- Confirm Delete Modal -->
        <div id="confirmDeleteModal" class="modal">
            <div class="modal-content">
                <span class="close" id="closeDeleteModalBtn">&times;</span>
                <h2>Confirm Delete</h2>
                <p>Are you sure you want to delete your profile?</p>
                <form action="../Backend_Files/deleteProfile.php" method="post">
                    <button type="submit" class="deleteButton">Yes, Delete</button>
                </form>
                <button id="cancelDeleteBtn">Cancel</button>
            </div>
        </div>

    </div>

    <script src="index.js"></script>
</body>

</html>