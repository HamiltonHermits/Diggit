<?php
    session_start();
    
    if (isset($_SESSION['user_id'])) {
        $userId = $_SESSION['user_id'];
    } else {
        //send error message if user is not logged in
        $response['success'] = false;
        $response['message'] = 'You are not logged in';
        header('Content-Type: application/json');
        echo json_encode($response);
    }
            
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Initialize a response array
        $response = array();
    //Connect to database
    require_once('../Backend_Files/database_connect.php');
        // Get the data sent via POST
        //grab all the data and escape it to stop sql injection
        $propTitle = isset($_POST['title']) ? mysqli_real_escape_string($conn, $_POST['title']) : '';
        $propDescription = isset($_POST['desc']) ? mysqli_real_escape_string($conn, $_POST['desc']) : '';
        $propAddress = isset($_POST['address']) ? mysqli_real_escape_string($conn, $_POST['address']) : '';
        $propLat = isset($_POST['lat']) ? mysqli_real_escape_string($conn, $_POST['lat']) : '';
        $propLong = isset($_POST['long']) ? mysqli_real_escape_string($conn, $_POST['long']) : '';
        $propAmenities = isset($_POST['amenities']) ? mysqli_real_escape_string($conn, $_POST['amenities']) : '';
        $propTenants = isset($_POST['tenants']) ? mysqli_real_escape_string($conn, $_POST['tenants']) : '';
    
        // Get the date
        $currentDate = date("Y-m-d");

        //insert prop title
        $query = "INSERT INTO property (prop_name, created_by, prop_description,created_on, address, lat, `long`) 
                    VALUES ('$propTitle', '$userId', '$propDescription','$currentDate', '$propAddress', '$propLat', '$propLong')";
        $result = mysqli_query($conn, $query);

        if (!$result) { //if query fails, return error, check network packets in dev tools
            http_response_code(400); // Bad Request
            echo json_encode(["error" => "Query error: " . $conn->error]);
            exit;
        }

        ////////////////////////////////////
        // get prop_id using prop_name
        $query = "SELECT prop_id FROM property WHERE prop_name = '$propTitle'";
        $result = mysqli_query($conn, $query);
        $prop_id = mysqli_fetch_assoc($result)['prop_id'];
        ////////////////////////////////////

        // Get images from array
        if (isset($_FILES['images'])) {
            $uploadedFiles = $_FILES['images'];
            $something = "";
            foreach ($uploadedFiles['tmp_name'] as $key => $tmp_name) {
                $file_name = time() . $uploadedFiles['name'][$key];
                $file_tmp = $tmp_name;
                $something .=  " " . $file_name;
        
                // Construct the destination path for the uploaded file
                $destination = "../PropertyPage/images/" . $file_name;
        
                // Move the uploaded file to the destination
                move_uploaded_file($file_tmp, $destination);

                // insert images into database
                $query = "INSERT INTO property_images (prop_id, image_name) VALUES ($prop_id,'$file_name')";
                $result = mysqli_query($conn, $query);
                if (!$result) { //if query fails, return error, check network packets in dev tools
                    http_response_code(400); // Bad Request
                    echo json_encode(["error" => "Query error: " . $conn->error]);
                    exit;
                }
            }
        }
        
        //insert prop amenities
        // propAmenities in the form of a string like: "1,2,3,4"
        $propAmenitiesArray = explode(",", $propAmenities); //break string into an array
        foreach ($propAmenitiesArray as $amenity) {
            $query = "INSERT INTO property_amenity (prop_id, amenity_id) VALUES ('$prop_id','$amenity')";
            $result = mysqli_query($conn, $query);
            if (!$result) { //if query fails, return error, check network packets in dev tools
                http_response_code(400); // Bad Request
                echo json_encode(["error" => "Query error: " . $conn->error]);
                exit;
            }
        }

        // insert prop tenants
        $tenantCount = 0;
        $propTenantsArray = explode(",", $propTenants); //break string into an array
        foreach ($propTenantsArray as $tenant) {
            $tenantCount = $tenantCount + 1;
            $query = "INSERT INTO tenants (prop_id, tenant_id) VALUES ('$prop_id','$tenant')";
            $result = mysqli_query($conn, $query);
            if (!$result) { //if query fails, return error, check network packets in dev tools
                http_response_code(400); // Bad Request
                echo json_encode(["error" => "Query error: " . $conn->error]);
                exit;
            }
        }

        //set the current amount of tenants
        $query = "UPDATE property SET curr_tenants = '$tenantCount' WHERE (prop_id = '$prop_id')";
        $result = mysqli_query($conn, $query);
        if (!$result) { //if query fails, return error, check network packets in dev tools
            http_response_code(400); // Bad Request
            echo json_encode(["error" => "Query error: " . $conn->error]);
            exit;
        }

        

        $response['success'] = true;
        $response['prop_id'] = $prop_id;
        $response['message'] = 'this ran succesfully ' . $propTenants;
    
        // Send the JSON response
        header('Content-Type: application/json');
        echo json_encode($response);
    } else {
        // Handle non-POST requests or direct access to this script
        header('HTTP/1.1 405 Method Not Allowed');
        echo 'Method Not Allowed';
    }
?>