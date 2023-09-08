<?php
// Server-side PHP script for processing searches in the searchbar
include_once('config.php');
include_once('database_connect.php');

// User's search input
$searchQuery = $_GET["query"];

// Prepare and execute the SQL query
$stmt = $conn->prepare("SELECT * FROM searchbar_testing WHERE name LIKE ? OR location LIKE ? OR description LIKE ?");
$searchParam = "%" . $searchQuery . "%";
$stmt->bind_param("sss", $searchParam, $searchParam, $searchParam);
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