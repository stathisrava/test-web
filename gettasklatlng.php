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

// Second Query
$sql2 = "SELECT  
                latitude, longitude 
                FROM locations
                INNER JOIN users ON locations.users_id = users.users_id
                INNER JOIN civilian ON users.users_id = civilian.users_id
                INNER JOIN requests ON civilian.civilian_id = requests.civilian_id
                INNER JOIN tasks ON requests.tasks_id = tasks.tasks_id
                INNER JOIN vehicles ON tasks.vehicles_id = vehicles.vehicles_id
                INNER JOIN rescuer ON vehicles.vehicles_id = rescuer.vehicles_id 
                WHERE tasks_status = 'ON-ROAD' AND rescuer.users_id = $intValue";

$result2 = $conn->query($sql2);

if (!$result2) {
    die("Query 2 failed: " . $conn->error);
}


$locations2 = [];

if ($result2->num_rows > 0) {
    while ($row2 = $result2->fetch_assoc()) {
        $locations2[] = $row2;
    }
}

$conn->close();



header('Content-Type: application/json');
echo json_encode($locations2);
?>
