<?php
session_start();
// Check if the user is logged in
if (isset($_SESSION['username'])) {
    // User is logged in
    echo "User is logged in. User ID: " . $_SESSION['username'];
} else {
    // User is not logged in
    echo "User is not logged in. Redirect to login page or take appropriate action.";
    // Redirect to the login page
  // header("Location: http://localhost/web2023-24/login.html");
   // exit();
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
  </nav>

  
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


  <div id="map"></div>

  <!-- Include Leaflet scripts -->
  <script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"></script>




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


<!-- Button to redirect to index.html for signup -->
<a href="index.html" style="display: block; margin-top: 20px; padding: 10px;
 background-color: #2ecc71; color: #fff; text-align: center; text-decoration: none; font-size: 16px; 
 border-radius: 5px; cursor: pointer;" onmouseover="this.style.backgroundColor='#2980b9'" 
 onmouseout="this.style.backgroundColor='#3498db'"> Create a Rescuer Account Here </a>




  
  <!-- Initialize map and other scripts -->
  <script>
    let lat1, lng1;

    var map = L.map('map');
    map.setView([38.2462420, 21.7350847], 11);

    L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
      maxZoom: 19,
      attribution: 'Map data Â© <a href="https://openstreetmap.org">OpenStreetMap</a> contributors'
    }).addTo(map);

    navigator.geolocation.getCurrentPosition(success, error);

    function success(position) {
      lat1 = position.coords.latitude;
      lng1 = position.coords.longitude;

      // Center the map on your location
      map.setView([lat1, lng1], 1);

      // Add a marker for your location
      const userLocationMarker = L.marker([lat1, lng1]).addTo(map);
      userLocationMarker.bindPopup("Your are here").openPopup();

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

     flagMarker.bindPopup("Flag Marker").openPopup();
    }


 }

    function error(err) {
      if (err.code == 1) {
        alert("Please allow your location access");
      } else {
        alert("Cannot get current location");
      }
    }
  </script>

</body>
</html>
