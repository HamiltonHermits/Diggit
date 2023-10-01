<?php
// Server-side PHP script for processing searches in the searchbar
include_once('config.php');
include_once('database_connect.php');

// User's search input
$searchQuery = $_GET["query"];

// Prepare and execute the SQL query
$stmt = $conn->prepare("SELECT property.prop_id,
                               property.prop_name, property.prop_description, 
                               location.street_num, location.street_name,
                               location.city, location.suburb
                        FROM property 
                        JOIN location ON property.location_id = location.location_id
                        WHERE property.prop_name LIKE ?
                        OR property.prop_description LIKE ? 
                        OR location.street_num LIKE ? OR location.street_name LIKE ? 
                        OR location.city LIKE ? OR location.suburb LIKE ?");
$searchParam = "%" . $searchQuery . "%";
$stmt->bind_param("ssssss", $searchParam, $searchParam, $searchParam, $searchParam, $searchParam, $searchParam);
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