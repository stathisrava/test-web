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

// Assuming you have a column named 'inventory_id' that uniquely identifies the record
$inventoryId = 1; // Replace '1' with the actual inventory item ID

// Fetch the location from the database
$sql = "SELECT latitude, longitude FROM INVENTORYLOCATION WHERE id = $inventoryId";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // Output data of each row
    $row = $result->fetch_assoc();
    $location = array(
        'latitude' => $row['latitude'],
        'longitude' => $row['longitude']
    );
    echo json_encode($location);
} else {
    echo "Location not found";
}

$conn->close();
?>
