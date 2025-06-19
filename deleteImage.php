<?php
session_start();
require_once("db_conn.php");

if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['image_name']) && isset($_GET['dorm_id'])) {
    $fileName = $_GET['image_name'];
    $dormId = $_GET['dorm_id'];

    // Fetch existing dorm images from the database
    $stmt = $conn->prepare("SELECT images FROM dormitories WHERE dorm_id = ?");
    $stmt->bind_param("i", $dormId);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();
        $existing_images = explode(', ', trim($row['images'], ', '));

        // Remove the deleted image from the array
        $existing_images = array_diff($existing_images, array($fileName));

        // Update the dormitory record with the new set of images
        $updated_images = implode(', ', $existing_images);
        $stmt = $conn->prepare("UPDATE dormitories SET images = ? WHERE dorm_id = ?");
        $stmt->bind_param("si", $updated_images, $dormId);
        $stmt->execute();
        $stmt->close();

        // Delete the image file from the server
        $uploadDirectory = "uploads/";
        $image_path = $uploadDirectory . $fileName;

        if (file_exists($image_path)) {
            unlink($image_path);
        }

        echo "Image deleted successfully!";
        exit();
    }
}

// Return an error message if the request is invalid
echo "Invalid request!";
exit();
?>
