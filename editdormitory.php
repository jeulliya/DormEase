<?php
session_start();
require_once("db_conn.php");

$dormitoryId = $_SESSION['dormitory_id'];

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
$update = false;

$selectedAmenities = array();

if (isset($_GET['edit'])) {
    $id = $_GET['edit'];
    $update = true;
    $stmt = $conn->prepare("SELECT * FROM dormitories WHERE dorm_id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 1) {
        $n = $result->fetch_assoc();
        $dorm_name = $n['dorm_name'];
        $existing_dorm_images = $n['images'];
        $dorm_owner = $n['dorm_owner'];
        $address = $n['address'];
        $rooms = $n['rooms'];
        $r_fee = $n['r_fee'];
        $selectedAmenities = explode(', ', $n['amenities']);
        $r_avail = $n['r_avail'];
        $description = $n['description'];
    }

    $stmt->close();
}

if (isset($_POST['submit'])) {
    $id = $_POST['dorm_id'];
    $dorm_name = $_POST['dorm_name'];
    $dorm_owner = $_POST['dorm_owner'];
    $address = $_POST['address'];
    $rooms = $_POST['rooms'];
    $r_fee = $_POST['r_fee'];
    $amenities = isset($_POST['amenities']) ? implode(', ', $_POST['amenities']) : '';
    $amenities = empty($amenities) ? '' : $amenities;
    $r_avail = $_POST['r_avail'];
    $description = $_POST['description'];

    $uploadDirectory = "uploads/";

    // File upload handling for dorm images
    if (!empty($_FILES['dorm_images']['name'][0])) {
        $uploadedDormImages = array();
        $allowedExtensions = ['jpg', 'jpeg', 'png'];
        $allowedMimeTypes = ['image/jpeg', 'image/jpg', 'image/png'];

        foreach ($_FILES['dorm_images']['tmp_name'] as $key => $tmp_name) {
            $fileName = basename($_FILES['dorm_images']['name'][$key]);
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

    // File upload handling for map image
    if (!empty($_FILES['map_img_file']['name'])) {
        $allowedExtensions = ['jpg', 'jpeg', 'png'];
        $allowedMimeTypes = ['image/jpeg', 'image/jpg', 'image/png'];
        $fileName = basename($_FILES['map_img_file']['name']);
        $fileExtension = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));

        if (!in_array($fileExtension, $allowedExtensions) || !in_array($_FILES['map_img_file']['type'], $allowedMimeTypes)) {
            $_SESSION['err'] = "Invalid file type. Please upload only JPG, JPEG, or PNG files for the map image.";
            exit();
        }

        $uploadedFilePath = $uploadDirectory . $fileName;

        if (move_uploaded_file($_FILES['map_img_file']['tmp_name'], $uploadedFilePath)) {
            $map_img = $fileName;
        } else {
            echo "Map image file upload failed!";
            exit();
        }
    }

    $stmt = $conn->prepare("UPDATE dormitories SET images=?, dorm_name=?, dorm_owner=?, address=?, rooms=?, r_fee=?, amenities=?, r_avail=?, description=? WHERE dorm_id=?");
    $stmt->bind_param("ssssiisssi", $images, $dorm_name, $dorm_owner, $address, $rooms, $r_fee, $amenities, $r_avail, $description, $id);
    $stmt->execute();
    $stmt->close();

    $_SESSION['message'] = "Dormitory information updated!";
    header('location: do-dashboard.php');
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
    <title>Edit Dormitory</title>
    <style>
    .input-container {
        margin-bottom: 20px;
    }
</style>

</head>

<body>
    <section>
        <?php include 'do-navbar.php'; ?>
    </section>

    <div class="form-container2" style="margin-top:0;">
    <form method="post" action="editdormitory.php?edit=<?php echo $id; ?>" enctype="multipart/form-data">
            <input type="hidden" name="dorm_id" value="<?php echo $id; ?>">
            <div class="input-container">
                <label for="dorm_name">Dorm Name:</label>
                <input class="input" type="text" id="dorm_name" name="dorm_name" value="<?php echo $dorm_name; ?>" readonly>
                <!-- File upload element for dorm images -->
                <label for="dorm_images">Upload Dorm Images:</label>
                <div id="FileUpload">
                    <div class="wrapper">
                        <div class="upload">
                            <input type="file" id="dorm_images" name="dorm_images[]" style="display:none;" multiple>
                            <div class="upload__button" onclick="document.getElementById('dorm_images').click();">
                                <p>Upload Images</p>
                            </div>
                        </div>
                        <div id="uploadedFiles" class="uploaded">
                            <?php if (isset($_SESSION['err'])): ?>
                                <div class="error">
                                    <?php 
                                        echo $_SESSION['err']; 
                                        unset($_SESSION['err']);
                                    ?>
                                </div>
                            <?php endif ?>
                            <?php
                                // Display existing uploaded dorm images when editing
                                $existingImages = explode(', ', trim($existing_dorm_images, ', '));
                                foreach ($existingImages as $imageName) {
                                    echo '<div class="file">';
                                    echo '<div class="file__name">' . $imageName . '</div>';
                                    echo '</div>';
                                }
                                                                                            
                            ?>
                            <!-- This is where uploaded dorm images will be displayed -->
                        </div>
                    </div>
                </div>

                <label for="dorm_owner">Dorm Owner:</label>
                <input class="input" type="text" id="dorm_owner" name="dorm_owner" value="<?php echo $dorm_owner; ?>" readonly required>
                <label for="address">Address:</label>
                <input class="input" type="text" id="address" name="address" value="<?php echo $address; ?>" readonly required>
                
                <div class="location-container">
                    <div class="input-pair">
                        <label for="rooms">Number of Rooms:</label>
                        <input class="input1" type="text" id="rooms" name="rooms" value="<?php echo $rooms?>" autocomplete="off" required>
                    </div>
                    <div class="input-pair1">
                        <label for="r_fee">Rental Fee:</label>
                        <input class="input1" type="text" id="r_fee" name="r_fee" value="<?php echo $r_fee?>" autocomplete="off" required>
                    </div>
                </div> 
                
                <label for="amenities">Amenities:</label>
                <div class="amenities-container">
                    <?php
                    // Define the available amenities
                    $availableAmenities = array("parking", "wifi", "lounge", "kitchen", "laundromat", "study area", "canteen", "water", "electricity", "rooftop");

                    foreach ($availableAmenities as $index => $amenity) {
                        $isChecked = in_array($amenity, $selectedAmenities);
                        ?>
                        <input type="checkbox" id="amenities_<?php echo $amenity; ?>" name="amenities[]" value="<?php echo $amenity; ?>" <?php echo $isChecked ? 'checked' : ''; ?>>
                        <label for="amenities_<?php echo $amenity; ?>"><?php echo ucfirst($amenity); ?></label>
                        <?php

                        // Add a line break after certain checkboxes
                        if ($index === 5) {
                            echo '<br>';
                        }
                    }
                    ?>
                </div>
                <label for="description">Description:</label>
                <textarea class="input" type="text" id="description" name="description"><?php echo $description; ?></textarea>
                <label for="r_avail">Room Availability:</label>
                <select name="r_avail" id="r_avail" class="room">
                <option selected disabled hidden></option>
                    <option value="Available" <?php echo ($r_avail == 'Available') ? 'selected' : ''; ?>>Available</option>
                    <option value="Not Available" <?php echo ($r_avail == 'Not Available') ? 'selected' : ''; ?>>Not Available</option>
                </select>
             
            </div>
            <div class="submit-container2">
                <input class="submit1" type="submit" name="submit" value="Submit">
                <a href="do-dashboard.php" class="cancel" type="cancel" name="cancel">Cancel</a><br>
            </div>
        </form>
    </div>

    <script>
    // Function to create delete button
    function createDeleteButton(fileDiv, fileName) {
        var buttonContainer = document.createElement('div');
        buttonContainer.style.display = 'flex';
        buttonContainer.style.alignItems = 'center';
        buttonContainer.style.marginTop = '-5px';
        buttonContainer.style.marginBottom = '0';

        var deleteButton = document.createElement('img');
        deleteButton.src = 'assets/images/x.png';
        deleteButton.alt = 'Delete';
        deleteButton.style.cursor = 'pointer';
        deleteButton.style.width = '20px';

        deleteButton.addEventListener('click', function () {
            // Make an AJAX call to deleteImage.php with a GET request
            var dormId = <?php echo $id; ?>; // Get the dormitory ID from PHP
            deleteImage(fileName, dormId, fileDiv);
        });

        buttonContainer.appendChild(deleteButton);

        return buttonContainer;
    }

    // Add an event listener for the delete button
    document.querySelectorAll('.file').forEach(function (fileDiv) {
        var fileName = fileDiv.querySelector('.file__name').textContent;

        // Check if the file has a name before adding delete button
        if (fileName.trim() !== '') {
            var deleteButtonContainer = createDeleteButton(fileDiv, fileName);
            fileDiv.appendChild(deleteButtonContainer);
        }
    });

    // Function to delete an image using AJAX
    function deleteImage(fileName, dormId, fileDiv) {
        // Make an AJAX call to deleteImage.php
        $.ajax({
            url: 'deleteImage.php',
            type: 'GET',
            data: {
                dorm_id: dormId,
                image_name: fileName
            },
            success: function (response) {
                // Remove the fileDiv after successful deletion
                fileDiv.remove();
            },
            error: function () {
                alert('Error deleting image. Please try again.');
            }
        });
    }

    // For handling dorm images upload
    document.getElementById('dorm_images').addEventListener('change', function () {
        handleFileUpload(this.files, 'uploadedFiles');
    });

function handleFileUpload(files, containerId) {
    var uploadedFilesContainer = document.getElementById(containerId);

    // Remove existing error messages
    var errorMessages = uploadedFilesContainer.getElementsByClassName('error');
    for (var i = 0; i < errorMessages.length; i++) {
        errorMessages[i].remove();
    }

    for (var i = 0; i < files.length; i++) {
        var file = files[i];

        var fileDiv = document.createElement('div');
        fileDiv.className = 'file';

        if (!isFileExtensionAllowed(file.name)) {
            var errorMessage = document.createElement('div');
            errorMessage.className = 'error';
            errorMessage.textContent = "Invalid file type. Please upload only JPG, JPEG, or PNG files.";

            uploadedFilesContainer.appendChild(errorMessage);
            continue; // Skip this file and move to the next one
        }

        var fileNameDiv = document.createElement('div');
        fileNameDiv.className = 'file__name';
        fileNameDiv.textContent = file.name;

        var deleteButton = createDeleteButton(fileDiv); // Pass the fileDiv to createDeleteButton
        fileNameDiv.appendChild(deleteButton);
        fileDiv.appendChild(fileNameDiv);

        uploadedFilesContainer.appendChild(fileDiv);
    }
}

function isFileExtensionAllowed(fileName) {
    var allowedExtensions = ['jpg', 'jpeg', 'png'];
    var fileExtension = fileName.split('.').pop().toLowerCase();
    return allowedExtensions.includes(fileExtension);
}
</script>

</body>

</html>
