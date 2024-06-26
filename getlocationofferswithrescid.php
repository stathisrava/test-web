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
//echo $usersId;
$sql = "SELECT users_id AS ID FROM users WHERE username = '$usersId'";
$resultuser = mysqli_query($conn,$sql);
$row = mysqli_fetch_assoc($resultuser);
$intValue = $row["ID"]; //isset($row[0]) ? $row[0] : 0;
// echo (string)$row;
//echo $intValue;

$sql = "SELECT locations.latitude, locations.longitude , civilian.name,
civilian.lastname, civilian.phone_num, offers.submission_date, 
offers.offers_quantity, offers.offers_items, offers.takeaway_date,
 vehicles.vehicles_name 
     
FROM locations
INNER JOIN users ON locations.users_id = users.users_id
INNER JOIN civilian ON users.users_id = civilian.users_id
INNER JOIN offers ON civilian.civilian_id = offers.civilian_id
INNER JOIN tasks ON offers.tasks_id = tasks.tasks_id
INNER JOIN vehicles ON tasks.vehicles_id = vehicles.vehicles_id
INNER JOIN rescuer ON vehicles.vehicles_id = rescuer.vehicles_id
WHERE tasks.tasks_status = 'ON-ROAD' 
AND tasks.type = 'OFFER'
AND rescuer.users_id = $intValue";


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