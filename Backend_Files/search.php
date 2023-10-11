<?php
// Server-side PHP script for processing searches in the searchbar
include_once('config.php');
include_once('database_connect.php');

// User's search input
$searchQuery = $_GET["query"];
$filterOption = $_GET["filterOption"];

switch ($filterOption) {
    case 'overallRating':
        $stmt = $conn->prepare("SELECT
        property.prop_id,
        property.prop_name,
        property.prop_description,
        property.address,
        MAX(review.overall_property_rating) AS overall_property_rating
    FROM
        property
    JOIN
        review ON property.prop_id = review.prop_id
    WHERE
        (property.prop_name LIKE ? OR address LIKE ?)
        AND property.is_deleted = false
    GROUP BY
        property.prop_id,
        property.prop_name,
        property.prop_description,
        property.address
    ORDER BY
        overall_property_rating DESC
    ");
        break;
    
    default:
        $stmt = $conn->prepare("SELECT property.prop_id, property.prop_name, property.prop_description, property.address
                                FROM property
                                WHERE (property.prop_name LIKE ? 
                                OR address LIKE ?)
                                AND property.is_deleted = false");
        break;
}

// Prepare and execute the SQL query

$searchParam = "%" . $searchQuery . "%";
$stmt->bind_param("ss", $searchParam, $searchParam);
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