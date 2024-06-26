<?php
// Start the session
session_start();

// Assuming you have connected to the database
$conn = new mysqli('localhost', 'root', '', 'web');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Collect user input from the login form
    $username = $_POST["username"];
    $password = $_POST["passwords"];

    // You may want to add some validation and sanitation here before proceeding
    $stmt = $conn->prepare("SELECT users_id, passwords FROM users WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $stmt->bind_result($userId, $hashedPassword);
    $stmt->fetch();
    $stmt->close();

    // Verify the entered password against the hashed password
    if (password_verify($password, $hashedPassword)) {
        // Passwords match, user is authenticated
        // Store the user's ID in the session
        $_SESSION['users_id'] = $userId;

        // Check if the username is one of the admin usernames
        $adminUsernames = array("stath", "desp", "eyty"); // Add your admin usernames here

        if (in_array($username, $adminUsernames)) {
            header("Location: newtestmap.php"); // Redirect to the admin dashboard
            exit();
        } else {
            header("Location: newtestmap.php"); // Redirect to the user dashboard
            exit();
        }
    } else {
        // Passwords do not match, show error message
        echo "<script>alert('Login failed. Please check your username and password.');</script>";
        echo "<script>window.location.href= 'login.html' </script>";
        exit();
    }
}

// Close the database connection
$conn->close();
?>