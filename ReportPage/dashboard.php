<?php

// Database connection parameters
include_once('../Backend_Files/config.php');
include_once('../Backend_Files/database_connect.php');
// Create a database connection
$conn = new mysqli($db_host, $db_user, $db_pass, $db_name);

// Check if the connection was successful
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

function get_property($conn)
{
    $sql = "SELECT * FROM property";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        echo "<table border='1'>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Description</th>
                <th>Max Tenants</th>
            </tr>";

        // Output data of each row
        getPropertiesPrint($result);
    } else {
        echo "No digs found.";
    }
}
// Close the database connection
$conn->close();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Diggit</title>
    <link rel="stylesheet" href="styleDashboard.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Suez One">

    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>


    <script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"></script>
    <script src="dashboard.js" defer></script>
</head>

<body>
    <div class="background-sidebar-container">
        <div class="sidebar">
            <div class="logo-container">
                <a id="logo" href="../IndexPage/index.php">
                    <div id="digg">Digg</div>
                    <div id="it">It</div>
                </a>

            </div>
            <div class="page-indicator-container">
                <div class="page-indicator-inner-container">
                    <a class="page-indicator" id="prop-indicator" href="#">
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
                    <a class="page-indicator" id="amenity-indicator" href="#">
                        <div class="icon">
                            <svg width="25" height="25" viewBox="0 0 29 34" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M3.51611 34C2.55361 34 1.72966 33.6671 1.04424 33.0013C0.358822 32.3354 0.0161133 31.535 0.0161133 30.6V3.4C0.0161133 2.465 0.358822 1.66458 1.04424 0.99875C1.72966 0.332917 2.55361 0 3.51611 0H24.5161C25.4786 0 26.3026 0.332917 26.988 0.99875C27.6734 1.66458 28.0161 2.465 28.0161 3.4V30.6C28.0161 31.535 27.6734 32.3354 26.988 33.0013C26.3026 33.6671 25.4786 34 24.5161 34H3.51611ZM3.51611 30.6H24.5161V3.4H3.51611V30.6ZM14.0161 28.9C16.4369 28.9 18.5005 28.0713 20.2067 26.4138C21.913 24.7563 22.7661 22.7517 22.7661 20.4C22.7661 18.0483 21.913 16.0438 20.2067 14.3863C18.5005 12.7288 16.4369 11.9 14.0161 11.9C11.5953 11.9 9.53174 12.7288 7.82549 14.3863C6.11924 16.0438 5.26611 18.0483 5.26611 20.4C5.26611 22.7517 6.11924 24.7563 7.82549 26.4138C9.53174 28.0713 11.5953 28.9 14.0161 28.9ZM14.0161 26.01C13.2578 26.01 12.5213 25.8754 11.8067 25.6063C11.0922 25.3371 10.4578 24.9333 9.90361 24.395L18.1286 16.405C18.6828 16.9433 19.0984 17.5596 19.3755 18.2538C19.6526 18.9479 19.7911 19.6633 19.7911 20.4C19.7911 21.9583 19.2297 23.2829 18.1067 24.3738C16.9838 25.4646 15.6203 26.01 14.0161 26.01ZM7.01611 8.5C7.51195 8.5 7.92757 8.33708 8.26299 8.01125C8.5984 7.68542 8.76611 7.28167 8.76611 6.8C8.76611 6.31833 8.5984 5.91458 8.26299 5.58875C7.92757 5.26292 7.51195 5.1 7.01611 5.1C6.52028 5.1 6.10466 5.26292 5.76924 5.58875C5.43382 5.91458 5.26611 6.31833 5.26611 6.8C5.26611 7.28167 5.43382 7.68542 5.76924 8.01125C6.10466 8.33708 6.52028 8.5 7.01611 8.5ZM12.2661 8.5C12.7619 8.5 13.1776 8.33708 13.513 8.01125C13.8484 7.68542 14.0161 7.28167 14.0161 6.8C14.0161 6.31833 13.8484 5.91458 13.513 5.58875C13.1776 5.26292 12.7619 5.1 12.2661 5.1C11.7703 5.1 11.3547 5.26292 11.0192 5.58875C10.6838 5.91458 10.5161 6.31833 10.5161 6.8C10.5161 7.28167 10.6838 7.68542 11.0192 8.01125C11.3547 8.33708 11.7703 8.5 12.2661 8.5Z" fill="#D9D9D9" />
                            </svg>

                        </div>
                        Amenities
                    </a>
                    <!-- <a class="page-indicator" id="review-indicator" href="#">
                        <div class="icon">
                            <svg width="25" height="25" viewBox="0 0 34 34" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M11.7142 20.5463L16.5505 17.6464L21.3868 20.5463L20.1054 15.1142L24.4043 11.4383L18.7413 10.989L16.5505 5.84279L14.3597 10.989L8.69667 11.4383L12.9956 15.1142L11.7142 20.5463ZM0.0161133 33.2076V3.80064C0.0161133 2.9021 0.339912 2.13289 0.987509 1.49301C1.63511 0.85314 2.4136 0.533203 3.32299 0.533203H29.778C30.6874 0.533203 31.4659 0.85314 32.1135 1.49301C32.7611 2.13289 33.0849 2.9021 33.0849 3.80064V23.4053C33.0849 24.3038 32.7611 25.073 32.1135 25.7129C31.4659 26.3528 30.6874 26.6727 29.778 26.6727H6.62987L0.0161133 33.2076ZM5.22445 23.4053H29.778V3.80064H3.32299V25.2432L5.22445 23.4053Z"
                                    fill="#D9D9D9" />
                            </svg>

                        </div>
                        Reviews
                    </a> -->
                </div>
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
            <div class="empty-div"></div>
            <div class="profile-container">
                <button class="profile"><svg width="24" height="25" viewBox="0 0 24 25" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M4.50202 18.875C5.49597 18.0625 6.60686 17.4219 7.83468 16.9531C9.0625 16.4844 10.3488 16.25 11.6935 16.25C13.0383 16.25 14.3246 16.4844 15.5524 16.9531C16.7802 17.4219 17.8911 18.0625 18.8851 18.875C19.5672 18.0208 20.0983 17.0521 20.4783 15.9688C20.8584 14.8854 21.0484 13.7292 21.0484 12.5C21.0484 9.72917 20.1373 7.36979 18.315 5.42188C16.4928 3.47396 14.2856 2.5 11.6935 2.5C9.10148 2.5 6.89432 3.47396 5.07208 5.42188C3.24983 7.36979 2.33871 9.72917 2.33871 12.5C2.33871 13.7292 2.52873 14.8854 2.90877 15.9688C3.28881 17.0521 3.81989 18.0208 4.50202 18.875ZM11.6935 13.75C10.5437 13.75 9.57409 13.3281 8.78478 12.4844C7.99546 11.6406 7.60081 10.6042 7.60081 9.375C7.60081 8.14583 7.99546 7.10938 8.78478 6.26562C9.57409 5.42188 10.5437 5 11.6935 5C12.8434 5 13.813 5.42188 14.6023 6.26562C15.3916 7.10938 15.7863 8.14583 15.7863 9.375C15.7863 10.6042 15.3916 11.6406 14.6023 12.4844C13.813 13.3281 12.8434 13.75 11.6935 13.75ZM11.6935 25C10.0759 25 8.55578 24.6719 7.13306 24.0156C5.71035 23.3594 4.47278 22.4688 3.42036 21.3438C2.36794 20.2188 1.53478 18.8958 0.920867 17.375C0.306956 15.8542 0 14.2292 0 12.5C0 10.7708 0.306956 9.14583 0.920867 7.625C1.53478 6.10417 2.36794 4.78125 3.42036 3.65625C4.47278 2.53125 5.71035 1.64062 7.13306 0.984375C8.55578 0.328125 10.0759 0 11.6935 0C13.3112 0 14.8313 0.328125 16.254 0.984375C17.6768 1.64062 18.9143 2.53125 19.9667 3.65625C21.0192 4.78125 21.8523 6.10417 22.4662 7.625C23.0801 9.14583 23.3871 10.7708 23.3871 12.5C23.3871 14.2292 23.0801 15.8542 22.4662 17.375C21.8523 18.8958 21.0192 20.2188 19.9667 21.3438C18.9143 22.4688 17.6768 23.3594 16.254 24.0156C14.8313 24.6719 13.3112 25 11.6935 25ZM11.6935 22.5C12.7265 22.5 13.7009 22.3385 14.6169 22.0156C15.5329 21.6927 16.371 21.2292 17.1311 20.625C16.371 20.0208 15.5329 19.5573 14.6169 19.2344C13.7009 18.9115 12.7265 18.75 11.6935 18.75C10.6606 18.75 9.68616 18.9115 8.77016 19.2344C7.85417 19.5573 7.01613 20.0208 6.25605 20.625C7.01613 21.2292 7.85417 21.6927 8.77016 22.0156C9.68616 22.3385 10.6606 22.5 11.6935 22.5ZM11.6935 11.25C12.2003 11.25 12.6193 11.0729 12.9506 10.7187C13.2819 10.3646 13.4476 9.91667 13.4476 9.375C13.4476 8.83333 13.2819 8.38542 12.9506 8.03125C12.6193 7.67708 12.2003 7.5 11.6935 7.5C11.1868 7.5 10.7678 7.67708 10.4365 8.03125C10.1052 8.38542 9.93952 8.83333 9.93952 9.375C9.93952 9.91667 10.1052 10.3646 10.4365 10.7187C10.7678 11.0729 11.1868 11.25 11.6935 11.25Z" fill="#AD5511" />
                    </svg>
                </button>
            </div>
        </div>

        <div class="parent-container" id="property-parent-container" data-target="prop-indicator">
            <div class="boxes-container">
                <div class="left-box">
                    <div class="report-title-container">
                        <div class="report-title">
                            Tenant Report
                        </div>
                    </div>
                    <div class="searchbar-container-container">
                        <div class="searchbar-container">
                            <div class="borderSearchBar" id="borderSearchBar">
                                <button type="submit" class="searchButton" id="searchButton">
                                    <svg viewBox="0 0 18 19" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M16.6 18.5L10.3 12.2C9.8 12.6 9.225 12.9167 8.575 13.15C7.925 13.3833 7.23333 13.5 6.5 13.5C4.68333 13.5 3.14583 12.8708 1.8875 11.6125C0.629167 10.3542 0 8.81667 0 7C0 5.18333 0.629167 3.64583 1.8875 2.3875C3.14583 1.12917 4.68333 0.5 6.5 0.5C8.31667 0.5 9.85417 1.12917 11.1125 2.3875C12.3708 3.64583 13 5.18333 13 7C13 7.73333 12.8833 8.425 12.65 9.075C12.4167 9.725 12.1 10.3 11.7 10.8L18 17.1L16.6 18.5ZM6.5 11.5C7.75 11.5 8.8125 11.0625 9.6875 10.1875C10.5625 9.3125 11 8.25 11 7C11 5.75 10.5625 4.6875 9.6875 3.8125C8.8125 2.9375 7.75 2.5 6.5 2.5C5.25 2.5 4.1875 2.9375 3.3125 3.8125C2.4375 4.6875 2 5.75 2 7C2 8.25 2.4375 9.3125 3.3125 10.1875C4.1875 11.0625 5.25 11.5 6.5 11.5Z" fill="#D9D9D9" />
                                    </svg>
                                </button>
                                <input id="searchbar" type="text" class="searchTerm" spellcheck="false" placeholder="Search for a Tenant..">
                                <div id="dropdown" class="dropdown-content"></div>
                            </div>
                        </div>
                    </div>
                    <div id="generateReportButton" class="generateReportButton">
                        <button id="generateTenantReport" class="filledButton">Generate Report</button>
                        <button id="allTenantReport" class="filledButton"><a href="/SysDev/HamiltonHermits/ReportPage/tenantReport.php"> All Tenants</a></button>
                    </div>
                    <div class="report-container" id="tenant-report-container">
                        <div class="report-text-container" id="tenant-report-text-container">
                            <!-- php here -->
                        </div>

                    </div>
                </div>

                <div class="right-box">
                    <div class="report-title-container">
                        <div class="report-title">
                            Property Report
                        </div>
                    </div>
                    <div class="searchbar-container-container">
                        <div class="searchbar-container">
                            <div class="borderSearchBar" id="borderSearchBar">
                                <button type="submit" class="searchButton" id="searchButton">
                                    <svg viewBox="0 0 18 19" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M16.6 18.5L10.3 12.2C9.8 12.6 9.225 12.9167 8.575 13.15C7.925 13.3833 7.23333 13.5 6.5 13.5C4.68333 13.5 3.14583 12.8708 1.8875 11.6125C0.629167 10.3542 0 8.81667 0 7C0 5.18333 0.629167 3.64583 1.8875 2.3875C3.14583 1.12917 4.68333 0.5 6.5 0.5C8.31667 0.5 9.85417 1.12917 11.1125 2.3875C12.3708 3.64583 13 5.18333 13 7C13 7.73333 12.8833 8.425 12.65 9.075C12.4167 9.725 12.1 10.3 11.7 10.8L18 17.1L16.6 18.5ZM6.5 11.5C7.75 11.5 8.8125 11.0625 9.6875 10.1875C10.5625 9.3125 11 8.25 11 7C11 5.75 10.5625 4.6875 9.6875 3.8125C8.8125 2.9375 7.75 2.5 6.5 2.5C5.25 2.5 4.1875 2.9375 3.3125 3.8125C2.4375 4.6875 2 5.75 2 7C2 8.25 2.4375 9.3125 3.3125 10.1875C4.1875 11.0625 5.25 11.5 6.5 11.5Z" fill="#D9D9D9" />
                                    </svg>
                                </button>
                                <input id="searchbar" type="text" class="searchTerm" spellcheck="false" placeholder="Search for a Property..">
                                <div id="dropdown" class="dropdown-content"></div>
                            </div>
                        </div>
                    </div>
                    <div id="generateReportButton" class="generateReportButton">
                        <button id="generatePropertyReport" class="filledButton">Generate Report</button>
                        <button id="allPropertyReport" class="filledButton" onclick="get_property()">List All Properties</button>
                    </div>
                    <div class="report-container" id="property-report-container">
                        <div class="report-text-container" id="property-report-text-container">
                            <?php
                            function getPropertiesPrint($result){
                                while ($row = $result->fetch_assoc()) {
                                    echo "<tr>
                                        <td>" . $row["prop_id"] . "</td>
                                        <td>" . $row["prop_name"] . "</td>
                                        <td>" . $row["prop_description"] . "</td>
                                        <td>" . $row["max_tenants"] . "</td>
                                    </tr>";
                                }
                        
                                echo "</table>";
                            }
                            ?>
                        </div>

                    </div>
                </div>
            </div>
        </div>

        <div class="parent-container" id="property-parent-container" data-target="prop-indicator">
            <div class="boxes-container">
                <div class="left-box">
                    <div class="report-title-container">
                        <div class="report-title">
                            Tenant Report
                        </div>
                    </div>
                    <div class="searchbar-container-container">
                        <div class="searchbar-container">
                            <div class="borderSearchBar" id="borderSearchBar">
                                <button type="submit" class="searchButton" id="searchButton">
                                    <svg viewBox="0 0 18 19" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M16.6 18.5L10.3 12.2C9.8 12.6 9.225 12.9167 8.575 13.15C7.925 13.3833 7.23333 13.5 6.5 13.5C4.68333 13.5 3.14583 12.8708 1.8875 11.6125C0.629167 10.3542 0 8.81667 0 7C0 5.18333 0.629167 3.64583 1.8875 2.3875C3.14583 1.12917 4.68333 0.5 6.5 0.5C8.31667 0.5 9.85417 1.12917 11.1125 2.3875C12.3708 3.64583 13 5.18333 13 7C13 7.73333 12.8833 8.425 12.65 9.075C12.4167 9.725 12.1 10.3 11.7 10.8L18 17.1L16.6 18.5ZM6.5 11.5C7.75 11.5 8.8125 11.0625 9.6875 10.1875C10.5625 9.3125 11 8.25 11 7C11 5.75 10.5625 4.6875 9.6875 3.8125C8.8125 2.9375 7.75 2.5 6.5 2.5C5.25 2.5 4.1875 2.9375 3.3125 3.8125C2.4375 4.6875 2 5.75 2 7C2 8.25 2.4375 9.3125 3.3125 10.1875C4.1875 11.0625 5.25 11.5 6.5 11.5Z" fill="#D9D9D9" />
                                    </svg>
                                </button>
                                <input id="searchbar" type="text" class="searchTerm" spellcheck="false" placeholder="Search for a Tenant..">
                                <div id="dropdown" class="dropdown-content"></div>
                            </div>
                        </div>
                    </div>
                    <div id="generateReportButton" class="generateReportButton">
                        <button id="generateTenantReport" class="filledButton">Generate Report</button>
                    </div>
                    <div class="report-container" id="tenant-report-container">
                        <div class="report-text-container" id="tenant-report-text-container">
                            <!-- php here -->
                        </div>

                    </div>
                </div>

                <div class="right-box">
                    <div class="report-title-container">
                        <div class="report-title">
                            Criteria Report
                        </div>
                    </div>
                    <div class="searchbar-container-container">
                        <div class="searchbar-container">
                            <div class="borderSearchBar" id="borderSearchBar">
                                <button type="submit" class="searchButton" id="searchButton">
                                    <svg viewBox="0 0 18 19" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M16.6 18.5L10.3 12.2C9.8 12.6 9.225 12.9167 8.575 13.15C7.925 13.3833 7.23333 13.5 6.5 13.5C4.68333 13.5 3.14583 12.8708 1.8875 11.6125C0.629167 10.3542 0 8.81667 0 7C0 5.18333 0.629167 3.64583 1.8875 2.3875C3.14583 1.12917 4.68333 0.5 6.5 0.5C8.31667 0.5 9.85417 1.12917 11.1125 2.3875C12.3708 3.64583 13 5.18333 13 7C13 7.73333 12.8833 8.425 12.65 9.075C12.4167 9.725 12.1 10.3 11.7 10.8L18 17.1L16.6 18.5ZM6.5 11.5C7.75 11.5 8.8125 11.0625 9.6875 10.1875C10.5625 9.3125 11 8.25 11 7C11 5.75 10.5625 4.6875 9.6875 3.8125C8.8125 2.9375 7.75 2.5 6.5 2.5C5.25 2.5 4.1875 2.9375 3.3125 3.8125C2.4375 4.6875 2 5.75 2 7C2 8.25 2.4375 9.3125 3.3125 10.1875C4.1875 11.0625 5.25 11.5 6.5 11.5Z" fill="#D9D9D9" />
                                    </svg>
                                </button>
                                <input id="searchbar" type="text" class="searchTerm" spellcheck="false" placeholder="Search for a Property..">
                                <div id="dropdown" class="dropdown-content"></div>
                            </div>
                        </div>
                    </div>
                    <div id="generateReportButton" class="generateReportButton">
                        <button id="generateCriteriaReport" class="filledButton">Generate Report</button>
                    </div>
                    <div class="report-container" id="criteria-report-container">
                        <div class="report-text-container" id="criteria-report-text-container">
                            <!-- php here -->
                        </div>

                    </div>
                </div>
            </div>
        </div>


        <div class="rate-prop-btn-container">
            <button id="rate-property" class="filledButton">
                Save Property
            </button>
        </div>
</body>

</html>