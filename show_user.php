<?php
include 'db_conn.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $userId = $_POST['userId'];

    try {
        // Start a transaction
        $conn->begin_transaction();

        // Fetch user details before showing
        $sql_select_hidden_user = "SELECT * FROM hidden_users WHERE id = ?";
        $stmt_select_hidden_user = $conn->prepare($sql_select_hidden_user);
        $stmt_select_hidden_user->bind_param('i', $userId);
        $stmt_select_hidden_user->execute();
        $result_select_hidden_user = $stmt_select_hidden_user->get_result();
        $hiddenUserDetails = $result_select_hidden_user->fetch_assoc();
        $stmt_select_hidden_user->close();

        // Insert hidden user details into users table
        $sql_show = "INSERT INTO users (id, dormitory_id, firstname, middlename, lastname, username, password, email, gender, role) 
                     VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt_show = $conn->prepare($sql_show);
        $stmt_show->bind_param('iissssssss', 
            $hiddenUserDetails['id'], 
            $hiddenUserDetails['dormitory_id'], 
            $hiddenUserDetails['firstname'], 
            $hiddenUserDetails['middlename'], 
            $hiddenUserDetails['lastname'], 
            $hiddenUserDetails['username'], 
            $hiddenUserDetails['password'], 
            $hiddenUserDetails['email'], 
            $hiddenUserDetails['gender'], 
            $hiddenUserDetails['role']
        );
        $stmt_show->execute();
        $stmt_show->close();

        // Delete the user record from hidden_users table
        $sql_delete_hidden = "DELETE FROM hidden_users WHERE id = ?";
        $stmt_delete_hidden = $conn->prepare($sql_delete_hidden);
        $stmt_delete_hidden->bind_param('i', $userId);
        $stmt_delete_hidden->execute();
        $stmt_delete_hidden->close();

        // Commit the transaction
        $conn->commit();

        $conn->close();

        // Redirect back to adduser.php
        header("Location: adduser.php");
        exit();
    } catch (Exception $e) {
        // An error occurred, roll back the transaction
        $conn->rollback();
        echo "Error: " . $e->getMessage();
    }
}
?>
