<?php
include_once('database_connect.php');
global $conn;

session_start();

if (!isset($_SESSION["user_id"])) {
    $_SESSION['changePasswordError'] = "Not logged in";
    moveHeader();
    exit;
}

// Assuming you have the user's ID in a session variable
$userId = $_SESSION['user_id'];

$query = "UPDATE usertbl SET `is_deleted` = '1' WHERE user_id = ?";

$stmt = mysqli_prepare($conn, $query);
mysqli_stmt_bind_param($stmt, "i", $userId);
$result = mysqli_stmt_execute($stmt);

if ($result) {
    $_SESSION['profileMessage'] = "Deleted";
    moveHeaderLogout();
    exit;
} else {
    $_SESSION['profileMessage'] = "Couldn't Delete";
    moveHeader();
    exit;
}

function moveHeader() {
    // This moves the page depending on the page you are on if wrong
    if (isset($_GET['page'])) {
        $location = $_GET['page'];
        if ($location == 'create') {
            header("Location: ../CreatePropertyPage/$location.php");
        } elseif ($location == 'property') {
            $id = $_GET['id'];
            header("Location: ../PropertyPage/$location.php?id=$id");
        }
        exit();
    }
    header("Location: ../IndexPage/index.php");
    exit();
}

function moveHeaderLogout() {
    // This moves the page depending on the page you are on if right
    if (isset($_GET['page'])) {
        $location = $_GET['page'];
        if ($location == 'create') {
            header("Location: ../Backend_Files/logout.php?page=$location");
        } elseif ($location == 'property') {
            $id = $_GET['id'];
            header("Location: ../Backend_Files/logout.php?page=$location&id=$id");
        }
        exit();
    }
    header("Location: ../Backend_Files/logout.php");
    exit();
}
?>
