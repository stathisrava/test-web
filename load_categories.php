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
$jsonFile = 'categories.json';
$jsonContent = file_get_contents($jsonFile);
$data = json_decode($jsonContent, true);

// Insert data into the database
foreach ($data['categories'] as $category) {
    $id = $category['id'];
    $categoryName = $conn->real_escape_string($category['category_name']);

    $sql = "INSERT INTO category (id, category_name) VALUES ('$id', '$categoryName')";

    if ($conn->query($sql) === TRUE) {
        echo "Record inserted successfully for ID: $id<br>";
    } else {
        echo "Error inserting record for ID: $id - " . $conn->error . "<br>";
    }
}

// Close connection
$conn->close();
?>
