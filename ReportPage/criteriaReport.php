<!-- report.php -->
<!DOCTYPE html>
<html>
<head>
    <title>digsRating Report</title>
</head>
<body>
    <h1>digsRating Report</h1>

    <?php
    // Database connection parameters
    include_once('../Backend_Files/config.php');
    include_once('../Backend_Files/database_connect.php');
    // Create a database connection
    $conn = new mysqli($host, $username, $password, $database);

    // Check if the connection was successful
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // SQL query to retrieve dig information
    $sql = "SELECT * FROM digs";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        echo "<table border='1'>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Location</th>
                <th>Date</th>
            </tr>";

        // Output data of each row
        while ($row = $result->fetch_assoc()) {
            echo "<tr>
                <td>" . $row["id"] . "</td>
                <td>" . $row["name"] . "</td>
                <td>" . $row["location"] . "</td>
                <td>" . $row["date"] . "</td>
            </tr>";
        }

        echo "</table>";
    } else {
        echo "No digs found.";
    }

    // Close the database connection
    $conn->close();
    ?>

</body>
</html>