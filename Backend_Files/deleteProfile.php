<?php 
include_once('database_connect.php');
global $conn;

session_start();

if(!isset($_SESSION["user_id"])){
    $_SESSION['changePasswordError'] = "Not logged in";
    header("Location: ../IndexPage/index.php");
    exit;
}

// Assuming you have the user's ID in a session variable 
$userId = $_SESSION['user_id'];

$query = "UPDATE usertbl SET `is_deleted` = '1' WHERE user_id = '$userId'";

$result = mysqli_query($conn, $query);

if ($result) {
    $_SESSION['profileMessage'] = "Deleted";
    header("Location: ../Backend_Files/logout.php");
    exit;
} else {
    $_SESSION['profileMessage'] = "Couldn't Delete";
    header("Location: ../IndexPage/index.php");
    exit;
}
?>
