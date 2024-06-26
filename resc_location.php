<?php
session_start();

// Assuming you have a MySQL database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "web";


// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if latitude and longitude are provided in the POST request
if (isset($_POST['latitude']) && isset($_POST['longitude'])) {
    // Get latitude and longitude from POST data
    $latitude = $_POST['latitude'];
    $longitude = $_POST['longitude'];

    // Assuming you have a column named 'users_id' that uniquely identifies the user
    // For demo purposes, set it to a static value (you should adapt this based on your user identification)
    // egw thelw edw id...
    $usersId = $_SESSION['username'];
    //echo $usersId;
    $sql = "SELECT users_id AS ID FROM users WHERE username = '$usersId'";
    $resultuser = mysqli_query($conn,$sql);
    $row = mysqli_fetch_assoc($resultuser);
    $intValue = $row["ID"]; //isset($row[0]) ? $row[0] : 0;
   // echo (string)$row;
    echo $intValue;


    // Check if the user already has a location in the database
    $checkSql = "SELECT * FROM resclocations WHERE users_id = $intValue";
    $result = $conn->query($checkSql);

    if ($result->num_rows > 0) {
        // User already has a location, update it
        $updateSql = "UPDATE resclocations SET latitude = '$latitude', longitude = '$longitude', date_recorded = NOW() 
                      WHERE users_id = $intValue";
    } else {
        // User doesn't have a location, insert it
        $updateSql = "INSERT INTO resclocations (users_id, latitude, longitude, date_recorded) 
                      VALUES ($intValue, '$latitude', '$longitude', NOW())";
    }

    if ($conn->query($updateSql) === TRUE) {
        echo "Coordinates updated successfully";
    } else {
        echo "Error updating coordinates: " . $conn->error;
    }

    $conn->close();
    exit(); // Stop further execution
}



// Close the database connection
$conn->close();
?>


