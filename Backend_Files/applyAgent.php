<?php
require_once('database_connect.php');
require_once('auth_agent.php');

session_start();

global $conn;
if (isset($_POST['phoneNumber']) && isset($_POST['companyName']) && isset($_FILES["profilePicture"])) {
    $phonenum = $_POST['phoneNumber'];
    $companyNum = $_POST['companyName'];

    $_SESSION['phoneNumber'] = $phonenum;
    $_SESSION['companyName'] = $companyNum;

    $authorized = validatePhoneNumber($phonenum); //by default cause i am tired

    if (isset($_SESSION["user_id"])) {

        if ($authorized['authenticated']) {
            
            $picture = time(). $_FILES['profilePicture']['name'];

            $destination = "../PropertyPage/profilepics/".$picture;

            move_uploaded_file($_FILES['profilePicture']['tmp_name'],$destination);

            $phonenum = substr($phonenum,0,3).substr($phonenum,4,3).substr($phonenum,8,4);

            $user_id = $_SESSION["user_id"];

            $updateQuerry = "UPDATE usertbl
        SET 
        is_agent = '1',
        agent_phone = '$phonenum',
        agent_company = '$companyNum',
        profile_pic = '$picture'
        
        WHERE
        user_id = $user_id";
            $_SESSION['userType'] = 'Agent';
            $_SESSION['applicationSuccess'] = true;

            $result = mysqli_query($conn, $updateQuerry);

            if ($result) {
                header("Location: ../CreatePropertyPage/create.php");
            } else {
                $_SESSION['applyAgentError'] = "There was an error with executing query: ".mysqli_error($conn);
                header("Location: ../CreatePropertyPage/create.php");
            }
        } else {
            $_SESSION['applyAgentError'] = $authorized['error'];
            header("Location: ../CreatePropertyPage/create.php");
        }
    } else {
        // Invalid request method
        $_SESSION['applyAgentError'] = "You are not logged in";
        header("Location: ../CreatePropertyPage/create.php");
    }
} else {
    // Invalid request method
    $_SESSION['applyAgentError'] = "Invalid request method on applyAgent.";
    header("Location: ../CreatePropertyPage/create.php");
}
exit();
