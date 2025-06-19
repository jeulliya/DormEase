<?php
session_start();
include 'db_conn.php';

// Fetch hidden dorms
$sql_hidden = "SELECT * FROM hidden_dorms";
$result_hidden = $conn->query($sql_hidden);

// Check if there are hidden dorms
if ($result_hidden !== false) {
    $hiddenResult = $result_hidden;
}

// Check if the user is logged in and has the appropriate role
if (!isset($_SESSION['username']) || !isset($_SESSION['role']) || $_SESSION['role'] !== 'Admin') {
    // Display an error message
    header("Location: login.php?error=Access denied!");
}


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $dorm_name = isset($_POST['dorm_name']) ? $_POST['dorm_name'] : '';
    $images = isset($_POST['images']) ? $_POST['images'] : '';
    $lat = $_POST['lat'];
    $lng = $_POST['lng'];
    $dorm_owner = $_POST['dorm_owner'];
    $address = $_POST['address'];
    $rooms = $_POST['rooms'];
    $r_fee = $_POST['r_fee'];
    $amenities = isset($_POST['amenities']) ? implode(', ', $_POST['amenities']) : '';
    // If no amenities are selected, set $amenities to an empty string
    $amenities = empty($amenities) ? '' : $amenities;
    $r_avail = $_POST['r_avail'];
    $description = $_POST['description'];
    $b_permit = $_POST['b_permit'];

    $uploadDirectory = "uploads/";

    // File upload handling for dorm images
    if (!empty($_FILES['dorm_images']['name'][0])) {
        $uploadedDormImages = array();
        $allowedExtensions = ['jpg', 'jpeg', 'png'];
        $allowedMimeTypes = ['image/jpeg', 'image/jpg', 'image/png'];
    
        foreach ($_FILES['dorm_images']['name'] as $key => $fileName) {
            $tmp_name = $_FILES['dorm_images']['tmp_name'][$key];
            $fileExtension = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
    
            if (!in_array($fileExtension, $allowedExtensions) || !in_array($_FILES['dorm_images']['type'][$key], $allowedMimeTypes)) {
                $_SESSION['err'] = "Invalid file type. Please upload only JPG, JPEG, or PNG files.";
                exit();
            }
    
            $uploadedFilePath = $uploadDirectory . $fileName;
    
            if (move_uploaded_file($tmp_name, $uploadedFilePath)) {
                $uploadedDormImages[] = $fileName;
            } else {
                $_SESSION['err'] = "Dorm image file upload failed!";
                exit();
            }
        }
        $existingImages = explode(',', trim($existing_dorm_images, ', '));
        $images = implode(', ', array_merge($existingImages, $uploadedDormImages));
        $images = ltrim($images, ',');         

    } else {
        $images = $existing_dorm_images;
    }

// Insert query to add a new dormitory with the uploaded images and map_img
$sql_insert = "INSERT INTO dormitories (images, lat, lng, dorm_name, dorm_owner, address, rooms, r_fee, amenities, r_avail, b_permit, description) 
               VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
$stmt = $conn->prepare($sql_insert);
$stmt->bind_param('sddsssiissss', $images, $lat, $lng, $dorm_name, $dorm_owner, $address, $rooms, $r_fee, $amenities, $r_avail, $b_permit, $description);

// Execute the prepared statement
$stmt->execute();

// Check if the execution was successful
if ($stmt->affected_rows > 0) {
    // Set the session message
    $_SESSION['message'] = "Dormitory added successfully!";

    // Redirect to the same page to display the message
    header('Location: dorm-list.php');
    exit(); // Ensure that no further code is executed after the redirect
} else {
    echo "Error: " . $stmt->error;
}

// Close the prepared statement
$stmt->close();

}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/x-icon" href="favicon.ico">
    <link rel="stylesheet" href="assets/css/dorm-list.css">
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBdDeqiJgvPJAOuYgqok22Wig8_OrFjal8&libraries=places&callback=initMap"></script>
    <title>Dormitories</title>
</head>

<body onload="initMap()">
    <section>
        <?php
        include 'a-navbar.php';
        ?>
    </section>
    <?php if (isset($_SESSION['message'])): ?>
        <div class="msg">
            <?php 
                echo $_SESSION['message']; 
                unset($_SESSION['message']);
            ?>
        </div>
    <?php endif ?>
    <h2 class="add">Add Listing</h2>
    <div class="form-container2" style="margin-top:0;">
        <form method="post" action="dorm-list.php" enctype="multipart/form-data">
            <div class="input-container">
                <label for="dorm_name">Dorm Name:</label>
                <input class="input" type="text" id="dorm_name" name="dorm_name" autocomplete="off" required>
                <!-- File upload element for dorm images -->
                <label for="images">Upload Dorm Images:</label>
                <div id="FileUpload">
                    <div class="wrapper">
                        <div class="upload">
                        <input type="file" id="dorm_images" name="dorm_images[]" style="display:none;" multiple>
                            <div class="upload__button" onclick="document.getElementById('dorm_images').click();">
                                <p>Upload Image</p>
                            </div>
                        </div>
                        <div id="uploadedFiles" class="uploaded">
                            <!-- This is where uploaded files will be displayed -->
                            <?php if (isset($_SESSION['err'])): ?>
                                <div class="error">
                                    <?php 
                                        echo $_SESSION['err']; 
                                        unset($_SESSION['err']);
                                    ?>
                                </div>
                            <?php endif ?>
                        </div>
                    </div>
                </div><br>
                <label for="map">Select Location on Map:</label>
                <div id="map-container"></div><br><br>
                <div class="location-container">
                    <div class="input-pair">
                        <label for="lat">Latitude:</label>
                        <input class="input1" type="text" id="lat" name="lat" autocomplete="off">
                    </div>
                    <div class="input-pair1">
                        <label for="lng">Longitude:</label>
                        <input class="input1" type="text" id="lng" name="lng" autocomplete="off">
                    </div>
                </div>  

                <label for="dorm_owner">Dorm Owner:</label>
                <input class="input" type="text" id="dorm_owner" name="dorm_owner" autocomplete="off" required>
                <label for="address">Address:</label>
                <input class="input" type="text" id="address" name="address" autocomplete="off" required>
                
                <div class="location-container">
                    <div class="input-pair">
                        <label for="rooms">Number of Rooms:</label>
                        <input class="input1" type="text" id="rooms" name="rooms" autocomplete="off" required>
                    </div>
                    <div class="input-pair1">
                        <label for="r_fee">Rental Fee:</label>
                        <input class="input1" type="text" id="r_fee" name="r_fee" autocomplete="off" required>
                    </div>
                </div>  

                <label for="amenities">Amenities:</label>
                <div class="amenities-container">
                    <input type="checkbox" id="amenity_parking" name="amenities[]" value="parking">
                    <label for="amenity_parking" class="a-text">Parking</label>

                    <input type="checkbox" id="amenity_wifi" name="amenities[]" value="wifi">
                    <label for="amenity_wifi" class="a-text">Wifi</label>

                    <input type="checkbox" id="amenity_lounge" name="amenities[]" value="lounge">
                    <label for="amenity_lounge" class="a-text">Lounge</label>

                    <input type="checkbox" id="amenity_kitchen" name="amenities[]" value="kitchen">
                    <label for="amenity_kitchen" class="a-text">Kitchen</label>

                    <input type="checkbox" id="amenity_laundromat" name="amenities[]" value="laundromat">
                    <label for="amenity_laundromat" class="a-text">Laundromat</label>

                    <input type="checkbox" id="amenity_study_area" name="amenities[]" value="study area">
                    <label for="amenity_study_area" class="a-text">Study Area</label><br>

                    <input type="checkbox" id="amenity_canteen" name="amenities[]" value="canteen">
                    <label for="amenity_canteen" class="a-text">Canteen</label>

                    <input type="checkbox" id="amenity_water" name="amenities[]" value="water">
                    <label for="amenity_water">Water</label>

                    <input type="checkbox" id="amenity_electricity" name="amenities[]" value="electricity">
                    <label for="amenity_canteen">Electricity</label>

                    <input type="checkbox" id="amenity_rooftop" name="amenities[]" value="rooftop">
                    <label for="amenity_rooftop">Rooftop</label>
                </div>
                <label for="description">Description:</label>
                <textarea class="input" type="text" id="description" name="description" autocomplete="off"></textarea>
                <label for="r_avail">Room Availability:</label>
                <select name="r_avail" id="r_avail" class="room" required>
                    <option selected disabled hidden></option>
                    <option value="Available"<?php if(isset($_GET['r_avail']) && $_GET['r_avail'] == 'Available') echo ' selected'; ?>>Available</option>
                    <option value="Not Available"<?php if(isset($_GET['r_avail']) && $_GET['r_avail'] == 'Not Available') echo ' selected'; ?>>Not Available</option>
                </select>
                <label for="b_permit" class="permit">Do you have Business Permit?</label>
                    <div class="radio-container">
                        <input type="radio" id="yes" name="b_permit" value="Yes" required>
                        <label for="yes">Yes</label>

                        <input type="radio" id="no" name="b_permit" value="No" required>
                        <label for="no">No</label>
                    </div>
            </div>
                <div class="submit-container2">
                    <input class="submit" type="submit" value="Submit">
                    
                </div>
            </div>
        </form>
    </div>

    <h2 class="dorms">Dormitories</h2><br>

    <div class="search-container">
        <input type="text" id="search" onkeyup="myFunction()" placeholder="Search Dormitories" name="search" autocomplete="off">   
    </div><br>

        <!-- Sorting buttons -->
        <div class="sort">
            <button onclick="sortDorms('Kaytapos')">Brgy. Kaytapos</button>
            <button onclick="sortDorms('Poblacion')">Brgy. Poblacion 1</button>
            <button onclick="sortDorms('Bancod')">Brgy. Bancod</button>
        </div><br><br>

    <div class="centered-table"><br><br>
        <?php

        $sql = "SELECT * FROM dormitories";

        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            echo "<table>";
            echo "<tr>";
            echo "<th>Dorm ID</th>";
            echo "<th>Dorm Name</th>";
            echo "<th>Dorm Owner</th>";
            echo "<th>Address</th>";
            echo "<th>Number of Rooms</th>";
            echo "<th>Rental Fee</th>";
            echo "<th>Amenities</th>";
            echo "<th class='des-column'>Description</th>";
            echo "<th>Room Availability</th>";
            echo "<th>Business Permit</th>";
            echo "<th colspan='4'>Action</th>";
            echo "</tr>";
            while ($row = $result->fetch_assoc()) {
                echo "<tr class='main-table-row'>";
                echo "<td>" . $row["dorm_id"] . "</td>";
                echo "<td>" . $row["dorm_name"] . "</td>";
                echo "<td>" . $row["dorm_owner"] . "</td>";
                echo "<td>" . $row["address"] . "</td>";
                echo "<td>" . $row["rooms"] . "</td>";
                echo "<td>" . $row["r_fee"] . "</td>";
                echo "<td>" . implode(', ', explode(', ', $row["amenities"])) . "</td>";
                echo "<td class='des-column'>" . $row["description"] . "</td>";
                echo "<td>" . $row["r_avail"] . "</td>";
                echo "<td class='" . strtolower($row["b_permit"]) . "'>" . $row["b_permit"] . "</td>";
                echo "<td>";
                echo '<a href="editdorm.php?edit=' . $row['dorm_id'] . '" class="edit_btn">Edit</a>';
                echo "</td>";
                echo "<td>";
                echo '<form method="post" action="hide_dorm.php?redirect=dorm-list.php">';
                echo '<input type="hidden" name="dormId" value="' . $row['dorm_id'] . '">';
                echo '<button type="submit" class="hide_btn">Hide</button>';
                echo '</form>';
                echo "</td>";
                echo "</tr>";
            }
            echo "</table>";
        }

        ?>
    </div>

<h2 class="hidden-dorms">Hidden Dormitories</h2>
<div class="centered-table hidden-table"><br><br>
    <table>
        <tr>
            <th>Dorm ID</th>
            <th>Dorm Name</th>
            <th>Dorm Owner</th>
            <th>Address</th>
            <th>Number of Rooms</th>
            <th>Rental Fee</th>
            <th>Amenities</th>
            <th>Description</th>
            <th>Room Availability</th>
            <th>Business Permit</th>
            <th>Action</th>
        </tr>
        <?php
        // Assume $hiddenRow is the result from fetching hidden dormitories
        while ($hiddenRow = $hiddenResult->fetch_assoc()) {
            echo "<tr data-dorm-id='" . $hiddenRow["dorm_id"] . "' class='hidden-table-row'>";
            echo "<td>" . $hiddenRow["dorm_id"] . "</td>";

            // Display dormitory information with "hidden" in italic style
            echo "<td><i>hidden</i></td>"; // Dorm Name
            echo "<td><i>hidden</i></td>"; // Dorm Owner
            echo "<td><i>hidden</i></td>"; // Address
            echo "<td><i>hidden</i></td>"; // Number of Rooms
            echo "<td><i>hidden</i></td>"; // Rental Fee
            echo "<td><i>hidden</i></td>"; // Amenities
            echo "<td><i>hidden</i></td>"; // Description
            echo "<td><i>hidden</i></td>"; // Room Availability
            echo "<td><i>hidden</i></td>"; // Business Permit

            // Action button for showing the hidden dormitory
            echo "<td>";
            echo '<form method="post" action="show_dorm.php?redirect=dorm-list.php">';
            echo '<input type="hidden" name="dormId" value="' . $hiddenRow['dorm_id'] . '">';
            echo '<button type="submit" class="show_btn">Show</button>';
            echo '</form>';
            echo "</td>";
            echo "</tr>";
        }
        ?>
    </table>
</div>

<script>
    let map;
    let marker;

    function initMap() {
        map = new google.maps.Map(document.getElementById('map-container'), {
            center: { lat: 14.200974449976675, lng: 120.88241101039964 },
            zoom: 15,
            mapId: '6f33173a4413a9fc'
        });

        // Add a marker for the initial location
        marker = new google.maps.Marker({
            position: { lat: 0, lng: 0 },
            map: map,
            draggable: true
        });

        // Add event listener for marker drag
        google.maps.event.addListener(marker, 'dragend', function () {
            updateLatLng(marker.getPosition().lat(), marker.getPosition().lng());
        });

        // Add event listener for map click
        google.maps.event.addListener(map, 'click', function (event) {
            marker.setPosition(event.latLng);
            updateLatLng(event.latLng.lat(), event.latLng.lng());
        });
    }

    function getLocation() {
        // Open the map modal or any other UI logic to interact with the map
    }

    function updateLatLng(lat, lng) {
        // Update the latitude and longitude fields in your form
        document.getElementById('lat').value = lat;
        document.getElementById('lng').value = lng;
    }
</script>

<script src="assets/js/dorm-list.js"></script>
</body>

</html>