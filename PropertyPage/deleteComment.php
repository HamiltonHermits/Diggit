<?php
include('../Backend_Files/database_connect.php');
// Define your SQL query based on the sorting option
$propId = $_GET["id"];
$sort_option = isset($_GET['sort']) ? $_GET['sort'] : 'desc';


        $sql = "DELETE 
        FROM hamiltonhermits.review
        
        WHERE review.prop_id=$propId";
        

// Execute the SQL query and fetch comments
$result = mysqli_query($conn, $sql);

if (!$result) {
    die("Database query failed: " . mysqli_error($conn));
}


// Close the database connection
mysqli_close($conn);
?>