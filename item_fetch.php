<?php
// item_fetch.php

if (isset($_GET['category_name'])) {
    $category_name = $_GET['category_name'];

    // Perform your database connection and query here
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "web";

    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Use prepared statement to prevent SQL injection
    $stmt = $conn->prepare("SELECT name FROM items WHERE category_id = (SELECT id FROM category WHERE category_name = ?)");
    $stmt->bind_param("s", $category_name);
    $stmt->execute();
    $result = $stmt->get_result();

    $items = [];

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $items[] = $row;
        }
    }

    $stmt->close();
    $conn->close();

    // Return JSON response
    header('Content-Type: application/json');
    echo json_encode($items);
} else {
    // Handle other cases or return an empty response
    header('Content-Type: application/json');
    echo json_encode([]);
}
?>