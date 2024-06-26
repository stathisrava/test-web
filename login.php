<?php
session_start();

$conn = new mysqli('localhost', 'root', '', 'web');

if ($conn->connect_error) {
    echo "$conn->connect_error";
    die("Connection Failed : " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["username"];
    $password_input = $_POST['password'];

    // Use prepared statements to prevent SQL injection
    $stmt = $conn->prepare("SELECT * FROM users WHERE username=?");
    $stmt->bind_param("s", $username);

    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {

        $row = $result->fetch_assoc();

        // Verify hashed password
        if (password_verify($password_input, $row['password'])) {

            $_SESSION['username'] = $row['username'];
            $_SESSION['users_id'] = $row['users_id'];

            // Check if the user is a rescuer
            $rescuerCheck = $conn->prepare("SELECT * FROM rescuer WHERE users_id = ?");
            $rescuerCheck->bind_param("i", $_SESSION['users_id']);
            $rescuerCheck->execute();
            $rescuerResult = $rescuerCheck->get_result();

            /*
            // Check for specific usernames and redirect accordingly
            if ($username === 'eyty' || $username === 'stath' || $username === 'desp') {
                header("Location: map.php");
            } else {
                header("Location: civmap.php");
            }
            // edw synexeia gia redirect stous RESCUERS RESCMAP.PHP
             */
            // Check for specific usernames
             if ($username === 'eyty' || $username === 'stath' || $username === 'desp') {
                header("Location: map.php");
            } elseif ($rescuerResult->num_rows > 0) {
               // User is a rescuer
               header("Location: rescmap.php");
            } else {
               // User is a civilian
               header("Location: civmap.php?username=" . urlencode($username));
            }


            exit();









        } else {

            // Display an error message with entered username and password
            echo "<script>alert('Incorrect username or password.');</script>";
            // Redirect back to 'login.html' after the message is displayed
            echo "<script>window.location.href = 'login.html';</script>";
            exit();

        }

    } else {

        // Display an error message with entered username
        echo "<script>alert('Username not found.');</script>";
        // Redirect back to 'login.html' after the message is displayed
        echo "<script>window.location.href = 'login.html';</script>";
        exit();

    }
} else {

    header("Location: login.html");
    exit();

}
?>