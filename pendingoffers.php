<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "web";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT COUNT(*) AS location_count, GROUP_CONCAT(DISTINCT offers_id) AS ids, GROUP_CONCAT(DISTINCT offers.submission_date) AS submission_dates
        FROM locations
        INNER JOIN users ON locations.users_id = users.users_id
        INNER JOIN civilian ON users.users_id = civilian.users_id
        INNER JOIN offers ON civilian.civilian_id = offers.civilian_id
        INNER JOIN tasks ON offers.tasks_id = tasks.tasks_id
        WHERE tasks.tasks_status = 'PENDING' AND tasks.type = 'OFFER'";

$result = $conn->query($sql);

if (!$result) {
    die("Query failed: " . $conn->error);
}

$data = [];

while ($row = $result->fetch_assoc()) {
    $data[] = [
        'location_count' => $row['location_count'],
        'ids' => $row['ids'], // IDs as a comma-separated string
        'submission_dates' => $row['submission_dates'],
    ];
}

$conn->close();

header('Content-Type: application/json');
echo json_encode($data);
?>
