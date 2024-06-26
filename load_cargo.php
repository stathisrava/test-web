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

//query to retrieve the request tasks
$query1 = "SELECT tasks.tasks_id FROM tasks
INNER JOIN rescuer ON tasks.vehicles_id = rescuer.vehicles_id
WHERE tasks.type = 'REQUEST' AND rescuer.users_id = '$intValue'
AND tasks.tasks_status = 'ON-ROAD' ";
$tasksID_result = mysqli_query($conn, $query1);

if (!$tasksID_result) {
    die("First Query failed: " . $conn->error);
}

$row = mysqli_fetch_assoc($tasksID_result);
$tasksID = $row['tasks_id'];

$query2 = "SELECT requests.requests_id FROM requests
INNER JOIN tasks ON requests.tasks_id = tasks.tasks_id
WHERE requests.tasks_id = '$tasksID'";
$requestID_result = mysqli_query($conn, $query2);

if (!$requestID_result) {
    die("Second Query failed: " . $conn->error);
}

$row = mysqli_fetch_assoc($requestID_result);
$requestID = $row['requests_id'];

$query3 = "SELECT items_id from requests 
where requests_id = '$requestID'";
$requestItemID_result = mysqli_query($conn, $query3);

if (!$requestItemID_result) {
    die("Third Query failed: " . $conn->error);
}

$row = mysqli_fetch_assoc($requestItemID_result);
$requestItemID = $row['items_id'];

$query4 = "SELECT quantity from requests 
where requests_id = '$requestID'";
$requestQuantity_result = mysqli_query($conn, $query4);

if (!$requestQuantity_result) {
    die("Fourth Query failed: " . $conn->error);
}

$row = mysqli_fetch_assoc($requestQuantity_result);
$requestQuantity = $row['quantity'];

$UpdateInventory = "UPDATE inventory 
INNER JOIN requests ON inventory.id = requests.items_id
SET inventory.amount = inventory.amount - $requestQuantity
WHERE inventory.id = $requestItemID";

$resultUpdateInventory = $conn->query($UpdateInventory);

if (!$resultUpdateInventory) {
    die("First UPDATE Query failed: " . $conn->error);
}

$loadVehiclesID = "SELECT rescuer.vehicles_id from rescuer
where rescuer.users_id = '$intValue'";
$resultloadVehiclesID = $conn->query($loadVehiclesID);
if (!$resultloadVehiclesID) {
    die("Query failed: " . $conn->error);
}

$row = mysqli_fetch_assoc($resultloadVehiclesID);
$vehiclesID = $row['vehicles_id'];

//
$que = "SELECT inventory_id from inventory WHERE id = $requestItemID";
$invID_result = mysqli_query($conn, $que);

if (!$invID_result) {
    die("Second Query failed: " . $conn->error);
}
$row = mysqli_fetch_assoc($invID_result);
$invID_result = $row['inventory_id'];
//

$insertCargo = "INSERT INTO cargo(amount, vehicles_id, inventory_id, items_id)
VALUES ($requestQuantity, $vehiclesID, /*null*/ $invID_result , $requestItemID)";

$resultInsertCargo = $conn->query($insertCargo);

if (!$resultInsertCargo) {
    die("Insert Cargo Query failed: " . $conn->error);
}

$conn->close();