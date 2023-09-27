<?php
//Connect to database
include_once('../Backend_Files/config.php');
include_once('../Backend_Files/database_connect.php');

//Get property id

$propId = $_GET["id"];


// $propId = "1";

// Get property
$stmt = $conn->prepare("SELECT * from property WHERE prop_id = ?");
$stmt->bind_param("s", $propId);
$stmt->execute();

$result = $stmt->get_result();
$result = $result->fetch_assoc();
$stmt->close();

//Get agent details who created property
$stmtUser = $conn->prepare(" SELECT usertbl.first_name, usertbl.last_name, usertbl.agent_phone, usertbl.email, usertbl.agent_company
                                 FROM usertbl
                                 JOIN property ON usertbl.user_id = property.created_by 
                                 WHERE property.prop_id = ?;
                               ");
$stmtUser->bind_param("s", $propId);
$stmtUser->execute();

$resultUser = $stmtUser->get_result();
$resultUser = $resultUser->fetch_assoc();


// Get amenities for property
$stmtAmenity = $conn->prepare(" SELECT amenity_test.amenity_name
                                    FROM hamiltonhermits.amenity_test
                                    INNER JOIN property_amenity ON amenity_test.amenity_id = property_amenity.amenity_id
                                    WHERE property_amenity.prop_id = ?;
                                    INNER JOIN property_amenity ON amenity_test.amenity_id = property_amenity.amenity_id
                                    WHERE property_amenity.prop_id = ?;
                                  ");
$stmtAmenity->bind_param("s", $propId);
$stmtAmenity->execute();
$resultAmenity = $stmtAmenity->get_result();
$stmtAmenity->close();


// Get reviews for property
$stmtReview = $conn->prepare(" SELECT review.written_review
                                   FROM hamiltonhermits.review
                                   JOIN hamiltonhermits.usertbl ON review.user_id=usertbl.user_id
                                   WHERE usertbl.user_id = ?;
                                 ");
$stmtReview->bind_param("s", $propId);
$stmtReview->execute();
$resultReview = $stmtReview->get_result();
$stmtReview->close();

// Get reviewer's name for property
$stmtReviewerName = $conn->prepare(" SELECT usertbl.username
                                   FROM hamiltonhermits.usertbl
                                   JOIN hamiltonhermits.review ON usertbl.user_id=review.user_id
                                   WHERE review.user_id= ?;
                                ");
$stmtReviewerName->bind_param("s", $propId);
$stmtReviewerName->execute();
$resultReviewerName = $stmtReviewerName->get_result();
$stmtReviewerName->close();


// Close the database connection
$conn->close();
