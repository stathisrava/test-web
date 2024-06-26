<?php
//to trexoyme treis fores gia ta 3 admin names k passowrds

// Assuming you have connected to the database
$conn = new mysqli('localhost', 'root', '', 'web');

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Function to hash passwords
function hashPassword($password) {
    return password_hash($password, PASSWORD_DEFAULT);
}

// Example user data (replace with actual data)
$username = "desp";
$password = "despDESP123!";

// Hash the password
$hashedPassword = hashPassword($password);

// Prepare the SQL statement to insert into the user table
$stmtUser = $conn->prepare("INSERT INTO users (username, password) VALUES (?, ?)");
$stmtUser->bind_param("ss", $username, $hashedPassword);

// Execute the statement for the user table
if ($stmtUser->execute()) {
    echo "User record inserted successfully";
} else {
    echo "Error inserting user record: " . $stmtUser->error;
}

// Close the user statement
$stmtUser->close();

// Close the database connection
$conn->close();
?>