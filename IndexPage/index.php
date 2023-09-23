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
    unset($_SESSION["newPassword"]);
    unset($_SESSION["confirmPass"]);
    unset($_SESSION['password']);
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
    <script src="index.js" defer></script>
    <script src="../Backend_Files/common.js" defer></script>
    
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
                <button id="openModalBtn"><svg width="24" height="25" viewBox="0 0 24 25" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M4.50202 18.875C5.49597 18.0625 6.60686 17.4219 7.83468 16.9531C9.0625 16.4844 10.3488 16.25 11.6935 16.25C13.0383 16.25 14.3246 16.4844 15.5524 16.9531C16.7802 17.4219 17.8911 18.0625 18.8851 18.875C19.5672 18.0208 20.0983 17.0521 20.4783 15.9688C20.8584 14.8854 21.0484 13.7292 21.0484 12.5C21.0484 9.72917 20.1373 7.36979 18.315 5.42188C16.4928 3.47396 14.2856 2.5 11.6935 2.5C9.10148 2.5 6.89432 3.47396 5.07208 5.42188C3.24983 7.36979 2.33871 9.72917 2.33871 12.5C2.33871 13.7292 2.52873 14.8854 2.90877 15.9688C3.28881 17.0521 3.81989 18.0208 4.50202 18.875ZM11.6935 13.75C10.5437 13.75 9.57409 13.3281 8.78478 12.4844C7.99546 11.6406 7.60081 10.6042 7.60081 9.375C7.60081 8.14583 7.99546 7.10938 8.78478 6.26562C9.57409 5.42188 10.5437 5 11.6935 5C12.8434 5 13.813 5.42188 14.6023 6.26562C15.3916 7.10938 15.7863 8.14583 15.7863 9.375C15.7863 10.6042 15.3916 11.6406 14.6023 12.4844C13.813 13.3281 12.8434 13.75 11.6935 13.75ZM11.6935 25C10.0759 25 8.55578 24.6719 7.13306 24.0156C5.71035 23.3594 4.47278 22.4688 3.42036 21.3438C2.36794 20.2188 1.53478 18.8958 0.920867 17.375C0.306956 15.8542 0 14.2292 0 12.5C0 10.7708 0.306956 9.14583 0.920867 7.625C1.53478 6.10417 2.36794 4.78125 3.42036 3.65625C4.47278 2.53125 5.71035 1.64062 7.13306 0.984375C8.55578 0.328125 10.0759 0 11.6935 0C13.3112 0 14.8313 0.328125 16.254 0.984375C17.6768 1.64062 18.9143 2.53125 19.9667 3.65625C21.0192 4.78125 21.8523 6.10417 22.4662 7.625C23.0801 9.14583 23.3871 10.7708 23.3871 12.5C23.3871 14.2292 23.0801 15.8542 22.4662 17.375C21.8523 18.8958 21.0192 20.2188 19.9667 21.3438C18.9143 22.4688 17.6768 23.3594 16.254 24.0156C14.8313 24.6719 13.3112 25 11.6935 25ZM11.6935 22.5C12.7265 22.5 13.7009 22.3385 14.6169 22.0156C15.5329 21.6927 16.371 21.2292 17.1311 20.625C16.371 20.0208 15.5329 19.5573 14.6169 19.2344C13.7009 18.9115 12.7265 18.75 11.6935 18.75C10.6606 18.75 9.68616 18.9115 8.77016 19.2344C7.85417 19.5573 7.01613 20.0208 6.25605 20.625C7.01613 21.2292 7.85417 21.6927 8.77016 22.0156C9.68616 22.3385 10.6606 22.5 11.6935 22.5ZM11.6935 11.25C12.2003 11.25 12.6193 11.0729 12.9506 10.7187C13.2819 10.3646 13.4476 9.91667 13.4476 9.375C13.4476 8.83333 13.2819 8.38542 12.9506 8.03125C12.6193 7.67708 12.2003 7.5 11.6935 7.5C11.1868 7.5 10.7678 7.67708 10.4365 8.03125C10.1052 8.38542 9.93952 8.83333 9.93952 9.375C9.93952 9.91667 10.1052 10.3646 10.4365 10.7187C10.7678 11.0729 11.1868 11.25 11.6935 11.25Z" fill="#AD5511" />
                    </svg></button>
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
                    <input type="text" id="username" name="username" value="<?php echo isset($_SESSION['username']) ? htmlspecialchars($_SESSION['username']) : ''; ?>" placeholder="Username" required><br>
                    <label for="password" class="modalLabel">Password:</label>
                    <input type="password" id="password" name="password" value="<?php echo isset($_SESSION['password']) ? htmlspecialchars($_SESSION['password']) : ''; ?>" placeholder="Password" required><br>
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
                <span class="back-arrow" style="color:white;" id="backToLoginButton">&#8592;</span>
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
                    <input type="text" id="newUsername" name="newUsername" class="modalInput" value="<?php echo isset($_SESSION['username']) ? htmlspecialchars($_SESSION['username']) : ''; ?>" placeholder="Username" required>
                    <label for="newEmail" class="modalLabel">Email:</label>
                    <input type="email" id="newEmail" name="newEmail" class="modalInput" value="<?php echo isset($_SESSION['email']) ? htmlspecialchars($_SESSION['email']) : ''; ?>" placeholder="example@gmail.com" required>

                    <label for="firstName" class="modalLabel">First Name:</label>
                    <input type="text" id="firstName" name="firstName" class="modalInput" value="<?php echo isset($_SESSION['firstName']) ? htmlspecialchars($_SESSION['firstName']) : ''; ?>" placeholder="e.g: Klark" required>
                    <label for="lastName" class="modalLabel">Last Name:</label>
                    <input type="text" id="lastName" name="lastName" class="modalInput" value="<?php echo isset($_SESSION['lastName']) ? htmlspecialchars($_SESSION['lastName']) : ''; ?>" placeholder="e.g: Kent" required>

                    <label for="newPassword" class="modalLabel">Password:</label>
                    <input type="password" id="newPassword" name="newPassword" class="modalInput" value="<?php echo isset($_SESSION['newPassword']) ? htmlspecialchars($_SESSION['newPassword']) : ''; ?>" placeholder="Password" required>
                    <label for="passwordConfirm" class="modalLabel">Confirm Password:</label>
                    <input type="password" id="passwordConfirm" name="passwordConfirm" class="modalInput" value="<?php echo isset($_SESSION['confirmPass']) ? htmlspecialchars($_SESSION['confirmPass']) : ''; ?>" placeholder="Confirm Password" required>
                    <input type="submit" id="submitSignup" value="Signup">
                </form>
            </div>
        </div>

        <!-- The profile modal (hidden by default) -->
        <div id="profileModal" class="modal">
            <div class="modal-content">

                <?php if (isset($profileMessage)) { ?>
                    <p><?php echo $profileMessage; ?></p>
                    <?php echo '<script>profileModal.style.display = "block";</script>'; ?>
                <?php } ?>

                <span class="close" id="closeModalBtn">&times;</span>
                <img id="profileImage" style="max-width: 10vh;" src="ImagesIndex/User.png" alt="Profile Picture">

                <h2 id="usernameProfile" class="modalLabel">Hello, <?php if (isset($_SESSION['username'])) echo $_SESSION['username']; ?></h2>
                <!-- <p id="fullNameProfile" class = "modalLabel">Fullname: <?php if (isset($_SESSION['fullName'])) /*echo $_SESSION['fullName'];*/ ?></p> -->
                <p id="emailProfile" class="modalLabel"><?php if (isset($_SESSION['email'])) echo $_SESSION['email']; ?></p>
                <p id="userType" class="modalLabel"><?php if (isset($_SESSION["userType"])) echo $_SESSION["userType"]; ?></p>
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
                <span class="back-arrow" style="color:white;" id="backToProfile">&#8592;</span>

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

    
</body>

</html>