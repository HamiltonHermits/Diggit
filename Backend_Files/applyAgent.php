<?php
include_once('database_connect.php');
session_start();
global $conn;
if (isset($_POST['phoneNumber']) && isset($_POST['companyName'])) {
    $phonenum = $_POST['phoneNumber'];
    $companyNum = $_POST['companyName'];

    $_SESSION['phoneNumber'] = $phonenum;
    $_SESSION['companyName'] = $companyNum;

    $authorized = false;//by default cause i am tired
    if (isset($_SESSION["user_id"])) {

        if ($authorized) {
            $user_id = $_SESSION["user_id"];

            $updateQuerry = "UPDATE usertbl
        SET 
        is_agent = '1',
        agent_phone = '$phonenum',
        agent_company = '$companyNum'
        WHERE
        user_id = $user_id";

            $result = mysqli_query($conn, $updateQuerry)
                or die("FAILED: " . mysqli_error($conn));

            header("Location: ../CreatePropertyPage/create.php");
        } else {
            $_SESSION['applyAgentError'] = "Authorization failed";
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
