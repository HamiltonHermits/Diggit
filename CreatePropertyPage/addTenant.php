<?php
    include_once('../Backend_Files/database_connect.php');

    // get email from the request
    $email = $_GET["email"];

    // check if the provided email belongs to a existing tenant in the db
    $query = "SELECT * FROM tenants WHERE tenant_id = '$email'";

    $result = mysqli_query($conn, $query);

    if (!$result) { //if query fails, return error, check network packets in dev tools
        http_response_code(400); // Bad Request
        echo json_encode(["error" => "Query error: " . $conn->error]);
        exit;
    }

    // if query returns no rows, return false
    // else return true
    if (mysqli_num_rows($result) == 0) {
        echo json_encode(false);
        exit;
    } else {
        echo json_encode(true);
        exit;
    }
?>