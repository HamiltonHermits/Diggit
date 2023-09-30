<?php

include_once('../Backend_Files/database_connect.php');

$propId = $_GET["id"];

$query = "SELECT prop_name, lat, `long` FROM property WHERE prop_id = '$propId'";

$result = mysqli_query($conn, $query);

if (!$result) { //if query fails, return error, check network packets in dev tools
    http_response_code(400); // Bad Request
    echo json_encode(["error" => "Query error: " . $conn->error]);
    exit;
}

// Fetch data and send it as JSON
$data = $result->fetch_all(MYSQLI_ASSOC);
echo json_encode($data);
?>