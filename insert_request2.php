<?php

session_start();

//session_regenerate_id(true); // Create a new session with a new ID
// Assuming you have a database connection already established
$mysqli = new mysqli('localhost', 'root', '', 'web');

// Check connection
if ($mysqli->connect_error) {
    die('Connect Error (' . $mysqli->connect_errno . ') ' . $mysqli->connect_error);
}

// Extract data from the AJAX request
$category = $_POST['category'];
$item = $_POST['item'];
$quantity = $_POST['quantity'];

// Set default values
$taskStatus = 'PENDING';
$type = 'REQUEST';
$vehiclesId = null; // Set NULL

// Insert data into the 'tasks' table
$tableNameTasks = 'tasks';
$queryTasks = "INSERT INTO $tableNameTasks (tasks_status, type, vehicles_id) VALUES (?, ?, ?)";
$stmtTasks = $mysqli->prepare($queryTasks);

// Bind parameters for tasks table
$stmtTasks->bind_param('sss', $taskStatus, $type, $vehiclesId);

// Execute the statement for tasks table
if ($stmtTasks->execute()) {
    // Insert successful
    $taskId = $mysqli->insert_id; // Get the ID of the inserted task

    $usersId = $_SESSION['username'];
    //echo $usersId;
    $sql = "SELECT civilian_id  AS ID FROM civilian
    INNER JOIN users 
    ON civilian.users_id= users.users_id
    WHERE username = '$usersId'";
    
    $resultuser = mysqli_query($mysqli,$sql);
    $row = mysqli_fetch_assoc($resultuser);
    $intValue = $row["ID"]; //isset($row[0]) ? $row[0] : 0;
   // echo (string)$row;
    echo $intValue; 

    // Now, retrieve the item ID from the 'items' table based on the item name
    $tableNameItems = 'items';
    $queryItems = "SELECT id FROM $tableNameItems WHERE name = ?";
    $stmtItems = $mysqli->prepare($queryItems);

    // Bind parameter for items table
    $stmtItems->bind_param('s', $item);

    // Execute the statement for items table
    $stmtItems->execute();
    $stmtItems->bind_result($itemId);
    $stmtItems->fetch();

    // Close the statement for items table
    $stmtItems->close();

    // Now, insert data into the 'requests' table
    $tableNameRequests = 'requests';
    $submissionDate = date('Y-m-d'); // Current date and time

    // Modify the query for the requests table
    $queryRequests = "INSERT INTO $tableNameRequests (takeaway_date, submission_date, quantity, civilian_id, items_id, tasks_id) VALUES (NULL, ?, ?, ?, ?, ?)";
    $stmtRequests = $mysqli->prepare($queryRequests);

    // Assuming you have variables for civilian ID, replace with actual values
    //$civilianId = 62; // Replace with the actual civilian ID

    // Bind parameters for requests table
    $stmtRequests->bind_param('siiii', $submissionDate, $quantity, $intValue, $itemId, $taskId);

    // Execute the statement for requests table
    if ($stmtRequests->execute()) {
        // Second insert successful
        echo json_encode(['status' => 'success']);
    } else {
        // Second insert failed
        echo json_encode(['status' => 'error', 'message' => $stmtRequests->error]);
    }

    // Close the statement for requests table
    $stmtRequests->close();
} else {
    // First insert failed
    echo json_encode(['status' => 'error', 'message' => $stmtTasks->error]);
}

// Close the statements and connection
$stmtTasks->close();
$mysqli->close();

?>