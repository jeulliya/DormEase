<?php 
session_start();
require_once("db_conn.php");

// initialize variables
$dorm_id = 0;
$dorm_name = "";
$dorm_owner = "";
$address = "";
$rooms = "";
$r_fee = "";
$amenities = "";
$descr = "";
$r_avail = "";
$update = false;

if (isset($_POST['submit'])) {
    $dorm_name = $_POST['dorm_name'];
    $dorm_owner = $_POST['dorm_owner'];
    $address = $_POST['address'];
    $rooms = $_POST['rooms'];
    $r_fee = $_POST['r_fee'];
    $amenities = $_POST['amenities'];
    $description = $_POST['description'];
    $r_avail = $_POST['r_avail'];

    mysqli_query($conn, "INSERT INTO dormitories (dorm_name, dorm_owner, address, rooms, r_fee, amenities, description, r_avail) 
    VALUES ('$dorm_name', '$dorm_owner', '$address', '$rooms', '$r_fee', '$amenities', '$description', '$r_avail')"); 
    $_SESSION['message'] = "Dormitory information saved"; 
    header('location: dorm-list.php');
}

if (isset($_GET['del'])) {
    $dorm_id = $_GET['del'];
    mysqli_query($conn, "DELETE FROM dormitories WHERE dorm_id=$dorm_id");
    $_SESSION['message'] = "Dormitory information deleted!"; 
    header('location: dorm-list.php');
}

if (isset($_GET['edit'])) {
    $dorm_id = $_GET['edit'];
    $update = true;
    $record = mysqli_query($conn, "SELECT * FROM dormitories WHERE dorm_id=$dorm_id");

    if (mysqli_num_rows($record) == 1 ) {
        $n = mysqli_fetch_array($record);
        $dorm_name = $n['dorm_name'];
        $dorm_owner = $n['dorm_owner'];
        $address = $n['address'];
        $rooms = $n['rooms'];
        $r_fee = $n['r_fee'];
        $amenities = $n['amenities'];
        $description = $n['description'];
        $r_avail = $n['r_avail'];

    }
}


if (isset($_POST['update'])) {
    $dorm_id = $_POST['dorm_id'];
    $r_fee = $_POST['r_fee'];
    $amenities = $_POST['amenities'];
    $description = $_POST['description'];
    $r_avail = $_POST['r_avail'];

    mysqli_query($conn, "UPDATE dormitories SET r_fee='$r_fee', amenities='$amenities', 
    description='$description', r_avail='$r_avail' WHERE dorm_id=$dorm_id");
    $_SESSION['message'] = "Dormitory information updated!"; 
    header('location: dorm-list.php');
}

?>

