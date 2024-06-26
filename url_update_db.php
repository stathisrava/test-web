<?php

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "web";

// Establish database connection
$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// External URL with JSON data
$externalUrl = "http://usidas.ceid.upatras.gr/web/2023/export.php";

// Fetch JSON data from the external URL
$jsonString = file_get_contents($externalUrl);

if ($jsonString === false) {
    die('Error retrieving JSON from the external URL');
}

// Parse JSON data
$jsonData = json_decode($jsonString, true);

if ($jsonData === null) {
    die('Error decoding JSON data');
}

// Function to recursively update data in tables
function updateData($data, $parentTable = '') {
    global $conn;

    foreach ($data as $key => $value) {
        // Rename 'categories' to 'category'
        $newKey = ($key === 'categories') ? 'category' : $key;

        $tableName = $parentTable . '_' . $newKey; // Concatenate parent table name if it exists

        if (is_array($value) || is_object($value)) {
            // If the value is an array or object, recursively call the function
            updateData((array)$value, $tableName);
        } else {
            // Check if the table already exists
            $checkTableQuery = "SHOW TABLES LIKE '$tableName'";
            $result = $conn->query($checkTableQuery);

            if ($result->num_rows > 0) {
                // If the table exists, update the data
                $updateQuery = "UPDATE $tableName SET $newKey = '$value'";

                if ($conn->query($updateQuery) === false) {
                    die("Error updating data in table $tableName: " . $conn->error);
                } else {
                    echo "Updated data in table $tableName: $newKey = $value<br>";
                }
            } else {
                echo "Table $tableName does not exist. Data not updated.<br>";
            }
        }
    }
}

// Call the updateData function with the top-level JSON data
updateData($jsonData);

// Close connection
$conn->close();

echo "Data from the external URL has been successfully updated in the database.";

?>