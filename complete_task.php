<?php

// Establish a database connection (replace with your database credentials)
$host = "localhost";
$username = "root";
$password = "";
$database = "web";

$connection = mysqli_connect($host, $username, $password, $database);

if (!$connection) {
    $errorResponse = array("status" => "error", "message" => "Database connection failed");
    header("Content-type: application/json");
    echo json_encode($errorResponse);
    exit;
}

// Check if the request is a POST request
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Get the task ID from the POST data
    $taskId = $_POST["tasks_id"];

    // Update the task status to "Complete"
    $sql = "UPDATE tasks SET tasks_status = 'Complete' WHERE tasks_id = ?";
    $stmt = mysqli_prepare($connection, $sql);

    // Bind the parameter and execute
    mysqli_stmt_bind_param($stmt, "i", $taskId);

    try {
        mysqli_stmt_execute($stmt);

        // Check if the update was successful
        if (mysqli_affected_rows($connection) > 0) {
            $successResponse = array("status" => "success", "message" => "Task completed successfully");
            header("Content-type: application/json");
            echo json_encode($successResponse);
        } else {
            $errorResponse = array("status" => "error", "message" => "Task not found or already completed");
            header("Content-type: application/json");
            echo json_encode($errorResponse);
        }
    } catch (Exception $e) {
        $errorResponse = array("status" => "error", "message" => "Error completing task: " . $e->getMessage());
        header("Content-type: application/json");
        echo json_encode($errorResponse);
    }

    // Close the statement and connection
    mysqli_stmt_close($stmt);
    mysqli_close($connection);
} else {
    $errorResponse = array("status" => "error", "message" => "Invalid request method");
    header("Content-type: application/json");
    echo json_encode($errorResponse);
}

$sqlnewnew = "INSERT INTO cargo (amount, vehicles_id, inventory_id, items_id)
VALUES ($offersQuantity, $intValue2, NULL, $offersItems)";

// to cargo na paei sto inventory
$sql1 = "";


?>
