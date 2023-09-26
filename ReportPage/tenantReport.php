<?php
require_once('../Backend_Files/database_connect.php');

// Get the search term from the GET request
$searchTerm = isset($_GET['search']) ? $_GET['search'] : '';

// Construct the SQL query with the LIKE condition on the "username" column
$query = "SELECT user_id, username, CONCAT(first_name, ' ', last_name) AS 'name',
                 IF(is_agent = 1 AND is_admin = 1, 'Admin', IF(is_agent = 1, 'Agent', 'Tenant')) AS 'role',
                 (CASE is_deleted WHEN 0 THEN 'FALSE' ELSE 'TRUE' END) AS 'deleted', agent_phone, agent_company 
                 FROM usertbl
                 WHERE username LIKE '%" . $searchTerm . "%'";

$result = $conn->query($query);

if ($result->num_rows > 0) {
    // Output the table header with column names
    echo "<tr>";
    echo "<th>User ID</th>";
    echo "<th>Username</th>";
    echo "<th>Name</th>";
    echo "<th>Role</th>";
    echo "<th>Deleted</th>";
    echo "<th>Agent Phone</th>";
    echo "<th>Agent Company</th>";
    echo "</tr>";

    while ($row = $result->fetch_assoc()) {
        // Generate HTML rows for the table
        echo "<tr>";
        echo "<td>" . $row['user_id'] . "</td>";
        echo "<td>" . $row['username'] . "</td>";
        echo "<td>" . $row['name'] . "</td>";
        echo "<td>" . $row['role'] . "</td>";
        echo "<td>" . $row['deleted'] . "</td>";
        echo "<td>" . $row['agent_phone'] . "</td>";
        echo "<td>" . $row['agent_company'] . "</td>";
        echo "</tr>";
    }
} else {
    echo "<tr><td colspan='7'>No data found</td></tr>";
}

$conn->close();
?>
