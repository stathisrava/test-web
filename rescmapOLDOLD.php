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
    
<!-- Dropdown menu for map filter -->
<div><br>
  <label for="mapFilter">Map Filter:</label>
  <select id="mapFilter" onchange="handleMapFilterChange()">
    <option value="all" selected>All</option>
    <option value="reqtakenUp">Requests Taken Up</option>
    <option value="reqnotTakenUp">Requests Not Taken Up</option>
    <option value="offerstakenup">Offers Taken Up</option>
    <option value="offersnottakenup">Offers Not Taken Up</option>
    
  </select>
</div>

<!-- ... (your existing map script) ... -->

<script>
  // Define layer groups for different marker types in the global scope
  const truckMarkersGroup = L.layerGroup();
  const redMarkersGroup = L.layerGroup();
  const greenMarkersGroup = L.layerGroup();
  const reddiffMarkersGroup = L.layerGroup();
  const greendiffMarkersGroup = L.layerGroup();

  // Variable to store the previous selected filter
  // Variable to store the previous selected filter
let previousFilter = '';

// Function to handle map filter change
// Function to handle map filter change
// Function to handle map filter change

function handleMapFilterChange() {
  var mapFilter = document.getElementById('mapFilter').value;

  // Add all layers to the map
  map.addLayer(truckMarkersGroup);
  map.addLayer(redMarkersGroup);
  map.addLayer(greenMarkersGroup);
  map.addLayer(reddiffMarkersGroup);
  map.addLayer(greendiffMarkersGroup);

  // Remove layers not needed based on the selected filter
  switch (mapFilter) {
    case 'reqtakenUp':
      map.removeLayer(greenMarkersGroup);
      map.removeLayer(reddiffMarkersGroup);
      map.removeLayer(greendiffMarkersGroup);
      map.removeLayer(truckMarkersGroup);
      break;
    case 'reqnotTakenUp':
      map.removeLayer(truckMarkersGroup);
      map.removeLayer(redMarkersGroup);
      map.removeLayer(greenMarkersGroup);
      map.removeLayer(greendiffMarkersGroup);
      break;
    case 'offerstakenup':
      map.removeLayer(truckMarkersGroup);
      map.removeLayer(redMarkersGroup);
      map.removeLayer(reddiffMarkersGroup);
      map.removeLayer(greendiffMarkersGroup);
      break;
    case 'offersnottakenup':
      map.removeLayer(truckMarkersGroup);
      map.removeLayer(redMarkersGroup);
      map.removeLayer(greenMarkersGroup);
      map.removeLayer(reddiffMarkersGroup);
      break;
    case 'noActiveTasks':
      map.removeLayer(redMarkersGroup);
      map.removeLayer(greenMarkersGroup);
      map.removeLayer(reddiffMarkersGroup);
      map.removeLayer(greendiffMarkersGroup);
      break;
    case 'all':
      // Do nothing extra, as all layers are already added
      break;
    default:
      console.error('Invalid map filter:', mapFilter);
  }
}



// Initial call to set up the map with 'All' category
handleMapFilterChange();


  
  </script>



<!-- Initialize map and other scripts -->
<script>
    let lat1, lng1;
    let userLocationMarker1;

    var map = L.map('map').setView([38.2462420, 21.7350847], 11);

    L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: 'Map data © <a href="https://openstreetmap.org">OpenStreetMap</a> contributors'
    }).addTo(map);


    let originalMarkerPosition; // Declare the variable here

const userLocationMarker = L.marker([0, 0], { draggable: false }).addTo(map);

// Fetch the initial location from the server
$.ajax({
    type: 'GET',
    url: 'fetch_invloc_fromdb.php',
    success: function(response) {
        const location = JSON.parse(response);
        // Update the marker position and map view with the fetched location
        userLocationMarker.setLatLng([location.latitude, location.longitude]);
        map.setView([location.latitude, location.longitude], 11);
    },
    error: function(error) {
        console.error("Error fetching location:", error);
    }
});

userLocationMarker.bindPopup("Base").openPopup();

    // Event handler for dragstart
userLocationMarker.on('dragstart', function () {
  // Store the original marker position when dragging starts
  originalMarkerPosition = userLocationMarker.getLatLng();
});

// Event handler for dragend
userLocationMarker.on('dragend', function (event) {
  confirmMarkerMove(event.target);
});

function confirmMarkerMove(marker) {
var confirmation = confirm("Are you sure you want to move the marker?");
if (confirmation) {
    const newPosition = marker.getLatLng();
    
    // Log the latitude and longitude to the console
    console.log("New Latitude:", newPosition.lat);
    console.log("New Longitude:", newPosition.lng);

    // Make an AJAX request to update the coordinates in the database
    updateDatabaseCoordinates(newPosition.lat, newPosition.lng);
} else {
    // User clicked "Cancel" or closed the dialog
    // Reset the marker position to its original location
    marker.setLatLng(originalMarkerPosition);
}
}

function updateDatabaseCoordinates(latitude, longitude) {
// Assuming you have a unique identifier for the inventory item (replace '1' with your actual inventory item ID)
var inventoryId = 1;

// Make an AJAX request to the server-side script
$.ajax({
    type: 'POST',
    url: 'fetch_invloc.php',
    data: {
        latitude: latitude,
        longitude: longitude,
        inventory_id: inventoryId
    },
    success: function(response) {
        console.log(response); // Log the server response to the console
    },
    error: function(error) {
        console.error("Error updating coordinates:", error);
    }
});
}

navigator.geolocation.getCurrentPosition(success, error);
const greenMarkers = [];
const redMarkers = [];

    function getCurrentPosition() {
        navigator.geolocation.getCurrentPosition(success, error);
    }

  /*  function takeUpFunction(tasksId) {
                // Add the logic for what happens when the "Take Up" button is clicked
                // For example, you can perform an action or show a message
                alert("Taking up the offer!");

                // Assuming you have access to the user's ID, you might want to pass it in the request
                //const userId = users.users_id; // Replace 'id' with the actual property name in your user object
                //const tasksId = users.tasks_id; // Assuming tasksId is a property in your user object

                // Make an AJAX call using the fetch API
                fetch('offer_chose.php', {
                  method: 'POST',
                  headers: {
                    'Content-Type': 'application/json', // Adjust the content type as needed
                  },
                  body: JSON.stringify({
                    
                    tasksId: tasksId
                    
                    // Add other data you want to send to the server
                  }),
                })
                  .then(response => {
                    if (!response.ok) {
                      throw new Error(`HTTP error! Status: ${response.status}`);
                    }
                    return response.json(); // Assuming the response is in JSON format
                  })
                  .then(data => {
                    // Handle the data returned from the server
                    console.log('Server response:', data);
                    // You can update the UI or take further actions based on the response
                  })
                  .catch(error => {
                    console.error('Error:', error);
                    // Handle errors, display a message, etc.
                  });
              }
*/


    function success(position) {
        lat1 = position.coords.latitude;
        lng1 = position.coords.longitude;

        if (userLocationMarker1) {
            map.removeLayer(userLocationMarker1);
        }

        userLocationMarker1 = L.marker([lat1, lng1], { draggable: true }).addTo(map);

        userLocationMarker1.on('dragend', function (event) {
            const markerLatLng = event.target.getLatLng();
            lat1 = markerLatLng.lat;
            lng1 = markerLatLng.lng;
            console.log('Updated Latitude:', lat1);
            console.log('Updated Longitude:', lng1);
            updateLocationInDatabase(lat1, lng1);

        });

        const popupContent = "You are here<br>";
        userLocationMarker1.bindPopup(popupContent).openPopup();

        map.setView([lat1, lng1]);

        console.log('Initial Latitude:', lat1);
        console.log('Initial Longitude:', lng1);





        lat1 = position.coords.latitude;
      lng1 = position.coords.longitude;

      // Center the map on your location
      map.setView([lat1, lng1], 1);


// offers not taken up 
// EDW

const nottakenofeMarkerIcon = L.icon({
  iconUrl: 'cross_1.png',
  iconSize: [25, 41],
  iconAnchor: [12, 41],
  popupAnchor: [1, -34],
  shadowSize: [41, 41]
});

function offernottakenup() {

  function takeUpFunction(tasksId) {
                // Add the logic for what happens when the "Take Up" button is clicked
                // For example, you can perform an action or show a message
                alert("Taking up the offer!");

                // Assuming you have access to the user's ID, you might want to pass it in the request
                //const userId = users.users_id; // Replace 'id' with the actual property name in your user object
                //const tasksId = users.tasks_id; // Assuming tasksId is a property in your user object

                // Make an AJAX call using the fetch API
                fetch('offer_chose.php', {
                  method: 'POST',
                  headers: {
                    'Content-Type': 'application/json', // Adjust the content type as needed
                  },
                  body: JSON.stringify({
                    
                    tasksId: tasksId
                    
                    // Add other data you want to send to the server
                  }),
                })
                  .then(response => {
                    if (!response.ok) {
                      throw new Error(`HTTP error! Status: ${response.status}`);
                    }
                    return response.json(); // Assuming the response is in JSON format
                  })
                  .then(data => {
                    // Handle the data returned from the server
                    console.log('Server response:', data);
                    // You can update the UI or take further actions based on the response
                  })
                  .catch(error => {
                    console.error('Error:', error);
                    // Handle errors, display a message, etc.
                  });
              }




  $.ajax({
    url: 'find_not_taken_offer.php',
    method: 'GET',
    success: function (data) {
      try {
        // Attempt to parse the data as JSON
        data = JSON.parse(data);

        // Check if data is an array
        if (Array.isArray(data)) {
          // Check if the array is not empty
          if (data.length > 0) {
            // Iterate over the array
            data.forEach(function (user) {
              const marker = L.marker([user.latitude, user.longitude], { icon: nottakenofeMarkerIcon }).addTo(map);

              greendiffMarkersGroup.addLayer(marker);

              

              // Construct the content for the popup
              const popupContent = `
                <strong>Name:</strong> ${user.name}<br>
                <strong>Lastname:</strong> ${user.lastname}<br>
                <strong>Phone Number:</strong> ${user.phone_num}<br>
                <strong>Takeaway Date:</strong> ${user.takeaway_date}<br>
                <strong>Submission Date:</strong> ${user.submission_date}<br>
                <strong>Offer Quantity:</strong> ${user.offers_quantity}<br>
                <strong>Offer Items:</strong> ${user.offers_items}<br>
                <strong>Vehicle's Name:</strong> ${user.vehicles_name}<br>
                <strong>Task's Id:</strong> ${user.tasks_id}<br>

                <button class="take-up-button">Take Up</button>
              `;

              marker.bindPopup(popupContent);
 // Get the button element by class name
 const takeUpButton = document.querySelector('.take-up-button');

// Add an event listener to the button

    if (takeUpButton) {
    takeUpButton.addEventListener('click', function () {
        takeUpFunction(user.tasks_id);
    });
}
              
    

            
          })} else {
            console.error('Received empty array:', data);
          }
        } else {
          console.error('Received non-array data:', data);
        }
      } catch (error) {
        console.error('Error parsing JSON:', error);
      }
    },
    error: function (error) {
      console.error('Error fetching user locations:', error);
    }
  });
}

// Call the function to fetch and display user locations
offernottakenup();











// requests not taken up 
// EDW
const nottakenreqMarkerIcon = L.icon({
  iconUrl: 'cross.png', 
          iconSize: [25, 41],
          iconAnchor: [12, 41],
          popupAnchor: [1, -34],
          shadowSize: [41, 41]
        });
        function requestsnottakenup() {
  $.ajax({
    url: 'find_not_taken_request.php',
    method: 'GET',
    success: function (data) {
      try {
        // Attempt to parse the data as JSON
        data = JSON.parse(data);

        // Check if data is an array
        if (Array.isArray(data)) {
          // Check if the array is not empty
          if (data.length > 0) {
            // Iterate over the array
            data.forEach(function (user) {
              const marker = L.marker([user.latitude, user.longitude], { icon: nottakenreqMarkerIcon }).addTo(map);

              reddiffMarkersGroup.addLayer(marker);

              // Construct the content for the popup
              const popupContent = `
                <strong>Name:</strong> ${user.name}<br>
                <strong>Lastname:</strong> ${user.lastname}<br>
                <strong>Phone Number:</strong> ${user.phone_num}<br>
                <strong>Takeaway Date:</strong> ${user.takeaway_date}<br>
                <strong>Submission Date:</strong> ${user.submission_date}<br>
                <strong>Request Quantity:</strong> ${user.quantity}<br>
                <strong>Request Items:</strong> ${user.items_id}<br>
                <strong>Vehicle's Name:</strong> ${user.vehicles_name}<br>
              `;

              marker.bindPopup(popupContent);
            });
          } else {
            console.error('Received empty array:', data);
          }
        } else {
          console.error('Received non-array data:', data);
        }
      } catch (error) {
        console.error('Error parsing JSON:', error);
      }
    },
    error: function (error) {
      console.error('Error fetching user locations:', error);
    }
  });
}

// Call the function to fetch and display user locations
requestsnottakenup();






      //fetch users OFFERS
      const greenMarkerIcon = L.icon({
          iconUrl: 'https://raw.githubusercontent.com/pointhi/leaflet-color-markers/master/img/marker-icon-2x-green.png',
          shadowUrl: 'https://cdnjs.cloudflare.com/ajax/libs/leaflet/1.7.1/images/marker-shadow.png',
          iconSize: [25, 41],
          iconAnchor: [12, 41],
          popupAnchor: [1, -34],
          shadowSize: [41, 41]
        });

      function fetchUserLocations() {
        $.ajax({
            url: 'getlocationofferswithrescid.php',
            method: 'GET',
            success: function (data) {
          
              // Add markers for each user location
            data.forEach(function (user) {
               
                const marker = L.marker([user.latitude, user.longitude], {icon: greenMarkerIcon}).addTo(map);

                greenMarkersGroup.addLayer(marker);
                greenMarkers.push(marker);

                // Concatenate user information into a single string for the popup
               // Construct the content for the popup
               const popupContent = `
                    <strong>Name:</strong> ${user.name}<br>
                    <strong>Lastname:</strong> ${user.lastname}<br>
                    <strong>Phone Number:</strong> ${user.phone_num}<br>
                    <strong>Takeaway Date:</strong> ${user.takeaway_date}<br>
                    <strong>Submission Date:</strong> ${user.submission_date}<br>
                    <strong>Offer Quantity:</strong> ${user.offers_quantity}<br>
                    <strong>Offer Items:</strong> ${user.offers_items}<br>
                    <strong>Vehicle's Name:</strong> ${user.vehicles_name}<br>
                `;

                marker.bindPopup(popupContent);
                  
                });
            },
            error: function (error) {
                console.error('Error fetching user locations:', error);
            }
        });
    }

    // Call the function to fetch and display user locations
    fetchUserLocations();


  //fetch users REQUESTS
  const redMarkerIcon = L.icon({
          iconUrl: 'https://raw.githubusercontent.com/pointhi/leaflet-color-markers/master/img/marker-icon-2x-red.png',
          shadowUrl: 'https://cdnjs.cloudflare.com/ajax/libs/leaflet/1.7.1/images/marker-shadow.png',
          iconSize: [25, 41],
          iconAnchor: [12, 41],
          popupAnchor: [1, -34],
          shadowSize: [41, 41]
        });

  function fetchUserreqLocations() {
        $.ajax({
            url: 'getlocationrequestswithrescid.php',
            method: 'GET',
            success: function (data) {
          
              // Add markers for each user location
            data.forEach(function (user) {
                const marker = L.marker([user.latitude, user.longitude],{ icon: redMarkerIcon }).addTo(map);

              redMarkersGroup.addLayer(marker);
              redMarkers.push(marker);
             

                // Concatenate user information into a single string for the popup
               // Construct the content for the popup
               const popupContent = `
                    <strong>Name:</strong> ${user.name}<br>
                    <strong>Lastname:</strong> ${user.lastname}<br>
                    <strong>Phone Number:</strong> ${user.phone_num}<br>
                    <strong>Takeaway Date:</strong> ${user.takeaway_date}<br>
                    <strong>Submission Date:</strong> ${user.submission_date}<br>
                    <strong>Request Quantity:</strong> ${user.quantity}<br>
                    <strong>Request Items:</strong> ${user.items_id}<br>
                    <strong>Vehicle's Name:</strong> ${user.vehicles_name}<br>   
                `;

                marker.bindPopup(popupContent);
                  
                });
            },
            error: function (error) {
                console.error('Error fetching user locations:', error);
            }
        });
    }

    // Call the function to fetch and display user locations
    fetchUserreqLocations();




//We don't want that here 
/*
      //fetch rescuers

      // Define a custom icon for the rescuers  

const rescuerIcon = L.icon({
    iconUrl: 'cargo-truck.png',
    iconSize: [32, 32], // Adjust the size as needed
    iconAnchor: [16, 16], // Adjust the anchor point if needed
    popupAnchor: [0, -16] // Adjust the popup anchor if needed
});
    function fetchRescuerLocations() {
        $.ajax({
            url: 'getresclocation.php',
            method: 'GET',
            success: function (data) {
          
              // Add markers for each rescuer location
            data.forEach(function (rescuer) {
                const marker = L.marker([rescuer.latitude, rescuer.longitude], { icon: rescuerIcon }).addTo(map);

                truckMarkersGroup.addLayer(marker);
                
                // Concatenate user information into a single string for the popup
               // Construct the content for the popup
               const popupContent = `
            <strong>User ID:</strong> ${rescuer.users_id}<br>
            <strong>Vehicles ID:</strong> ${rescuer.vehicles_id}<br>
            <strong>Vehicles Name:</strong> ${rescuer.vehicles_name}<br>
            <strong>Item Id:</strong> ${rescuer.items_id}<br>
            <strong>Item Name:</strong> ${rescuer.name}<br>
            <strong>Amount:</strong> ${rescuer.amount}<br>
            <strong>Active tasks:</strong> ${rescuer.active_tasks}<br>
                `;

                marker.bindPopup(popupContent);
                  
                });
            },
            error: function (error) {
                console.error('Error fetching rescuer locations:', error);
            }
        });
    }

    // Call the function to fetch and display rescuer locations
    fetchRescuerLocations();

*/


    

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
