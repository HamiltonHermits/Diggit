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
        // Get images
        $propImages = isset($_FILES['file']) ? $_FILES['file'] : '';
        $propImages = time() . $_FILES['file']['name'];
        //move the file to the upload folder
        $destination = "../PropertyPage/images/" . $propImages;
        move_uploaded_file($_FILES['file']['tmp_name'], $destination);
        // Get description
        $propDescription = isset($_POST['desc']) ? $_POST['desc'] : '';
        // Get searchbar text
        $propSearchbar = isset($_POST['searchbar']) ? $_POST['searchbar'] : '';
        // Get amenities array
        $propAmenities = isset($_POST['amenities']) ? $_POST['amenities'] : '';
        // Get tenants array
        $propTenants = isset($_POST['tenants']) ? $_POST['tenants'] : '';

        //Connect to database
        require_once('../Backend_Files/database_connect.php');

        //insert prop title
            $query = "INSERT INTO property (prop_name, created_by, prop_description, address) 
                      VALUES ('$propTitle', '$userId', '$propDescription', '$propSearchbar')";
            $result = mysqli_query($conn, $query) or die(mysqli_error($conn));

        ////////////////////////////////////
        // get prop_id using prop_name
        $query = "SELECT prop_id FROM property WHERE prop_name = '$propTitle'";
        $result = mysqli_query($conn, $query);
        $prop_id = mysqli_fetch_assoc($result)['prop_id'];
        ////////////////////////////////////

        //insert prop images
        $query = "INSERT INTO property_images (prop_id, image_name) VALUES ($prop_id,'$propImages')";
        $result = mysqli_query($conn, $query);
        

        //insert prop description
        // $query = "INSERT INTO searchbar_testing (location) VALUES ('$propDescription')";
        // $result = mysqli_query($conn, $query);

        //insert prop searchbar
        // $query = "INSERT INTO searchbar_testing (location) VALUES ('$propSearchbar')";
        // $result = mysqli_query($conn, $query);

        //insert prop amenities
        // propAmenities in the form of a string like: "wifi,waterTank,electricStove"
        // $propAmenitiesArray = explode(",", $propAmenities); //break string into an array
        // foreach ($propAmenitiesArray as $amenity) {
        //     $query = "INSERT INTO searchbar_testing (location) VALUES ('$amenity')";
        //     $result = mysqli_query($conn, $query);
        // }

        //insert prop tenants
        // $propTenantsArray = explode(",", $propTenants); //break string into an array
        // foreach ($propTenantsArray as $tenant) {
        //     $query = "INSERT INTO searchbar_testing (location) VALUES ('$tenant')";
        //     $result = mysqli_query($conn, $query);
        // }



    
        // You can now process the data as needed, e.g., insert it into a database
    
        // For demonstration purposes, we'll just create a response array
        $response['success'] = true;
        $response['message'] = 'this ran ' . $prop_id . ' successfully';
    
        // Send the JSON response
        header('Content-Type: application/json');
        echo json_encode($response);
    } else {
        // Handle non-POST requests or direct access to this script
        header('HTTP/1.1 405 Method Not Allowed');
        echo 'Method Not Allowed';
    }
?>