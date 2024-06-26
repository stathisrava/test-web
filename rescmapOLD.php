<?php
session_start();

// Check if the user is logged in
if (isset($_SESSION['username'])) {
    // User is logged in
    $userMessage = "User is logged in. User ID: " . $_SESSION['username'];
} else {
    // User is not logged in
    $userMessage = "User is not logged in. Redirect to login page or take appropriate action.";
    // Redirect to the login page
    // header("Location: login.html");
    // exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rescuer's Map</title>

    <!-- Include Leaflet CSS directly -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css" />

    <!-- Include your script -->
    <link rel="stylesheet" href="map.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"></script>
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
        <li id="logout-link"><a href="#" onclick="confirmLogout()">Logout</a></li>
    </ul>
    <!--showConfirmationDialog() -->
</nav>

<!-- Container for user status message -->
<div id="user-status"> <br><br><br><br>
    <?php echo $userMessage; ?>
</div>

<!--div id="map-container"-->
<div id="map" style="height: 400px;"></div>



  <!-- Include your other scripts here -->

  <script>
    function confirmLogout() {
      var confirmation = confirm("Are you sure you want to log out?");
      if (confirmation) {
        // User clicked "OK"
        logout();
      } else {
        // User clicked "Cancel" or closed the dialog
        // Do nothing or handle accordingly
      }
    }

    function logout() {
      // Perform logout actions here
      // For example, redirect to logout page
      window.location.href = 'index.html';
    }
  </script>



<!-- Initialize map and other scripts -->
<script>
    let lat1, lng1;
    let userLocationMarker;

    var map = L.map('map').setView([38.2462420, 21.7350847], 11);

    L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: 'Map data © <a href="https://openstreetmap.org">OpenStreetMap</a> contributors'
    }).addTo(map);

    function getCurrentPosition() {
        navigator.geolocation.getCurrentPosition(success, error);
    }

    function success(position) {
        lat1 = position.coords.latitude;
        lng1 = position.coords.longitude;

        if (userLocationMarker) {
            map.removeLayer(userLocationMarker);
        }

        userLocationMarker = L.marker([lat1, lng1], { draggable: true }).addTo(map);

        userLocationMarker.on('dragend', function (event) {
            const markerLatLng = event.target.getLatLng();
            lat1 = markerLatLng.lat;
            lng1 = markerLatLng.lng;
            console.log('Updated Latitude:', lat1);
            console.log('Updated Longitude:', lng1);
            updateLocationInDatabase(lat1, lng1);

        });

        const popupContent = "You are here<br>";
        userLocationMarker.bindPopup(popupContent).openPopup();

        map.setView([lat1, lng1]);

        console.log('Initial Latitude:', lat1);
        console.log('Initial Longitude:', lng1);
    }

    function error(err) {
        if (err.code == 1) {
            alert("Please allow your location access");
        } else {
            alert("Cannot get current location");
        }
    }

    // Get the initial position when the page loads
    getCurrentPosition();




//new stuff
// Log latitude and longitude to the console
  
    function updateLocationInDatabase(latitude, longitude) {
            // Send AJAX request to update location in the database
            $.ajax({
                type: 'POST',
                url: 'resc_location.php', // Change to the correct path
                data: { latitude: latitude, longitude: longitude },
                success: function(response) {
                    console.log(response);
                },
                error: function(error) {
                    console.error(error);
                }
            });
        }



</script>










<!--new stuff -->
<style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }

        h2 {
            color: #333;
            font-weight: bold; /* Add this line to make the heading bold */
        }

        table {
            border-collapse: collapse;
            width: 100%;
            margin-top: 20px;
        }

        table, th, td {
            border: 1px solid #ddd;
        }

        th, td {
            padding: 10px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }
    </style>




<br><br><br> <h2>Τρέχοντα Tasks</h2>

<table border="1">
  <thead>
    <tr>
      <th>Rescuer Id</th>
      <th>Id</th>
      <th>First Name</th>
      <th>Last name</th>
      <th>Phone Number</th>
      <th>Submission Date</th>
      <th>Item</th>
      <th>Quantity</th>
      <th>Type</th>
      <th>Action</th>
      <th>Action</th>
    </tr>
  </thead>
  <tbody id="tasksTableBody"></tbody>
</table> <br> <br>

<script>
 $(document).ready(function() {
  // Fetch data from the server using AJAX
  $.ajax({
    url: 'tasks_fetch.php',
    method: 'GET',
    dataType: 'json', // Assuming your server returns JSON data
    success: function(data) {
      // Update the table with the fetched data
      updateTable(data, '#tasksTableBody');
    },
    error: function(error) {
      console.error('Error fetching data:', error);
    }
  });

  // Function to update the table with data
  function updateTable(data, tableBodyId) {
    var tableBody = $(tableBodyId);

    // Clear existing rows
    tableBody.empty();

    // Loop through the data and append rows to the table
    $.each(data, function(index, task) {
      var row = $('<tr>');
      row.append($('<td>').text(task.rescuer_id));
      row.append($('<td>').text(task.tasks_id));
      row.append($('<td>').text(task.name));
      row.append($('<td>').text(task.lastname));
      row.append($('<td>').text(task.phone_num));
      row.append($('<td>').text(task.submission_date));
      row.append($('<td>').text(task.item));
      row.append($('<td>').text(task.quantity));
      row.append($('<td>').text(task.type));

      //BUTTONS BOUTTONS
      // Add "Complete" button
      var completeButton = $('<button>').text('Complete');
      completeButton.click(function() {
        // Add logic for completing the task
        // You can make an AJAX request to update the server
        // and then update the UI accordingly
        $.ajax({
          url: 'complete_task.php', // Assuming you have a separate PHP file for completing tasks
          method: 'POST',
          dataType: 'json', // Assuming your server returns JSON data
          data: { tasks_id: task.tasks_id }, // Replace 'task_id' with your actual task ID field
          success: function(response) {
            // Handle the response from the server
            console.log('Task completed successfully:', response);

            // Assuming you want to remove the completed task from the table
            row.remove();
          },
          error: function(xhr, status, error) {
      console.error('Error completing task:', error);
      console.log('XHR:', xhr);
          }
        });
      });

      row.append($('<td>').append(completeButton));

      // Add "Cancel" button
      var cancelButton = $('<button>').text('Cancel');
      cancelButton.click(function() {
        // Add logic for canceling the task
        // You can make an AJAX request to update the server
        // and then update the UI accordingly
        $.ajax({
          url: 'cancel_task.php', // Assuming you have a separate PHP file for canceling tasks
          method: 'POST',
          dataType: 'json', // Assuming your server returns JSON data
          data: { task_id: task.task_id }, // Replace 'task_id' with your actual task ID field
          success: function(response) {
            // Handle the response from the server
            console.log('Task canceled successfully:', response);

            // Assuming you want to remove the canceled task from the table
            row.remove();
          },
          error: function(error) {
            console.error('Error canceling task:', error);
          }
        });
      });

      row.append($('<td>').append(cancelButton));

      tableBody.append(row);
    });
  }
});

</script>




</body>
</html>
