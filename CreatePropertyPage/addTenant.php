<?php
    include_once('../Backend_Files/database_connect.php');

    // Get email from the request (sanitize or validate input as needed)
    $email = $_GET["email"];

    // Check if the provided email belongs to an existing tenant in the db
    $query = "SELECT * FROM usertbl WHERE email = ?";
    
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $email);
    
    if (!$stmt->execute()) {
        http_response_code(400); // Bad Request
        echo json_encode(["error" => "Query error: " . $stmt->error]);
        exit;
    }

    $result = $stmt->get_result();

    // If query returns no rows, return false; otherwise, return true
    if ($result->num_rows == 0) {
        echo json_encode(false);
    } else {
        echo json_encode(true);
    }

    // Close the database connection
    $stmt->close();
?>
