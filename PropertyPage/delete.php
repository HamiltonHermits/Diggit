<?php
/////////////////////////////////////////////////////////////////

// NEED TO UPDATE SEARCH BAR TO CHECK FOR IS DELETED != 1 //////


////////////////////////////////////////////////////////////////
include('../Backend_Files/database_connect.php');
// Define your SQL query based on the sorting option
$propId = $_GET["id"];
$sort_option = isset($_GET['sort']) ? $_GET['sort'] : 'desc';

$sql = "UPDATE property SET is_deleted=1 WHERE prop_id=$propId";
        

// Execute the SQL query and fetch comments
$result = mysqli_query($conn, $sql);

if (!$result) {
    die("Database query failed: " . mysqli_error($conn));
}



// Close the database connection
mysqli_close($conn);

?>