<?php
require_once('../Backend_Files/database_connect.php');

// Get the search term from the GET request
$searchTerm = isset($_GET['search']) ? $_GET['search'] : '';

// Construct the SQL query with the LIKE condition
// $query = "SELECT prop_id, prop_name, (usertbl.first_name) AS 'created_by_name', prop_description, created_on, address AS 'location'
//           FROM hamiltonhermits.property, hamiltonhermits.usertbl, hamiltonhermits.location
//           WHERE property.created_by = usertbl.user_id
$query = "SELECT prop_id,prop_name,(usertbl.username) as 'username',prop_description,created_on,address 
          FROM property,usertbl
          WHERE usertbl.user_id = property.created_by
          AND property.is_deleted = false
          AND (prop_name LIKE '%" . $searchTerm . "%'
          OR prop_description LIKE '%" . $searchTerm . "%' 
          OR address LIKE '%" . $searchTerm . "%' 
          OR username LIKE '%" . $searchTerm . "%' 
          OR created_on LIKE '%" . $searchTerm . "%')";

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
        echo "<td>" . $row['username'] . "</td>";
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
