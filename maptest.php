<?php
session_start();
// Check if the user is logged in

$conn = new mysqli('localhost', 'root', '', 'web');

if (isset($_SESSION['username'])) {
    $userMessage = "User is logged in. User ID: " . $_SESSION['username'];
} else {
    $userMessage = "User is not logged in. Redirect to login page or take appropriate action.";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Admin's Map</title>

  <link rel="stylesheet" href="map.css">
  <link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css" />
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
  
  <!-- Include Leaflet scripts -->
  <script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"></script>
  <!-- Include Chart.js library -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

  
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
<div><br>
  <label for="mapFilter">Map Filter:</label>
  <select id="mapFilter" onchange="handleMapFilterChange()">
    <option value="all" selected>All</option>
    <option value="reqtakenUp">Requests Taken Up</option>
    <option value="reqnotTakenUp">Requests Not Taken Up</option>
    <option value="offerstakenup">Offers Taken Up</option>
    <option value="offersnottakenup">Offers Not Taken Up</option>
    <option value="noActiveTasks">Vehicles</option>
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
  clearPolylines();

  // Remove layers not needed based on the selected filter
  switch (mapFilter) {
    case 'reqtakenUp':
      clearPolylines();
      map.removeLayer(greenMarkersGroup);
      map.removeLayer(reddiffMarkersGroup);
      map.removeLayer(greendiffMarkersGroup);
      map.removeLayer(truckMarkersGroup);
      break;
    case 'reqnotTakenUp':
      clearPolylines();
      map.removeLayer(truckMarkersGroup);
      map.removeLayer(redMarkersGroup);
      map.removeLayer(greenMarkersGroup);
      map.removeLayer(greendiffMarkersGroup);
      break;
    case 'offerstakenup':
      clearPolylines();
      map.removeLayer(truckMarkersGroup);
      map.removeLayer(redMarkersGroup);
      map.removeLayer(reddiffMarkersGroup);
      map.removeLayer(greendiffMarkersGroup);
      break;
    case 'offersnottakenup':
      clearPolylines();
      map.removeLayer(truckMarkersGroup);
      map.removeLayer(redMarkersGroup);
      map.removeLayer(greenMarkersGroup);
      map.removeLayer(reddiffMarkersGroup);
      break;
    case 'noActiveTasks':
      clearPolylines();
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
  

  

    

  </script>

  <div id="map-container">
  <div id="map"></div>

  


  
 
<!-- Button to redirect to index.html for signup -->
<a href="indexresc.html" style="display: block; margin-top: 20px; padding: 10px;
 background-color: #2ecc71; color: #fff; text-align: center; text-decoration: none; font-size: 16px; 
 border-radius: 5px; cursor: pointer;" onmouseover="this.style.backgroundColor='#2980b9'" 
 onmouseout="this.style.backgroundColor='#3498db'"> Create a Rescuer Account Here </a>

 <a href="add_category.php" style="display: block; margin-top: 20px; padding: 10px; 
 background-color: #2ecc71; color: #fff; text-align: center; text-decoration: none; font-size: 16px; border-radius: 5px; 
 cursor: pointer;" onmouseover="this.style.backgroundColor='#2980b9'" onmouseout="this.style.backgroundColor='#3498db'">Add Category</a>

<a href="add_item.php" style="display: block; margin-top: 20px; padding: 10px; 
 background-color: #2ecc71; color: #fff; text-align: center; text-decoration: none; font-size: 16px; border-radius: 5px; 
 cursor: pointer;" onmouseover="this.style.backgroundColor='#2980b9'" onmouseout="this.style.backgroundColor='#3498db'">Add Items</a><br><br>



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
  <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.js"></script>

<!-- Date Range Picker -->
<label for="startDate">Start Date:</label>
<input type="date" id="startDate">
<label for="endDate">End Date:</label>
<input type="date" id="endDate">
<button onclick="updateChart()">Update Chart</button>

<br><br><canvas id="myChart" style="width:100%;max-width:600px"></canvas><br><br>

<script>
// Function to get an array of date strings for the current week
function getDaysOfWeek() {
  const daysOfWeek = [];
  const currentDate = new Date();
  const currentDay = currentDate.getDay();
  const firstDay = new Date(currentDate);
  firstDay.setDate(currentDate.getDate() - currentDay);
  
  for (let i = 0; i < 7; i++) {
    const day = new Date(firstDay);
    day.setDate(firstDay.getDate() + i);
    daysOfWeek.push(day.toISOString().split('T')[0]);
  }

  return daysOfWeek;
}

// Function to update the chart based on the selected date range
async function updateChart() {
  const startDate = document.getElementById('startDate').value;
  const endDate = document.getElementById('endDate').value;

  // Validate the selected dates
  if (startDate === '' || endDate === '') {
    alert('Please select both start and end dates.');
    return;
  }

  // Fetch data for the selected date range from your PHP files
  try {
    const offersResponse = await fetch(`completeoffers.php?start_date=${startDate}&end_date=${endDate}`);
    const requestsResponse = await fetch(`completerequests.php?start_date=${startDate}&end_date=${endDate}`);
    const pendingOffersResponse = await fetch(`pendingoffers.php?start_date=${startDate}&end_date=${endDate}`);
    const pendingRequestsResponse = await fetch(`pendingrequests.php?start_date=${startDate}&end_date=${endDate}`);
    
    const offersData = await offersResponse.json();
    const requestsData = await requestsResponse.json();
    const pendingOffersData = await pendingOffersResponse.json();
    const pendingRequestsData = await pendingRequestsResponse.json();

    // Get the selected date range
    const selectedDateRange = getDaysOfWeek(startDate, endDate);

    // Process data for offers
    const offersCounts = Array.from({ length: selectedDateRange.length }, (_, index) => {
      const date = selectedDateRange[index];
      const offersCount = offersData.find(item => item.submission_dates.includes(date))?.location_count || 0;
      return offersCount;
    });

    // Process data for requests
    const requestsCounts = Array.from({ length: selectedDateRange.length }, (_, index) => {
      const date = selectedDateRange[index];
      const requestsCount = requestsData.find(item => item.submission_dates.includes(date))?.location_count || 0;
      return requestsCount;
    });

    // Process data for pending offers
    const pendingOffersCounts = Array.from({ length: selectedDateRange.length }, (_, index) => {
      const date = selectedDateRange[index];
      const pendingOffersCount = pendingOffersData.find(item => item.submission_dates.includes(date))?.location_count || 0;
      return pendingOffersCount;
    });

    // Process data for pending requests
    const pendingRequestsCounts = Array.from({ length: selectedDateRange.length }, (_, index) => {
      const date = selectedDateRange[index];
      const pendingRequestsCount = pendingRequestsData.find(item => item.submission_dates.includes(date))?.location_count || 0;
      return pendingRequestsCount;
    });

    // Update the chart data and redraw
    updateChartWithData(selectedDateRange, offersCounts, requestsCounts, pendingOffersCounts, pendingRequestsCounts);
  } catch (error) {
    console.error('Error fetching data:', error);
    alert('Error fetching data. Please try again.');
  }
}

// Function to update the chart with specific data
function updateChartWithData(labels, offersData, requestsData, pendingOffersData, pendingRequestsData) {
  // Create or update the chart
  if (!myChart) {
    const ctx = document.getElementById('myChart').getContext('2d');
    myChart = new Chart(ctx, {
      type: 'bar',
      data: {
        labels: labels,
        datasets: [
          {
            label: 'Complete Offers',
            backgroundColor: 'rgba(128, 0, 128, 0.2)', // Purple color
            borderColor: 'rgba(128, 0, 128, 1)',
            borderWidth: 1,
            data: offersData
          },
          {
            label: 'Complete Requests',
            backgroundColor: 'rgba(255, 99, 132, 0.2)',
            borderColor: 'rgba(255, 99, 132, 1)',
            borderWidth: 1,
            data: requestsData
          },
          {
            label: 'Pending Offers',
            backgroundColor: 'rgba(255, 206, 86, 0.2)',
            borderColor: 'rgba(255, 206, 86, 1)',
            borderWidth: 1,
            data: pendingOffersData
          },
          {
            label: 'Pending Requests',
            backgroundColor: 'rgba(54, 162, 235, 0.2)',
            borderColor: 'rgba(54, 162, 235, 1)',
            borderWidth: 1,
            data: pendingRequestsData
          }
        ]
      },
      options: {
        scales: {
          x: {
            type: 'time',
            time: {
              unit: 'day',
              tooltipFormat: 'DD-MM-YYYY',
              displayFormats: {
                day: 'DD-MM-YYYY'
              }
            }
          },
          y: {
            beginAtZero: true
          }
        },
        legend: {
          display: true,
          position: 'top'
        }
      }
    });
  } else {
    myChart.data.labels = labels;
    myChart.data.datasets[0].data = offersData;
    myChart.data.datasets[1].data = requestsData;
    myChart.data.datasets[2].data = pendingOffersData;
    myChart.data.datasets[3].data = pendingRequestsData;
    myChart.update();
  }
}

// Function to get an array of date strings for the selected date range
function getDaysOfWeek(startDate, endDate) {
  const daysInRange = [];
  const currentDay = new Date(startDate);
  while (currentDay <= new Date(endDate)) {
    daysInRange.push(currentDay.toISOString().split('T')[0]);
    currentDay.setDate(currentDay.getDate() + 1);
  }
  return daysInRange;
}

let myChart; // Declare myChart outside the script block
</script>












  
  <!-- Initialize map and other scripts -->
  <script>
    let lat1, lng1;

    var map = L.map('map');
    map.setView([38.2462420, 21.7350847], 11);

    L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
      maxZoom: 19,
      attribution: 'Map data Â© <a href="https://openstreetmap.org">OpenStreetMap</a> contributors'
    }).addTo(map);

    let originalMarkerPosition; // Declare the variable here

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

let polylines = [];
// Keep track of the drawn polylines
let drawnPolylines = null;
const polylineGroup = L.layerGroup().addTo(map);
let polyline = null; // Declare polyline outside the drawPolylines function

// Function to draw polylines between the clicked truck and red/green markers
function drawPolylines(truckMarker, redMarkers, greenMarkers) {
    // Clear existing polylines
    clearPolylines();
  
    // Draw polylines to red markers
    redMarkers.forEach((redMarker) => {
        const polyline = L.polyline([truckMarker.getLatLng(), redMarker.getLatLng()], { color: 'red' }).addTo(map);
        polylines.push(polyline);
    });

    // Draw polylines to green markers
    greenMarkers.forEach((greenMarker) => {
        const polyline = L.polyline([truckMarker.getLatLng(), greenMarker.getLatLng()], { color: 'green' }).addTo(map);
        polylines.push(polyline);
    });

 // Example: Create a polyline using Leaflet's Polyline method
 //const polyline = L.polyline(/* Your polyline coordinates */, { color: 'blue' });

// Add the polyline to the map (or layer group)
//polyline.addTo(map);




    return polyline; // Make sure 'polyline' is defined in your existing function
}

// Function to clear existing polylines
function clearPolylines() {
    polylines.forEach((polyline) => {
        map.removeLayer(polyline);
    });
    polylines = [];
}



    navigator.geolocation.getCurrentPosition(success, error);
    const greenMarkers = [];
  const redMarkers = [];

    function success(position) {
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
    <strong>Takeaway Date:</strong> ${user.takeaway_date }<br>
    <strong>Submission Date:</strong> ${user.submission_date}<br>
    <strong>Offer Quantity:</strong> ${user.offers_quantity }<br>
    <strong>Offer Items:</strong> ${user.offers_items }<br>
    <strong>Vehicle's Name:</strong> ${user.vehicles_name }<br>
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
            url: 'getlocationoffers.php',
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
            url: 'getlocationrequests.php',
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





      //fetch rescuers

      // Define a custom icon for the rescuers
const rescuerIcon = L.icon({
    iconUrl: 'cargo-truck.png',
    iconSize: [32, 32], // Adjust the size as needed
    iconAnchor: [16, 16], // Adjust the anchor point if needed
    popupAnchor: [0, -16] // Adjust the popup anchor if needed
});



// Function to fetch and display rescuer locations
function fetchRescuerLocations() {
    $.ajax({
        url: 'getresclocation.php',
        method: 'GET',
        success: function (data) {
            // Add markers for each rescuer location
            data.forEach(function (rescuer) {
                const marker = L.marker([rescuer.latitude, rescuer.longitude], { icon: rescuerIcon }).addTo(map);

                // Check if the rescuer has active tasks
                if (rescuer.active_tasks > 0) {
                  marker.openPopup();

                                    marker.on('click', function () {
                         // Toggle the removal or addition of drawnPolylines
                          if (drawnPolylines) {
                                map.removeLayer(drawnPolylines);
                               drawnPolylines = null;
                         } else {
                                drawnPolylines = drawPolylines(marker, redMarkers, greenMarkers);
                                if (drawnPolylines) {
                                  map.addLayer(drawnPolylines);
                                    }
                           }
                  });

          }

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



 } 
 

    function error(err) {
      if (err.code == 1) {
        alert("Please allow your location access");
      } else {
        alert("Cannot get current location");
      }
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
</head>
<body>



<h2>Announcement System</h2>

<button onclick="openModal()">Click here to make an announcement</button><br><br>

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
  xhr.open('GET', 'http://localhost/WEB2023-24/item_fetch_all.php', true);
  xhr.send();
}

  // Function to close the modal
  function closeModal() {
    modal.style.display = 'none';
  }


  function submitAnnouncement() {
    // Get all checkboxes in the table
    var checkboxes = document.querySelectorAll('#itemsTableContainer input[type="checkbox"]:checked');
    
    // Extract selected item values
    var selectedItems = Array.from(checkboxes).map(function(checkbox) {
        return checkbox.name;
    });

    // Check if there are selected items
    if (selectedItems.length === 0) {
        console.error('No items selected.');
        return;
    }

    // Log selected items to the console for verification
    console.log('Selected Items:', selectedItems);

    // Send selected items to the server
    var xhr = new XMLHttpRequest();
    xhr.onreadystatechange = function() {
        if (xhr.readyState == 4) {
            console.log('Response:', xhr.responseText); // Log the entire response
            if (xhr.status == 200) {
                var response = JSON.parse(xhr.responseText);
                if (response.status === 'success') {
                    console.log(response.message);

                    // Close the modal after submission
                    closeModal();

                } else {
                    console.error(response.message);
                }
            } else {
                console.error('Error submitting announcement. Status:', xhr.status);
            }
        }
    };

    xhr.open('POST', 'http://localhost/WEB2023-24/submit_announcement.php', true);
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

    // Convert selectedItems to a JSON string and send it in the request body
    var requestBody = 'selectedItems=' + encodeURIComponent(JSON.stringify(selectedItems));
    console.log('Request Body:', requestBody); // Log the request body
    xhr.send(requestBody);
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