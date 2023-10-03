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
    <link rel="stylesheet" href="../generic.css" />
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
    <div id="outer-index-sidebar-container">
        <div id="index-sidebar-container">
            <div id="menu-sidebar-container">
                <div id="menu-sidebar"><strong>Menu</strong></div>
                <button id="close-sidebar-btn"><strong>x</strong></button>
            </div>
            <div id="middle-sidebar-container">
                <a href="../CreatePropertyPage/create.php" id="add-property-sidebar">
                    <div class="icon">
                        <svg width="30" height="30" viewBox="0 0 40 42" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <mask id="mask0_30_336" style="mask-type:alpha" maskUnits="userSpaceOnUse" x="0" y="0" width="40" height="42">
                                <rect x="0.0161133" y="0.962891" width="39" height="40.0435" fill="#202024" />
                            </mask>
                            <g mask="url(#mask0_30_336)">
                                <path d="M31.7927 25.9399V12.4857L24.0143 6.86243L16.2762 12.4857V16.9427H12.4474V10.4863L24.0143 1.94727L35.6214 10.4697V25.9399H31.7927ZM24.5785 15.1932H26.6742V13.0689H24.5785V15.1932ZM21.3543 15.1932H23.45V13.0689H21.3543V15.1932ZM24.5785 18.5255H26.6742V16.4012H24.5785V18.5255ZM21.3543 18.5255H23.45V16.4012H21.3543V18.5255ZM23.047 39.1442L10.9965 35.562V37.7697H0.920898V19.4419H14.4626L24.9009 23.524C25.7876 23.8572 26.5399 24.4126 27.1579 25.1902C27.7759 25.9677 28.0848 27.0507 28.0848 28.4392H31.7524C33.1204 28.4392 34.2752 28.8071 35.2167 29.543C36.1582 30.2789 36.629 31.4521 36.629 33.0628V34.8955L23.047 39.1442ZM4.26601 34.3124H7.57082V22.8992H4.26601V34.3124ZM22.8858 35.562L33.2033 32.313C33.0152 31.7854 32.8039 31.4244 32.5693 31.23C32.3348 31.0356 32.0605 30.9384 31.7465 30.9384H23.3694C22.644 30.9384 21.9051 30.8829 21.1528 30.7718C20.4005 30.6607 19.7691 30.5219 19.2586 30.3553L15.9538 29.2723L16.8404 26.8563L19.6213 27.8144C20.4005 28.0643 21.0876 28.2309 21.6827 28.3142C22.2777 28.3975 23.243 28.4392 24.5785 28.4392C24.5785 28.1059 24.5181 27.7797 24.3972 27.4603C24.2762 27.141 24.068 26.9119 23.7725 26.773L13.8983 22.8992H10.9965V31.9381L22.8858 35.562Z" fill="#D9D9D9" />
                            </g>
                        </svg>
                    </div>
                    Add Property
                </a>
                <?php if (isset($_SESSION['isAdmin'])) : ?>
                    <?php if ($_SESSION['isAdmin']) : ?>
                        <a href="../ReportPage/dashboard.php" id="reports-sidebar">
                            <div class="icon">
                                <svg width="30" height="30" viewBox="0 0 40 42" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <mask id="mask0_30_336" style="mask-type:alpha" maskUnits="userSpaceOnUse" x="0" y="0" width="40" height="42">
                                        <rect x="0.0161133" y="0.962891" width="39" height="40.0435" fill="#202024" />
                                    </mask>
                                    <g mask="url(#mask0_30_336)">
                                        <path d="M31.7927 25.9399V12.4857L24.0143 6.86243L16.2762 12.4857V16.9427H12.4474V10.4863L24.0143 1.94727L35.6214 10.4697V25.9399H31.7927ZM24.5785 15.1932H26.6742V13.0689H24.5785V15.1932ZM21.3543 15.1932H23.45V13.0689H21.3543V15.1932ZM24.5785 18.5255H26.6742V16.4012H24.5785V18.5255ZM21.3543 18.5255H23.45V16.4012H21.3543V18.5255ZM23.047 39.1442L10.9965 35.562V37.7697H0.920898V19.4419H14.4626L24.9009 23.524C25.7876 23.8572 26.5399 24.4126 27.1579 25.1902C27.7759 25.9677 28.0848 27.0507 28.0848 28.4392H31.7524C33.1204 28.4392 34.2752 28.8071 35.2167 29.543C36.1582 30.2789 36.629 31.4521 36.629 33.0628V34.8955L23.047 39.1442ZM4.26601 34.3124H7.57082V22.8992H4.26601V34.3124ZM22.8858 35.562L33.2033 32.313C33.0152 31.7854 32.8039 31.4244 32.5693 31.23C32.3348 31.0356 32.0605 30.9384 31.7465 30.9384H23.3694C22.644 30.9384 21.9051 30.8829 21.1528 30.7718C20.4005 30.6607 19.7691 30.5219 19.2586 30.3553L15.9538 29.2723L16.8404 26.8563L19.6213 27.8144C20.4005 28.0643 21.0876 28.2309 21.6827 28.3142C22.2777 28.3975 23.243 28.4392 24.5785 28.4392C24.5785 28.1059 24.5181 27.7797 24.3972 27.4603C24.2762 27.141 24.068 26.9119 23.7725 26.773L13.8983 22.8992H10.9965V31.9381L22.8858 35.562Z" fill="#D9D9D9" />
                                    </g>
                                </svg>
                            </div>
                            Reports
                        </a>
                    <?php endif; ?>
                <?php endif; ?>
            </div>
            <a id="settings-sidebar">
                <svg width="30" height="30" viewBox="0 0 45 40" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <mask id="mask0_36_15" style="mask-type:alpha" maskUnits="userSpaceOnUse" x="0" y="0" width="45" height="40">
                        <rect width="45" height="40" fill="#D9D9D9" />
                    </mask>
                    <g mask="url(#mask0_36_15)">
                        <path d="M21.3983 39.7257L20.6641 34.0096C20.2664 33.8608 19.8917 33.6821 19.5399 33.4737C19.1882 33.2653 18.844 33.0421 18.5075 32.8039L13.0473 35.0367L8 26.5519L12.7261 23.0686C12.6955 22.8602 12.6802 22.6593 12.6802 22.4657V21.26C12.6802 21.0665 12.6955 20.8655 12.7261 20.6571L8 17.1739L13.0473 8.689L18.5075 10.9219C18.844 10.6837 19.1958 10.4604 19.5629 10.252C19.93 10.0436 20.297 9.86498 20.6641 9.71612L21.3983 4H31.4928L32.227 9.71612C32.6247 9.86498 32.9994 10.0436 33.3512 10.252C33.7029 10.4604 34.0471 10.6837 34.3836 10.9219L39.8438 8.689L44.8911 17.1739L40.165 20.6571C40.1956 20.8655 40.2109 21.0665 40.2109 21.26V22.4657C40.2109 22.6593 40.1803 22.8602 40.1191 23.0686L44.8452 26.5519L39.7979 35.0367L34.3836 32.8039C34.0471 33.0421 33.6953 33.2653 33.3282 33.4737C32.9612 33.6821 32.5941 33.8608 32.227 34.0096L31.4928 39.7257H21.3983ZM26.5373 28.1149C28.3115 28.1149 29.8257 27.5046 31.0799 26.2839C32.3341 25.0633 32.9612 23.5896 32.9612 21.8629C32.9612 20.1361 32.3341 18.6624 31.0799 17.4418C29.8257 16.2212 28.3115 15.6109 26.5373 15.6109C24.7325 15.6109 23.2107 16.2212 21.9718 17.4418C20.7329 18.6624 20.1135 20.1361 20.1135 21.8629C20.1135 23.5896 20.7329 25.0633 21.9718 26.2839C23.2107 27.5046 24.7325 28.1149 26.5373 28.1149ZM26.5373 24.5423C25.7726 24.5423 25.1226 24.2818 24.5872 23.7608C24.0519 23.2398 23.7843 22.6072 23.7843 21.8629C23.7843 21.1186 24.0519 20.4859 24.5872 19.9649C25.1226 19.4439 25.7726 19.1834 26.5373 19.1834C27.3021 19.1834 27.9521 19.4439 28.4874 19.9649C29.0227 20.4859 29.2904 21.1186 29.2904 21.8629C29.2904 22.6072 29.0227 23.2398 28.4874 23.7608C27.9521 24.2818 27.3021 24.5423 26.5373 24.5423ZM24.6102 36.1532H28.2351L28.8774 31.4195C29.8257 31.1813 30.7052 30.8315 31.5158 30.3701C32.3264 29.9086 33.0682 29.3504 33.7412 28.6954L38.2838 30.5264L40.0732 27.4897L36.1272 24.587C36.2801 24.1702 36.3872 23.731 36.4484 23.2696C36.5096 22.8081 36.5401 22.3392 36.5401 21.8629C36.5401 21.3865 36.5096 20.9176 36.4484 20.4562C36.3872 19.9947 36.2801 19.5556 36.1272 19.1388L40.0732 16.2361L38.2838 13.1994L33.7412 15.075C33.0682 14.3902 32.3264 13.8171 31.5158 13.3557C30.7052 12.8942 29.8257 12.5444 28.8774 12.3062L28.2809 7.57258H24.6561L24.0137 12.3062C23.0654 12.5444 22.1859 12.8942 21.3753 13.3557C20.5647 13.8171 19.8229 14.3754 19.1499 15.0303L14.6074 13.1994L12.8179 16.2361L16.7639 19.0941C16.611 19.5407 16.5039 19.9873 16.4427 20.4338C16.3816 20.8804 16.351 21.3568 16.351 21.8629C16.351 22.3392 16.3816 22.8007 16.4427 23.2472C16.5039 23.6938 16.611 24.1404 16.7639 24.587L12.8179 27.4897L14.6074 30.5264L19.1499 28.6508C19.8229 29.3355 20.5647 29.9086 21.3753 30.3701C22.1859 30.8315 23.0654 31.1813 24.0137 31.4195L24.6102 36.1532Z" fill="#D9D9D9" />
                    </g>
                </svg>
                Settings
            </a>
        </div>
    </div>
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
                <div class="dropdown-filter" id="dropdownFilter">
                    <select id="filterSelect">
                        <option value="" disabled selected>Filter</option>
                        <option value=""> No Filter</option>
                        <option value="overallRating">Prop Rating</option>
                    </select>
                </div>
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
                    <?php echo '<script>loginModal.style.display = "block";</script>';
                    unset($_SESSION['$login_error_message;']) ?>
                <?php } ?>

                <form id="loginForm" action="../Backend_Files/login.php" method="POST">
                    <!-- Login form fields -->
                    <label for="username" class="modalLabel">Username:</label>
                    <input type="text" id="username" name="username" value="<?php echo isset($_SESSION['username']) ? htmlspecialchars($_SESSION['username']) : ''; ?>" placeholder="Username" required><br>
                    <label for="password" class="modalLabel">Password:</label>
                    <input type="password" id="password" name="password" value="<?php echo isset($_SESSION['password']) ? htmlspecialchars($_SESSION['password']) : ''; ?>" placeholder="Password" required><br>
                    <input type="submit" id="submitLogin" value="Login">
                    <button type="button" id="signupButton">Signup</button>
                </form>

                <!-- Add a button to open the signup modal -->

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
                <button id="changePasswordBtn" class="inverseFilledButton">Change Password</button>

                <button id="deleteProfileBtn" class="inverseFilledButton">Delete Profile</button>

                <form action="../Backend_Files/logout.php" method="post" id="formProfileBtn">
                    <button id="logoutButton" type="submit" class="filledButton loginButton">Logout</button>
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

                <h2 class="textWhite">Change Password</h2>
                <form id="changePasswordForm" action="../Backend_Files/change_password.php" method="post">
                    <label for="currentPassword" class="textWhite">Current Password:</label>
                    <input type="password" id="currentPassword" class="modalInput" name="currentPassword" required><br>

                    <label for="changeNewPassword" class="textWhite">New Password:</label>
                    <input type="password" id="changeNewPassword" class="modalInput" name="changeNewPassword" required><br>

                    <label for="confirmPassword" class="textWhite">Confirm New Password:</label>
                    <input type="password" id="confirmPassword" class="modalInput" name="confirmPassword" required><br>
                    <br>

                    <button id="changePasswordButtonFinal" type="submit" class="filledButton" style="display: inline-block;">Change Password</button>
                </form>
            </div>
        </div>
        <!-- Confirm Delete Modal -->
        <div id="confirmDeleteModal" class="modal">
            <div class="modal-content">
                <span class="close" id="closeDeleteModalBtn">&times;</span>

                <h2 class="modalLabel">Confirm Delete</h2>
                <p class="modalLabel">Are you sure you want to delete your profile?</p>
                <form action="../Backend_Files/deleteProfile.php" class="confirmDeleteForm" method="post">
                    <button type="submit" class="deleteButton inverseFilledButton">Yes, Delete</button>
                    <button type="button" id="cancelDeleteBtn" class="filledButton" style="right: 0;">Cancel</button>
                </form>
            </div>
        </div>

    </div>


</body>

</html>