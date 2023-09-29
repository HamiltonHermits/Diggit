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
    
        // Get the data sent via POST
        $propTitle = isset($_POST['title']) ? $_POST['title'] : '';
    

        // Get description
        $propDescription = isset($_POST['desc']) ? $_POST['desc'] : '';
        // Get searchbar text
        $propAddress= isset($_POST['address']) ? $_POST['address'] : '';

        //Get lat and long
        $propLat = isset($_POST['lat']) ? $_POST['lat'] : '';
        // $propLat = floatval($propLat);
        $propLong = isset($_POST['long']) ? $_POST['long'] : '';
        // $propLong = floatval($propLong);

        // Get amenities array
        $propAmenities = isset($_POST['amenities']) ? $_POST['amenities'] : '';
        // Get tenants array
        $propTenants = isset($_POST['tenants']) ? $_POST['tenants'] : '';

        //Connect to database
        require_once('../Backend_Files/database_connect.php');

        //insert prop title
        $query = "INSERT INTO property (prop_name, created_by, prop_description, address, lat, `long`) 
                    VALUES ('$propTitle', '$userId', '$propDescription', '$propAddress', '$propLat', '$propLong')";
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
            }
        }
        
        //insert prop amenities
        // propAmenities in the form of a string like: "1,2,3,4"
        $propAmenitiesArray = explode(",", $propAmenities); //break string into an array
        foreach ($propAmenitiesArray as $amenity) {
            $query = "INSERT INTO property_amenity (prop_id, amenity_id) VALUES ('$prop_id','$amenity')";
            $result = mysqli_query($conn, $query);
        }

        // insert prop tenants
        $propTenantsArray = explode(",", $propTenants); //break string into an array
        foreach ($propTenantsArray as $tenant) {
            $query = "INSERT INTO tenants (prop_id, tenant_id) VALUES ('$prop_id','$tenant')";
            $result = mysqli_query($conn, $query);
        }
        
        // You can now process the data as needed, e.g., insert it into a database
    
        // For demonstration purposes, we'll just create a response array
        $response['success'] = true;
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