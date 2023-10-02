<?php
require_once('../Backend_Files/database_connect.php');

// Get the search term from the GET request
$searchTerm = isset($_GET['search']) ? $_GET['search'] : '';

// Construct the SQL query with the LIKE condition
// $query = "SELECT prop_id, prop_name, (usertbl.first_name) AS 'created_by_name', prop_description, created_on, address AS 'location'
//           FROM hamiltonhermits.property, hamiltonhermits.usertbl, hamiltonhermits.location
//           WHERE property.created_by = usertbl.user_id
$query = "SELECT *
          FROM property
          WHERE prop_name LIKE '%" . $searchTerm . "%'";

$result = $conn->query($query);

if ($result->num_rows > 0) {
    // Output the table header with column names
    echo "<table>"; // Start the table
    echo "<tr>";
    echo "<th>Property ID</th>";
    echo "<th>Property Name</th>";
    echo "<th>Created By</th>";
    echo "<th>Description</th>";
    echo "<th>Created On</th>";
    echo "<th>Address</th>";
    echo "</tr>";

    while ($row = $result->fetch_assoc()) {
        // Generate HTML rows for the table
        echo "<tr>";
        echo "<td>" . $row['prop_id'] . "</td>";
        echo "<td>" . $row['prop_name'] . "</td>";
        echo "<td>" . $row['created_by'] . "</td>";
        echo "<td>" . $row['prop_description'] . "</td>";
        echo "<td>" . $row['created_on'] . "</td>";
        echo "<td>" . $row['address'] . "</td>";
        echo "</tr>";
    }

    echo "</table>"; // End the table
} else {
    echo "No data found";
}

$conn->close();
?>
