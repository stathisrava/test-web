<?php
// Assuming you have a MySQL database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "web";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get latitude and longitude from POST data
$latitude = $_POST['latitude'];
$longitude = $_POST['longitude'];

// Assuming you have a column named 'inventory_id' that uniquely identifies the record
$inventoryId = 1;//$_POST['inventory_id'];

// Update the coordinates in the database
$sql = "UPDATE INVENTORYLOCATION SET latitude = $latitude, longitude = $longitude WHERE id = $inventoryId";

if ($conn->query($sql) === TRUE) {
    echo "Coordinates updated successfully";
} else {
    echo "Error updating coordinates: " . $conn->error;
}

$conn->close();
?>
