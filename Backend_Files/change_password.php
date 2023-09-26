<?php
// Include the database connection script (db_connect.php)
require_once('database_connect.php');
require_once('password_check.php');
require_once('auth_login.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    session_start();
    if (isset($_POST["currentPassword"]) && isset($_POST["changeNewPassword"]) && isset($_POST["confirmPassword"])) {
        
        $currentPassword = $_POST['currentPassword'];
        $newPassword = $_POST['changeNewPassword'];
        $confirmPassword = $_POST['confirmPassword'];
        

        if($confirmPassword != $newPassword){
            $_SESSION['changePasswordError'] = "Password ";
            moveHeader();
            exit;
        }
        //validation for new password and confirmation here
        $pStrengthCheck = isPasswordStrong($newPassword);

        if (!$pStrengthCheck['strong_password']) {
            $_SESSION['changePasswordError'] = $pStrengthCheck['error'];
            moveHeader();
            exit;
        }
        if(!isset($_SESSION["user_id"])){
            $_SESSION['changePasswordError'] = "Not logged in";
            moveHeader();
            exit;
        }
        
        // Assuming you have the user's ID in a session variable 
        $userId = $_SESSION['user_id'];


        if(!isset($_SESSION["username"])){
            $_SESSION['changePasswordError'] = "Not logged in";
            moveHeader();
            exit;
        }
        
        // Assuming you have the username in a session variable 
        $username = $_SESSION["username"];

        //checks to see that the users info is correct
        $authResult = authenticateUser($username, $currentPassword);
        if(!$authResult['authenticated']){
            $_SESSION['changePasswordError'] = "Password is incorrect";
            moveHeader();
            exit;
        }
        // Hash the new password (you should use password_hash() in a real application)
        $hashedNewPassword = password_hash($newPassword, PASSWORD_DEFAULT);

        // Update the user's password in the database
        $query = "UPDATE usertbl SET password = '$hashedNewPassword' WHERE user_id = '$userId'";

        // Execute the query
        $result = mysqli_query($conn, $query);

        if ($result) {
            $_SESSION['profileMessage'] = "Password Changed Successfully";
            moveHeader();
            exit;
            
        } else {
            $_SESSION['changePasswordError'] = "Error with sql querry".mysqli_error($conn) ;
            moveHeader();
            exit;
        }
    } else {

        // 'username' or 'password' not provided in the form
        $_SESSION['changePasswordError'] = "All fields need to be filled in.";
        moveHeader();
        exit;
    }
} else {

    // Invalid request method
    $_SESSION['changePasswordError'] = "Invalid request method.";
    moveHeader();
    exit;
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

