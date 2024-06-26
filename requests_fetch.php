<?php
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

// Query to retrieve user data
$query = "SELECT requests_id, takeaway_date, submission_date, tasks_status, items_id FROM requests
INNER JOIN tasks ON requests.tasks_id = tasks.tasks_id";
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