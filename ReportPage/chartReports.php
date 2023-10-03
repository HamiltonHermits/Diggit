<?php
require_once('../Backend_Files/database_connect.php');

// Get the chart type and search
$chartType = isset($_GET['chart']) ? $_GET['chart'] : '';

switch ($chartType) {
    case 'overall-prop-rating-cc':
        $query = "SELECT property.prop_name, review.overall_property_rating
                  FROM property
                  JOIN review ON property.prop_id = review.prop_id
                  ORDER BY review.overall_property_rating DESC";
        break;
    case 'noise':
        $selectedCriteria = 'noise_rating';
        $reviewSelectedCriteria = 'review.' . $selectedCriteria;
        $query = "SELECT property.prop_name, $reviewSelectedCriteria
                  FROM property
                  JOIN review ON property.prop_id = review.prop_id
                  WHERE property.prop_name LIKE '%" . $searchTerm . "%'";
        break;
    case 'location':
        $selectedCriteria = 'location_rating';
        $reviewSelectedCriteria = 'review.' . $selectedCriteria;
        $query = "SELECT property.prop_name, $reviewSelectedCriteria
                  FROM property
                  JOIN review ON property.prop_id = review.prop_id
                  WHERE property.prop_name LIKE '%" . $searchTerm . "%'";
        break;
    case 'safety':
        $selectedCriteria = 'saftey_rating';
        $reviewSelectedCriteria = 'review.' . $selectedCriteria;
        $query = "SELECT property.prop_name, $reviewSelectedCriteria
                  FROM property
                  JOIN review ON property.prop_id = review.prop_id
                  WHERE property.prop_name LIKE '%" . $searchTerm . "%'";
        break;
    case 'affordability':
        $selectedCriteria = 'affordability_rating';
        $reviewSelectedCriteria = 'review.' . $selectedCriteria;
        $query = "SELECT property.prop_name, $reviewSelectedCriteria
                  FROM property
                  JOIN review ON property.prop_id = review.prop_id
                  WHERE property.prop_name LIKE '%" . $searchTerm . "%'";
        break;
       
    default:
        break;
}

$result = $conn->query($query);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $response[] = $row; // Add each row to the response array
    }
    echo json_encode($response); 
} else {
    echo "<tr><td colspan='7'>No data found</td></tr>";
}


$conn->close();
?>