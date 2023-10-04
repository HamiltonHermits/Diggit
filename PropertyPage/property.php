<?php
// Start the session (if not already started)
session_start();

$login_username_value = "";
$signup_username_value = "";
$signup_email_value = "";

$isAuthenticated = false;
// Check if a login error message exists
if (isset($_SESSION['login_error'])) {
    $login_error_message = $_SESSION['login_error'];

    $login_username_value = isset($_SESSION['username']) ? $_SESSION['username'] : "";
    // Clear the error message from the session
    unset($_SESSION['login_error']);
}
if (isset($_SESSION['signup_error'])) {
    $signup_error_message = $_SESSION['signup_error'];
    $signup_username_value = isset($_SESSION['username']) ? $_SESSION['username'] : "";
    $signup_email_value = isset($_SESSION['email']) ? $_SESSION['email'] : "";
    // Clear the error message from the session
    unset($_SESSION['signup_error']);
}
if (isset($_SESSION['authenticated']) && $_SESSION['authenticated'] === true) {
    // User is authenticated, show authenticated content
    unset($_SESSION["newPassword"]);
    unset($_SESSION["confirmPass"]);
    unset($_SESSION['password']);
    $isAuthenticated = true;
}

if (isset($_SESSION['changePasswordError'])) {
    $changePasswordError = $_SESSION['changePasswordError'];
    unset($_SESSION['changePasswordError']);
}
if (isset($_SESSION['profileMessage'])) {
    $profileMessage = $_SESSION['profileMessage'];
    unset($_SESSION['changePasswordError']);
}
// if (isset($_GET['id'])) {
//     // Escape and format the data before embedding it in JavaScript
//     $pageId = $_GET['id'];
//     echo "<div style='display: none;' id = pageIdDiv>$pageId</div>";
// }
// if (isset($_SESSION['user_id'])) {
//     // Escape and format the data before embedding it in JavaScript
//     $userId = $_SESSION['user_id'];
//     echo "<div style='display: none;' id = userIdDiv>$userId</div>";
// }


//Connect to database
// require_once('../Backend_Files/config.php');
require_once('../Backend_Files/database_connect.php');

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
if ($result['is_deleted']) header("Location: ../IndexPage/index.php");

$landlordId = $result['created_by'];

$isLandlord = false;
if (isset($_SESSION['user_id']) && $_SESSION['user_id'] == $landlordId) {
    $isLandlord = true;
    $_SESSION['isLandlord'] = $isLandlord;
}
//Get agent details who created property
$stmtUser = $conn->prepare(" SELECT usertbl.first_name, usertbl.last_name, usertbl.agent_phone, usertbl.email, usertbl.agent_company,usertbl.profile_pic
                                 FROM usertbl
                                 JOIN property ON usertbl.user_id = property.created_by 
                                 WHERE property.prop_id = ?;
                               ");
$stmtUser->bind_param("s", $propId);
$stmtUser->execute();

$resultUser = $stmtUser->get_result();
$resultUser = $resultUser->fetch_assoc();
$stmtUser->close();

//Get amenities for property
$stmtAmenity = $conn->prepare(" SELECT amenity_test.amenity_name, amenity_test.amenity_image
                                FROM hamiltonhermits.amenity_test
                                INNER JOIN property_amenity ON amenity_test.amenity_id = property_amenity.amenity_id
                                WHERE property_amenity.prop_id = ?;");
$stmtAmenity->bind_param("s", $propId);
$stmtAmenity->execute();
$resultAmenity = $stmtAmenity->get_result();
$stmtAmenity->close();

//get users that can comment
$stmtAllowedUsers = $conn->prepare(" SELECT * FROM tenants WHERE prop_id = ?;");
$stmtAllowedUsers->bind_param("s", $propId);
$stmtAllowedUsers->execute();
$stmtAllowedUsers = $stmtAllowedUsers->get_result();
$isTenant = false;
while ($row = mysqli_fetch_array($stmtAllowedUsers)) {
    if (isset($_SESSION['email'])) {
        if ($_SESSION['email'] == $row['tenant_id']) {
            $isTenant = true;
        }
    }
}

// Get image for property
$stmtImages = $conn->prepare(" SELECT * FROM property_images WHERE prop_id = ?;");
$stmtImages->bind_param("s", $propId);
$stmtImages->execute();
$resultImages = $stmtImages->get_result(); //this is gonna be all the rows the images are in 
$stmtImages->close();

//get reviews for agent
$stmtReviews = $conn->prepare("SELECT * FROM review WHERE prop_id = ?;");
$stmtReviews->bind_param("s", $propId);
$stmtReviews->execute();
$resultReviews = $stmtReviews->get_result(); // Fetch the results
$stmtReviews->close();

//reviews for the property
$cleanliness = 0.0;
$noise = 0.0;
$location = 0.0;
$safety = 0.0;
$affordability = 0.0;
$overallRating = 0.0;

//reviews for the agent 
$count = 0;
$agentPolite = 0;
$agentQuality = 0;
$agentResponse = 0;
$agentOverall = 0;

$countFive = 0;
$countFour = 0;
$countThree = 0;
$countTwo = 0;
$countOne = 0;
$countOne = 0;
$countTotal = 0;
//we gonna go through and and grab every review
while ($row = mysqli_fetch_array($resultReviews)) {
    if ($row['overall_property_rating'] == 5) $countFive += 1;
    if ($row['overall_property_rating'] == 4) $countFour += 1;
    if ($row['overall_property_rating'] == 3) $countThree += 1;
    if ($row['overall_property_rating'] == 2) $countTwo += 1;
    if ($row['overall_property_rating'] == 1) $countOne += 1;

    $cleanliness += $row['cleanliness_rating'];
    $noise += $row['noise_rating'];
    $location += $row['location_rating'];
    $safety += $row['saftey_rating'];
    $affordability += $row['affordability_rating'];
    $overallRating += $row['overall_property_rating'];

    $agentPolite += $row['politeness_rating'];
    $agentQuality += $row['repair_quality_rating'];
    $agentResponse += $row['response_time_rating'];
    $agentOverall += $row['overall_tenant_rating'];
    $count++;
}
$countTotal = $countFive + $countFour + $countThree + $countTwo + $countOne;
echo "<script>console.log($countTotal);</script>";

//then we are going to average them out
if ($count > 0 && $countTotal > 0) {
    $countPercentFive = $countFive / $countTotal;
    $countPercentFour = $countFour / $countTotal;
    $countPercentThree = $countThree / $countTotal;
    $countPercentTwo = $countTwo / $countTotal;
    $countPercentOne = $countOne / $countTotal;


    $cleanliness /= $count;
    $noise /= $count;
    $location /= $count;
    $safety /= $count;
    $affordability /= $count;
    $overallRating /= $count;

    $agentPolite /= $count;
    $agentQuality /= $count;
    $agentResponse /= $count;
    $agentOverall /= $count;
}



// Close the database connection
$conn->close();

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Diggit</title>
    <link rel="stylesheet" href="property.css" />
    <link rel="stylesheet" href="../generic.css" />
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins" />
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Suez One" />

    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>

    <link rel="icon" type="image/x-icon" href="../crab.png">


    <script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"></script>
    <script src="../Backend_Files/searchbar.js" defer></script>
    <script src="property.js" defer></script>
    <script src="ratingModal.js" defer></script>
    <script src="visualElements.js" defer></script>
    <script src="../Backend_Files/common.js" defer></script>
    <script src="comments.js" defer></script>

</head>

<body>
    <div class="background-sidebar-container" id="outer-sidebar">
        <div class="sidebar" id="inner-sidebar">
            <div class="logo-container">
                <a id="logo" href="../IndexPage/index.php">
                    <div id="digg">Digg</div>
                    <div id="it">It</div>
                </a>

            </div>
            <span class="close" id="closeSignupButton" onclick="hidePhoneSidebar()">&times;</span>
            <div class="page-indicator-container">
                <div class="page-indicator-inner-container" id="prop-indicator">
                    <a class="page-indicator" href="#property-parent-container">
                        <div class="icon">
                            <svg width="30" height="30" viewBox="0 0 40 42" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <mask id="mask0_30_336" style="mask-type:alpha" maskUnits="userSpaceOnUse" x="0" y="0" width="40" height="42">
                                    <rect x="0.0161133" y="0.962891" width="39" height="40.0435" fill="#202024" />
                                </mask>
                                <g mask="url(#mask0_30_336)">
                                    <path d="M31.7927 25.9399V12.4857L24.0143 6.86243L16.2762 12.4857V16.9427H12.4474V10.4863L24.0143 1.94727L35.6214 10.4697V25.9399H31.7927ZM24.5785 15.1932H26.6742V13.0689H24.5785V15.1932ZM21.3543 15.1932H23.45V13.0689H21.3543V15.1932ZM24.5785 18.5255H26.6742V16.4012H24.5785V18.5255ZM21.3543 18.5255H23.45V16.4012H21.3543V18.5255ZM23.047 39.1442L10.9965 35.562V37.7697H0.920898V19.4419H14.4626L24.9009 23.524C25.7876 23.8572 26.5399 24.4126 27.1579 25.1902C27.7759 25.9677 28.0848 27.0507 28.0848 28.4392H31.7524C33.1204 28.4392 34.2752 28.8071 35.2167 29.543C36.1582 30.2789 36.629 31.4521 36.629 33.0628V34.8955L23.047 39.1442ZM4.26601 34.3124H7.57082V22.8992H4.26601V34.3124ZM22.8858 35.562L33.2033 32.313C33.0152 31.7854 32.8039 31.4244 32.5693 31.23C32.3348 31.0356 32.0605 30.9384 31.7465 30.9384H23.3694C22.644 30.9384 21.9051 30.8829 21.1528 30.7718C20.4005 30.6607 19.7691 30.5219 19.2586 30.3553L15.9538 29.2723L16.8404 26.8563L19.6213 27.8144C20.4005 28.0643 21.0876 28.2309 21.6827 28.3142C22.2777 28.3975 23.243 28.4392 24.5785 28.4392C24.5785 28.1059 24.5181 27.7797 24.3972 27.4603C24.2762 27.141 24.068 26.9119 23.7725 26.773L13.8983 22.8992H10.9965V31.9381L22.8858 35.562Z" fill="#D9D9D9" />
                                </g>
                            </svg>
                        </div>
                        Property
                    </a>
                </div>
                <div class="page-indicator-inner-container" id="amenity-indicator">
                    <a class="page-indicator" href="#amenity-parent-container">
                        <div class="icon">
                            <svg width="25" height="25" viewBox="0 0 29 34" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M3.51611 34C2.55361 34 1.72966 33.6671 1.04424 33.0013C0.358822 32.3354 0.0161133 31.535 0.0161133 30.6V3.4C0.0161133 2.465 0.358822 1.66458 1.04424 0.99875C1.72966 0.332917 2.55361 0 3.51611 0H24.5161C25.4786 0 26.3026 0.332917 26.988 0.99875C27.6734 1.66458 28.0161 2.465 28.0161 3.4V30.6C28.0161 31.535 27.6734 32.3354 26.988 33.0013C26.3026 33.6671 25.4786 34 24.5161 34H3.51611ZM3.51611 30.6H24.5161V3.4H3.51611V30.6ZM14.0161 28.9C16.4369 28.9 18.5005 28.0713 20.2067 26.4138C21.913 24.7563 22.7661 22.7517 22.7661 20.4C22.7661 18.0483 21.913 16.0438 20.2067 14.3863C18.5005 12.7288 16.4369 11.9 14.0161 11.9C11.5953 11.9 9.53174 12.7288 7.82549 14.3863C6.11924 16.0438 5.26611 18.0483 5.26611 20.4C5.26611 22.7517 6.11924 24.7563 7.82549 26.4138C9.53174 28.0713 11.5953 28.9 14.0161 28.9ZM14.0161 26.01C13.2578 26.01 12.5213 25.8754 11.8067 25.6063C11.0922 25.3371 10.4578 24.9333 9.90361 24.395L18.1286 16.405C18.6828 16.9433 19.0984 17.5596 19.3755 18.2538C19.6526 18.9479 19.7911 19.6633 19.7911 20.4C19.7911 21.9583 19.2297 23.2829 18.1067 24.3738C16.9838 25.4646 15.6203 26.01 14.0161 26.01ZM7.01611 8.5C7.51195 8.5 7.92757 8.33708 8.26299 8.01125C8.5984 7.68542 8.76611 7.28167 8.76611 6.8C8.76611 6.31833 8.5984 5.91458 8.26299 5.58875C7.92757 5.26292 7.51195 5.1 7.01611 5.1C6.52028 5.1 6.10466 5.26292 5.76924 5.58875C5.43382 5.91458 5.26611 6.31833 5.26611 6.8C5.26611 7.28167 5.43382 7.68542 5.76924 8.01125C6.10466 8.33708 6.52028 8.5 7.01611 8.5ZM12.2661 8.5C12.7619 8.5 13.1776 8.33708 13.513 8.01125C13.8484 7.68542 14.0161 7.28167 14.0161 6.8C14.0161 6.31833 13.8484 5.91458 13.513 5.58875C13.1776 5.26292 12.7619 5.1 12.2661 5.1C11.7703 5.1 11.3547 5.26292 11.0192 5.58875C10.6838 5.91458 10.5161 6.31833 10.5161 6.8C10.5161 7.28167 10.6838 7.68542 11.0192 8.01125C11.3547 8.33708 11.7703 8.5 12.2661 8.5Z" fill="#D9D9D9" />
                            </svg>

                        </div>
                        Amenities
                    </a>
                </div>
                <div class="page-indicator-inner-container" id="review-indicator">
                    <a class="page-indicator" href="#comment-parent-container">
                        <div class="icon">
                            <svg width="25" height="25" viewBox="0 0 34 34" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M11.7142 20.5463L16.5505 17.6464L21.3868 20.5463L20.1054 15.1142L24.4043 11.4383L18.7413 10.989L16.5505 5.84279L14.3597 10.989L8.69667 11.4383L12.9956 15.1142L11.7142 20.5463ZM0.0161133 33.2076V3.80064C0.0161133 2.9021 0.339912 2.13289 0.987509 1.49301C1.63511 0.85314 2.4136 0.533203 3.32299 0.533203H29.778C30.6874 0.533203 31.4659 0.85314 32.1135 1.49301C32.7611 2.13289 33.0849 2.9021 33.0849 3.80064V23.4053C33.0849 24.3038 32.7611 25.073 32.1135 25.7129C31.4659 26.3528 30.6874 26.6727 29.778 26.6727H6.62987L0.0161133 33.2076ZM5.22445 23.4053H29.778V3.80064H3.32299V25.2432L5.22445 23.4053Z" fill="#D9D9D9" />
                            </svg>

                        </div>
                        Reviews
                    </a>
                </div>
                <?php if ($isLandlord) : ?>
                    <div class="page-indicator-inner-container" id="edit-indicator">
                        <a class="page-indicator" href=<?php echo "../CreatePropertyPage/create.php?pageId=$propId"; ?>>
                            <div class="icon">
                                <svg width="25" height="25" viewBox="0 0 34 34" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M11.7142 20.5463L16.5505 17.6464L21.3868 20.5463L20.1054 15.1142L24.4043 11.4383L18.7413 10.989L16.5505 5.84279L14.3597 10.989L8.69667 11.4383L12.9956 15.1142L11.7142 20.5463ZM0.0161133 33.2076V3.80064C0.0161133 2.9021 0.339912 2.13289 0.987509 1.49301C1.63511 0.85314 2.4136 0.533203 3.32299 0.533203H29.778C30.6874 0.533203 31.4659 0.85314 32.1135 1.49301C32.7611 2.13289 33.0849 2.9021 33.0849 3.80064V23.4053C33.0849 24.3038 32.7611 25.073 32.1135 25.7129C31.4659 26.3528 30.6874 26.6727 29.778 26.6727H6.62987L0.0161133 33.2076ZM5.22445 23.4053H29.778V3.80064H3.32299V25.2432L5.22445 23.4053Z" fill="#D9D9D9" />
                                </svg>
                            </div>
                            Edit
                        </a>
                    </div>
                <?php endif; ?>
            </div>
            <div class="settings-container">
                <svg width="30" height="30" viewBox="0 0 45 40" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <mask id="mask0_36_15" style="mask-type:alpha" maskUnits="userSpaceOnUse" x="0" y="0" width="45" height="40">
                        <rect width="45" height="40" fill="#D9D9D9" />
                    </mask>
                    <g mask="url(#mask0_36_15)">
                        <path d="M21.3983 39.7257L20.6641 34.0096C20.2664 33.8608 19.8917 33.6821 19.5399 33.4737C19.1882 33.2653 18.844 33.0421 18.5075 32.8039L13.0473 35.0367L8 26.5519L12.7261 23.0686C12.6955 22.8602 12.6802 22.6593 12.6802 22.4657V21.26C12.6802 21.0665 12.6955 20.8655 12.7261 20.6571L8 17.1739L13.0473 8.689L18.5075 10.9219C18.844 10.6837 19.1958 10.4604 19.5629 10.252C19.93 10.0436 20.297 9.86498 20.6641 9.71612L21.3983 4H31.4928L32.227 9.71612C32.6247 9.86498 32.9994 10.0436 33.3512 10.252C33.7029 10.4604 34.0471 10.6837 34.3836 10.9219L39.8438 8.689L44.8911 17.1739L40.165 20.6571C40.1956 20.8655 40.2109 21.0665 40.2109 21.26V22.4657C40.2109 22.6593 40.1803 22.8602 40.1191 23.0686L44.8452 26.5519L39.7979 35.0367L34.3836 32.8039C34.0471 33.0421 33.6953 33.2653 33.3282 33.4737C32.9612 33.6821 32.5941 33.8608 32.227 34.0096L31.4928 39.7257H21.3983ZM26.5373 28.1149C28.3115 28.1149 29.8257 27.5046 31.0799 26.2839C32.3341 25.0633 32.9612 23.5896 32.9612 21.8629C32.9612 20.1361 32.3341 18.6624 31.0799 17.4418C29.8257 16.2212 28.3115 15.6109 26.5373 15.6109C24.7325 15.6109 23.2107 16.2212 21.9718 17.4418C20.7329 18.6624 20.1135 20.1361 20.1135 21.8629C20.1135 23.5896 20.7329 25.0633 21.9718 26.2839C23.2107 27.5046 24.7325 28.1149 26.5373 28.1149ZM26.5373 24.5423C25.7726 24.5423 25.1226 24.2818 24.5872 23.7608C24.0519 23.2398 23.7843 22.6072 23.7843 21.8629C23.7843 21.1186 24.0519 20.4859 24.5872 19.9649C25.1226 19.4439 25.7726 19.1834 26.5373 19.1834C27.3021 19.1834 27.9521 19.4439 28.4874 19.9649C29.0227 20.4859 29.2904 21.1186 29.2904 21.8629C29.2904 22.6072 29.0227 23.2398 28.4874 23.7608C27.9521 24.2818 27.3021 24.5423 26.5373 24.5423ZM24.6102 36.1532H28.2351L28.8774 31.4195C29.8257 31.1813 30.7052 30.8315 31.5158 30.3701C32.3264 29.9086 33.0682 29.3504 33.7412 28.6954L38.2838 30.5264L40.0732 27.4897L36.1272 24.587C36.2801 24.1702 36.3872 23.731 36.4484 23.2696C36.5096 22.8081 36.5401 22.3392 36.5401 21.8629C36.5401 21.3865 36.5096 20.9176 36.4484 20.4562C36.3872 19.9947 36.2801 19.5556 36.1272 19.1388L40.0732 16.2361L38.2838 13.1994L33.7412 15.075C33.0682 14.3902 32.3264 13.8171 31.5158 13.3557C30.7052 12.8942 29.8257 12.5444 28.8774 12.3062L28.2809 7.57258H24.6561L24.0137 12.3062C23.0654 12.5444 22.1859 12.8942 21.3753 13.3557C20.5647 13.8171 19.8229 14.3754 19.1499 15.0303L14.6074 13.1994L12.8179 16.2361L16.7639 19.0941C16.611 19.5407 16.5039 19.9873 16.4427 20.4338C16.3816 20.8804 16.351 21.3568 16.351 21.8629C16.351 22.3392 16.3816 22.8007 16.4427 23.2472C16.5039 23.6938 16.611 24.1404 16.7639 24.587L12.8179 27.4897L14.6074 30.5264L19.1499 28.6508C19.8229 29.3355 20.5647 29.9086 21.3753 30.3701C22.1859 30.8315 23.0654 31.1813 24.0137 31.4195L24.6102 36.1532Z" fill="#D9D9D9" />
                    </g>
                </svg>

                <div class="settings">&nbsp;Settings</div>
            </div>
        </div>
    </div>
    <main>
        <div class="nav-top">
            <div class="profileContainer" id="dashboardContainer">
                <button id="openModalBtnDashboard" style="z-index: 99;" onclick="showPhoneSidebar()">
                    <svg width="40" height="40" viewBox="0 0 61 50" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <mask id="mask0_30_602" style="mask-type:alpha" maskUnits="userSpaceOnUse" x="0" y="0" width="61" height="50">
                            <rect width="61" height="50" fill="#D9D9D9" />
                        </mask>
                        <g mask="url(#mask0_30_602)">
                            <path d="M10.1665 31.25V27.0833H50.8332V31.25H10.1665ZM10.1665 22.9167V18.75H50.8332V22.9167H10.1665Z" fill="#E96B09" fill-opacity="0.7" />
                        </g>
                    </svg>
                </button>
            </div>
            <div class="searchbar-container">

                <div class="borderSearchBar" id="borderSearchBar">
                    <button type="submit" class="searchButton" id="searchButton">
                        <svg class="svgSearch" viewBox="0 0 28 28" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M19.6705 16.5218L19.6773 16.5121L19.6837 16.5021C20.709 14.8889 21.3112 12.9735 21.3112 10.9149C21.3112 5.16412 16.6544 0.499512 10.9089 0.499512C5.15702 0.499512 0.5 5.1639 0.5 10.9149C0.5 16.6656 5.15681 21.3302 10.9023 21.3302C12.9878 21.3302 14.9306 20.7146 16.5581 19.6615L16.5651 19.6569L16.572 19.6522L16.6779 19.5785L23.4524 26.3531L23.8091 26.7098L24.1626 26.3499L26.3567 24.1169L26.7038 23.7635L26.3537 23.413L19.5871 16.6402L19.6705 16.5218ZM16.1022 5.72806C17.4862 7.1121 18.2474 8.95104 18.2474 10.9084C18.2474 12.8657 17.4862 14.7046 16.1022 16.0887C14.7181 17.4727 12.8792 18.2339 10.9219 18.2339C8.96454 18.2339 7.1256 17.4727 5.74157 16.0887C4.35754 14.7046 3.59635 12.8657 3.59635 10.9084C3.59635 8.95104 4.35754 7.1121 5.74157 5.72806C7.1256 4.34403 8.96455 3.58284 10.9219 3.58284C12.8792 3.58284 14.7181 4.34403 16.1022 5.72806Z" fill="#d9d9d9" stroke="#d9d9d9" />
                        </svg>
                    </button>
                    <input id="searchbar" type="text" class="searchTerm" spellcheck="false" placeholder="Find your Digs..">
                    <!-- <img src="crab/crab.png" alt="" id="crab-logo"> -->
                    <div class="dropdown-filter" id="dropdownFilter">
                        <select id="filterSelect">
                            <option value="" disabled selected>Filter</option>
                            <option value="overallRating">Highest Overall Rating</option>
                        </select>
                    </div>


                </div>
                <div id="dropdown" class="dropdown-content"></div>

            </div>
            <!-- Personalised Search page if authenticated-->
            <?php if ($isAuthenticated) : ?>

                <div class="profileContainer" id="profile">
                    <button id="openModalBtn"><svg width="24" height="25" viewBox="0 0 24 25" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M4.50202 18.875C5.49597 18.0625 6.60686 17.4219 7.83468 16.9531C9.0625 16.4844 10.3488 16.25 11.6935 16.25C13.0383 16.25 14.3246 16.4844 15.5524 16.9531C16.7802 17.4219 17.8911 18.0625 18.8851 18.875C19.5672 18.0208 20.0983 17.0521 20.4783 15.9688C20.8584 14.8854 21.0484 13.7292 21.0484 12.5C21.0484 9.72917 20.1373 7.36979 18.315 5.42188C16.4928 3.47396 14.2856 2.5 11.6935 2.5C9.10148 2.5 6.89432 3.47396 5.07208 5.42188C3.24983 7.36979 2.33871 9.72917 2.33871 12.5C2.33871 13.7292 2.52873 14.8854 2.90877 15.9688C3.28881 17.0521 3.81989 18.0208 4.50202 18.875ZM11.6935 13.75C10.5437 13.75 9.57409 13.3281 8.78478 12.4844C7.99546 11.6406 7.60081 10.6042 7.60081 9.375C7.60081 8.14583 7.99546 7.10938 8.78478 6.26562C9.57409 5.42188 10.5437 5 11.6935 5C12.8434 5 13.813 5.42188 14.6023 6.26562C15.3916 7.10938 15.7863 8.14583 15.7863 9.375C15.7863 10.6042 15.3916 11.6406 14.6023 12.4844C13.813 13.3281 12.8434 13.75 11.6935 13.75ZM11.6935 25C10.0759 25 8.55578 24.6719 7.13306 24.0156C5.71035 23.3594 4.47278 22.4688 3.42036 21.3438C2.36794 20.2188 1.53478 18.8958 0.920867 17.375C0.306956 15.8542 0 14.2292 0 12.5C0 10.7708 0.306956 9.14583 0.920867 7.625C1.53478 6.10417 2.36794 4.78125 3.42036 3.65625C4.47278 2.53125 5.71035 1.64062 7.13306 0.984375C8.55578 0.328125 10.0759 0 11.6935 0C13.3112 0 14.8313 0.328125 16.254 0.984375C17.6768 1.64062 18.9143 2.53125 19.9667 3.65625C21.0192 4.78125 21.8523 6.10417 22.4662 7.625C23.0801 9.14583 23.3871 10.7708 23.3871 12.5C23.3871 14.2292 23.0801 15.8542 22.4662 17.375C21.8523 18.8958 21.0192 20.2188 19.9667 21.3438C18.9143 22.4688 17.6768 23.3594 16.254 24.0156C14.8313 24.6719 13.3112 25 11.6935 25ZM11.6935 22.5C12.7265 22.5 13.7009 22.3385 14.6169 22.0156C15.5329 21.6927 16.371 21.2292 17.1311 20.625C16.371 20.0208 15.5329 19.5573 14.6169 19.2344C13.7009 18.9115 12.7265 18.75 11.6935 18.75C10.6606 18.75 9.68616 18.9115 8.77016 19.2344C7.85417 19.5573 7.01613 20.0208 6.25605 20.625C7.01613 21.2292 7.85417 21.6927 8.77016 22.0156C9.68616 22.3385 10.6606 22.5 11.6935 22.5ZM11.6935 11.25C12.2003 11.25 12.6193 11.0729 12.9506 10.7187C13.2819 10.3646 13.4476 9.91667 13.4476 9.375C13.4476 8.83333 13.2819 8.38542 12.9506 8.03125C12.6193 7.67708 12.2003 7.5 11.6935 7.5C11.1868 7.5 10.7678 7.67708 10.4365 8.03125C10.1052 8.38542 9.93952 8.83333 9.93952 9.375C9.93952 9.91667 10.1052 10.3646 10.4365 10.7187C10.7678 11.0729 11.1868 11.25 11.6935 11.25Z" fill="#AD5511" />
                        </svg></button>
                </div>

            <?php else : ?>

                <div class="loginContainer" id="login">
                    <button type="menu" class="inverseFilledButton loginButton" id="loginButton">Log in</button>
                </div>

            <?php endif; ?>
        </div>

        <div class="parent-container" id="property-parent-container" data-target="prop-indicator">
            <div class="boxes-container">
                <div class="left-box">
                    <div class="prop-title-container">
                        <div class="prop-title">
                            <?php echo $result['prop_name']; ?>
                        </div>
                    </div>
                    <div class="prop-images-container">
                        <div class="arrowContainer" id="left-arrow-container">
                            <button class="left-right-arrow-images" id="left-arrow" onclick="plusSlides(-1)">
                                <svg width="32" height="34" viewBox="0 0 32 34" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <ellipse cx="15.9366" cy="16.8541" rx="15.9366" ry="16.854" transform="rotate(-180 15.9366 16.8541)" fill="#D9D9D9" fill-opacity="0.6" />
                                    <mask id="mask0_531_53" style="mask-type:alpha" maskUnits="userSpaceOnUse" x="0" y="0" width="32" height="34">
                                        <rect x="32" y="34" width="31.8733" height="33.708" rx="15" transform="rotate(-180 32 34)" fill="#D9D9D9" />
                                    </mask>
                                    <g mask="url(#mask0_531_53)">
                                        <path d="M22.7769 8.99644L25 11.1747L18.6293 17.4169L25 23.6592L22.7769 25.8374L14.183 17.4169L22.7769 8.99644ZM10.4668 8.83388L10.4668 26H7.34778L7.34778 8.83388H10.4668Z" fill="#202024" />
                                    </g>
                                </svg>

                            </button>
                        </div>

                        <div class="prop-images">
                            <?php
                            while ($row = mysqli_fetch_array($resultImages)) {
                                echo " 
                                    <div class=\"propertyImage fade\">
                                    <img src= \"images/{$row['image_name']} \" alt=\"property image\">
                                    </div>
                                    ";
                            }
                            ?>
                        </div>

                        <div class="arrowContainer" id="right-arrow-container">
                            <button class="left-right-arrow-images" id="right-arrow" onclick="plusSlides(1)">
                                <svg width="32" height="34" viewBox="0 0 32 34" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <ellipse cx="16.0634" cy="17.1459" rx="15.9366" ry="16.854" fill="#D9D9D9" fill-opacity="0.6" />
                                    <mask id="mask0_30_300" style="mask-type:alpha" maskUnits="userSpaceOnUse" x="0" y="0" width="32" height="34">
                                        <rect width="31.8733" height="33.708" rx="15" fill="#D9D9D9" />
                                    </mask>
                                    <g mask="url(#mask0_30_300)">
                                        <path d="M9.22312 25.0036L7 22.8253L13.3707 16.5831L7 10.3408L9.22312 8.16256L17.817 16.5831L9.22312 25.0036ZM21.5332 25.1661V8H24.6522V25.1661H21.5332Z" fill="#202024" />
                                    </g>
                                </svg>

                            </button>
                        </div>

                    </div>
                    <div class="prop-desc-container">
                        <div class="prop-desc">
                            <?php echo $result['prop_description']; ?>
                            <!-- If you are looking for a flat or an apartment that is situated in a garden setting, this is the place for you! This highly sought after complex is ideally situated close to Rhodes and the Peppergrove Mall and extremely popular with students. It has two sizeable bedrooms, one bathroom, open plan kitchen/lounge, resnet for students, 24 hour security and off street parking. Its on the ground floor which gives you instant access to the garden ar- ...show more
                            If you are looking for a flat or an apartment that is situated in a garden setting, this is the place for you! This highly sought after complex is ideally situated close to Rhodes and the Peppergrove Mall and extremely popular with students. It has two sizeable bedrooms, one bathroom, open plan kitchen/lounge, resnet for students, 24 hour security and off street parking. Its on the ground floor which gives you instant access to the garden ar- ...show more
                            If you are looking for a flat or an apartment that is situated in a garden setting, this is the place for you! This highly sought after complex is ideally situated close to Rhodes and the Peppergrove Mall and extremely popular with students. It has two sizeable bedrooms, one bathroom, open plan kitchen/lounge, resnet for students, 24 hour security and off street parking. Its on the ground floor which gives you instant access to the garden ar- ...show more
                            If you are looking for a flat or an apartment that is situated in a garden setting, this is the place for you! This highly sought after complex is ideally situated close to Rhodes and the Peppergrove Mall and extremely popular with students. It has two sizeable bedrooms, one bathroom, open plan kitchen/lounge, resnet for students, 24 hour security and off street parking. Its on the ground floor which gives you instant access to the garden ar- ...show more
                            If you are looking for a flat or an apartment that is situated in a garden setting, this is the place for you! This highly sought after complex is ideally situated close to Rhodes and the Peppergrove Mall and extremely popular with students. It has two sizeable bedrooms, one bathroom, open plan kitchen/lounge, resnet for students, 24 hour security and off street parking. Its on the ground floor which gives you instant access to the garden ar- ...show more
                            If you are looking for a flat or an apartment that is situated in a garden setting, this is the place for you! This highly sought after complex is ideally situated close to Rhodes and the Peppergrove Mall and extremely popular with students. It has two sizeable bedrooms, one bathroom, open plan kitchen/lounge, resnet for students, 24 hour security and off street parking. Its on the ground floor which gives you instant access to the garden ar- ...show more
                            If you are looking for a flat or an apartment that is situated in a garden setting, this is the place for you! This highly sought after complex is ideally situated close to Rhodes and the Peppergrove Mall and extremely popular with students. It has two sizeable bedrooms, one bathroom, open plan kitchen/lounge, resnet for students, 24 hour security and off street parking. Its on the ground floor which gives you instant access to the garden ar- ...show more
                            If you are looking for a flat or an apartment that is situated in a garden setting, this is the place for you! This highly sought after complex is ideally situated close to Rhodes and the Peppergrove Mall and extremely popular with students. It has two sizeable bedrooms, one bathroom, open plan kitchen/lounge, resnet for students, 24 hour security and off street parking. Its on the ground floor which gives you instant access to the garden ar- ...show more
                            If you are looking for a flat or an apartment that is situated in a garden setting, this is the place for you! This highly sought after complex is ideally situated close to Rhodes and the Peppergrove Mall and extremely popular with students. It has two sizeable bedrooms, one bathroom, open plan kitchen/lounge, resnet for students, 24 hour security and off street parking. Its on the ground floor which gives you instant access to the garden ar- ...show more
                            If you are looking for a flat or an apartment that is situated in a garden setting, this is the place for you! This highly sought after complex is ideally situated close to Rhodes and the Peppergrove Mall and extremely popular with students. It has two sizeable bedrooms, one bathroom, open plan kitchen/lounge, resnet for students, 24 hour security and off street parking. Its on the ground floor which gives you instant access to the garden ar- ...show more -->
                        </div>
                    </div>
                </div>
                <div class="right-box">
                    <div class="top-container">
                        <div class="agent-container">
                            <div class="agent-title">Agent</div>
                            <div class="agent-info-container">
                                <div class="agent-name">
                                    <?php echo "{$resultUser['first_name']} {$resultUser['last_name']}"; ?>
                                </div>
                                <!-- <hr> -->
                                <div class="agent-text-container">
                                    <div class="agent-icon" id="agent-phone-icon">
                                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <mask id="mask0_30_290" style="mask-type:alpha" maskUnits="userSpaceOnUse" x="0" y="0" width="24" height="24">
                                                <rect width="24" height="24" fill="#D9D9D9" />
                                            </mask>
                                            <g mask="url(#mask0_30_290)">
                                                <path d="M19.962 21.2032C17.8543 21.2032 15.772 20.744 13.7149 19.8257C11.6579 18.9074 9.78407 17.604 8.09348 15.9154C6.4029 14.2268 5.09846 12.3533 4.18016 10.295C3.26188 8.23659 2.80273 6.15291 2.80273 4.04393C2.80273 3.68756 2.92095 3.39059 3.15738 3.15301C3.39382 2.91542 3.68937 2.79663 4.04403 2.79663H8.08806C8.41306 2.79663 8.69113 2.89274 8.92228 3.08495C9.15345 3.27717 9.29766 3.52346 9.35491 3.82383L9.99893 7.19828C10.0482 7.52473 10.0409 7.80154 9.97691 8.02871C9.91296 8.25589 9.79041 8.45408 9.60926 8.62328L7.14838 11.0255C7.46577 11.5983 7.84168 12.1562 8.27611 12.6994C8.71053 13.2425 9.19476 13.7727 9.72881 14.2901C10.2256 14.7869 10.7373 15.2421 11.2641 15.6559C11.791 16.0696 12.3431 16.4439 12.9207 16.7787L15.3125 14.4048C15.5063 14.2149 15.744 14.0785 16.0256 13.9956C16.3071 13.9126 16.5944 13.8957 16.8875 13.945L20.1761 14.6271C20.4931 14.7176 20.7436 14.8714 20.9275 15.0882C21.1113 15.3051 21.2033 15.5637 21.2033 15.864V19.9559C21.2033 20.3122 21.0844 20.6092 20.8465 20.8468C20.6086 21.0844 20.3138 21.2032 19.962 21.2032ZM6.06088 8.90426L7.70491 7.30806L7.29186 5.07166H5.10871C5.18408 5.72709 5.29368 6.37407 5.43753 7.01261C5.58138 7.65114 5.78917 8.28169 6.06088 8.90426ZM15.0348 17.8842C15.6609 18.1555 16.3005 18.3725 16.9535 18.5352C17.6066 18.6979 18.2649 18.8082 18.9283 18.8662V16.6961L16.6978 16.2331L15.0348 17.8842Z" fill="#D9D9D9" />
                                            </g>
                                        </svg>

                                    </div>
                                    <div class="agent-info-content" id="agent-phonenumber">
                                        <?php echo "{$resultUser['agent_phone']}"; ?>
                                    </div>
                                </div>
                                <div class="agent-text-container">
                                    <div class="agent-icon" id="agent-email-icon">
                                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <mask id="mask0_30_287" style="mask-type:alpha" maskUnits="userSpaceOnUse" x="0" y="0" width="24" height="24">
                                                <rect width="24" height="24" fill="#D9D9D9" />
                                            </mask>
                                            <g mask="url(#mask0_30_287)">
                                                <path d="M4.275 20.4065C3.64528 20.4065 3.10868 20.1848 2.6652 19.7413C2.22173 19.2978 2 18.7612 2 18.1315V6.27502C2 5.64531 2.22175 5.10871 2.66525 4.66523C3.10872 4.22174 3.64531 4 4.27503 4H20.1315C20.7612 4 21.2978 4.22174 21.7413 4.66523C22.1848 5.10871 22.4066 5.64531 22.4066 6.27502V18.1315C22.4066 18.7612 22.1848 19.2978 21.7413 19.7413C21.2978 20.1848 20.7612 20.4065 20.1315 20.4065H4.275ZM12.2032 13.4603L4.275 8.46035V18.1315H20.1315V8.46035L12.2032 13.4603ZM12.2032 11.275L20.1315 6.27502H4.275L12.2032 11.275ZM4.275 8.46035V6.27502V18.1315V8.46035Z" fill="#D9D9D9" />
                                            </g>
                                        </svg>

                                    </div>
                                    <div class="agent-info-content" id="agent-email">
                                        <?php echo $resultUser['email']; ?>
                                    </div>
                                </div>
                                <div class="agent-text-container">
                                    <div class="agent-icon" id="agent-company-icon">
                                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <mask id="mask0_30_284" style="mask-type:alpha" maskUnits="userSpaceOnUse" x="0" y="0" width="24" height="24">
                                                <rect width="24" height="24" fill="#D9D9D9" />
                                            </mask>
                                            <g mask="url(#mask0_30_284)">
                                                <path d="M3 20.55V6H7V2H17.55V10H21.55V20.55H13.275V16.275H11.275V20.55H3ZM5.275 18.275H7.275V16.275H5.275V18.275ZM5.275 14.275H7.275V12.275H5.275V14.275ZM5.275 10.275H7.275V8.275H5.275V10.275ZM9.275 14.275H11.275V12.275H9.275V14.275ZM9.275 10.275H11.275V8.275H9.275V10.275ZM9.275 6.275H11.275V4.275H9.275V6.275ZM13.275 14.275H15.275V12.275H13.275V14.275ZM13.275 10.275H15.275V8.275H13.275V10.275ZM13.275 6.275H15.275V4.275H13.275V6.275ZM17.275 18.275H19.275V16.275H17.275V18.275ZM17.275 14.275H19.275V12.275H17.275V14.275Z" fill="#D9D9D9" />
                                            </g>
                                        </svg>

                                    </div>
                                    <div class="agent-info-content" id="agent-company">
                                        <?php echo $resultUser['agent_company']; ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="contact-container">
                            <div class="title">Contact</div>
                            <div class="contact-info-container">
                                <form action="mailto:g21j5408@ru.ac.za.com" method="get" enctype="text/plain" class="contact-form">
                                    <label for="details">Your Details</label>
                                    <input type="text" class="contactTextField" placeholder="name" name="subject">
                                    <input type="email" class="contactTextField" placeholder="email" name="email">
                                    <input type="text" class="contactTextField" placeholder="phone number">
                                    <label id="message-label" for="body">Message</label>
                                    <textarea name="body" id="message" placeholder="Please contact the agent regarding this property."></textarea>
                                    <div class="email-btn-container">
                                        <input type="submit" class="email-agent-button inverseFilledButton" value="Email Agent">
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                    <div class="bottom-container">
                        <div class="map-container" id="map">

                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="parent-container" id="amenity-parent-container" data-target="amenity-indicator">
            <div class="boxes-container">
                <div class="left-box" id="left-box-amenity">
                    <div class="title" id="amenity-title">
                        Amenity
                        <hr>
                    </div>

                    <div id="amenity-item-container">
                        <div id="amenity-item-inner-container">
                            <?php
                            $amenityCount = 0;
                            while ($row = mysqli_fetch_array($resultAmenity)) {
                                echo " <div class=\"amenity-item\">
                                                <img id=\"amenity-img\" src=\"amenityImages/{$row['amenity_image']}\" alt=\"\"> {$row['amenity_name']}
                                           </div>";
                                $amenityCount++;
                            }
                            ?>
                        </div>
                    </div>
                    <!-- <div id="show-all-container">
                        <input type="button" name="show-all-btn" value="show all (<?php echo $amenityCount ?>)" id="show-all-btn">
                    </div> -->
                </div>
                <div class="right-box" id="right-box-amenity">
                    <div class="title" id="landlord-title">
                        Landlord
                        <hr>
                    </div>
                    <div class="main-content-landord-container">
                        <div id="picture-name-container">
                            <?php
                            echo "<img src= \"profilepics/{$resultUser['profile_pic']} \" alt=\"profile image\">";
                            ?>
                            <div><?php echo "{$resultUser['first_name']} {$resultUser['last_name']}"; ?></div>
                        </div>
                        <div id="disclaimer">The following information is based on reviews and may not be accurate *</div>
                        <div id="rating-bars-container">
                            <div class="landlord-rating-section">
                                <!-- Politeness Rating -->
                                <div class="rating-item">
                                    <div class="rating-label-container">
                                        <div class="ratingLabels">Politeness:</div>
                                        <!-- <div class="info-circle">
                                            <div class="info-icon">i</div>
                                            <div class="info-tooltip">left lower - right higher</div>
                                        </div> -->
                                    </div>
                                    <div class="rating-progress" id="politenessRatingDisplay">
                                        <div class="progress-bar" style="width: <?php echo $agentPolite * 20; ?>%;"></div>
                                    </div>
                                </div>

                                <!-- Quality of Repair Rating -->
                                <div class="rating-item">
                                    <div class="rating-label-container">
                                        <div class="ratingLabels">Quality of Repair:</div>
                                        <div class="info-circle">
                                            <div class="info-icon">i</div>
                                            <div class="info-tooltip">How helpful has the agent/landlord been with property repairs</div>
                                        </div>
                                    </div>
                                    <div class="rating-progress" id="repairRatingDisplay">
                                        <div class="progress-bar" style="width: <?php echo $agentQuality * 20; ?>%;"></div>
                                    </div>
                                </div>

                                <!-- Response Time Rating -->
                                <div class="rating-item">
                                    <div class="rating-label-container">
                                        <div class="ratingLabels">Response Time:</div>
                                        <div class="info-circle">
                                            <div class="info-icon">i</div>
                                            <div class="info-tooltip">How quick is the wait time when communicating with the agent/landlord</div>
                                        </div>
                                    </div>
                                    <div class="rating-progress" id="responseTimeRatingDisplay">
                                        <div class="progress-bar" style="width: <?php echo $agentResponse * 20; ?>%;"></div>
                                    </div>
                                </div>

                                <!-- Overall Landlord Rating -->
                                <div class="rating-item" id="overall-rating-item">
                                    <div class="inner-rating-item">
                                        <div class="rating-label-container">
                                            <div class="ratingLabels">Overall Landlord Rating:</div>
                                            <!-- <div class="info-circle">
                                                <div class="info-icon">i</div>
                                                <div class="info-tooltip">left lower - right higher</div>
                                            </div> -->
                                        </div>
                                        <div class="rating-progress" id="overallLandlordRatingDisplay">
                                            <div class="progress-bar" style="width: <?php echo $agentOverall * 20; ?>%;"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
        <!-- changes the button based off if you are logged in and can comment -->
        <?php if ($isAuthenticated) : ?>
            <?php if ($isTenant) : ?>
                <div class="rate-prop-btn-container">
                    <button class="rate-property filledButton" id="openRatingModalBtn">
                        Rate Property
                    </button>
                </div>
            <?php else : ?>
                <div class="rate-prop-btn-container">
                    <button class="rate-property filledButton" id="openWhoopsNotAllowed">
                        Rate Property
                    </button>
                </div>
            <?php endif; ?>
        <?php else : ?>
            <div class="rate-prop-btn-container">
                <button class="rate-property filledButton" id="openRatingModalBtnButItsNot">
                    Rate Property
                </button>
            </div>
        <?php endif; ?>

        <div class="parent-container" id="comment-parent-container" data-target="review-indicator">
            <div class="boxes-container">

                <div class="left-box">
                    <div class="comment-label-container">
                        <div class="commentLabel">Reviews</div>
                    </div>
                    <div class="comment-section">


                        <div class="sort-comments-container">
                            <div class="inner-sort-comments-container">
                                <label for="sort-comments">Sort by:</label>
                                <select name="sort-comments" id="sort-comments">
                                    <option value="desc">Highest</option>
                                    <option value="asc">Lowest</option>
                                    <option value="oldest">Oldest</option>
                                    <option value="newest">Newest</option>
                                </select>
                            </div>
                        </div>
                        <div class="comments-list-container">

                            <?php include('comments.php'); ?>

                        </div>

                        <div class="comment-page-container">
                            <!-- <div class="previous-page-container">
                                <button class="previous-page-button firstOrLastPage">Previous</button>
                            </div>
                            <div class="page-number-container">
                                <button class="page-number current-page">1</button>
                                <button class="page-number">2</button>
                                <button class="page-number">3</button>
                            </div>
                            <div class="next-page-container">
                                <button class="next-page-button">Next Page</button>
                            </div> -->
                        </div>
                    </div>
                </div>

                <div class="right-box">
                    <div class="rating-summary-container">
                        <div class="commentLabel">Overall</div>
                        <hr class="horizontal-line-comment">
                        <div class="rating-summary-overall-container">
                            <?php echo "<div class = 'ratingLabel'>$overallRating" ?>
                            <span class="star">&#9733;</span> - <?php echo " $count Reviews</div>" ?>
                        </div>
                        <hr class="horizontal-line-comment">
                        <div class="rating-summary-breakdown">
                            <div class="breakdown-box">
                                <div class="number">5</div> <span class="star">&#9733;</span>
                                <div class="rating-progress">
                                    <div class="progress-bar" style="width: <?php echo $countPercentFive * 100; ?>%;"></div>
                                </div>
                                <div class="amount"><?php echo " $countFive"; ?></div>
                            </div>

                            <!-- 4-star Rating -->
                            <div class="breakdown-box">
                                <div class="number">4</div> <span class="star">&#9733;</span>
                                <div class="rating-progress">
                                    <div class="progress-bar" style="width: <?php echo $countPercentFour * 100; ?>%;"></div>
                                </div>
                                <div class="amount"><?php echo " $countFive"; ?></div>
                            </div>

                            <!-- 3-star Rating -->
                            <div class="breakdown-box">
                                <div class="number">3</div> <span class="star">&#9733;</span>
                                <div class="rating-progress">
                                    <div class="progress-bar" style="width: <?php echo $countPercentThree * 100; ?>%;"></div>
                                </div>
                                <div class="amount"><?php echo " $countThree"; ?></div>
                            </div>

                            <!-- 2-star Rating -->
                            <div class="breakdown-box">
                                <div class="number">2</div> <span class="star">&#9733;</span>
                                <div class="rating-progress">
                                    <div class="progress-bar" style="width: <?php echo $countPercentTwo * 100; ?>%;"></div>
                                </div>
                                <div class="amount"><?php echo " $countTwo"; ?></div>
                            </div>

                            <!-- 1-star Rating -->
                            <div class="breakdown-box">
                                <div class="number">1</div> <span class="star">&#9733;</span>
                                <div class="rating-progress">
                                    <div class="progress-bar" style="width: <?php echo $countPercentOne * 100; ?>%;"></div>
                                </div>
                                <div class="amount"><?php echo " $countOne"; ?></div>
                            </div>
                        </div>

                    </div>
                    <div class=landlord-rating-summary-container>
                        <div class="star-rating-section">
                            <!-- Cleanliness Rating -->
                            <div class="rating-item">
                                <div class="ratingLabels">
                                    <div>Cleanliness</div>
                                </div>
                                <div class="star-rating-display" data-category="cleanliness" data-rating=<?php echo $cleanliness; ?>>
                                    <span class="star">&#9734;</span>
                                    <span class="star">&#9734;</span>
                                    <span class="star">&#9734;</span>
                                    <span class="star">&#9734;</span>
                                    <span class="star">&#9734;</span>
                                </div>
                            </div>

                            <!-- Noise Rating -->
                            <div class="rating-item">
                                <div class="ratingLabels">
                                    <div>Noise</div>
                                </div>
                                <div class="star-rating-display" data-category="noise" data-rating=<?php echo $noise; ?>>
                                    <span class="star">&#9734;</span>
                                    <span class="star">&#9734;</span>
                                    <span class="star">&#9734;</span>
                                    <span class="star">&#9734;</span>
                                    <span class="star">&#9734;</span>
                                </div>
                            </div>

                            <!-- Location Rating -->
                            <div class="rating-item">
                                <div class="ratingLabels">
                                    <div>Location</div>
                                </div>
                                <div class="star-rating-display" data-category="location" data-rating=<?php echo $location; ?>>
                                    <span class="star">&#9734;</span>
                                    <span class="star">&#9734;</span>
                                    <span class="star">&#9734;</span>
                                    <span class="star">&#9734;</span>
                                    <span class="star">&#9734;</span>
                                </div>

                            </div>

                            <!-- Safety Rating -->
                            <div class="rating-item">
                                <div class="ratingLabels">
                                    <div>Safety</div>
                                </div>
                                <div class="star-rating-display" data-category="safety" data-rating=<?php echo $safety; ?>>
                                    <span class="star">&#9734;</span>
                                    <span class="star">&#9734;</span>
                                    <span class="star">&#9734;</span>
                                    <span class="star">&#9734;</span>
                                    <span class="star">&#9734;</span>
                                </div>
                            </div>

                            <!-- Affordability Rating -->
                            <div class="rating-item">
                                <div class="ratingLabels">
                                    <div>Affordability</div>
                                </div>
                                <div class="star-rating-display" data-category="affordability" data-rating=<?php echo $affordability; ?>>
                                    <span class="star">&#9734;</span>
                                    <span class="star">&#9734;</span>
                                    <span class="star">&#9734;</span>
                                    <span class="star">&#9734;</span>
                                    <span class="star">&#9734;</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <footer>
            <img src="../footerImage.png">
            <div class="footer-tc">
                <div class="footer-tc-text-container">
                    <div class="footer-tc-text">&copy Hamilton Hermits 2023.</div>
                    <div class="footer-tc-text">|</div>
                    <div class="footer-tc-text">Rhodes University, Makhanda.</div>
                </div>
        </footer>



        <!-- The login modal -->
        <div id="loginModal" class="modal" style="display:none;">
            <div class="modal-content">
                <span class="close" id="closeButton">&times;</span>
                <h2 class="modalLabel">Login</h2>

                <!-- Display the error message if it exists -->

                <?php if (isset($login_error_message)) { ?>
                    <p class="textWhite"><?php echo $login_error_message; ?></p>
                    <?php echo '<script>loginModal.style.display = "block";</script>'; ?>
                <?php } ?>

                <form id="loginForm" action="../Backend_Files/login.php?page=property&id=<?php echo $propId; ?>" method="POST">
                    <!-- Login form fields -->
                    <label for="username" class="modalLabel">Username:</label>
                    <input type="text" id="username" name="username" value="<?php echo isset($_SESSION['username']) ? htmlspecialchars($_SESSION['username']) : ''; ?>" placeholder="Username" required><br>
                    <label for="password" class="modalLabel">Password:</label>
                    <input type="password" id="password" name="password" value="<?php echo isset($_SESSION['password']) ? htmlspecialchars($_SESSION['password']) : ''; ?>" placeholder="Password" required><br>
                    <input type="submit" id="submitLogin" class="filledButton" value="Login">
                    <button type="button" id="signupButton" class="filledButton">Signup</button>
                </form>

                <!-- Add a button to open the signup modal -->

            </div>
        </div>

        <!-- The signup modal (hidden by default) -->
        <div id="signupModal" class="modal" style="display: none;">
            <div class="modal-content">
                <span class="close" id="closeSignupButton">&times;</span>
                <span class="back-arrow" style="color:white;" id="backToLoginButton">&#8592;</span>
                <h2 class="modalLabel">Signup</h2>

                <!-- Display the error message if it exists -->

                <?php if (isset($signup_error_message)) { ?>
                    <p class="textWhite"><?php echo $signup_error_message; ?></p>
                    <?php echo '<script>signupModal.style.display = "block";</script>'; ?>
                <?php } ?>

                <!-- Signup form fields -->
                <form id="signupForm" action="../Backend_Files/signUp.php?page=property&id=<?php echo $propId; ?>" method="POST">
                    <!-- Signup form fields -->
                    <label for="newUsername" class="modalLabel">Username:</label>
                    <input type="text" id="newUsername" name="newUsername" class="modalInput" value="<?php echo isset($_SESSION['username']) ? htmlspecialchars($_SESSION['username']) : ''; ?>" placeholder="Username" required>
                    <label for="newEmail" class="modalLabel">Email:</label>
                    <input type="email" id="newEmail" name="newEmail" class="modalInput" value="<?php echo isset($_SESSION['email']) ? htmlspecialchars($_SESSION['email']) : ''; ?>" placeholder="example@gmail.com" required>

                    <label for="firstName" class="modalLabel">First Name:</label>
                    <input type="text" id="firstName" name="firstName" class="modalInput" value="<?php echo isset($_SESSION['firstName']) ? htmlspecialchars($_SESSION['firstName']) : ''; ?>" placeholder="e.g: Klark" required>
                    <label for="lastName" class="modalLabel">Last Name:</label>
                    <input type="text" id="lastName" name="lastName" class="modalInput" value="<?php echo isset($_SESSION['lastName']) ? htmlspecialchars($_SESSION['lastName']) : ''; ?>" placeholder="e.g: Kent" required>

                    <label for="newPassword" class="modalLabel">Password:</label>
                    <input type="password" id="newPassword" name="newPassword" class="modalInput" value="<?php echo isset($_SESSION['newPassword']) ? htmlspecialchars($_SESSION['newPassword']) : ''; ?>" placeholder="Password" required>
                    <label for="passwordConfirm" class="modalLabel">Confirm Password:</label>
                    <input type="password" id="passwordConfirm" name="passwordConfirm" class="modalInput" value="<?php echo isset($_SESSION['confirmPass']) ? htmlspecialchars($_SESSION['confirmPass']) : ''; ?>" placeholder="Confirm Password" required>
                    <input type="submit" id="submitSignup" value="Signup">
                </form>
            </div>
        </div>

        <!-- The profile modal (hidden by default) -->
        <div id="profileModal" class="modal" style="display: none;">
            <div class="modal-content">

                <?php if (isset($profileMessage)) { ?>
                    <p class="textWhite"><?php echo $profileMessage; ?></p>
                    <?php echo '<script>profileModal.style.display = "block";</script>'; ?>
                <?php } ?>

                <span class="close" id="closeModalBtn">&times;</span>
                <img id="profileImage" style="max-width: 10vh;" src="../IndexPage/ImagesIndex/User.png" alt="Profile Picture">

                <h2 id="usernameProfile" class="modalLabel">Hello, <?php if (isset($_SESSION['username'])) echo $_SESSION['username']; ?></h2>
                <!-- <p id="fullNameProfile" class = "modalLabel">Fullname: <?php if (isset($_SESSION['fullName'])) /*echo $_SESSION['fullName'];*/ ?></p> -->
                <p id="emailProfile" class="modalLabel"><?php if (isset($_SESSION['email'])) echo $_SESSION['email']; ?></p>
                <p id="userType" class="modalLabel"><?php if (isset($_SESSION["userType"])) echo $_SESSION["userType"]; ?></p>
                <button id="changePasswordBtn" class="inverseFilledButton">Change Password</button>

                <button id="deleteProfileBtn" class="inverseFilledButton">Delete Profile</button>

                <form action="../Backend_Files/logout.php?page=property&id=<?php echo $propId; ?>" method="post" id="formProfileBtn">
                    <button id="logoutButton" type="submit" class="filledButton loginButton">Logout</button>
                </form>
            </div>
        </div>

        <!-- Change Password Modal -->
        <div id="changePasswordModal" class="modal" style="display: none;">
            <div class="modal-content">

                <?php if (isset($changePasswordError)) { ?>
                    <p class="textWhite"><?php echo $changePasswordError; ?></p>
                    <?php echo '<script>changePasswordModal.style.display = "block";</script>'; ?>
                <?php } ?>

                <span class="close" id="closeChangePasswordModalBtn">&times;</span>
                <span class="back-arrow" style="color:white;" id="backToProfile">&#8592;</span>

                <h2>Change Password</h2>
                <form id="changePasswordForm" action="../Backend_Files/change_password.php" method="post">
                    <label for="currentPassword">Current Password:</label>
                    <input type="password" id="currentPassword" class="modalInput" name="currentPassword" required><br>

                    <label for="changeNewPassword">New Password:</label>
                    <input type="password" id="changeNewPassword" class="modalInput" name="changeNewPassword" required><br>

                    <label for="confirmPassword">Confirm New Password:</label>
                    <input type="password" id="confirmPassword" class="modalInput" name="confirmPassword" required><br>
                    <br>

                    <button id="changePasswordButtonFinal" type="submit" class="filledButton" style="display: inline-block;">Change Password</button>
                </form>
            </div>
        </div>
        <!-- Confirm Delete Modal -->
        <div id="confirmDeleteModal" class="modal" style="display: none;">
            <div class="modal-content">
                <span class="close" id="closeDeleteModalBtn">&times;</span>

                <h2>Confirm Delete</h2>
                <p>Are you sure you want to delete your profile?</p>
                <form action="../Backend_Files/deleteProfile.php?page=property&id=<?php echo $propId; ?>" class="confirmDeleteForm" method="post">
                    <button type="submit" class="deleteButton inverseFilledButton">Yes, Delete</button>
                    <button id="cancelDeleteBtn" class="filledButton">Cancel</button>
                </form>

            </div>
        </div>



        <!-- The Rating Modal -->
        <div id="ratingModal" class="modal" style="display: none;" data-page-id="<?php echo $_GET['id']; ?>" data-user-id="<?php echo isset($_SESSION['user_id']) ? $_SESSION['user_id'] : ''; ?>">
            <div class="modal-content" id="ratingModalInner">
                <span class="modal-close" id="closeRatingModalBtn">&times;</span>
                <form id="ratingForm" action="process_ratings.php" method="post">
                    <!-- Property Rating Section -->
                    <div class="rating-section-property">

                        <div class="rating-modal-header">Property Rating</div>
                        <div class="combined-inline-property">
                            <!-- Star Rating Section -->
                            <div class="star-rating-section">

                                <!-- Cleanliness Rating -->
                                <div class="rating-item">
                                    <p class="ratingLabels">Cleanliness</p>
                                    <div class="info-circle">
                                        <div class="info-icon">i</div>
                                        <div class="info-tooltip">More stars = cleaner digs</div>
                                    </div>
                                    <div class="star-rating" data-category="cleanliness" data-rating="0">
                                        <span class="star">&#9734;</span>
                                        <span class="star">&#9734;</span>
                                        <span class="star">&#9734;</span>
                                        <span class="star">&#9734;</span>
                                        <span class="star">&#9734;</span>
                                    </div>
                                </div>

                                <!-- Noise Rating -->
                                <div class="rating-item">
                                    <p class="ratingLabels">Noise</p>
                                    <div class="info-circle">
                                        <div class="info-icon">i</div>
                                        <div class="info-tooltip">More stars = lower noise levels</div>
                                    </div>
                                    <div class="star-rating" data-category="noise" data-rating="0">
                                        <span class="star">&#9734;</span>
                                        <span class="star">&#9734;</span>
                                        <span class="star">&#9734;</span>
                                        <span class="star">&#9734;</span>
                                        <span class="star">&#9734;</span>
                                    </div>
                                </div>

                                <!-- Location Rating -->
                                <div class="rating-item">
                                    <p class="ratingLabels">Location</p>
                                    <div class="info-circle">
                                        <div class="info-icon">i</div>
                                        <div class="info-tooltip">More stars = better location</div>
                                    </div>
                                    <div class="star-rating" data-category="location" data-rating="0">
                                        <span class="star">&#9734;</span>
                                        <span class="star">&#9734;</span>
                                        <span class="star">&#9734;</span>
                                        <span class="star">&#9734;</span>
                                        <span class="star">&#9734;</span>
                                    </div>

                                </div>

                                <!-- Safety Rating -->
                                <div class="rating-item">
                                    <p class="ratingLabels">Safety</p>
                                    <div class="info-circle">
                                        <div class="info-icon">i</div>
                                        <div class="info-tooltip">More stars = higher safety</div>
                                    </div>
                                    <div class="star-rating" data-category="safety" data-rating="0">
                                        <span class="star">&#9734;</span>
                                        <span class="star">&#9734;</span>
                                        <span class="star">&#9734;</span>
                                        <span class="star">&#9734;</span>
                                        <span class="star">&#9734;</span>
                                    </div>
                                </div>

                                <!-- Affordability Rating -->
                                <div class="rating-item">
                                    <p class="ratingLabels">Affordability</p>
                                    <div class="info-circle">
                                        <div class="info-icon">i</div>
                                        <div class="info-tooltip">More stars = better affordability</div>
                                    </div>
                                    <div class="star-rating" data-category="affordability" data-rating="0">
                                        <span class="star">&#9734;</span>
                                        <span class="star">&#9734;</span>
                                        <span class="star">&#9734;</span>
                                        <span class="star">&#9734;</span>
                                        <span class="star">&#9734;</span>
                                    </div>
                                </div>

                                <!-- Overall Property Rating -->
                                <div class="rating-item">
                                    <p class="ratingLabels">Overall Property Rating</p>
                                    <div class="info-circle">
                                        <div class="info-icon">i</div>
                                        <div class="info-tooltip">More stars = better experience</div>
                                    </div>
                                    <div class="star-rating" data-category="overallRating" id="overallRating" data-rating="0">
                                        <span class="star">&#9734;</span>
                                        <span class="star">&#9734;</span>
                                        <span class="star">&#9734;</span>
                                        <span class="star">&#9734;</span>
                                        <span class="star">&#9734;</span>
                                    </div>
                                </div>
                            </div>


                            <!-- Write a Review Section -->
                            <div class="review-section">
                                <div id="writeAReview">Please write a review (optional)</div>
                                <div class="reviewTextarea">
                                    <textarea id="reviewTextarea" name="property_review" maxlength="500" rows="4" cols="50"></textarea>
                                    <div id="wordCount">0/500</div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Landlord Rating Section -->
                    <div class="rating-section-with-submit">
                        <div class="rating-section">
                            <div class="ratingLabel">Landlord Rating</div>

                            <!-- Politeness Rating -->
                            <div class="landlord-rating-section">
                                <div class="rating-item">
                                    <p class="ratingLabels">Politeness:</p>
                                    <!-- <div class="info-circle">
                                        <div class="info-icon">i</div>
                                        <div class="info-tooltip">left lower - right higher</div>
                                    </div> -->
                                    <div class="rating-slider" id="politenessRating">
                                        <input type="range" min="1" max="5" value="3" class="slider" id="politenessSlider">
                                    </div>

                                </div>

                                <!-- Quality of Repair Rating -->
                                <div class="rating-item">
                                    <p class="ratingLabels">Quality of Repair:</p>
                                    <div class="info-circle">
                                        <div class="info-icon">i</div>
                                        <div class="info-tooltip">How helpful has the agent/landlord been with property repairs</div>
                                    </div>
                                    <div class="rating-slider" id="repairRating">
                                        <input type="range" min="1" max="5" value="3" class="slider" id="repairSlider">

                                    </div>

                                </div>

                                <!-- Response Time Rating -->
                                <div class="rating-item">
                                    <p class="ratingLabels">Response Time:</p>
                                    <div class="info-circle">
                                        <div class="info-icon">i</div>
                                        <div class="info-tooltip">How quick is the wait time when communicating with the agent/landlord</div>
                                    </div>
                                    <div class="rating-slider" id="responseTimeRating">
                                        <input type="range" min="1" max="5" value="3" class="slider" id="responseTimeSlider">

                                    </div>

                                </div>

                                <!-- Overall Landlord Rating -->
                                <div class="rating-item">
                                    <p class="ratingLabels">Overall Landlord Rating:</p>
                                    <!-- <div class="info-circle">
                                        <div class="info-icon">i</div>
                                        <div class="info-tooltip">left lower - right higher</div>
                                    </div> -->
                                    <div class="rating-slider" id="overallLandlordRating">
                                        <input type="range" min="1" max="5" value="3" class="slider" id="overallLandlordSlider">

                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Modal footer -->
                        <div class="modal-footer" id="ratingfooter">
                            <button type="submit" id="submitRatingBtn" class="inverseFilledButton">Submit</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <div id="notLoggedInModalSomethingElse" class="modal" style="display: none;">

            <div class="modal-content">
                <span class="close" id="closeNotLoggedInModalSomethingElse">&times;</span>
                <p>Please login to make a review</p>
                <button type="menu" class="filledButton loginButton" id="loginButtonPropertyPage">Log in</button>
            </div>
        </div>
        <div id="notATenantModal" class="modal" style="display: none;">
            <div class="modal-content">
                <span class="close" id="closeNotATenantModal">&times;</span>
                <p>Whoops sorry only tenants are allowed to make a review. Contact your agent so they can add you</p>
            </div>
        </div>
        <!-- if rating sucess -->
        <div id="ratingSuccessfulModal" class="modal" style="display: none;">
            <div class="modal-content">
                <span class="close" id="closeRatingSuccessfulModal">&times;</span>
                <p>Review has been sucessfully made!</p>
            </div>
        </div>
        <!-- if rating unsucc -->
        <div id="ratingUnsuccModal" class="modal" style="display: none;">
            <div class="modal-content">
                <span class="close" id="closeRatingUnsuccModal">&times;</span>
                <p>Whoops! sorry something unexpected happened </p>
                <p>... please try again later</p>
            </div>
        </div>
        <!-- The Modal -->
        <div id="editCommentModal" class="modal" style="display: none;" >
            <div class="modal-content">
                <span class="close" id="closeComentsEdit">&times;</span>
                <h2>Edit Comment</h2>
                <form id="editCommentForm" action="editComment.php" method="POST">
                    <input type="hidden" id="commentId" name="comment_id" value="">
                    <input type="hidden" id="pageId" name="page_id" value=<?php echo $propId; ?>>
                    <textarea id="editCommentText" name="edited_comment" rows="4" cols="50"></textarea>
                    <input type="submit" class="filledButton" name="editComment" value="Save Changes">
                </form>
            </div>
        </div>
    </main>
</body>

</html>