<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="assets/css/login.css">
    <link rel="icon" type="image/x-icon" href="favicon.ico">
</head>

<body>
    <div class="container">
        <section id="loginform">
            <a href="#"><img class="circlelogo" src="assets/images/dorm-logo.png" draggable="false"></a>
            <form action="login_check.php" method="post">
                <br><br>
                <h2>LOGIN</h2>
                <?php if(isset($_GET['error'])) { ?>
                <p class="error"><?php echo $_GET['error']; ?></p>
            <?php } ?><br>
        <div class="input-group">
            <input required="" class="input" type="text" name="username" id="username" maxlength="15" autocomplete="off">
                <label class="user-label">Username:</label>         
        </div><br><br>
        <div class="input-group1">
            <input required="" class="input" type="password" name="password" id="password" maxlength="5" autocomplete="off">
                <label class="user-label">Password:</label>   
        </div><br>

            <div class="btn-container">
                <button type="submit">Submit</button>
            </div>

            </form>
        </section>
    </div>

</body>

</html>