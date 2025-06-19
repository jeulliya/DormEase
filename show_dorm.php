<?php
include 'db_conn.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $dormId = $_POST['dormId'];

    try {
        // Fetch dormitory details before showing
        $sql_select_hidden = "SELECT * FROM hidden_dorms WHERE dorm_id = ?";
        $stmt_select_hidden = $conn->prepare($sql_select_hidden);
        $stmt_select_hidden->bind_param('i', $dormId);
        $stmt_select_hidden->execute();
        $result_select_hidden = $stmt_select_hidden->get_result();
        $hiddenDetails = $result_select_hidden->fetch_assoc();
        $stmt_select_hidden->close();

        // Insert dormitory details back into dormitories, including additional fields
        $sql_show = "INSERT INTO dormitories (dorm_id, images, lat, lng, dorm_name, dorm_owner, address, rooms, r_fee, amenities, r_avail, description, b_permit) 
                     VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt_show = $conn->prepare($sql_show);
        $stmt_show->bind_param('isddsssiissss', 
            $hiddenDetails['dorm_id'], 
            $hiddenDetails['images'],
            $hiddenDetails['lat'],
            $hiddenDetails['lng'],
            $hiddenDetails['dorm_name'], 
            $hiddenDetails['dorm_owner'], 
            $hiddenDetails['address'], 
            $hiddenDetails['rooms'], 
            $hiddenDetails['r_fee'], 
            $hiddenDetails['amenities'], 
            $hiddenDetails['r_avail'], 
            $hiddenDetails['description'],
            $hiddenDetails['b_permit']
        );
        $stmt_show->execute();
        $stmt_show->close();

        // Delete the dormitory record from hidden_dorms table
        $sql_delete_hidden = "DELETE FROM hidden_dorms WHERE dorm_id = ?";
        $stmt_delete_hidden = $conn->prepare($sql_delete_hidden);
        $stmt_delete_hidden->bind_param('i', $dormId);
        $stmt_delete_hidden->execute();
        $stmt_delete_hidden->close();

        $conn->close();

        // Send a success response
        echo "Dormitory shown successfully";
    } catch (Exception $e) {
        echo "Error: " . $e->getMessage();
    }
}
?>
