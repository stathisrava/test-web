<?php
// Establish a database connection (replace with your database credentials)
session_start();

$host = "localhost";
$username = "root";
$password = "";
$database = "web";

$connection = mysqli_connect($host, $username, $password, $database);

if (!$connection) {
    $errorResponse = array("error" => "Database connection failed");
    header("Content-type: application/json");
    echo json_encode($errorResponse);
    exit;
}

$usersId = $_SESSION['username'];
$sql = "SELECT users_id AS ID FROM users WHERE username = '$usersId'";
$resultuser = mysqli_query($connection, $sql);
$row = mysqli_fetch_assoc($resultuser);
$intValue = $row["ID"];

// Query to retrieve user data
$query = "SELECT offers.offers_id, offers.takeaway_date, offers.submission_date, tasks.tasks_status FROM tasks
INNER JOIN offers ON tasks.tasks_id = offers.tasks_id
INNER JOIN civilian ON offers.civilian_id = civilian.civilian_id
INNER JOIN users ON civilian.users_id = users.users_id
WHERE tasks.tasks_status != 'PENDING' AND civilian.users_id = $intValue";
$result = mysqli_query($connection, $query);

if (!$result) {
    $errorResponse = array("error" => "Database query failed: " . mysqli_error($connection));
    header("Content-type: application/json");
    echo json_encode($errorResponse);
    exit;
}

// Fetch user data and store it in an array
$usersData = array();
while ($row = mysqli_fetch_assoc($result)) {
    $usersData[] = $row;
}

// Close the database connection
mysqli_close($connection);

// Return user data as JSON
header("Content-type: application/json");
echo json_encode($usersData);
?>