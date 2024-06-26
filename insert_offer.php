<?php

session_start();

// Assuming you have a database connection already established
$mysqli = new mysqli('localhost', 'root', '', 'web');

// Check connection
if ($mysqli->connect_error) {
    die('Connect Error (' . $mysqli->connect_errno . ') ' . $mysqli->connect_error);
}

// Extract data from the AJAX request
$general_id = $_POST['general_id'];
$quantity = $_POST['quantity'];
$item_id = $_POST['item_id'];


// Set default values
$taskStatus = 'PENDING';
$type = 'OFFER';
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


    // Now, insert data into the 'offers' table
    $tableNameOffers = 'offers';
    $submissionDate = date('Y-m-d'); // Current date and time

    // Modify the query for the offers table
    $queryOffers = "INSERT INTO $tableNameOffers (takeaway_date, submission_date, offers_quantity, civilian_id, offers_items, tasks_id, general_id) 
    VALUES (NULL, ?, ?, ?, ?, ?, ?)";
    $stmtOffers = $mysqli->prepare($queryOffers);

    // Assuming you have variables for civilian ID and general ID, replace with actual values
   // $civilianId = 67; // Replace with the actual civilian ID
    //$generalId = 8;
   

    // Bind parameters for offers table                         //$civilianId
    $stmtOffers->bind_param('siiiii', $submissionDate, $quantity, $intValue, $item_id, $taskId, $general_id);

    // Execute the statement for offers table
    if ($stmtOffers->execute()) {
        // Second insert successful
        echo json_encode(['status' => 'success']);
    } else {
        // Second insert failed
        echo json_encode(['status' => 'error', 'message' => $stmtOffers->error]);
    }

    // Close the statement for offers table
    $stmtOffers->close();
} else {
    // First insert failed
    echo json_encode(['status' => 'error', 'message' => $stmtTasks->error]);
}

// Close the statements and connection
$stmtTasks->close();
$mysqli->close();
?>
