<?php
session_start();
require_once("db_conn.php");

// Initialize variables
$id = 0;
$firstname = "";
$middlename = "";
$lastname = "";
$username = "";
$plainPassword = "";
$email = "";
$gender = "";
$role = "";
$update = false;

if (isset($_GET['edit'])) {
    $id = $_GET['edit'];
    $update = true;
    $record = mysqli_query($conn, "SELECT * FROM users WHERE id=$id");

    if (mysqli_num_rows($record) == 1) {
        $n = mysqli_fetch_array($record);
        $firstname = $n['firstname'];
        $middlename = $n['middlename'];
        $lastname = $n['lastname'];
        $username = $n['username'];
        $plainPassword = $n['password'];
        $email = $n['email'];
        $gender = $n['gender'];
        $role = $n['role'];
    }
}

if (isset($_POST['submit'])) {
    $id = $_POST['id'];
    $firstname = $_POST['firstname'];
    $middlename = $_POST['middlename'];
    $lastname = $_POST['lastname'];
    $username = $_POST['username'];
    $plainPassword = $_POST['password'];
    $email = $_POST['email'];
    $gender = $_POST['gender'];
    $role = $_POST['role'];

    // Hash the password
    $hashedPassword = password_hash($plainPassword, PASSWORD_DEFAULT);

    // Perform the update query
    mysqli_query($conn, "UPDATE users SET firstname='$firstname', middlename='$middlename', lastname='$lastname', 
    username='$username', password='$hashedPassword', email='$email', gender='$gender', role='$role' WHERE id=$id");
    
    $_SESSION['message'] = "User information updated!";
    header('location: adduser.php');
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/x-icon" href="favicon.ico">
    <link rel="stylesheet" href="assets/css/adduser.css">
    <title>Edit User</title>
</head>

<body>
    <section>
        <?php include 'a-navbar.php'; ?>
    </section>
    <div class="form-container2" style="margin-top:0;">
        <form method="post" action="edituser.php">
            <input type="hidden" name="id" value="<?php echo $id; ?>">
            <div class="input-container">
                <label for="firstname">First Name:</label>
                <input class="input" type="text" id="firstname" name="firstname" value="<?php echo $firstname; ?>" readonly>
                <label for="middlename">Middle Name:</label>
                <input class="input" type="text" id="middlename" name="middlename" value="<?php echo $middlename; ?>" readonly>
                <label for="lastname">Last Name:</label>
                <input class="input" type="text" id="lastname" name="lastname" value="<?php echo $lastname; ?>" readonly>
                <label for="username">Username:</label>
                <input class="input" type="text" id="username" name="username" value="<?php echo $username; ?>" autocomplete="off">
                <label for="username">Password:</label>
                <input class="input" type="password" id="password" name="password" value="<?php echo $plainPassword; ?>" autocomplete="off">
                <label for="email">Email:</label>
                <input class="input" type="text" id="email" name="email" value="<?php echo $email; ?>">
                <label for="gender">Gender:</label>
                    <select name="gender" id="gender" class="gender" >
                    <option value="Female" <?php echo ($gender == 'Female') ? 'selected' : ''; ?>>Female</option>
                    <option value="Male" <?php echo ($gender == 'Male') ? 'selected' : ''; ?>>Male</option></select>
                <label for="role" class="rolee">Role:</label>
                    <select name="role" id="role" class="role" readonly>
                    <option value="Admin" <?php echo ($role == 'Admin') ? 'selected' : ''; ?>>Admin</option>
                    <option value="Dormitory Owner" <?php echo ($role == 'Dormitory Owner') ? 'selected' : ''; ?>>Dormitory Owner</option>
                    </select>
            </div>
            <div class="submit-container2">
                <input class="submit1" type="submit" name="submit" value="Submit">
                <a href="adduser.php" class="cancel" type="cancel" name="cancel">Cancel</a><br>
            </div>
        </form>
    </div>
</body>

</html>
