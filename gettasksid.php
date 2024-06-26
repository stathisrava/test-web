<?php
session_start();
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

// Check if user_id is provided in the GET request
if (isset($_GET['user_id'])) {
    $user_id = $_GET['user_id'];

    // First Query
    $query1 = "SELECT tasks.tasks_id, locations.latitude, locations.longitude FROM locations
        INNER JOIN users ON locations.users_id = users.users_id
        INNER JOIN civilian ON users.users_id = civilian.users_id
        INNER JOIN requests ON civilian.civilian_id = requests.civilian_id
        INNER JOIN tasks ON requests.tasks_id = tasks.tasks_id
        INNER JOIN rescuer ON tasks.vehicles_id=rescuer.vehicles_id
        WHERE rescuer.users_id = $user_id;";

    // Second Query
    $query2 = "SELECT tasks.tasks_id, locations.latitude, locations.longitude FROM locations
        INNER JOIN users ON locations.users_id = users.users_id
        INNER JOIN civilian ON users.users_id = civilian.users_id
        INNER JOIN offers ON civilian.civilian_id = offers.civilian_id
        INNER JOIN tasks ON offers.tasks_id = tasks.tasks_id
        INNER JOIN rescuer ON tasks.vehicles_id=rescuer.vehicles_id
        WHERE rescuer.users_id = $user_id;";

    // Execute the first query
    $result1 = mysqli_query($connection, $query1);

    // Execute the second query
    $result2 = mysqli_query($connection, $query2);

    // Check if both queries executed successfully
    if ($result1 && $result2) {
        // Fetch the results as associative arrays
        $tasks1 = mysqli_fetch_all($result1, MYSQLI_ASSOC);
        $tasks2 = mysqli_fetch_all($result2, MYSQLI_ASSOC);

        // Combine the results from both queries
        $combinedTasks = array_merge($tasks1, $tasks2);

        // Output combined tasks as JSON
        header('Content-Type: application/json');
        echo json_encode($combinedTasks);

        // Close the database connection
        mysqli_close($connection);
        exit;
    } else {
        // Handle the case where either query fails
        echo "Error executing query: " . mysqli_error($connection);
    }
} else {
    // Handle the case where user_id is not provided
    echo "Error: user_id not provided in the request.";
}

// Close the database connection (if not closed already due to an error)
mysqli_close($connection);
?>
