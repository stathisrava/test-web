<?php
$conn = new mysqli('localhost', 'root', '', 'web');


if ($conn->connect_error) {
    echo "$conn->connect_error";
    die("Connection Failed : " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["username"];
    $password = $_POST['password'];
    $vehicles_id = $_POST['vehicles_id'];
   // $name = $_POST["name"];
   // $lastname = $_POST["lastname"];
   // $phone_num = $_POST["phone_num"];
   // $address = $_POST["address"];

    // Hash the user's password
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Insert the new user into the "users" table
    $insert_user_query = "INSERT INTO users (username, password)
    VALUES ('$username', '$hashed_password')";

    // Check if the user already exists in the database
    $check_query = "SELECT * FROM users WHERE username = '$username'";

    // Attempt to fetch cached result first
    $cached_result = $conn->query($check_query);
    if ($cached_result !== false && $cached_result->num_rows > 0) {
        // Display a message to the user
        echo "<script>alert('Rescuer already registered. Please login.');</script>";
        // Redirect back to 'login.html' after the message is displayed
        echo "<script>window.location.href = 'indexresc.html';</script>";
        exit(); // Make sure to exit to prevent further execution
    }
/*
    // Fetch fresh result from the database
    $check_result = $conn->query($check_query);
    if ($check_result->num_rows > 0) {
        // Display a message to the user
        echo "<script>alert('Rescuer already registered. Please login.');</script>";
        // Redirect back to 'login.html' after the message is displayed
        echo "<script>window.location.href = 'login.html';</script>";
        exit(); // Make sure to exit to prevent further execution
    } 
*/
    // Execute the first query to insert into the "users" table
    if ($conn->query($insert_user_query) === false) {
        echo "Error: " . $insert_user_query . "<br>" . $conn->error;
        exit();
    }

    // Get the generated users_id (assuming it's an auto-increment primary key)
    $user_id = mysqli_insert_id($conn);


//

// Other PHP code above this line
// Debugging
// Retrieve coordinates from the form
 /*
 if (isset($_POST['latitude']) && isset($_POST['longitude'])) {
  
    $latitude = ($_POST['latitude']);
    $longitude = ($_POST['longitude']);
    // Debugging
    //echo "Latitude: $latitude, Longitude: $longitude";
     // Log values for debugging
     error_log("Latitude: " . $latitude);
     error_log("Longitude: " . $longitude);

    // Assuming you have a user ID, replace 'YOUR_USER_ID' with the actual user ID
    //$user_id = 'YOUR_USER_ID';

    // Insert coordinates into the database
    $location_sql = "INSERT INTO resclocations (users_id, latitude, longitude, date_recorded) VALUES ('$user_id', '$latitude', '$longitude', CURRENT_DATE)";

    if ($conn->query($location_sql) === TRUE) {
        echo json_encode(array('status' => 'success', 'message' => 'Coordinates inserted successfully'));
    } else {
        echo json_encode(array('status' => 'error', 'message' => 'Error inserting coordinates: ' . $conn->error));
    }
} else {
    echo json_encode(array('status' => 'error', 'message' => 'Latitude and longitude not provided'));
}

*/


    // Insert the new user into the "civilian" table
    $insert_rescuer_query = "INSERT INTO rescuer (users_id , vehicles_id)
    VALUES ('$user_id' , '$vehicles_id')";

    // Execute the second query to insert into the "rescuer" table
    if ($conn->query($insert_rescuer_query) === true) {
        // Display a success message to the user
        echo "<script>alert('Rescuer registered successfully!');</script>";
        // Redirect to 'map.html'
        echo "<script>window.location.href = 'indexresc.html';</script>";
        exit();
    } else {
        echo "Error: " . $insert_rescuer_query . "<br>" . $conn->error;
    }

}


?>