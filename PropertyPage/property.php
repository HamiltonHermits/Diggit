<?php
    //Connect to database
    include_once('../Backend_Files/config.php');
    include_once('../Backend_Files/database_connect.php');

    //Get property id
    $propId = $_GET["id"];
    // $propId = "1";

    // Prepare and execute the SQL query
    $stmt = $conn->prepare("SELECT * from searchbar_testing WHERE ID = ?");
    $stmt->bind_param("s", $propId);
    $stmt->execute();

    // Get the results
    $result = $stmt->get_result();
    $result = $result->fetch_assoc();
    $stmt->close();

    // Get amenities for property
    $stmtAmenity = $conn->prepare(" SELECT amenity_test.amenityName
                                    FROM hamiltonhermits.amenity_test
                                    INNER JOIN property_amenity ON amenity_test.amenityId = property_amenity.amenityId
                                    WHERE property_amenity.propId = ?;
                                  ");
    $stmtAmenity->bind_param("s", $propId);
    $stmtAmenity->execute();
    $resultAmenity = $stmtAmenity->get_result();
    $stmtAmenity->close();

    // Close the database connection
    $conn->close();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Diggit</title>
    <link rel="stylesheet" href="property.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Suez One">
    
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
        integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY="
        crossorigin=""/>
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"
        integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo="
        crossorigin=""></script>


    <script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"></script>
    <script src="property.js" defer></script>
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
                            <div class="icon">[]</div>
                            Property
                    </a>
                    <a class="page-indicator" id="amenity-indicator"href="#">
                            <div class="icon">[]</div>
                            Amenities
                    </a>
                    <a class="page-indicator" id="review-indicator" href="#">
                            <div class="icon">[]</div>
                            Reviews
                    </a>
                </div>
            </div>
            <div class="settings-container">
                <img src="" alt="">
                <div class="settings">Settings</div>
            </div>
        </div>
    </div>
    <main>
        <div class="nav-top">
            <div class="empty-div"></div>
            <div class="searchbar-container">
                    <div class="borderSearchBar" id="borderSearchBar">
                        <button type="submit" class="searchButton" id="searchButton">
                            <svg class="svgSearch" viewBox="0 0 28 28" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M19.6705 16.5218L19.6773 16.5121L19.6837 16.5021C20.709 14.8889 21.3112 12.9735 21.3112 10.9149C21.3112 5.16412 16.6544 0.499512 10.9089 0.499512C5.15702 0.499512 0.5 5.1639 0.5 10.9149C0.5 16.6656 5.15681 21.3302 10.9023 21.3302C12.9878 21.3302 14.9306 20.7146 16.5581 19.6615L16.5651 19.6569L16.572 19.6522L16.6779 19.5785L23.4524 26.3531L23.8091 26.7098L24.1626 26.3499L26.3567 24.1169L26.7038 23.7635L26.3537 23.413L19.5871 16.6402L19.6705 16.5218ZM16.1022 5.72806C17.4862 7.1121 18.2474 8.95104 18.2474 10.9084C18.2474 12.8657 17.4862 14.7046 16.1022 16.0887C14.7181 17.4727 12.8792 18.2339 10.9219 18.2339C8.96454 18.2339 7.1256 17.4727 5.74157 16.0887C4.35754 14.7046 3.59635 12.8657 3.59635 10.9084C3.59635 8.95104 4.35754 7.1121 5.74157 5.72806C7.1256 4.34403 8.96455 3.58284 10.9219 3.58284C12.8792 3.58284 14.7181 4.34403 16.1022 5.72806Z" fill="#AD5511" stroke="#AD5511" />
                            </svg>
                        </button>
                        <input id="searchbar" type="text" class="searchTerm" spellcheck="false" placeholder="Find your Digs..">
                        <div id="dropdown" class="dropdown-content"></div>
                    </div>
                    <div class="crab-logo">crab</div>
            </div>
            <div class="profile-container">
                <button class="profile">profile</button>
            </div>
        </div>

        <div class="parent-container" id="property-parent-container" data-target="prop-indicator">
            <div class="boxes-container">
                <div class="left-box">
                    <div class="prop-title-container">
                        <div class="prop-title"><?php echo $result['name']; ?></div>
                    </div>
                    <div class="prop-images-container">
                        <div class="prop-images">
                            <img src="./propertyImages/<?php echo $result['image']; ?>" alt="property image">
                        </div>
                    </div>
                    <div class="prop-desc-container">
                        <div class="prop-desc">
                            <?php echo $result['description']; ?>
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
                                    Dianne Psi
                                    <!-- <?php echo $result["agentName"]; ?> -->
                                </div>
                                <hr>
                                <div class="agent-phone-container">
                                    <div class="agent-icon" id="agent-phone-icon">icon</div>
                                    <div class="agent-info-content" id="agent-phonenumber">
                                        +27 82 555 5555
                                        <!-- <?php echo $result["agentPhoneNumber"]; ?> -->
                                    </div>
                                </div>
                                <div class="agent-email-container">
                                    <div class="agent-icon" id="agent-email-icon">icon</div>
                                    <div class="agent-info-content" id="agent-email">
                                        diannepsi@property.co.za
                                        <!-- <?php echo $result["agentEmail"]; ?> -->
                                    </div>
                                </div>
                                <div>
                                    <div class="agent-icon" id="agent-company-icon">icon</div>
                                    <div class="agent-info-content" id="agent-company">
                                        Property Co
                                        <!-- <?php echo $result["agentCompany"]; ?> -->
                                    </div>
                                </div>
                            </div>
                        </div>   
                        <div class="contact-container">
                            <div class="title">Contact</div>
                            <div class="contact-info-container">
                                <form action="" class="contact-form">
                                    <label for="details">Your Details</label>
                                    <input type="text">
                                    <input type="text">
                                    <input type="text">
                                    <label id="message-label" for="message">Message</label>
                                    <textarea name="message" id="message" rows="12"></textarea>
                                </form>
                            </div>
                        </div>         
                    </div>
                    <div class="email-btn-container">
                        <button class="email-agent-button">Email Agent</button>
                    </div>
                    <div class="bottom-container">
                        <div class="map-container" id="map">
                            MAP
                        </div>
                    </div>
                </div>   
            </div>
        </div>

        <div class="parent-container" id="amenity-parent-container">
            <div class="boxes-container">
                <div class="left-box" id="left-box-amenity">
                    <div class="title" id="amenity-title">Amenity</div>
                    <hr> 
                    <div id="amenity-item-container">
                        <div id="amenity-item-inner-container">
                            <?php 
                                while ($row = mysqli_fetch_array($resultAmenity)) {
                                    echo " <div class=\"amenity-item\">
                                                <img src=\"#\" alt=\"\">[] {$row['amenityName']}
                                           </div>";
                                }
                            ?>
                        </div>
                    </div>      
                    <div id="show-all-container">
                        <input type="button" name="show-all-btn" value="show all (n)">
                    </div>                  
                </div>
                <div class="right-box">
                    <div class="title" id="landlord-title">Landlord</div>
                    <hr>
                    <div id="picture-name-container">
                        <img src="#" alt="">
                        <div>Dianna Psi</div>
                    </div>
                    <div id="disclaimer">The following information is based on reviews and may not be accurate *</div>
                    <div id="rating-bars-container">
                        <div class="rating-bar">
                            <div class="rating-bar-title">
                                Politeness
                            </div>
                            <div class="rating-bar-rect">
                                [-------------------------]
                            </div>
                        </div>
                        <div class="rating-bar">
                            <div class="rating-bar-title">
                                Quality of repair
                            </div>
                            <div class="rating-bar-rect">
                                [-------------------------]
                            </div>
                        </div>
                        <div class="rating-bar">
                            <div class="rating-bar-title">
                                Response Time
                            </div>
                            <div class="rating-bar-rect">
                                [-------------------------]
                            </div>
                        </div>
                    </div>
                    <div id="overall-rating-container">
                </div>   
            </div>
        </div>

        <div class="rate-prop-btn-container">
            <button class="rate-property">
                Rate Property
            </button>
        </div>
</body>
</html>