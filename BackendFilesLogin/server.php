<?php
// This is a simple PHP script that responds to a client request with JSON data

// Simulate some data
$data = array('message' => 'You fuckin poes!');

// Set response headers to indicate JSON content
header('Content-Type: application/json');

// Encode the data as JSON and send it to the client
echo json_encode($data);
?>