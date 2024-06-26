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


<div id="map-container">
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
    

<!-- ... (your existing map script) ... -->

<script>
  // Define layer groups for different marker types in the global scope
  const truckMarkersGroup = L.layerGroup();
  const redMarkersGroup = L.layerGroup();
  const greenMarkersGroup = L.layerGroup();
  const reddiffMarkersGroup = L.layerGroup();
  const greendiffMarkersGroup = L.layerGroup();

  const allGreendiffMarkers = greendiffMarkersGroup.getLayers();
  const allReddiffMarkers = reddiffMarkersGroup.getLayers();

// Combine markers from both groups into a single array
const allTaskMarkers = [greendiffMarkersGroup.getLayers(), reddiffMarkersGroup.getLayers()];


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

userLocationMarker.bindPopup(`
<div style="text-align: center;">
<p>Base</p>
</div>
  <button id="baseButton" onclick="showBasePopup()" style="display: none;">Φόρτωση</button> 
  <button id="baseButton2" onclick="showBasePopup2()" style="display: none;">Εκφόρτωση</button>
`).openPopup();


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

//-------------------------------------------------------------------------------------------
            function showBasePopup() {
  // Your logic to show the base popup for Φόρτωση goes here
  alert("Φόρτωση Base Popup");
}

function showBasePopup2() {
  // Your logic to show the base popup for Εκφόρτωση goes here
  alert("Εκφόρτωση Base Popup");
}

// Get the user's location coordinates
const userLatLng = userLocationMarker1.getLatLng();

// Coordinates of the base (replace with the actual coordinates of your base)
const baseLatLng = userLocationMarker.getLatLng();

// Calculate the distance between the user's location and the base
const distanceToBase = userLatLng.distanceTo(baseLatLng);

// Now, you can use the distanceToBase value as needed
console.log('Distance to base:', distanceToBase);


// Check if the distance is less than or equal to 100 meters
if (distanceToBase <= 100) {
  // Show the buttons to open the base popup
  document.getElementById("baseButton").style.display = "block";
  document.getElementById("baseButton2").style.display = "block";
  $("#basePopupButton, #basePopupButton2").show();
 // console.log(distanceToBase);
} else {
  // Hide the buttons if the rescuer is not within the specified radius
  $("#basePopupButton, #basePopupButton2").hide();
}


// Event listener for the Φόρτωση button inside the popup
$(document).on('click', '#baseButton', function () {
  // Handle Φόρτωση button click inside the popup
  showBasePopup();
  // Make an AJAX request to load cargo when the button is clicked
  $.ajax({
    type: 'POST',
    url: 'load_cargo.php',  // Replace with the correct path to your load_cargo.php file
    data: {
      user_name: '<?php echo $_SESSION["username"]; ?>'
    },
    success: function(response) {
      console.log(response);  // Log the server response to the console
      // Handle the response as needed
    },
    error: function(error) {
      console.error("Error loading cargo:", error);
      // Handle the error as needed
    }
  });
});

// Event listener for the Εκφόρτωση button inside the popup
$(document).on('click', '#baseButton2', function () {
   // Handle Φόρτωση button click inside the popup
   showBasePopup2();
  // Make an AJAX request to load cargo when the button is clicked
  $.ajax({
    type: 'POST',
    url: 'deload_cargo.php',  // Replace with the correct path to your load_cargo.php file
    data: {
      user_name: '<?php echo $_SESSION["username"]; ?>'
    },
    success: function(response) {
      console.log(response);  // Log the server response to the console
      // Handle the response as needed
    },
    error: function(error) {
      console.error("Error deloading cargo:", error);
      // Handle the error as needed
    }
  });
});


            //--------------------------------------------------------------------------------------

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

// gia ta requests
function takeUpFunction2(tasksId) {

        
console.log("takeupfunction2 captures this tasksId ");
console.log(tasksId);

// Make an AJAX call using the fetch API
fetch('request_chose.php', {
    method: 'POST',
    headers: {
        'Content-Type': 'application/json',
    },
    body: JSON.stringify({
        tasksId: tasksId,
        
// Add other data you want to send to the server
    }),
})
    .then(response => {
        if (!response.ok) {
            throw new Error(`HTTP error! Status: ${response.status}`);
        }
        return response.json();
    })
    .then(data => {
        console.log('Server response:', data);
        // Reload the page
        window.location.href = 'rescmap.php';
        // You can update the UI or take further actions based on the response
    })
    .catch(error => {
        console.error('Error:', error);
        // Handle errors, display a message, etc.
    });
}
 


// gia ta offers
      function takeUpFunction(tasksId) {

        
    console.log("takeupfunction captures this tasksId ");
    console.log(tasksId);

    // Make an AJAX call using the fetch API
    fetch('offer_chose.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify({
            tasksId: tasksId,
            
// Add other data you want to send to the server
        }),
    })
        .then(response => {
            if (!response.ok) {
                throw new Error(`HTTP error! Status: ${response.status}`);
            }
            return response.json();
        })
        .then(data => {
            console.log('Server response:', data);
            // Reload the page
            window.location.href = 'rescmap.php';
            // You can update the UI or take further actions based on the response
        })
        .catch(error => {
            console.error('Error:', error);
            // Handle errors, display a message, etc.
        });
}

// for requests
document.getElementById('map-container').addEventListener('click', function (event) {
        const target = event.target;

        // Check if the clicked element has the 'take-up-button' class
        if (target.classList.contains('take-up-button2')) {
            const taskId = target.getAttribute('data-task-id');
            console.log('Button clicked for Task ID:', taskId);
            takeUpFunction2(taskId); // Pass the taskId as an argument
        }
    });

    // for offers 
document.getElementById('map-container').addEventListener('click', function (event) {
        const target = event.target;

        // Check if the clicked element has the 'take-up-button' class
        if (target.classList.contains('take-up-button')) {
            const taskId = target.getAttribute('data-task-id');
            console.log('Button clicked for Task ID:', taskId);
            takeUpFunction(taskId); // Pass the taskId as an argument
        }
    });


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

                                <button class="take-up-button" data-task-id="${user.tasks_id}">Take Up</button> `;

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
/*
// Delegate the event handling to the map container
document.getElementById('map-container').addEventListener('click', function (event) {
    const target = event.target;

    // Check if the clicked element has the 'take-up-button' class
    if (target.classList.contains('take-up-button')) {
        const taskId = target.getAttribute('data-task-id');
        console.log('Button clicked for Task ID:', taskId);
        takeUpFunction(taskId);
    } 
}); */




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
             // const allTaskMarkers = [];

              // Construct the content for the popup
              const popupContent = `
                <strong>Name:</strong> ${user.name}<br>
                <strong>Lastname:</strong> ${user.lastname}<br>
                <strong>Phone Number:</strong> ${user.phone_num}<br>
                <strong>Takeaway Date:</strong> ${user.takeaway_date}<br>
                <strong>Submission Date:</strong> ${user.submission_date}<br>
                <strong>Request Quantity:</strong> ${user.quantity}<br>
                <strong>Request Items:</strong> ${user.items_id}<br>
                <strong>Vehicle's Name:</strong> ${user.vehicles_name}
                <br> <strong>Task's Id:</strong> ${user.tasks_id}<br>
              

              <button class="take-up-button2" data-task-id="${user.tasks_id}">Take Up</button> `;

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
            text-align: center;
        }

        h2 {
            color: #333;
            font-weight: bold; /* Add this line to make the heading bold */
            margin: 0 auto;
        }

        table {
            border-collapse: collapse;
            width: 100%;
            margin-top: 20px;
        }

        table, th, td {
            border: 1px solid #ddd;
            margin: 0 auto;
        }

        th, td {
            padding: 10px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }
    </style>
   

<br><br><br> <h2>Είδη στο όχημα μου</h2>

<table border="1">
  <thead>
    <tr>    
      <th>Item Id</th>
      <th>Item name</th>
      <th>Quantity</th>
    </tr>
  </thead>
  <tbody id="tasksTableBody1"></tbody>
</table> <br> <br>

<script>
$(document).ready(function() {
  // Make an AJAX request
  $.ajax({
    url: 'seemycargo.php',  // Change this URL to the correct path of your seemycargo.php file
    type: 'GET',
    dataType: 'json',  // Assuming the response is in JSON format
    success: function(data) {
      // Clear existing table data
      $('#tasksTableBody1').empty();

      // Populate the table with received data
      $.each(data, function(index, item) {
        $('#tasksTableBody1').append('<tr><td>' + item.itemId + '</td><td>' + item.itemName + '</td><td>' + item.quantity + '</td></tr>');
      });
    },
    error: function(error) {
      console.log('Error:', error);
    }
  });
});
</script>


<!---------------------------------------------------------------------------------->
<br><br><br> <h2>Τρέχοντα Tasks</h2>

<table border="1">
  <thead>
    <tr>    
      <th>First Name</th>
      <th>Last name</th>
      <th>Phone Number</th>
      <th>Submission Date</th>
      <th>Offer Quantity</th>
      <th>Offer Item Id</th>
      <th>Request Quantity</th>
      <th>Request Item Id</th>
      <th>Type</th>
      <th>Status</th>
      <th>Action</th>
      <th>Action</th>
    </tr>
  </thead>
  <tbody id="tasksTableBody"></tbody>
</table> <br> <br>

<script>

//let distanceToTask; // Declare the variable in an outer scope

//--------------------------------------------------------------------------------------
 /* function showBasePopup() {
  // Your logic to show the base popup for Φόρτωση goes here
  alert("Φόρτωση Base Popup");
}

function showBasePopup2() {
  // Your logic to show the base popup for Εκφόρτωση goes here
  alert("Εκφόρτωση Base Popup");
}

// Get the user's location coordinates
const userLatLng = userLocationMarker1.getLatLng();

// Coordinates of the base (replace with the actual coordinates of your base)
const baseLatLng = userLocationMarker.getLatLng();

// Calculate the distance between the user's location and the base
const distanceToBase = userLatLng.distanceTo(baseLatLng);

// Now, you can use the distanceToBase value as needed
console.log('Distance to base:', distanceToBase);


// Check if the distance is less than or equal to 100 meters
if (distanceToBase <= 100) {
  // Show the buttons to open the base popup
  $("#basePopupButton, #basePopupButton2").show();
} else {
  // Hide the buttons if the rescuer is not within the specified radius
  $("#basePopupButton, #basePopupButton2").hide();
}


// Event listener for the Φόρτωση button inside the popup
$(document).on('click', '#baseButton', function () {
  // Handle Φόρτωση button click inside the popup
  showBasePopup();
});

// Event listener for the Εκφόρτωση button inside the popup
$(document).on('click', '#baseButton2', function () {
  // Handle Εκφόρτωση button click inside the popup
  showBasePopup2();
});

*/

//------------------------------------------------------------------------------------------
$(document).ready(function() {
  // Fetch data from the server using AJAX
  $.ajax({
    url: 'tasks_fetch.php',
    method: 'GET',
    dataType: 'json', // Assuming your server returns JSON data
    success: function(data) {
      var combinedData = data.query1.concat(data.query2);

      // Update the table with the combined data
      updateTable(combinedData, '#tasksTableBody');
    },
    error: function(error) {
      console.error('Error fetching data:', error);
    }
  });

  let distanceToTask;

  // Function to update the table with data
  function updateTable(data, tableBodyId) {
    var tableBody = $(tableBodyId);

    // Clear existing rows
    tableBody.empty();

    // Loop through the data and append rows to the table
    $.each(data, function(index, task) {
      var row = $('<tr>');
      row.append($('<td>').text(task.name));
      row.append($('<td>').text(task.lastname));
      row.append($('<td>').text(task.phone_num));
      row.append($('<td>').text(task.submission_date));
      row.append($('<td>').text(task.offers_quantity)); // Use offers_quantity if available, otherwise use quantity
      row.append($('<td>').text(task.offers_items));
      row.append($('<td>').text(task.quantity));
      row.append($('<td>').text(task.items_id));
      row.append($('<td>').text(task.type));
      row.append($('<td>').text(task.tasks_status));

      // Add "Complete" button
      var completeButton = $('<button>').text('Complete');
      completeButton.click(function() {
        // Get the user's location coordinates
        const userLatLng = userLocationMarker1.getLatLng();

        $.ajax({
          url: 'gettasklatlng.php',
          method: 'POST',
          dataType: 'json',
          data: { tasks_id: task.tasks_id },
          success: function(response) {
            let distanceToTask; // Declare the variable in an outer scope
            // Handle the response from the server
            if (response.length > 0) {
              const taskLatLng = L.latLng(parseFloat(response[0].latitude), parseFloat(response[0].longitude));
              distanceToTask = userLatLng.distanceTo(taskLatLng);
              console.log('Distance to task:', distanceToTask + ' meters');
              console.log('Distance to task:', distanceToTask);

              // Your existing logic for completing the task...

            } else {
              console.error('Empty response or invalid data format.');
            }
          },
          error: function(xhr, status, error) {
            console.error('Error getting task coordinates:', error);
            console.log('XHR:', xhr);
          }
        });

        // Check if the distance is less than or equal to 50 meters
        if (distanceToTask <= 50) {
          $.ajax({
            url: 'complete_task.php',
            method: 'POST',
            dataType: 'json',
            data: { tasks_id: task.tasks_id },
            success: function(response) {
              console.log('Task completed successfully:', response);
              row.remove();
            },
            error: function(xhr, status, error) {
              console.error('Error completing task:', error);
              console.log('XHR:', xhr);
            }
          });
        } else {
          alert('You must be within 50 meters of the task to complete the task.');
        }
      });

      row.append($('<td>').append(completeButton));

      // Add "Cancel" button
      var cancelButton = $('<button>').text('Cancel');
      cancelButton.click(function() {
        $.ajax({
          url: 'cancel_task.php',
          method: 'POST',
          dataType: 'json',
          data: { tasks_id: task.tasks_id },
          success: function(response) {
            console.log('Task canceled successfully:', response);
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





</body>
</html>