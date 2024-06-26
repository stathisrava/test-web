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

// Check if itemId is set in the GET parameters
if (isset($_GET['itemId'])) {
    $itemId = mysqli_real_escape_string($connection, $_GET['itemId']);

    // Query to retrieve item name based on itemId
    $query = "SELECT name FROM items WHERE id = '$itemId'";
    $result = mysqli_query($connection, $query);

    if (!$result) {
        $errorResponse = array("error" => "Database query failed: " . mysqli_error($connection));
        header("Content-type: application/json");
        echo json_encode($errorResponse);
        exit;
    }

    // Fetch and return the item name
    $row = mysqli_fetch_assoc($result);
    $itemName = $row['name'];

    // Close the database connection
    mysqli_close($connection);

    // Return the item name as JSON
    header("Content-type: application/json");
    echo json_encode(array("name" => $itemName));
} else {
    $errorResponse = array("error" => "Missing itemId parameter");
    header("Content-type: application/json");
    echo json_encode($errorResponse);
    exit;
}
?>