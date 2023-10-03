<?php
include('../Backend_Files/database_connect.php');
// Define your SQL query based on the sorting option
$propId = $_GET["id"];

$sqlUser=$sql = "SELECT *
FROM hamiltonhermits.usertbl;";

$result = mysqli_query($conn, $sqlUser);


while ($row = mysqli_fetch_assoc($result)) {
    if($row['username']==$_SESSION['username']){
        $userId=$row['user_id'];
    }
}

if (!$result) {
    die("Database query failed: " . mysqli_error($conn));
}


        $sql = "DELETE 
        FROM hamiltonhermits.review
        
        WHERE review.prop_id=$propId AND review.user_id=$userId;";
        

// Execute the SQL query and fetch comments
$result = mysqli_query($conn, $sql);

if (!$result) {
    die("Database query failed: " . mysqli_error($conn));
}


// Close the database connection
mysqli_close($conn);
?>