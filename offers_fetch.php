<?php
session_start();
// Establish a database connection (replace with your database credentials)
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
//echo $intValue;

// Query to retrieve user data
$query = "SELECT offers_id, takeaway_date, submission_date, tasks_status FROM offers
INNER JOIN civilian ON offers.civilian_id = civilian.civilian_id
INNER JOIN tasks ON offers.tasks_id = tasks.tasks_id
WHERE tasks_status = 'PENDING' AND civilian.users_id = $intValue";
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