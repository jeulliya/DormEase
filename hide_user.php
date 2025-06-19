<?php
include 'db_conn.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $userId = $_POST['userId'];

    try {
        // Start a transaction
        $conn->begin_transaction();

        // Fetch user details before hiding
        $sql_select_user = "SELECT * FROM users WHERE id = ?";
        $stmt_select_user = $conn->prepare($sql_select_user);
        $stmt_select_user->bind_param('i', $userId);
        $stmt_select_user->execute();
        $result_select_user = $stmt_select_user->get_result();
        $userDetails = $result_select_user->fetch_assoc();
        $stmt_select_user->close();

        // Insert user details into hidden_users
        $sql_hide = "INSERT INTO hidden_users (id, dormitory_id, firstname, middlename, lastname, username, password, email, gender, role) 
                     VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt_hide = $conn->prepare($sql_hide);
        $stmt_hide->bind_param('iissssssss', 
            $userDetails['id'], 
            $userDetails['dormitory_id'], 
            $userDetails['firstname'], 
            $userDetails['middlename'], 
            $userDetails['lastname'], 
            $userDetails['username'], 
            $userDetails['password'], 
            $userDetails['email'], 
            $userDetails['gender'], 
            $userDetails['role']
        );
        $stmt_hide->execute();
        $stmt_hide->close();

        // Delete the user record from the users table
        $sql_delete = "DELETE FROM users WHERE id = ?";
        $stmt_delete = $conn->prepare($sql_delete);
        $stmt_delete->bind_param('i', $userId);
        $stmt_delete->execute();
        $stmt_delete->close();

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
