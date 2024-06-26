<?php
// Assuming you have a database connection established
$dbHost = 'localhost';
$dbUser = 'root';
$dbPassword = '';
$dbName = 'web';

$conn = new mysqli($dbHost, $dbUser, $dbPassword, $dbName);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch announcements from the database
$sql = "SELECT general_id, announcement_id, item_id, quantity, civilian_id, announ_status, created_at, updated_at, name
 FROM testan
 INNER JOIN items
 ON testan.item_id = items.id";

$result = $conn->query($sql);

$result = $conn->query($sql);

if (!$result) {
    die("Error in SQL query: " . $conn->error);
}



if ($result->num_rows > 0) {
    $announcements = array();

    while ($row = $result->fetch_assoc()) {
        $announcements[] = array(
            'general_id' => $row['general_id'],
            'announcement_id' => $row['announcement_id'],
            'item_id' => $row['item_id'],
            'name' => $row['name'],
            'quantity' => $row['quantity'],
            'civilian_id' => $row['civilian_id'],
            'announ_status' => $row['announ_status'],
            'created_at' => $row['created_at'],
            'updated_at' => $row['updated_at']
        );
    }

    // Return announcements as JSON
    echo json_encode($announcements);
} else {
    // No announcements found
    echo json_encode(array());
}

$conn->close();
?>
