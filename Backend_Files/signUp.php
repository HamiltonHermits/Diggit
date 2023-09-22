<?php
include_once('auth_signup.php');
/**
 * Server-side PHP script for user signup processing.
 *
 * Variables Used:
 *   - $_SERVER: Superglobal array containing server environment and request info.
 *   - $_POST: Superglobal array containing data from HTTP POST request.
 *   - $username: User-provided username from the signup form.
 *   - $password: User-provided password from the signup form.
 *   - $confirmPass: User-provided password confirmation from the signup form.
 *   - $registrationResult: Associative array with registration status and user information.
 *
 * Variables Assigned:
 *   - $_SESSION: Superglobal array for storing user session data.
 */
// Check if the registration form was submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    //error_log("we got into signup");
    // Check if the required form fields exist in $_POST
    if (isset($_POST["newUsername"]) && isset($_POST["newPassword"]) && isset($_POST["passwordConfirm"]) && isset($_POST["newEmail"]) && isset($_POST['firstName']) && isset($_POST['lastName'])) {

        // Retrieve user input
        $username = $_POST["newUsername"];
        $password = $_POST["newPassword"];
        $confirmPass = $_POST["passwordConfirm"];
        $email = $_POST["newEmail"];
        $firstName = $_POST["firstName"];
        $lastName = $_POST["lastName"];

        session_start();
        $_SESSION["username"] = $username ;
        $_SESSION["newPassword"] = $password ;
        $_SESSION["confirmPass"] = $confirmPass ;
        $_SESSION["email"] = $email ;
        $_SESSION["firstName"] = $firstName ;
        $_SESSION["lastName"] = $lastName ;
        

        if ($password == $confirmPass) {
            // Perform user registration using a function 

            //if the user is already in the table we are just going to update there information
            $getUser = "SELECT * FROM usertbl WHERE username = '$username'";
            //query the database
            $result = mysqli_query($conn, $getUser);

            if (!$result) {
                die("Error in SQL query: " . mysqli_error($conn));
            }

            if (mysqli_num_rows($result) === 1) {
                $row = mysqli_fetch_assoc($result);
                $user_id = $row['user_id'];
                //update there information
                $registrationResult = reRegisterUser($user_id, $username, $password, $email, $firstName, $lastName);
            } else {
                //else we register them as new user
                $registrationResult = registerUser($username, $password, $email, $firstName, $lastName);
            }
            // Check if it was registered
            if ($registrationResult['registered']) {
                // Registration successful, set up a session or handle as needed
                session_start();

                unset($_SESSION["newPassword"]);
                unset($_SESSION["confirmPass"]);
                $_SESSION["user_id"] = $registrationResult['user_id'];
                $_SESSION["username"] = $registrationResult['username'];
                $_SESSION["fullName"] = $registrationResult['fullName'];
                $_SESSION["email"] = $registrationResult['email'];
                $_SESSION["authenticated"] = true;

                // Stay on same page, but with updated sections
                header("Location: ../IndexPage/index.php");
                exit();
            } else {
                // Registration failed
                session_start();
                $_SESSION["authenticated"] = false;
                $_SESSION['signup_error'] = $registrationResult['error'];
                header("Location: ../IndexPage/index.php"); // Stay on same page, but with updated sections
                exit;
            }
        } else {
            session_start();
            $_SESSION["authenticated"] = false;
            $_SESSION['signup_error'] = "Password does not match";
            header("Location: ../IndexPage/index.php"); // Stay on same page, but with updated sections
            exit;
        }
    } else {
        // Required fields not provided in the form
        session_start();
        $_SESSION["authenticated"] = false;
        $_SESSION['signup_error'] = "Make sure to fill in every option";
        header("Location: ../IndexPage/index.php"); // Stay on same page, but with updated sections
        exit;
    }
} else {
    // Invalid request method
    //idk how this happens but just in case
    session_start();
    $_SESSION["authenticated"] = false;
    $_SESSION['signup_error'] = "Invalid request method.";
    header("Location: ../IndexPage/index.php"); // Redirect to the signup page
    exit;
}
