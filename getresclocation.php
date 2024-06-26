<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "web";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT resclocations.users_id, latitude, longitude, rescuer.vehicles_id, 
vehicles.vehicles_name, cargo.items_id, cargo.amount, items.name, vehicles.active_tasks 
        FROM resclocations
        INNER JOIN rescuer ON resclocations.users_id = rescuer.users_id
        LEFT JOIN vehicles ON rescuer.vehicles_id = vehicles.vehicles_id
        LEFT JOIN cargo ON vehicles.vehicles_id = cargo.vehicles_id
        LEFT JOIN items ON cargo.items_id = items.id ";


$result = $conn->query($sql);

if (!$result) {
    die("Query failed: " . $conn->error);
}

$locations = [];

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $locations[] = $row;
    }
}




$conn->close();

header('Content-Type: application/json');
echo json_encode($locations);
?>
