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

// Check if 'selectedItems' is set in the POST data
if (!isset($_POST['selectedItems'])) {
    echo json_encode(['status' => 'error', 'message' => 'No selectedItems data received.']);
    exit;
}

// Get selected items from the POST data
$selectedItemsJSON = $_POST['selectedItems'];

// Check if selectedItemsJSON is not empty and is a valid JSON string
if (empty($selectedItemsJSON) || !json_decode($selectedItemsJSON)) {
    echo json_encode(['status' => 'error', 'message' => 'Invalid or empty selectedItems data.']);
    exit;
}

$selectedItems = json_decode($selectedItemsJSON);

// Array to store item IDs
$itemIds = array();

// Fetch item IDs from the database based on selected items
foreach ($selectedItems as $selectedItem) {
    $selectedItem = $conn->real_escape_string($selectedItem);
    $sql = "SELECT id FROM items WHERE name = '$selectedItem' LIMIT 1";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $itemIds[] = $row['id'];
    }
}

// Check if item IDs are found
if (empty($itemIds)) {
    echo json_encode(['status' => 'error', 'message' => 'No item IDs found for selected items.']);
    exit;
}

// Convert item IDs to a JSON string
$itemIdsJSON = json_encode($itemIds);

// Assuming 'announcements' is your table name
$tableName = 'announcements';

// Fetch an existing civilian_id (replace this logic with your actual logic)
$civilian_id = 36; // Replace with your logic to get an existing civilian_id

// Begin a transaction
$conn->begin_transaction();



// Create a single announcement for all selected items
$announcementText = implode(', ', $selectedItems);
$announcementText = $conn->real_escape_string($announcementText);

// Assuming 'created_at' and 'updated_at' are TIMESTAMP columns
$sql = "INSERT INTO $tableName (announ_status, created_at, updated_at ) 
        VALUES (IFNULL('$announcementText', 'free'), CURRENT_TIMESTAMP, CURRENT_TIMESTAMP)";

if ($conn->query($sql) !== TRUE) {
    echo json_encode(['status' => 'error', 'message' => 'Error inserting into the database: ' . $conn->error]);
    $conn->rollback();
} else {
    // Get the last inserted announcement_id
    $lastAnnouncementId = $conn->insert_id;
    $quantity = 1; // panta ena einai, den xreiazetai?

    // Additional insert into TESTAN table
    foreach ($itemIds as $itemId) {
        $sqlTestan = "INSERT INTO TESTAN (announcement_id, item_id, quantity, civilian_id, announ_status, created_at, updated_at) 
                      VALUES ('$lastAnnouncementId', '$itemId', '$quantity', NULL, 'free', CURRENT_TIMESTAMP, NULL /*CURRENT_TIMESTAMP*/)";
        if ($conn->query($sqlTestan) !== TRUE) {
            echo json_encode(['status' => 'error', 'message' => 'Error inserting into TESTAN: ' . $conn->error]);
            $conn->rollback();
            exit; // Exit if there's an error
        }
    }

    $conn->commit();
    echo json_encode(['status' => 'success', 'message' => 'Record(s) inserted successfully.']);
}

$conn->close();
?>
