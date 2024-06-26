<?php
session_start();
$conn = new mysqli('localhost', 'root', '', 'web');

// Check the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Assuming the AJAX request sends the selected mapFilter value
//if (isset($_POST['mapFilter'])) {
 //   $mapFilter = $_POST['mapFilter'];

  //  if ($mapFilter == 'notTakenUp') {
        // Perform the database queries to retrieve information
        $sql = "SELECT locations.latitude, locations.longitude , civilian.name,
        civilian.lastname, civilian.phone_num, requests.submission_date, 
        requests.quantity, requests.items_id, requests.takeaway_date, tasks.tasks_id
     /*   ,   vehicles.vehicles_name */
              FROM locations
                INNER JOIN users ON locations.users_id = users.users_id
                INNER JOIN civilian ON users.users_id = civilian.users_id
                INNER JOIN requests ON civilian.civilian_id = requests.civilian_id
                INNER JOIN tasks ON requests.tasks_id = tasks.tasks_id
             /* INNER JOIN vehicles ON tasks.vehicles_id = vehicles.vehicles_id
                INNER JOIN rescuer ON vehicles.vehicles_id = rescuer.vehicles_id */
                WHERE tasks.tasks_status = 'PENDING' AND tasks.type = 'REQUEST'"; 


        $result = $conn->query($sql);

        if ($result) {
            $data = [];

            while ($row = $result->fetch_assoc()) {
                $data[] = $row;
            }

            // Convert the result to JSON and send it as the response
            echo json_encode($data);
        } else {
            // Handle database query error
            echo json_encode(['error' => 'Database query error']);
        }
   // } 
 


// Close the database connection
$conn->close();
?>