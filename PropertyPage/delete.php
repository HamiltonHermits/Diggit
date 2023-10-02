<?php
include('../Backend_Files/database_connect.php');
// Define your SQL query based on the sorting option
$propId = $_GET["id"];
$sort_option = isset($_GET['sort']) ? $_GET['sort'] : 'desc';

$sql = "SELECT *
        FROM hamiltonhermits.review
        JOIN hamiltonhermits.usertbl ON usertbl.user_id = review.user_id
        JOIN hamiltonhermits.property ON property.prop_id = review.prop_id
        WHERE property.prop_id=$propId
        ORDER BY overall_property_rating ASC";
        

// Execute the SQL query and fetch comments
$result = mysqli_query($conn, $sql);

if (!$result) {
    die("Database query failed: " . mysqli_error($conn));
}



// Close the database connection
mysqli_close($conn);
?>