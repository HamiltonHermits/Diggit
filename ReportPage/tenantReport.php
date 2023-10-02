<?php
require_once('../Backend_Files/database_connect.php');

// Get the search term from the GET request
$searchTerm = isset($_GET['search']) ? $_GET['search'] : '';

// Construct the SQL query with the LIKE condition on the "username" column
// $query = "SELECT user_id, username, CONCAT(first_name, ' ', last_name) AS 'name',
//                  IF(is_agent = 1 AND is_admin = 1, 'Admin', IF(is_agent = 1, 'Agent', 'Tenant')) AS 'role',
//                  (CASE is_deleted WHEN 0 THEN 'FALSE' ELSE 'TRUE' END) AS 'deleted', agent_phone, agent_company 
//                  FROM usertbl
//                  WHERE username LIKE '%" . $searchTerm . "%'";

// $query = "SELECT tenants.tenant_id, property.prop_name
//           FROM hamiltonhermits.tenants
//           JOIN hamiltonhermits.property ON property.prop_id = tenants.prop_id
//           JOIN hamiltonhermits.usertbl ON usertbl.email = tenants.tenant_id
//           WHERE tenants.tenant_id LIKE '%" . $searchTerm . "%'";

$query = "SELECT usertbl.username,CONCAT(usertbl.first_name, ' ', usertbl.last_name) AS 'name',tenants.tenant_id as 'email', property.prop_name,
          IF(is_agent = 1 AND is_admin = 1, 'Admin', IF(is_agent = 1, 'Agent', 'Tenant')) AS 'role'
          FROM hamiltonhermits.tenants
          JOIN hamiltonhermits.property ON property.prop_id = tenants.prop_id
          JOIN hamiltonhermits.usertbl ON usertbl.email = tenants.tenant_id
          WHERE usertbl.is_deleted = false
          AND (tenants.tenant_id LIKE '%" . $searchTerm . "%' 
          OR email LIKE '%" . $searchTerm . "%' 
          OR property.prop_name LIKE '%" . $searchTerm . "%'
          OR CONCAT(usertbl.first_name, ' ', usertbl.last_name) LIKE '%" . $searchTerm . "%')";

$result = $conn->query($query);

if ($result->num_rows > 0) {
    // Output the table header with column names
    echo "<tr>";
    echo "<th>Username</th>";
    echo "<th>Name</th>";
    echo "<th>Email</th>";
    echo "<th>Property Name</th>";
    echo "<th>Role</th>";
    echo "</tr>";

    while ($row = $result->fetch_assoc()) {
        // Generate HTML rows for the table
        echo "<tr>";
        echo "<td>" . $row['username'] . "</td>";
        echo "<td>" . $row['name'] . "</td>";
        echo "<td>" . $row['email'] . "</td>";
        echo "<td>" . $row['prop_name'] . "</td>";
        echo "<td>" . $row['role'] . "</td>";
        echo "</tr>";
    }
} else {
    echo "<tr><td colspan='7'>No data found</td></tr>";
}

$conn->close();
?>
