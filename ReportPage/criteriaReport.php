<!-- report.php -->
<?php
require_once('../Backend_Files/database_connect.php');

// Get the search term from the GET request
$searchTerm = isset($_GET['search']) ? $_GET['search'] : '';

switch ($searchTerm) {
    case 'cleanliness':
        $selectedCriteria = 'cleanliness_rating';
        $reviewSelectedCriteria = 'review.' . $selectedCriteria;
        $query = "SELECT property.prop_name, $reviewSelectedCriteria
                  FROM property
                  JOIN review ON property.prop_id = review.prop_id";
        break;
    case 'noise':
        $selectedCriteria = 'noise_rating';
        $reviewSelectedCriteria = 'review.' . $selectedCriteria;
        $query = "SELECT property.prop_name, $reviewSelectedCriteria
                  FROM property
                  JOIN review ON property.prop_id = review.prop_id";
        break;
    case 'location':
        $selectedCriteria = 'location_rating';
        $reviewSelectedCriteria = 'review.' . $selectedCriteria;
        $query = "SELECT property.prop_name, $reviewSelectedCriteria
                  FROM property
                  JOIN review ON property.prop_id = review.prop_id";
        break;
    case 'safety':
        $selectedCriteria = 'saftey_rating';
        $reviewSelectedCriteria = 'review.' . $selectedCriteria;
        $query = "SELECT property.prop_name, $reviewSelectedCriteria
                  FROM property
                  JOIN review ON property.prop_id = review.prop_id";
        break;
    case 'affordability':
        $selectedCriteria = 'affordability_rating';
        $reviewSelectedCriteria = 'review.' . $selectedCriteria;
        $query = "SELECT property.prop_name, $reviewSelectedCriteria
                  FROM property
                  JOIN review ON property.prop_id = review.prop_id";
        break;
       
    default:
        break;
}

$result = $conn->query($query);

if ($result->num_rows > 0) {
    // Output the table header with column names
    echo "<table>";
    echo "<tr>";
    echo "<th>Property Name</th>";
    echo "<th>Criteria Rating</th>";
    echo "</tr>";

    while ($row = $result->fetch_assoc()) {
        // Generate HTML rows for the table
        echo "<tr>";
        echo "<td>" . $row['prop_name'] . "</td>";
        echo "<td>" . $row[$selectedCriteria] . "</td>";
        echo "</tr>";
    }
    echo "</table>";
} else {
    echo "<tr><td colspan='7'>No data found</td></tr>";
}

$conn->close();
?>
