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


$query1 = "SELECT tasks.tasks_id FROM tasks
INNER JOIN rescuer ON tasks.vehicles_id = rescuer.vehicles_id
WHERE tasks.type = 'OFFER' AND rescuer.users_id = '$intValue'
AND tasks.tasks_status = 'ON-ROAD' ";
$tasksID_result = mysqli_query($conn, $query1);

if (!$tasksID_result) {
    die("First Query failed: " . $conn->error);
}

$row = mysqli_fetch_assoc($tasksID_result);
$tasksID = $row['tasks_id'];

$query2 = "SELECT offers.offers_id FROM offers
INNER JOIN tasks ON offers.tasks_id = tasks.tasks_id
WHERE offers.tasks_id = '$tasksID'";
$offersID_result = mysqli_query($conn, $query2);

if (!$offersID_result) {
    die("Second Query failed: " . $conn->error);
}

$row = mysqli_fetch_assoc($offersID_result);
$offersID = $row['offers_id'];

$query8 = "SELECT offers.offers_items FROM offers
INNER JOIN tasks ON offers.tasks_id = tasks.tasks_id
WHERE offers.tasks_id = '$tasksID'";

$offersitem_result = mysqli_query($conn, $query8);

if (!$offersitem_result) {
    die("Second Query failed: " . $conn->error);
}
$row = mysqli_fetch_assoc($offersitem_result);
$offersitem_result = $row['offers_items'];

$query4 = "SELECT offers_quantity from offers 
where offers_id = '$offersID'";
$offersQuantity_result = mysqli_query($conn, $query4);

if (!$offersQuantity_result) {
    die("Fourth Query failed: " . $conn->error);
}

$row = mysqli_fetch_assoc($offersQuantity_result);
$offersQuantity = $row['offers_quantity'];

$UpdateInventory = "UPDATE inventory 
INNER JOIN offers ON inventory.id = offers.offers_items
SET inventory.amount = inventory.amount + '$offersQuantity'
WHERE inventory.id = '$offersitem_result'";

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

$deleteCargo = "DELETE FROM cargo 
                WHERE vehicles_id = '$vehiclesID'
                AND items_id = '$offersitem_result'";

$resultDeleteCargo = $conn->query($deleteCargo);

if (!$resultDeleteCargo) {
    die("Delete Cargo Query failed: " . $conn->error);
}

$conn->close();