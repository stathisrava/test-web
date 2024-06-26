<?php
  // Establish a database connection (replace with your database credentials)
  $host = "localhost";
  $username = "root";
  $password = "";
  $database = "web";

  $connection = mysqli_connect($host, $username, $password, $database);

  
    // Check if the connection was successful
    if (!$connection) {
        $response = array('status' => 'error', 'message' => 'Database connection failed');
        echo json_encode($response);
        exit();
    }

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get the offer ID from the POST data
    $offerId = $_POST['offer_id'];


    // Prepare and execute the SQL query to delete the offer
    $sql = "DELETE FROM offers WHERE offers_id = ?";
    $stmt = mysqli_prepare($connection, $sql);

    // Bind the parameter and execute
    mysqli_stmt_bind_param($stmt, "i", $offerId);

    try {
        mysqli_stmt_execute($stmt);
        // Assuming the deletion is successful
        $response = array('status' => 'success', 'message' => 'Offer canceled successfully');
        echo json_encode($response);
    } catch (Exception $e) {
        // Handle SQL error
        $response = array('status' => 'error', 'message' => 'Error canceling offer: ' . $e->getMessage());
        echo json_encode($response);
    }

    // Close the statement and connection
    mysqli_stmt_close($stmt);
    mysqli_close($connection);
} else {
    // Handle invalid requests (only allow POST requests)
    $response = array('status' => 'error', 'message' => 'Invalid request method');
    echo json_encode($response);
}
?>
