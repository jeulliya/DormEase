<?php
session_start();
include 'db_conn.php';

// Check if the user is logged in and has the appropriate role
if (!isset($_SESSION['username']) || !isset($_SESSION['role']) || $_SESSION['role'] !== 'Dormitory Owner') {
    // Display an error message
    header("Location: login.php?error=Access denied!");
}
// Retrieve dormitory information based on the dormitory owner's session
$dormitoryId = $_SESSION['dormitory_id'];

if ($dormitoryId) {
    // Fetch dormitory information based on $dormitoryId and display it
    $sql = "SELECT * FROM dormitories WHERE dorm_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('i', $dormitoryId);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result && $result->num_rows > 0) {
        $dormitory = $result->fetch_assoc();
    } else {
        echo "No dormitory found for the current user.";
    }
} else {
    // Dormitory ID not set in the session
    echo "Dormitory ID not set for the user.";
}

// Initialize variables
$id = 0;
$dorm_name = "";
$existing_dorm_images = "";
$dorm_owner = "";
$address = "";
$rooms = "";
$r_fee = "";
$amenities = "";
$r_avail = "";
$description = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $dorm_name = $_POST['dorm_name'];
    $dorm_owner = $_POST['dorm_owner'];
    $address = $_POST['address'];
    $rooms = $_POST['rooms'];
    $r_fee = $_POST['r_fee'];
    $amenities = isset($_POST['amenities']) ? implode(', ', $_POST['amenities']) : '';
    $r_avail = $_POST['r_avail'];
    $description = $_POST['description'];

    $conn->close();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/x-icon" href="favicon.ico">
    <link rel="stylesheet" href="assets/css/dorm-list.css">
    <title>Dormitories</title>
</head>

<body>
    <section>
        <?php
        include 'do-navbar.php';
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
    <h2 class="add">Edit Listing</h2>
    <div class="form-container2" style="margin-top:0;">
        <form method="post" action="do-dashboard.php">
            <div class="input-container">
                <!-- Use readonly attribute and set value from dormitory information -->
                <label for="dorm_name">Dorm Name:</label>
                <input class="input" type="text" id="dorm_name" name="dorm_name" value="<?php echo $dormitory['dorm_name']; ?>" readonly>

                    <!-- Display existing uploaded dorm images -->
                <label for="dorm_images">Uploaded Dorm Images:</label>
                <div class="uploaded">
                    <?php
                    $existingImages = explode(', ', trim($dormitory['images'], ', '));
                    foreach ($existingImages as $imageName) {
                        echo '<div class="file">';
                        echo '<div class="file__name">' . $imageName . '</div>';
                        echo '</div>';
                    }
                    ?>
                </div>

                <label for="dorm_owner">Dorm Owner:</label>
                <input class="input" type="text" id="dorm_owner" name="dorm_owner" value="<?php echo $dormitory['dorm_owner']; ?>" readonly>
                
                <label for="address">Address:</label>
                <input class="input" type="text" id="address" name="address" value="<?php echo $dormitory['address']; ?>" readonly>
                
                <div class="location-container">
                    <div class="input-pair">
                        <label for="rooms">Number of Rooms:</label>
                        <input class="input1" type="text" id="rooms" name="rooms" value="<?php echo $dormitory['rooms']?>" autocomplete="off" readonly>
                    </div>
                    <div class="input-pair1">
                        <label for="r_fee">Rental Fee:</label>
                        <input class="input1" type="text" id="r_fee" name="r_fee" value="<?php echo $dormitory['r_fee']?>" autocomplete="off" readonly>
                    </div>
                </div> 
                
                <label for="amenities">Amenities:</label>
                <div class="amenities-container">
                    <?php
                    // Define the available amenities
                    $availableAmenities = array("parking", "wifi", "lounge", "kitchen", "laundromat", "study area", "canteen", "water", "electricity", "rooftop");

                    foreach ($availableAmenities as $index => $amenity) {
                        $isChecked = in_array($amenity, explode(', ', $dormitory['amenities']));
                        ?>
                        <input type="checkbox" id="amenities_<?php echo $amenity; ?>" name="amenities[]" value="<?php echo $amenity; ?>" <?php echo $isChecked ? 'checked' : ''; ?> disabled>
                        <label for="amenities_<?php echo $amenity; ?>"><?php echo ucfirst($amenity); ?></label>

                        <?php
                        if ($index === 5) {
                            echo '<br>';
                        }
                    }
                    ?>
                </div>
                
                <label for="description">Description:</label>
                <textarea class="input" type="text" id="description" name="description" readonly><?php echo $dormitory['description']; ?></textarea>
                
                <label for="r_avail">Room Availability:</label>
                <select name="r_avail" id="r_avail" class="room" disabled>
                    <option value="Available" <?php echo ($dormitory['r_avail'] == 'Available') ? 'selected' : ''; ?>>Available</option>
                    <option value="Not Available" <?php echo ($dormitory['r_avail'] == 'Not Available') ? 'selected' : ''; ?>>Not Available</option>
                </select>
            </div>

                <div class="submit-container"><br>
                <a href="editdormitory.php?edit=<?php echo $dormitory['dorm_id']; ?>" class="edit_btn1" name="edit" type="edit">Edit</a>

                </div>
            </div>
        </form>
    </div>
</body>

</html>