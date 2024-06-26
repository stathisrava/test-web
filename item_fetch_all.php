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

// Use prepared statements to prevent SQL injection
$query = "SELECT name FROM items";
$stmt = mysqli_prepare($connection, $query);

mysqli_stmt_execute($stmt);

$result = mysqli_stmt_get_result($stmt);

if (!$result) {
    $errorResponse = array("error" => "Database query failed: " . mysqli_error($connection));
    header("Content-type: application/json");
    echo json_encode($errorResponse);
    exit;
}

// Fetch item data and store it in an array
$itemsData = array();
while ($row = mysqli_fetch_assoc($result)) {
    $itemsData[] = $row;
}

// Close the database connection
mysqli_close($connection);

// Return item data as JSON
header("Content-type: application/json");
echo json_encode($itemsData);
?>