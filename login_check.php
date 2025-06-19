<?php
session_start();
include 'db_conn.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $uname = $_POST['username'];
    $pass = $_POST['password'];

    // Use prepared statements to prevent SQL injection
    $sql = "SELECT * FROM users WHERE username = ? LIMIT 1";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('s', $uname);
    $stmt->execute();
    $result = $stmt->get_result();

    if (empty($uname) || empty($pass)) {
        header("Location: login.php?error=Empty Username or Password");
        exit();
    }

    if ($result && $result->num_rows > 0) {
        $user = $result->fetch_assoc();

        // Check if the entered password is correct
        if (password_verify($pass, $user['password'])) {

            $_SESSION['username'] = $user['username'];
            $_SESSION['role'] = $user['role'];

            // Continue with your role-based redirection
            if ($user['role'] == 'Dormitory Owner') {
                $dormitoryId = $user['dormitory_id'];
                $_SESSION['dormitory_id'] = $dormitoryId;
                header("Location: do-dashboard.php?dorm_id=$dormitoryId");
                exit();
            } elseif ($user['role'] == 'Admin') {
                header('Location: admin-dashboard.php');
                exit();
            }
        } else {
            // Incorrect password
            header("Location: login.php?error=Incorrect password");
            exit();
        }
    } else {
        // User not found
        header("Location: login.php?error=User not found");
        exit();
    }
}
?>
