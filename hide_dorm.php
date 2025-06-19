<?php
include 'db_conn.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $dormId = $_POST['dormId'];


    // Fetch dormitory details before hiding
    $sql_select_dorm = "SELECT * FROM dormitories WHERE dorm_id = ?";
    $stmt_select_dorm = $conn->prepare($sql_select_dorm);
    $stmt_select_dorm->bind_param('i', $dormId);
    $stmt_select_dorm->execute();
    $result_select_dorm = $stmt_select_dorm->get_result();
    $dormDetails = $result_select_dorm->fetch_assoc();
    $stmt_select_dorm->close();

    // Insert dormitory details into hidden_dorms
    $sql_hide = "INSERT INTO hidden_dorms (dorm_id, images, lat, lng, dorm_name, dorm_owner, address, rooms, r_fee, amenities, r_avail, description, b_permit) 
                 VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt_hide = $conn->prepare($sql_hide);
    $stmt_hide->bind_param('isddsssiissss', 
        $dormDetails['dorm_id'],
        $dormDetails['images'],
        $dormDetails['lat'],
        $dormDetails['lng'],
        $dormDetails['dorm_name'], 
        $dormDetails['dorm_owner'], 
        $dormDetails['address'], 
        $dormDetails['rooms'], 
        $dormDetails['r_fee'], 
        $dormDetails['amenities'], 
        $dormDetails['r_avail'], 
        $dormDetails['description'],
        $dormDetails['b_permit']
    );
    $stmt_hide->execute();
        $stmt_hide->close();

        // Delete the dorm record from the dormitories table
        $sql_delete = "DELETE FROM dormitories WHERE dorm_id = ?";
        $stmt_delete = $conn->prepare($sql_delete);
        $stmt_delete->bind_param('i', $dormId);
        $stmt_delete->execute();
        $stmt_delete->close();
        
        // Redirect back to dorm_list.php or a suitable page
        header("Location: dorm-list.php");
        exit();

}
?>
