<?php
session_start();
include 'db_conn.php';

// Check if the user is logged in and has the appropriate role
if (!isset($_SESSION['username']) || !isset($_SESSION['role']) || $_SESSION['role'] !== 'Admin') {
    // Display an error message
    header("Location: login.php?error=Access denied!");
}

// Get the current sum of all users
$userCountQuery = "SELECT COUNT(*) AS userCount FROM users";
$userCountResult = mysqli_query($conn, $userCountQuery);
$userCount = mysqli_fetch_assoc($userCountResult)['userCount'];

// Get the current sum of all dormitories
$dormCountQuery = "SELECT COUNT(*) AS dormCount FROM dormitories";
$dormCountResult = mysqli_query($conn, $dormCountQuery);
$dormCount = mysqli_fetch_assoc($dormCountResult)['dormCount'];
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="assets/css/a-dashboard.css">
    <link rel="icon" type="image/x-icon" href="favicon.ico">
</head>

<body>
    <section>
        <?php
        include_once 'a-navbar.php';
        ?>
    </section>

<!-- ***** Contact Us Start ***** -->
<section id="dashboard" style="display:flex; align-items:center; justify-content:center; margin-top:10vh;">
        <div class="container" draggable="false">
            <div class="row">
             <!-- Mini Box 1 -->
             <div class="col-md-6">
                <div class="mini-box" style="height:50vh;">
                    <div class="mini-box-content" style="margin-top:10vh;">
                        <h1>Number of Users</h1>
                    <div style="display:flex; align-items:center; justify-content:center; margin-top:6vh;">
                        <img src="assets/images/users.png" style="margin-right:5vh; width:10vh;">
                        <h2 style="font-size:7vh;"><?php echo $userCount; ?></h2>
                    </div>
                    </div>
                </div>
            </div>

          

            <!-- Mini Box 1 -->
            <div class="col-md-6">
                <div class="mini-box" style="height:50vh;">
                    <div class="mini-box-content" style="margin-top:10vh;">
                        <h1>Registered Dormitories</h1>
                        <div style="display:flex; align-items:center; justify-content:center; margin-top:6vh;">
                        <img src="assets/images/dorm.png" style="margin-right:5vh; width:10vh;">
                        <h2 style="font-size:7vh;"><?php echo $dormCount; ?></h2>
                    </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</section>
<!-- ***** Contact Us End ***** -->

</body>



</html>