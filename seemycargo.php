<?php
session_start();
// Assuming you have a database connection established
// Replace these values with your actual database credentials
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "web";

// Create a connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
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


// SQL query
$sql = "SELECT cargo.items_id, cargo.amount, items.name FROM cargo
        INNER JOIN items ON cargo.items_id = items.id
        INNER JOIN rescuer ON cargo.vehicles_id = rescuer.vehicles_id
        WHERE rescuer.users_id = $intValue";

$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // Output data as JSON
    $output = array();
    while ($row = $result->fetch_assoc()) {
        $output[] = array(
            'itemId' => $row['items_id'],
            'itemName' => $row['name'],
            'quantity' => $row['amount']
        );
    }

    header('Content-Type: application/json');
    echo json_encode($output);
} else {
    // No results
    echo "No data found";
}

$conn->close();

?>
