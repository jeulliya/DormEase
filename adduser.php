<?php
include 'db_conn.php';
include 'crud.php';

// Fetch hidden users
$sql_hidden = "SELECT * FROM hidden_users";
$result_hidden = $conn->query($sql_hidden);

// Check if there are hidden users
if ($result_hidden !== false) {
    $hiddenResult = $result_hidden;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $firstname = $_POST['firstname'];
    $middlename = $_POST['middlename'];
    $lastname = $_POST['lastname'];
    $username = $_POST['username'];
    $password = $_POST['password'];
    $email = $_POST['email'];
    $gender = $_POST['gender'];
    $role = $_POST['role'];

    // Use password_hash for secure password hashing
    $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

    // Insert query to add a new user with the manually incremented ID
    $sql_insert = "INSERT INTO users (firstname, middlename, lastname, username, password, email, gender, role) 
    VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql_insert);
    $stmt->bind_param('ssssssss', $firstname, $middlename, $lastname, $username, $hashedPassword, $email, $gender, $role);
    $stmt->execute();

    if ($stmt->affected_rows > 0) {
        // Set the session message
        $_SESSION['message'] = "User added successfully!"; 

        // Redirect to the same page to display the message
        header('Location: adduser.php');
        exit(); // Ensure that no further code is executed after the redirect
    } else {
        echo "Error: " . $sql_insert . "<br>" . $stmt->error;
    }
    $stmt->close();
    $conn->close();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/x-icon" href="favicon.ico">
    <link rel="stylesheet" href="assets/css/adduser.css">
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <title>Add User</title>
</head>

<body>
    <section>
        <?php
        include 'a-navbar.php';
        ?>
    </section>
    <?php if (isset($_SESSION['message'])): ?>
        <div class="msg">
            <?php 
                echo $_SESSION['message']; 
                unset($_SESSION['message']);
            ?>
        </div>
    <?php endif ?>
    <h2 class="add">Add User</h2>
    <div class="form-container2" style="margin-top:0;">
        <form method="post" action="adduser.php" autocomplete="off">
            <div class="input-container">
                <label for="firstname">First Name:</label>
                <input class="input" type="text" id="firstname" name="firstname" required autocomplete="off">
                <label for="middlename">Middle Name:</label>
                <input class="input" type="text" id="middlename" name="middlename" autocomplete="off">
                <label for="lastname">Last Name:</label>
                <input class="input" type="text" id="lastname" name="lastname" required autocomplete="off">
                <label for="username">Username:</label>
                <input class="input" type="text" id="username" name="username" required autocomplete="off">
                <label for="username">Password:</label>
                <input class="input" type="text" id="password" name="password" required autocomplete="off">
                <label for="email">Email:</label>
                <input class="input" type="text" id="email" name="email" autocomplete="off">
                <label for="gender">Gender:</label>
                <select name="gender" id="gender" class="gender" required>
                    <option selected disabled hidden></option>
                    <option value="Female"<?php if(isset($_GET['gender']) && $_GET['gender'] == 'Female') echo ' selected'; ?>>Female</option>
                    <option value="Male"<?php if(isset($_GET['gender']) && $_GET['gender'] == 'Male') echo ' selected'; ?>>Male</option></select>
                <label for="role" class="rolee">Role:</label>
                <select name="role" id="role" class="role" required>
                    <option selected disabled hidden></option>
                    <option value="Dormitory Owner"<?php if(isset($_GET['role']) && $_GET['role'] == 'Dormitory Owner') echo ' selected'; ?>>Dormitory Owner</option>
                    <option value="Admin"<?php if(isset($_GET['role']) && $_GET['role'] == 'Admin') echo ' selected'; ?>>Admin</option></select>
                <div class="submit-container2">
                    <input class="submit" type="submit" value="Submit">
                    
                </div>
            </div>
        </form>
    </div>

    <h2 class="users">Users</h2>

    <div class="search-container">
        <input type="text" id="search" onkeyup="myFunction()" placeholder="Search Users" name="search" autocomplete="off">  
    </div>
        <!-- Sorting buttons -->
        <div class="sort">
        <button onclick="sortUsers('Admin')">Admin</button>
        <button onclick="sortUsers('Dormitory Owner')">Dormitory Owner</button>
        </div>

    <div class="centered-table"><br><br>
        <?php
        include 'db_conn.php';

        $sql = "SELECT * FROM users";

        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            echo "<table>";
            echo "<tr>";
            echo "<th>ID</th>";
            echo "<th>First Name</th>";
            echo "<th>Middle Name</th>";
            echo "<th>Last Name</th>";
            echo "<th>Username</th>";
            echo "<th>Email</th>";
            echo "<th>Gender</th>";
            echo "<th>Role</th>";
            echo "<th>Status</th>";
            echo "<th colspan='2'>Action</th>";
            echo "</tr>";
            while ($row = $result->fetch_assoc()) {
                $rowClass = '';
                if (isset($_POST['hiddenUserId']) && $_POST['hiddenUserId'] == $row['id']) {
                    $rowClass = 'fade-out';
                }
                echo "<tr class='$rowClass'>";
                echo "<td>" . $row["id"] . "</td>";
                echo "<td>" . $row["firstname"] . "</td>";
                echo "<td>" . $row["middlename"] . "</td>";
                echo "<td>" . $row["lastname"] . "</td>";
                echo "<td>" . $row["username"] . "</td>";
                echo "<td>" . $row["email"] . "</td>";
                echo "<td>" . $row["gender"] . "</td>";
                echo "<td>" . $row["role"] . "</td>";
                echo "<td class='active'>" . "Active" . "</td>";
                echo "<td>";
                echo '<a href="edituser.php?edit=' . $row['id'] . '" class="edit_btn">Edit</a>';
                echo "</td>";
                echo "<td>";
                echo '<form method="post" action="hide_user.php?redirect=adduser.php">';
                echo '<input type="hidden" name="userId" value="' . $row['id'] . '">';
                echo '<button type="submit" class="hide_btn">Hide</button>';
                echo '</form>';
                echo "</td>";
                echo "</tr>";
            }
            echo "</table>";
        }
        ?>
    </div>

<h2 class="hidden-users">Hidden Users</h2>
<div class="centered-table hidden-table"><br><br>
    <table>
        <tr>
            <th>ID</th>
            <th>First Name</th>
            <th>Middle Name</th>
            <th>Last Name</th>
            <th>Username</th>
            <th>Email</th>
            <th>Gender</th>
            <th>Role</th>
            <th>Status</th>
            <th>Action</th>
        </tr>
        <?php
        // Assume $hiddenRow is the result from fetching hidden users
        while ($hiddenRow = $hiddenResult->fetch_assoc()) {
            echo "<tr data-user-id='" . $hiddenRow["id"] . "'>";
            echo "<td>" . $hiddenRow["id"] . "</td>";
             echo "<td><i>hidden</i></td>";
             echo "<td><i>hidden</i></td>";
             echo "<td><i>hidden</i></td>";
             echo "<td><i>hidden</i></td>";
             echo "<td><i>hidden</i></td>";
             echo "<td><i>hidden</i></td>";
             echo "<td><i>hidden</i></td>";
             echo "<td class='inactive'>Inactive</td>";
            echo "<td>";
            echo '<form method="post" action="show_user.php?redirect=adduser.php">';
            echo '<input type="hidden" name="userId" value="' . $hiddenRow['id'] . '">';
            echo '<button type="submit" class="show_btn">Show</button>';
            echo '</form>';
            echo "</td>";
            echo "</tr>";
        }
        ?>
    </table>
</div>


<script>
function myFunction() {
  // Declare variables
  var input, filter, table, rows, cells, i, j, txtValue;
  input = document.getElementById("search");
  filter = input.value.toUpperCase();
  table = document.querySelector(".centered-table table");

  // Get all rows from the table
  rows = table.getElementsByTagName("tr");

  // Loop through all rows, and hide those that don't match the search query
  for (i = 1; i < rows.length; i++) {
    cells = rows[i].getElementsByTagName("td");

    // Loop through all cells in the current row
    for (j = 0; j < cells.length; j++) {
      txtValue = cells[j].textContent || cells[j].innerText;

      // Check if the cell value matches the search query
      if (txtValue.toUpperCase().indexOf(filter) > -1) {
        rows[i].style.display = "";
        break; // Break the loop if a match is found in any cell
      } else {
        rows[i].style.display = "none";
      }
    }
  }
}

function sortUsers(role) {
    var table, rows, i, x, shouldShow;
    table = document.querySelector(".centered-table table");
    rows = table.getElementsByTagName("tr");

    for (i = 1; i < rows.length; i++) {
        x = rows[i].getElementsByTagName("td")[7].innerHTML; // Adjust the index based on the role column
        shouldShow = (role === 'All' || x.toLowerCase() === role.toLowerCase());

        if (shouldShow) {
            rows[i].style.display = ""; // Show the row
        } else {
            rows[i].style.display = "none"; // Hide the row
        }
    }
}

document.addEventListener('DOMContentLoaded', function () {
        // Click event for the "Hide" buttons
        var hideButtons = document.querySelectorAll('.hide_btn');
        hideButtons.forEach(function (button) {
            button.addEventListener('click', function (event) {
                event.preventDefault(); // Prevent the default form submission behavior
                var userId = this.closest('form').querySelector('input[name="userId"]').value;
                hideUser(userId);
            });
        });

        // Click event for the "Show" buttons
        var showButtons = document.querySelectorAll('.show_btn');
        showButtons.forEach(function (button) {
            button.addEventListener('click', function (event) {
                event.preventDefault(); // Prevent the default form submission behavior
                var userId = this.closest('form').querySelector('input[name="userId"]').value;
                showUser(userId);
            });
        });
    });

    function hideUser(userId) {
    var xhr = new XMLHttpRequest();
    xhr.open('POST', 'hide_user.php', true);
    xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
    xhr.onreadystatechange = function () {
        if (xhr.readyState == 4 && xhr.status == 200) {
            // Handle the response if needed
            console.log(xhr.responseText);

            // Fade out the corresponding row in the main table
            var mainTableRow = document.querySelector('.centered-table table tr[data-user-id="' + userId + '"]');
            if (mainTableRow) {
                mainTableRow.classList.add('fade-out');
            }

            // Fade out the corresponding row in the hidden table
            var hiddenTableRow = document.querySelector('.hidden-table table tr[data-user-id="' + userId + '"]');
            if (hiddenTableRow) {
                hiddenTableRow.classList.add('fade-out');
            }

            // Reload or update the content on the page as required
            // For example, you can reload the current page using:
            window.location.reload(false);
        }
    };

    // Build the request body
    var requestBody = 'userId=' + userId;
    xhr.send(requestBody);
}

    function showUser(userId) {
        var xhr = new XMLHttpRequest();
        xhr.open('POST', 'show_user.php', true);
        xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
        xhr.onreadystatechange = function () {
            if (xhr.readyState == 4 && xhr.status == 200) {
                // Handle the response if needed
                console.log(xhr.responseText);

                // Remove the fade-out class from the corresponding row
                var shownRow = document.querySelector('.centered-table table tr[data-user-id="' + userId + '"]');
                if (shownRow) {
                    shownRow.classList.remove('fade-out');
                }

                // Reload or update the content on the page as required
                // For example, you can reload the current page using:
                window.location.reload(false);
            }
        };

        // Build the request body
        var requestBody = 'userId=' + userId;
        xhr.send(requestBody);
    }

</script>


</body>

</html>