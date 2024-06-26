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

$usersId = $_SESSION['username'];
$sql = "SELECT users_id AS ID FROM users WHERE username = '$usersId'";
$resultuser = mysqli_query($conn, $sql);
$row = mysqli_fetch_assoc($resultuser);
$intValue = $row["ID"];
//echo $intValue;

// First Query
$sql1 = "SELECT  
            name, lastname, phone_num, offers.submission_date, offers.offers_quantity, offers.offers_items,tasks.type, tasks.tasks_status, tasks.tasks_id
        FROM civilian
        INNER JOIN offers ON civilian.civilian_id = offers.civilian_id
        LEFT JOIN tasks ON offers.tasks_id = tasks.tasks_id
        LEFT JOIN vehicles ON tasks.vehicles_id = vehicles.vehicles_id
        LEFT JOIN rescuer ON vehicles.vehicles_id = rescuer.vehicles_id 
        WHERE tasks_status = 'ON-ROAD' AND rescuer.users_id = $intValue";

$result1 = $conn->query($sql1);

if (!$result1) {
    die("Query 1 failed: " . $conn->error);
}

// Second Query
$sql2 = "SELECT  
            name,  lastname,  phone_num, requests.submission_date, requests.quantity, requests.items_id, tasks.type, tasks.tasks_status, tasks.tasks_id
        FROM civilian
        LEFT JOIN requests ON civilian.civilian_id = requests.civilian_id
        LEFT JOIN tasks ON requests.tasks_id = tasks.tasks_id
        LEFT JOIN vehicles ON tasks.vehicles_id = vehicles.vehicles_id
        LEFT JOIN rescuer ON vehicles.vehicles_id = rescuer.vehicles_id 
        WHERE tasks_status = 'ON-ROAD' AND rescuer.users_id = $intValue";

$result2 = $conn->query($sql2);

if (!$result2) {
    die("Query 2 failed: " . $conn->error);
}

// Process results
$locations1 = [];
$locations2 = [];

if ($result1->num_rows > 0) {
    while ($row1 = $result1->fetch_assoc()) {
        $locations1[] = $row1;
    }
}

if ($result2->num_rows > 0) {
    while ($row2 = $result2->fetch_assoc()) {
        $locations2[] = $row2;
    }
}

$conn->close();

// Combine results
$combinedResults = [
    "query1" => $locations1,
    "query2" => $locations2
];

header('Content-Type: application/json');
echo json_encode($combinedResults);
?>
