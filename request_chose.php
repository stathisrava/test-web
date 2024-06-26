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

// Get the JSON data from the request body
$data = json_decode(file_get_contents("php://input"));

// Check if tasksId is present in the received data
if (isset($data->tasksId)) {
    // Access tasksId value
    $tasksId = $data->tasksId;

    $usersId = $_SESSION['username'];
    $sql = "SELECT users_id AS ID FROM users WHERE username = '$usersId'";
    $resultuser = mysqli_query($conn, $sql);
    $row = mysqli_fetch_assoc($resultuser);
    $intValue = $row["ID"];

    $sql2 = "SELECT vehicles.vehicles_id AS ID2 FROM vehicles 
             INNER JOIN rescuer ON vehicles.vehicles_id = rescuer.vehicles_id
             WHERE rescuer.users_id = '$intValue'";
    $resultuser2 = mysqli_query($conn, $sql2);
    $row2 = mysqli_fetch_assoc($resultuser2);
    $intValue2 = $row2["ID2"];

    // Combine the two UPDATE queries into one
    $sqlUpdateTasks = "UPDATE tasks 
                    /*INNER JOIN vehicles ON tasks.vehicles_id = vehicles.vehicles_id */
                    SET 
                        tasks.tasks_status = 'ON-ROAD', 
                        tasks.vehicles_id = $intValue2
                       /* vehicles.availability = 
                            CASE 
                                WHEN vehicles.active_tasks < 4 THEN 'not_busy'
                                ELSE 'busy'
                            END,
                        vehicles.active_tasks = vehicles.active_tasks + 1 */
                    WHERE tasks.tasks_id = $tasksId";


$resultUpdateTasks = $conn->query($sqlUpdateTasks);

if (!$resultUpdateTasks) {
    die("First UPDATE Query failed: " . $conn->error);
}


$sqlUpdateVehicles = "UPDATE tasks 
                    INNER JOIN vehicles ON tasks.vehicles_id = vehicles.vehicles_id 
                    SET 
                        vehicles.availability = 
                            CASE 
                                WHEN vehicles.active_tasks < 4 THEN 'not_busy'
                                ELSE 'busy'
                            END,
                        vehicles.active_tasks = vehicles.active_tasks + 1 
                    WHERE tasks.tasks_id = $tasksId";



$resultUpdateVehicles = $conn->query($sqlUpdateVehicles);

if (!$resultUpdateVehicles) {
    die("Second UPDATE Query failed: " . $conn->error);
}

$sqlUpdateSubmissionDate = "UPDATE requests
                    INNER JOIN tasks ON requests.tasks_id = tasks.tasks_id 
                    SET 
                        requests.takeaway_date = CURRENT_DATE()
                    WHERE tasks.tasks_id = $tasksId";



$resultUpdateSubmissionDate = $conn->query($sqlUpdateSubmissionDate);

if (!$resultUpdateSubmissionDate) {
    die("THIRD UPDATE Query failed: " . $conn->error);
}



    // Perform a SELECT query to retrieve updated data
    $sqlSelect = "SELECT * FROM tasks 
                  INNER JOIN rescuer ON tasks.vehicles_id = rescuer.vehicles_id  
                  WHERE tasks.tasks_status = 'ON-ROAD' 
                  AND tasks.type = 'REQUEST'
                  AND rescuer.users_id = $intValue";

    $resultSelect = $conn->query($sqlSelect);

    if (!$resultSelect) {
        die("SELECT Query failed: " . $conn->error);
    }

    $updatedData = [];

    if ($resultSelect->num_rows > 0) {
        while ($row = $resultSelect->fetch_assoc()) {
            $updatedData[] = $row;
        }
    }

    // Close the database connection
    $conn->close();

    // Send the JSON response for the updated data
    header('Content-Type: application/json');
    echo json_encode($updatedData);
} else {
    // Handle the case where tasksId is not present in the received data
    $response = array("status" => "error", "message" => "tasksId not provided in the request");
    echo json_encode($response);
}
?>