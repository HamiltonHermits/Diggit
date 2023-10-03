<?php
require_once('../Backend_Files/database_connect.php');
session_start();
// echo "we gosdsathere";
if (isset($_SESSION['property_id'])) {
    echo "we gothere";
    $propId = $_SESSION['property_id'];
    $query = "UPDATE property
        SET
            is_deleted = '1'
        WHERE
            prop_id = '$propId'";

    $result = mysqli_query($conn, $query);

    header("Location: ../IndexPage/index.php");
    
}
