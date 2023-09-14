<?php
// Server-side PHP script for processing searches in the searchbar
// include_once('config.php');
// include_once('database_connect.php');

define('USER', 'root');
define('PASSWORD', '');
define('DB', 'testdb');

$conn = mysqli_connect('localhost', USER, PASSWORD, DB) or
die("Connection failed: " . mysqli_connect_error());

// User's search input
$searchQuery = $_GET["query"];

// Prepare and execute the SQL query
$stmt = $conn->prepare("SELECT * FROM property WHERE propName LIKE ?");
$searchParam = "%" . $searchQuery . "%";
$stmt->bind_param("sss", $searchParam);
$stmt->execute();

// Get the results
$result = $stmt->get_result();
$apartments = array();

while ($row = $result->fetch_assoc()) {
    $apartments[] = $row;
}

// Close the database connection
$stmt->close();
$conn->close();

// Return the results as JSON
header("Content-Type: application/json");
echo json_encode($apartments);