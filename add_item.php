<?php
// Replace these variables with your actual database credentials
$hostname = 'localhost';
$username = 'root';
$password = '';
$database = 'web';

// Create a connection to the MySQL database
$conn = new mysqli($hostname, $username, $password, $database);

// Check the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch category names from the 'category' table
$categoryQuery = "SELECT id, category_name FROM category";
$categoryResult = $conn->query($categoryQuery);
$categoryOptions = "";

if ($categoryResult->num_rows > 0) {
    while ($row = $categoryResult->fetch_assoc()) {
        $categoryOptions .= "<option value='" . $row["id"] . "'>" . $row["category_name"] . "</option>";
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Process the form submission

    // Get item details from the form
    $itemName = $_POST["itemName"];
    $itemDetailedName = $_POST["itemDetailedName"];
    $itemDetailedValue = $_POST["itemDetailedValue"];
    $selectedCategoryId = $_POST["category"];

    // Check if the item already exists in the 'items' table
    $checkQuery = "SELECT * FROM items WHERE name = ?";
    $checkStatement = $conn->prepare($checkQuery);
    $checkStatement->bind_param("s", $itemName);
    $checkStatement->execute();
    $checkResult = $checkStatement->get_result();

    if ($checkResult->num_rows > 0) {
        // Item already exists
        echo "<script>alert('Item already exists. Please choose a different name.');</script>";
    } else {
        // Item does not exist, insert it into the 'items' table
        $insertItemQuery = "INSERT INTO items (name, category_id) VALUES (?, ?)";
        $insertItemStatement = $conn->prepare($insertItemQuery);
        $insertItemStatement->bind_param("si", $itemName, $selectedCategoryId);
        $insertItemStatement->execute();

        // Get the last inserted item id
        $lastItemId = $conn->insert_id;

        // Insert item details into the 'details' table
        $insertDetailsQuery = "INSERT INTO details (id, detail_name, detail_value) VALUES (?, ?, ?)";
        $insertDetailsStatement = $conn->prepare($insertDetailsQuery);
        $insertDetailsStatement->bind_param("iss", $lastItemId, $itemDetailedName, $itemDetailedValue);
        $insertDetailsStatement->execute();

        // Display success message
        echo "<script>alert('Item added successfully.');</script>";
        echo "<script>window.location.href = 'map.php';</script>";
    }
}

// Close the database connection when you're done
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Random Markers with Connections</title>

    <link rel="stylesheet" href="map.css">
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css" />
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">

    <style>
        form {
            max-width: 400px;
            margin: 0 auto;
        }

        label, input, select {
            display: block;
            margin-bottom: 10px;
        }

        button {
            margin-top: 10px;
        }
    </style>
</head>
<body>

<nav>
    <div class="logo">
        <p>Des Times</p>
    </div>
    <ul>
        <li><a href="ABOUT.html">About</a></li>
        <li><a href="CONTACT.html">Contact</a></li>
        <li><a href="map.php">Go Back</a></li>
    </ul>
</nav>

<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
    <label for="itemName">Item Name:</label>
    <input type="text" name="itemName" required>

    <!-- Additional fields for Item Detailed Name and Value -->
    <label for="itemDetailedName">Item Detailed Name(e.g., "volume"):</label>
    <input type="text" name="itemDetailedName" required>

    <label for="itemDetailedValue">Item Detailed Value(e.g., "500ml"):</label>
    <input type="text" name="itemDetailedValue" required>
    <!-- End of additional fields -->

    <label for="category">Select Category:</label>
    <select name="category" required>
        <?php echo $categoryOptions; ?>
    </select>

    <button type="submit">Add Item</button>
</form>

</body>
</html>
