<?php
// Set database connection parameters
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

// Read JSON file
$jsonFile = 'items.json';
$jsonContent = file_get_contents($jsonFile);
$data = json_decode($jsonContent, true);

// Insert data into the database
foreach ($data['items'] as $item) {
    $id = $item['id'];
    $name = $conn->real_escape_string($item['name']);
    $category_id = $item['category'];

    $sql = "INSERT INTO items (id, name, category_id) VALUES ('$id', '$name', '$category_id')";

    if ($conn->query($sql) === TRUE) {
        echo "Record inserted successfully for ID: $id<br>";
    } else {
        echo "Error inserting record for ID: $id - " . $conn->error . "<br>";
    }
}

// Close connection
$conn->close();
?>
