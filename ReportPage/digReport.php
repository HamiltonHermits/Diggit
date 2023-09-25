<?php
    
    // Database connection parameters
    include_once('../Backend_Files/config.php');
    include_once('../Backend_Files/database_connect.php');
    // Create a database connection
    $conn = new mysqli($db_host, $db_user, $db_pass, $db_name);

    // Check if the connection was successful
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // SQL query to retrieve dig information
    $sql = "SELECT * FROM property";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        echo "<table border='1'>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Description</th>
                <th>Max Tenants</th>
            </tr>";

        // Output data of each row
        while ($row = $result->fetch_assoc()) {
            echo "<tr>
                <td>" . $row["prop_id"] . "</td>
                <td>" . $row["prop_name"] . "</td>
                <td>" . $row["prop_description"] . "</td>
                <td>" . $row["max_tenants"] . "</td>
            </tr>";
        }

        echo "</table>";
    } else {
        echo "No digs found.";
    }
    header('Location: http://is3-dev.ict.ru.ac.za/SysDev/HamiltonHermits/ReportPage/dashboard.php');
    // Close the database connection
    $conn->close();
    ?>
<!-- report.php -->
<!DOCTYPE html>
<html>
<head>
    <title>Dig Report</title>
</head>
<body>
    <h1>Dig Report</h1>

    

</body>
</html>