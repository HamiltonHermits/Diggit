<?php
include_once('auth_login.php');
/**
 * Server-side PHP script for user login processing.
 *
 * Variables Used:
 *   - $_SERVER: Superglobal array containing server environment and request info.
 *   - $_POST: Superglobal array containing data from HTTP POST request.
 *   - $username: User-provided username from the login form.
 *   - $password: User-provided password from the login form.
 *   - $authResult: Associative array with authentication status.
 *
 * Variables Assigned:
 *   - $_SESSION: Superglobal array for storing user session data.
 */
// Check if the login form was submitted
session_start();
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    // Check if the 'username' and 'password' keys exist in $_POST
    if (isset($_POST["username"]) && isset($_POST["password"])) {

        // Retrieve user input (e.g., username and password)
        $username = $_POST["username"];
        $password = $_POST["password"];
        //used incase information was wrong
        session_start();
        $_SESSION['username'] = $username;
        $_SESSION['password'] = $password;

        //authenticate the user with your db 
        $authResult = authenticateUser($username, $password);

        // Validate user credentials
        if ($authResult['authenticated']) {
            // Valid credentials, set up a session or store user information in cookies
            session_start();
            //we dont want the password to be stored for security reasons
            unset($_SESSION['password']);
            $_SESSION["user_id"] = $authResult['user_id'];
            $_SESSION["username"] = $authResult['username'];
            $_SESSION["fullName"] = $authResult['fullName'];
            $_SESSION["email"] = $authResult['email'];
            $_SESSION["authenticated"] = true;
            //if the user is loging in as an agent there info is there for adding a property
            if($authResult['isAgent']){
                $_SESSION["userType"] = "Agent";
                $_SESSION["agentPhone"] = $authResult['agentPhone'];
                $_SESSION["agentCompany"] = $authResult['agentCompany'];
            }


            // Redirect to a secure page (e.g., whatever page they were on)
            moveHeader();
        } else {
            session_start();
            // Invalid credentials, sends through error message in the session

            $_SESSION["authenticated"] = false;
            $_SESSION['login_error'] = $authResult['error'];
            moveHeader();

        }
    } else {
        // 'username' or 'password' not provided in the form
        $_SESSION["authenticated"] = false;
        $_SESSION['login_error'] = "Username and password are required.";
        moveHeader();
    }
} else {
    // Invalid request method
    $_SESSION["authenticated"] = false;
    $_SESSION['login_error'] = "Invalid request method.";
    moveHeader();
}
function moveHeader() {
    //this moves the login page depending on the page you are on
    if(isset($_GET['page'])){
        $location = $_GET['page'];
        if ($location == 'create'){
            header("Location: ../CreatePropertyPage/$location.php");
        }elseif ($location == 'property'){
            $id = $_GET['id'];
            header("Location: ../PropertyPage/$location.php?id=$id");
        }
        exit();
    }
    header("Location: ../IndexPage/index.php");
    exit();
}
