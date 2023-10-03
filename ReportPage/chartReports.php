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
    case 'rating-distribution-bc':
        $query = "SELECT overall_property_rating, COUNT(review.overall_property_rating) AS rating_count
                  FROM review
                  GROUP BY overall_property_rating
                  ORDER BY overall_property_rating";
        break;
    case 'agent-overall-rating-bc':
        $query = "SELECT usertbl.username, review.overall_tenant_rating
                  FROM hamiltonhermits.usertbl
                  JOIN hamiltonhermits.property ON property.created_by = usertbl.user_id 
                  JOIN hamiltonhermits.review ON property.prop_id = review.prop_id
                  ORDER BY review.overall_tenant_rating DESC";
    default:
        break;
}

$result = $conn->query($query);

if ($result->num_rows > 0) {
    $response = array(
        'chart_type' => $chartType,
        'chartData' => array()
    );

    while ($row = $result->fetch_assoc()) {
        $response['chartData'][] = $row; // Add each row to the data array
    }

    echo json_encode($response); 

    // while ($row = $result->fetch_assoc()) {
    //     $response[] = $row; // Add each row to the response array
    // }
    // echo json_encode($response); 
} else {
    echo "<tr><td colspan='7'>No data found</td></tr>";
}


$conn->close();
?>