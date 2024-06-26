<?php
session_start();

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "web";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch distinct category names from the items table
$categorySql = "SELECT DISTINCT category_name FROM category";
$categoryResult = $conn->query($categorySql);

if ($categoryResult->num_rows > 0) {
    $categories = array();
    while ($row = $categoryResult->fetch_assoc()) {
        $categories[] = $row['category_name'];
    }
} else {
    $categories = array(); // Handle the case where there are no categories
}

// Now, fetch the items data
$sql = "SELECT category.category_name, cargo.items_id, cargo.amount, items.name FROM cargo
        INNER JOIN items ON cargo.items_id = items.id
        INNER JOIN category ON items.category_id = category.id ";

$sql2 = "SELECT category.category_name, inventory.id, inventory.amount, items.name FROM inventory
        INNER JOIN items ON inventory.id = items.id
        INNER JOIN category ON items.category_id = category.id ";

$result = $conn->query($sql);
$result2 = $conn->query($sql2);

if ($result->num_rows > 0 || $result2->num_rows > 0) {
    $output = array();

    // Process cargo data
    while ($row = $result->fetch_assoc()) {
        $output[] = array(
            'source' => 'cargo',
            'category' => $row['category_name'],
            'itemId' => $row['items_id'],
            'itemName' => $row['name'],
            'quantity' => $row['amount']
        );
    }

    // Process inventory data
    while ($row = $result2->fetch_assoc()) {
        $output[] = array(
            'source' => 'inventory',
            'category' => $row['category_name'],
            'itemId' => $row['id'],
            'itemName' => $row['name'],
            'quantity' => $row['amount']
        );
    }

    $response = array(
        'categories' => $categories,
        'data' => $output
    );

    header('Content-Type: application/json');
    echo json_encode($response);
} else {
    // No results
    echo "No data found";
}

$conn->close();
?>
