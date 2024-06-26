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
  //  exit();
}








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
      <li id="logout-link"><a href="#" onclick="confirmLogout()">Logout</a></li>
    </ul>                                      <!--showConfirmationDialog() -->
  </nav>

    <!-- Container for user status message -->
    <div id="user-status"> <br><br><br><br>
    <?php echo $userMessage; ?>
    </div>

   <!-- Dropdown menu for map filter -->
   <div> <br> 
    <label for="mapFilter">Map Filter:</label>
    <select id="mapFilter" onchange="handleMapFilterChange()">
      <option value="all" selected>All</option>
      <option value="takenUp">Requests Taken Up</option>
      <option value="notTakenUp">Requests Not Taken Up</option>
      <option value="offers">Offers</option>
      <option value="activeTasks">Vehicles with Active Tasks</option>
      <option value="noActiveTasks">Vehicles with No Active Tasks</option>
      <option value="straightLines">Straight Lines</option>
    </select>
  </div>
 

  <!-- ... (your existing map script) ... -->

  <script>
    // Your existing JavaScript code
// Define layer groups for different marker types
const straightLinesGroup = L.layerGroup();
const redMarkersGroup = L.layerGroup();
const greenMarkersGroup = L.layerGroup();
const truckMarkersGroup = L.layerGroup();
const flagMarkersGroup = L.layerGroup();

//let originalMarkerPosition; // Variable to store the original marker position

    // Function to handle map filter change
    function handleMapFilterChange() {
      var mapFilter = document.getElementById('mapFilter').value;

       // Clear all existing markers from the map
  map.eachLayer(layer => {
    if (layer instanceof L.Marker || layer instanceof L.Polyline) {
      map.removeLayer(layer);
    }
  });
// Implement your logic based on the selected map filter
if (mapFilter === 'all') {
    // Code for 'All' category
    // Add all marker groups to the map
    map.addLayer(straightLinesGroup);
    map.addLayer(redMarkersGroup);
    map.addLayer(greenMarkersGroup);
    map.addLayer(truckMarkersGroup);
  } else if (mapFilter === 'straightLines') {
    // Code for 'Straight Lines' category
    // Add only the straight lines group to the map
    map.addLayer(straightLinesGroup);
  } else {
    // Code for other categories (red, green, trucks, etc.)
    // Add only the corresponding marker group to the map
    if (mapFilter === 'takenUp') {
      map.addLayer(redMarkersGroup);
    } else if (mapFilter === 'notTakenUp') {
      map.addLayer(greenMarkersGroup);
    } else if (mapFilter === 'offers') {
      map.addLayer(redMarkersGroup);
    } else if (mapFilter === 'activeTasks') {
      map.addLayer(truckMarkersGroup);
    } else if (mapFilter === 'noActiveTasks') {
      map.addLayer(truckMarkersGroup);
    }

    }
  }

  </script>

  <div id="map-container">
  <div id="map"></div>

  

  <!-- Include Leaflet scripts -->
  <script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"></script>




  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>



  

  
 
<!-- Button to redirect to index.html for signup -->
<a href="index.html" style="display: block; margin-top: 20px; padding: 10px;
 background-color: #2ecc71; color: #fff; text-align: center; text-decoration: none; font-size: 16px; 
 border-radius: 5px; cursor: pointer;" onmouseover="this.style.backgroundColor='#2980b9'" 
 onmouseout="this.style.backgroundColor='#3498db'"> Create a Rescuer Account Here </a>



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



  <!-- Bar Chart -->
  

  <!-- Date Range Selection -->
  <div><br> <br>
    <label for="dateRange">Select Date Range to see the Bar Chart:</label>
    <input type="text" id="dateRange" placeholder="Select date range" readonly="readonly">
  </div>

  <!-- Bar Chart -->
  <canvas id="barChart" width="400" height="200"></canvas>

  <!-- JavaScript code -->
  <script>
    // Extract data from the fake data table
    const dataTable = [
      { date: '2023-01-01', newRequests: 10, newOffers: 5, doneRequests: 8, doneOffers: 3 },
      { date: '2023-01-02', newRequests: 15, newOffers: 7, doneRequests: 12, doneOffers: 6 },
      { date: '2023-01-03', newRequests: 10, newOffers: 5, doneRequests: 8, doneOffers: 3 },
      { date: '2023-01-04', newRequests: 15, newOffers: 7, doneRequests: 12, doneOffers: 6 },
      { date: '2023-01-05', newRequests: 10, newOffers: 5, doneRequests: 8, doneOffers: 3 },
      { date: '2023-01-06', newRequests: 15, newOffers: 7, doneRequests: 12, doneOffers: 6 },
      { date: '2023-01-07', newRequests: 10, newOffers: 5, doneRequests: 8, doneOffers: 3 },
      { date: '2023-01-08', newRequests: 15, newOffers: 7, doneRequests: 12, doneOffers: 6 },
      // Add more data as needed
    ];

    // Extract dates and amounts for the chart
    const dates = dataTable.map(entry => entry.date);
    const newRequests = dataTable.map(entry => entry.newRequests);
    const newOffers = dataTable.map(entry => entry.newOffers);
    const doneRequests = dataTable.map(entry => entry.doneRequests);
    const doneOffers = dataTable.map(entry => entry.doneOffers);

    // Initialize flatpickr for date range selection
    flatpickr("#dateRange", {
      mode: "range",
      dateFormat: "Y-m-d",
      onClose: handleDateRangeClose,
    });

    // Function to handle date range close event
    function handleDateRangeClose(selectedDates, dateStr, instance) {
      // Filter data based on the selected date range
      const startDate = selectedDates[0];
      const endDate = selectedDates[1];

      // Filter data based on the selected date range
      const filteredData = dataTable.filter(entry => {
        const entryDate = new Date(entry.date);
        return entryDate >= startDate && entryDate <= endDate;
      });

      // Update the chart with the filtered data
      updateChart(filteredData);
    }

    // Function to update the chart with new data
    function updateChart(data) {
      // Extract dates and amounts for the chart
      const dates = data.map(entry => entry.date);
      const newRequests = data.map(entry => entry.newRequests);
      const newOffers = data.map(entry => entry.newOffers);
      const doneRequests = data.map(entry => entry.doneRequests);
      const doneOffers = data.map(entry => entry.doneOffers);

      // Create a bar chart
      const ctx = document.getElementById('barChart').getContext('2d');
      const barChart = new Chart(ctx, {
        type: 'bar',
        data: {
          labels: dates,
          datasets: [
            { label: 'New Requests', data: newRequests, backgroundColor: 'rgba(75, 192, 192, 0.2)', borderColor: 'rgba(75, 192, 192, 1)', borderWidth: 1 },
            { label: 'New Offers', data: newOffers, backgroundColor: 'rgba(255, 99, 132, 0.2)', borderColor: 'rgba(255, 99, 132, 1)', borderWidth: 1 },
            { label: 'Done Requests', data: doneRequests, backgroundColor: 'rgba(54, 162, 235, 0.2)', borderColor: 'rgba(54, 162, 235, 1)', borderWidth: 1 },
            { label: 'Done Offers', data: doneOffers, backgroundColor: 'rgba(255, 206, 86, 0.2)', borderColor: 'rgba(255, 206, 86, 1)', borderWidth: 1 },
          ],
        },
        options: {
          scales: {
            x: { stacked: true },
            y: { stacked: true },
          },
        },
      });
    }
  </script>





  
  <!-- Initialize map and other scripts -->
  
  <script>
    /*
    let lat1 = 38.24738860426854 ;
    let lng1 = 21.735424708276504;
    let originalMarkerPosition; // Declare the variable here

    var map = L.map('map');
    //map.setView([38.2462420, 21.7350847], 11);
   // Add a marker for your location
    const userLocationMarker = L.marker([lat1, lng1], { draggable: true }).addTo(map);

    userLocationMarker.bindPopup("Base").openPopup();


    L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
     // maxZoom: 10,
      attribution: 'Map data Â© <a href="https://openstreetmap.org">OpenStreetMap</a> contributors'}).addTo(map);
    map.setView([lat1, lng1], 11);
  
*/
let originalMarkerPosition; // Declare the variable here

var map = L.map('map');
const userLocationMarker = L.marker([0, 0], { draggable: true }).addTo(map);

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

L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
    attribution: 'Map data Â© <a href="https://openstreetmap.org">OpenStreetMap</a> contributors'
}).addTo(map);







    
   
   
      // Center the map on your location
      //map.setView([lat1, lng1], 1);

    // Event handler for dragstart
userLocationMarker.on('dragstart', function () {
  // Store the original marker position when dragging starts
  originalMarkerPosition = userLocationMarker.getLatLng();
});

// Event handler for dragend
userLocationMarker.on('dragend', function (event) {
  confirmMarkerMove(event.target);
});


/*
    function confirmMarkerMove(marker) {
  var confirmation = confirm("Are you sure you want to move the marker?");
  if (confirmation) {
    // User clicked "OK"
    // Handle marker move (e.g., update the marker's position in your data)
    const newPosition = marker.getLatLng();
    // Update your data or perform any other actions here

    // You may want to update other elements on the map or trigger additional actions

  } else {
    // User clicked "Cancel" or closed the dialog
    // Reset the marker position to its original location
    marker.setLatLng(originalMarkerPosition);
  }
} */


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





  //  </script>


<script>


      // Arrays to store marker instances
      const redMarkers = [];
      const greenMarkers = [];
      const truckMarkers = [];

      // Add random markers with the same coloring
      for (let i = 0; i < 5; i++) {
        const randomLat = lat1 + (Math.random() - 0.5) / 10;
        const randomLng = lng1 + (Math.random() - 0.5) / 10;

        const redMarkerIcon = L.icon({
          iconUrl: 'https://raw.githubusercontent.com/pointhi/leaflet-color-markers/master/img/marker-icon-2x-red.png',
          shadowUrl: 'https://cdnjs.cloudflare.com/ajax/libs/leaflet/1.7.1/images/marker-shadow.png',
          iconSize: [25, 41],
          iconAnchor: [12, 41],
          popupAnchor: [1, -34],
          shadowSize: [41, 41]
        });

        const marker = L.marker([randomLat, randomLng], { icon: redMarkerIcon }).addTo(map);
        redMarkers.push(marker);
        redMarkersGroup.addLayer(redMarker);

        // Bind a popup to each random marker
        marker.bindPopup("Random Red Marker " + (i + 1)).openPopup();
      }

      // green markers
      for (let i = 0; i < 5; i++) {
        const randomLat = lat1 + (Math.random() - 0.5) / 10;
        const randomLng = lng1 + (Math.random() - 0.5) / 10;

        const greenMarkerIcon = L.icon({
          iconUrl: 'https://raw.githubusercontent.com/pointhi/leaflet-color-markers/master/img/marker-icon-2x-green.png',
          shadowUrl: 'https://cdnjs.cloudflare.com/ajax/libs/leaflet/1.7.1/images/marker-shadow.png',
          iconSize: [25, 41],
          iconAnchor: [12, 41],
          popupAnchor: [1, -34],
          shadowSize: [41, 41]
        });

        const marker = L.marker([randomLat, randomLng], { icon: greenMarkerIcon }).addTo(map);
        greenMarkers.push(marker);
        greenMarkersGroup.addLayer(greenMarker);

        // Bind a popup to each random marker
        marker.bindPopup("Random Green Marker " + (i + 1)).openPopup();
      }


      for (let i = 0; i < 5; i++) {
      const randomLat = lat1 + (Math.random() - 0.5) / 10;
      const randomLng = lng1 + (Math.random() - 0.5) / 10;

     // blue truck marker with a different truck icon
     const truckIcon = L.icon({
      iconUrl: 'cargo-truck.png', // Truck icon from Leaflet Routing Machine
     iconSize: [34, 34], // Adjust the size as needed
     iconAnchor: [16, 16], // Adjust the anchor point
      popupAnchor: [0, -16], // Adjust the popup anchor
      });

     const truckMarker = L.marker([randomLat, randomLng], { icon: truckIcon }).addTo(map);
     truckMarkers.push(truckMarker);
     truckMarkersGroup.addLayer(truckMarker);

     truckMarker.bindPopup("Truck Marker").openPopup();
    }

      // Connect one red marker with one green marker
      const randomRedMarker = redMarkers[Math.floor(Math.random() * redMarkers.length)];
      const randomGreenMarker = greenMarkers[Math.floor(Math.random() * greenMarkers.length)];
      //const randomTruckMarker = truckMarkers[Math.floor(Math.random() * truckMarkers.length)];
      
      const connectionPolyline = L.polyline([randomRedMarker.getLatLng(), randomGreenMarker.getLatLng()], { color: 'brown' }).addTo(map);

      // Connect each truck marker with a random red marker
  for (let i = 0; i < Math.min(redMarkers.length, truckMarkers.length); i++) {
    const connectionPolyline = L.polyline([redMarkers[i].getLatLng(), truckMarkers[i].getLatLng()], { color: 'blue' }).addTo(map);
  }


  for (let i = 0; i < 5; i++) {
      const randomLat = lat1 + (Math.random() - 0.5) / 10;
      const randomLng = lng1 + (Math.random() - 0.5) / 10;

     // blue truck marker with a different truck icon
     const flagIcon = L.icon({
      iconUrl: 'finish-flag.png', // Truck icon from Leaflet Routing Machine
     iconSize: [34, 34], // Adjust the size as needed
     iconAnchor: [16, 16], // Adjust the anchor point
      popupAnchor: [0, -16], // Adjust the popup anchor
      });

     const flagMarker = L.marker([randomLat, randomLng], { icon: flagIcon }).addTo(map);
     truckMarkers.push(flagMarker);
     flagMarkersGroup.addLayer(flagMarker);

     flagMarker.bindPopup("Flag Marker").openPopup();
    }

 

    
  </script>


  <style>
    /* Add your styles here */
    body {
      font-family: Arial, sans-serif;
    }

    #myModal {
      display: none;
      position: fixed;
      z-index: 1;
      left: 0;
      top: 0;
      width: 100%;
      height: 100%;
      overflow: auto;
      background-color: rgb(0,0,0);
      background-color: rgba(0,0,0,0.4);
      padding-top: 60px;
    }

    .modal-content {
      background-color: #fefefe;
      margin: 5% auto;
      padding: 20px;
      border: 1px solid #888;
      width: 80%;
    }

    .close {
      color: #aaa;
      float: right;
      font-size: 28px;
      font-weight: bold;
    }

    .close:hover,
    .close:focus {
      color: black;
      text-decoration: none;
      cursor: pointer;
    }
  </style>


<h2>Announcement System</h2>

<button onclick="openModal()">Click here to make an announcement</button>

<!-- The Modal -->
<div id="myModal" class="modal">
  <!-- Modal content -->
  <div class="modal-content">
    <span class="close" onclick="closeModal()">&times;</span>
    <h3>Select items for the announcement:</h3>

    <div id="itemsTableContainer"></div>

    <br>

    <button onclick="submitAnnouncement()">OK</button>
  </div>
</div>

<script>
  // Get the modal
  var modal = document.getElementById('myModal');

  var itemsArray = []; // Declare a global variable

// Function to open the modal and fetch items
function openModal() {
  // Fetch items using AJAX
  var xhr = new XMLHttpRequest();
  xhr.onreadystatechange = function() {
    if (xhr.readyState == 4) {
      if (xhr.status == 200) {
        itemsArray = JSON.parse(xhr.responseText); // Store items globally
        if (itemsArray && itemsArray.length > 0) {
          populateItemsTable(itemsArray);
          modal.style.display = 'block';
        } else {
          console.error('No items received from the server.');
        }
      } else {
        console.error('Error fetching items. Status:', xhr.status);
      }
    }
  };
  xhr.open('GET', 'http://localhost/web2023-24/item_fetch_all.php', true);
  xhr.send();
}

  // Function to close the modal
  function closeModal() {
    modal.style.display = 'none';
  }

  // Function to handle the announcement submission
function submitAnnouncement() {
  // Get all checkboxes in the table
  var checkboxes = document.querySelectorAll('#itemsTableContainer input[type="checkbox"]:checked');
  
  // Extract selected item values
  var selectedItems = Array.from(checkboxes).map(function(checkbox) {
    return checkbox.name;
  });

  // Send selected items to the server
  var xhr = new XMLHttpRequest();
  xhr.onreadystatechange = function() {
    if (xhr.readyState == 4) {
      if (xhr.status == 200) {
        console.log('Announcement submitted successfully.');
      } else {
        console.error('Error submitting announcement. Status:', xhr.status);
      }
    }
  };
  xhr.open('POST', 'http://localhost/web2023-24/submit_announcement.php', true);
  xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
  xhr.send('selectedItems=' + encodeURIComponent(JSON.stringify(selectedItems)));
  
  // Close the modal after submission
  closeModal();
}


  // Function to populate the items table
  function populateItemsTable(items) {
    var itemsTableContainer = document.getElementById('itemsTableContainer');
    var itemsTableHTML = '<table id="itemsTable">';
    
    items.forEach(function(item) {
      itemsTableHTML += '<tr><td><input type="checkbox" name="' + item.name + '"> ' + item.name + '</td></tr>';
    });

    itemsTableHTML += '</table>';
    itemsTableContainer.innerHTML = itemsTableHTML;
  }
</script>

</body>
</html>




</body>
</html>
