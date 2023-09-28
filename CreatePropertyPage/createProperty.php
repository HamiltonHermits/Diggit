<?php
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Initialize a response array
        $response = array();
    
        // Get the data sent via POST
        $propTitle = isset($_POST['title']) ? $_POST['title'] : '';
        $propImages = isset($_FILES['file']) ? $_FILES['file'] : '';
        $propImages = time() . $_FILES['file']['name'];
        //move the file to the upload folder
        $destination = "../PropertyPage/images/" . $propImages;
        move_uploaded_file($_FILES['file']['tmp_name'], $destination);

        //Connect to database
        require_once('../Backend_Files/database_connect.php');

        //insert prop title
        // $query = "INSERT INTO searchbar_testing (name) VALUES ('$propTitle')";

        //insert iamge
        $query = "INSERT INTO searchbar_testing (location) VALUES ('$propImages')";

        $result = mysqli_query($conn, $query);


    
        // You can now process the data as needed, e.g., insert it into a database
    
        // For demonstration purposes, we'll just create a response array
        $response['success'] = true;
        $response['message'] = 'this ran ' . $propImages . ' successfully';
    
        // Send the JSON response
        header('Content-Type: application/json');
        echo json_encode($response);
    } else {
        // Handle non-POST requests or direct access to this script
        header('HTTP/1.1 405 Method Not Allowed');
        echo 'Method Not Allowed';
    }
?>