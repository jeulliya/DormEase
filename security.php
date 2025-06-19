<?php
session_start();
include 'db_conn.php';

// Function to log database activity
function logDatabaseActivity($username, $activityType) {
    global $conn;

    $query = "INSERT INTO activity_history (username, activity_type) VALUES (?, ?)";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("ss", $username, $activityType);
    $stmt->execute();
    $stmt->close();
}


// Function to perform database export
function performDatabaseExport($exportDir, $exportFilename) {
    $servername = 'localhost';
    $username = 'root';
    $db_name = 'dormies_db';

    $command = "C:\\xampp\\mysql\\bin\\mysqldump.exe --single-transaction --routines --events -h $servername -u $username $db_name > $exportDir$exportFilename 2>&1";

    exec($command, $output, $returnCode);

    if ($returnCode !== 0) {
        $_SESSION['message'] = "Failed to export database.";

    } else {
        $_SESSION['message'] = "Database exported successfully.";

    }
}

// Function to perform database import
function performDatabaseImport($importFilename) {
    $servername = 'localhost';
    $username = 'root';
    $db_name = 'dormies_db';

    $command = "C:\\xampp\\mysql\\bin\\mysql.exe -h $servername -u $username $db_name < $importFilename 2>&1";

    exec($command, $output, $returnCode);

    if ($returnCode !== 0) {
        $_SESSION['message'] = "Failed to import database";

    } else {
        $_SESSION['message'] = "Database imported successfully.";

    }
}

// Function to check if monthly backup is already performed
function isMonthlyBackupPerformed() {
    $exportDir = '../DormFinder/backups/';
    $exportFilename = 'monthly_backup_' . date('Ym') . '.sql';
    $backupFilePath = $exportDir . $exportFilename;
    
    return file_exists($backupFilePath);
}

// Function to get the most recent export file
function getMostRecentExportFile($exportDir) {
    $exportFiles = array_merge(glob($exportDir . 'export_*.sql'), glob($exportDir . 'monthly_backup_*.sql'));

    // Sort files by modification time in descending order
    usort($exportFiles, function ($a, $b) {
        return filemtime($b) - filemtime($a);
    });

    return reset($exportFiles); // Get the first element (most recent file)
}

// Function to perform automatic monthly backup
function performMonthlyBackup() {
    if (!isMonthlyBackupPerformed()) {
        $exportDir = '../DormFinder/backups/';
        $exportFilename = 'monthly_backup_' . date('Ym') . '.sql';
        performDatabaseExport($exportDir, $exportFilename);
    }
}

// Check if it's the first day of the month and perform the monthly backup
if (date('j') == 1) {
    performMonthlyBackup();
    logDatabaseActivity($_SESSION['username'], 'Export Database');
}

// Handle Export and Recover actions
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['export'])) {
        // New export database action
        $exportDir = '../DormFinder/backups/';
        $exportFilename = 'export_' . date('Ymd_His') . '.sql';
        performDatabaseExport($exportDir, $exportFilename);
        logDatabaseActivity($_SESSION['username'], 'Export Database');
    } elseif (isset($_POST['recover'])) {
        // Find the most recent export file
        $exportDir = '../DormFinder/backups/';
        $latestExportFile = getMostRecentExportFile($exportDir);
        performDatabaseImport($latestExportFile);
        logDatabaseActivity($_SESSION['username'], 'Recover Database');
    }

    // Redirect to the same page to display the message
    header('Location: security.php');
    exit();
}

// Fetch activity history from the database
$sql = "SELECT * FROM activity_history ORDER BY timestamp DESC, activity_id DESC LIMIT 5";
$result = mysqli_query($conn, $sql);

// Check if there are records
if ($result) {
    $activityHistory = mysqli_fetch_all($result, MYSQLI_ASSOC);
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Security</title>
    <link rel="stylesheet" href="assets/css/security.css">
    <link rel="icon" type="image/x-icon" href="favicon.ico">
    <style>
        .msg {
            margin: 30px auto; 
            padding: 10px; 
            border-radius: 5px; 
            color: #3c763d; 
            background: #dff0d8; 
            border: 1px solid #3c763d;
            width: 50%;
            text-align: center;
            margin-top: 0;
            margin-bottom: 0;
        }
    </style>
</head>

<body>
    <section>
        <?php
        include_once 'a-navbar.php';
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

    <div class="container">
        <div class="row">
            <div class="col-lg-6">
                <form method="post">
                    <div class="row">
                        <div class="col-lg-6 col-md-6 col-sm-6 col-6">
                            <input class="submit" type="submit" name="export" value="Backup Data">
                        </div>
                        <div class="col-lg-4 col-md-6 col-sm-6 col-6">
                            <input class="submit" type="submit" name="recover" value="Recover Data">
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <!-- Display activity history -->
        <form method="post">
        <div class="activity-history">
            <h3>Activity History</h3>
            <?php foreach ($activityHistory as $activity): ?>
                <div class="activity-item">
                    <strong><?= $activity['username']; ?></strong>
                    <?= $activity['activity_type']; ?> at <?= $activity['timestamp']; ?>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
    </form>
</body>

</html>
