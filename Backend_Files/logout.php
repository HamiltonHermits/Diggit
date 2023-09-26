<?php
session_start(); // Start the session

if (isset($_SESSION['authenticated']) && $_SESSION['authenticated'] === true) {
    // Unset all session variables
    $_SESSION = array();
    // Destroy the session
    session_destroy();

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
    
    // Redirect the user to a logout confirmation page or login page
    header("Location: ../IndexPage/index.php");
    exit(); // Important to stop further execution
}