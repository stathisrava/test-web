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

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Process the form submission

    // Get the category name from the form
    $categoryName = $_POST["categoryName"];

    // Check if the category already exists in the database
    $checkQuery = "SELECT * FROM category WHERE category_name = ?";
    $checkStatement = $conn->prepare($checkQuery);
    $checkStatement->bind_param("s", $categoryName);
    $checkStatement->execute();
    $checkResult = $checkStatement->get_result();

    if ($checkResult->num_rows > 0) {
        // Category already exists
        echo "<script>alert('Category already exists. Please choose a different name.');</script>";
    } else {
        // Category does not exist, insert it into the database
        $insertQuery = "INSERT INTO  category (category_name) VALUES (?)";
        $insertStatement = $conn->prepare($insertQuery);
        $insertStatement->bind_param("s", $categoryName);
        $insertStatement->execute();

        // Display success message
        echo "<script>alert('Category added successfully.');</script>";
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
</head>
<body>

   <!-- Adding a header -->
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
        <label for="categoryName">Category Name:</label>
        <input type="text" name="categoryName" required>
        <button type="submit">Add Category</button>
    </form>


</body>
</html>