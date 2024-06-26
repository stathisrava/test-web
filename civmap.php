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
  <title>Civilian's Map</title>

  <link rel="stylesheet" href="map.css">
  <link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css" />
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
  <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>


  <style>
        /* Add some basic styling */
        body {
            font-family: Arial, sans-serif;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th,
        td {
            border: 1px solid #ddd;
            padding: 10px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }

        h2 {
            margin-bottom: 20px;
        }
    </style>

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
        <?php
        // Retrieve the username from the URL
        $username = isset($_GET['username']) ? htmlspecialchars($_GET['username']) : '';

        // Display the username
        echo "Welcome, $username!";
        ?>
    </div>


  <!-- Include Leaflet scripts -->
  <script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"></script>

  
  

  <style>
        /* Add your styles here */
        #menu {
            max-width: 400px;
            margin: 0 auto;
        }

        select {
            width: 100%;
            margin-bottom: 10px;
            padding: 5px;
        }

        .item {
            margin-left: 20px;
        }
    </style>
    <title>Menu Example</title>


    <h2><br> Create a new request here</h2>
<div id="menu" style="display: flex; flex-direction: column; align-items: center;">
    <div style="margin-bottom: 10px;">
        <select id="categoryDropdown" onchange="showItems()">
            <option value="">Select Category</option>
            <!-- Fetch categories dynamically using JavaScript -->
        </select>
    </div>

    <div style="margin-bottom: 10px;">
        <select id="itemDropdown">
            <!-- Items will be displayed here -->
        </select>
    </div>

    <div style="margin-bottom: 10px;">
        <input type="number" id="quantityInput" placeholder="Quantity" min="1">
    </div>

    <div style="margin-bottom: 10px;">
        <button onclick="addToCart()" style="background-color: #4CAF50; border: none; color: white; padding: 15px 32px; text-align: center; text-decoration: none; display: inline-block; font-size: 16px; margin: 4px 2px; cursor: pointer;">Create</button>
    </div>
</div>

<script>
    // Add your JavaScript here
    // Fetch categories
    var categoryDropdown = document.getElementById("categoryDropdown");
    fetch("category_fetch.php")
        .then(response => response.json())
        .then(categories => {
            categories.forEach(category => {
                var option = document.createElement("option");
                option.value = category.category_name;
                option.text = category.category_name;
                categoryDropdown.add(option);
            });
        })
        .catch(error => console.error('Error fetching categories:', error));

    function showItems() {
        var categoryDropdown = document.getElementById("categoryDropdown");
        var itemDropdown = document.getElementById("itemDropdown");

        // Clear previous items
        itemDropdown.innerHTML = "<option value=''>Select Item</option>";

        // Fetch items for the selected category using JavaScript
        var selectedCategory = categoryDropdown.value;
        if (selectedCategory !== "") {
            fetch("item_fetch.php?category_name=" + encodeURIComponent(selectedCategory))
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Network response was not ok');
                    }
                    return response.json();
                })
                .then(items => {
                    if (!Array.isArray(items)) {
                        throw new Error('Response does not contain an array of items');
                    }

                    items.forEach(item => {
                        var option = document.createElement("option");
                        option.value = item.name;
                        option.text = item.name;
                        itemDropdown.add(option);
                    });
                })
                .catch(error => console.error('Error fetching items:', error.message));
        }
    }
</script>

<style>
    .center-container {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        height: 100vh; /* Adjust as needed */
    }

    input, button {
        margin-bottom: 10px;
    }
</style>

<div class="center-container">
    <h2>OR here</h2>

    <input type="text" id="searchBar" placeholder="Search for items">

    <script>
        $(function () {
            // Fetch all items and create an array for autocomplete
            $.ajax({
                url: "item_fetch_all.php",
                dataType: "json",
                success: function (data) {
                    console.log("Raw Response:", data);

                    // Map item names to create an array for autocomplete
                    var itemNames = data.map(item => item.name);

                    // Enable autocomplete on the search bar
                    $("#searchBar").autocomplete({
                        source: function (request, response) {
                            // Filter item names based on the user's input
                            var filteredItems = $.grep(itemNames, function (item) {
                                return item.toLowerCase().startsWith(request.term.toLowerCase());
                            });

                            // Provide the filtered items to the autocomplete
                            response(filteredItems);
                        },
                        minLength: 1
                    });
                },
                error: function (error) {
                    console.error('Error fetching items:', error);
                }
            });
        })
    </script>

    <div style="margin-bottom: 10px;">
        <input type="text" id="autocompleteInput" placeholder="Enter Quantity">
    </div>

    <div style="margin-bottom: 10px;">
        <button onclick="addToCartAutocomplete()" style="background-color: #4CAF50; border: none; color: white; padding: 15px 32px; text-align: center; text-decoration: none; display: inline-block; font-size: 16px; margin: 4px 2px; cursor: pointer;">Create</button>
    </div>
</div>



<script>
    function addToCart() {
        var selectedCategory = document.getElementById("categoryDropdown").value;
        var selectedItemDropdown = document.getElementById("itemDropdown");
        var selectedItem = selectedItemDropdown.value // || selectedItemDropdown.text;  // Use .text for autocomplete
        var quantity = document.getElementById("quantityInput").value;

        // Validate that either a category or item is selected and specify the quantity
        if ((selectedCategory === "" && selectedItem === "" && quantity !== "") ||
            (selectedCategory !== "" && selectedItem !== "" && quantity === "")
        ) {
            alert("Please select a category or item, and specify the quantity.");
            return;
        }

        console.log("Data to be sent:", {
          category: selectedCategory,
          item: selectedItem,
          quantity: quantity
          

        });

        // Use jQuery to submit the form data via AJAX
        $.ajax({
            type: 'POST',
            url: 'http://localhost/WEB2023-24/insert_request2.php',
            data: {
                category: selectedCategory,
                item: selectedItem,
                quantity: quantity
                
            },
            success: function (response) {
                // Handle the success response if needed
                alert("Request created successfully!");
                //reload the page after succesfull request
                location.reload();
            },
            error: function (error) {
                console.error('Error creating request:', error);
            }
        });
    }

    function addToCartAutocomplete() {
      var selectedItem = $("#searchBar").val();
            var quantity = $("#autocompleteInput").val();

            // Validate inputs
            if (selectedItem && quantity && !isNaN(quantity) && quantity > 0) {
                // Perform the action, e.g., send data to PHP file
                $.ajax({
                    type: 'POST',
                    url: 'http://localhost/WEB2023-24/insert_request3.php',
                    data: { item: selectedItem, quantity: quantity },
                    success: function (response) {
                        // Handle the success response if needed
                      alert("Request created successfully!");
                      //reload the page after succesfull request
                      location.reload();
                          },
                    error: function (error) {
                        console.error('Error  creating request:', error);
                    }
                });
            } else {
                alert("Please enter valid item and quantity.");
            }
        };
</script>




<h2>Requests List</h2>
<table border="1">
  <thead>
    <tr>
      <th>Request ID</th>
      <th>Takeaway Date</th>
      <th>Submission Date</th>
      <th>Status</th>
      <th>Item name</th>
    </tr>
  </thead>
  <tbody id="requestsTableBody"></tbody>
</table>

<script>
  $(document).ready(function() {
    // Fetch data from the server using AJAX
    $.ajax({
      url: 'requests_fetch.php',
      method: 'GET',
      dataType: 'json', // Assuming your server returns JSON data
      success: function(data) {
        // Update the table with the fetched data
        updateTable(data, '#requestsTableBody');
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
    $.each(data, function(index, request) {
        var row = $('<tr>');
        row.append($('<td>').text(request.requests_id));
        row.append($('<td>').text(request.takeaway_date));
        row.append($('<td>').text(request.submission_date));
        row.append($('<td>').text(request.tasks_status));
        
        // Assuming 'request.items_id' is the item ID, you may need to fetch the item name separately
        var itemName = fetchItemName(request.items_id);

        row.append($('<td>').text(itemName));
        tableBody.append(row);
    });
  }

    // Function to fetch the item name based on the item ID
    function fetchItemName(itemId) {
        var itemName;
        $.ajax({
             url: 'fetch_item_name.php',
             method: 'GET',
             data: { itemId: itemId },
             async: false, // Make the call synchronous to wait for the response
             success: function(response) {
                 itemName = response.name;
             },
             error: function(error) {
                 console.error('Error fetching item name:', error);
             }
         });
         return itemName;

    }
    
  });
</script>






<script> /*
    fetch("requests_fetch.php")
        .then(response => response.json())
        .then(announcements => {
            // Update the HTML with the fetched announcements
            const requestList = document.getElementById("requestList");
           // announcement_id, item_id, quantity, created_at, updated_at,  announ_status
            announcements.forEach(announcement => {
                const listItem = document.createElement("li");
                listItem.textContent = `Announcement ID: ${announcements.announcement_id}, Status: ${announcements.announ_status}`;
                //Item ID: ${announcement_items.item_id},
                //Quantity: ${announcement_items.quantity},
                //Created at: ${announcements.created_at},
                //Updated at: ${announcements.updated_at},                
                announcementsList.appendChild(listItem);
            });
        })
        .catch(error => console.error('Error fetching announcements:', error));
        */
</script>




<h2><br> Announcements </h2>
<h3> (Click on the row you want to make an offer) </h3>
<table id="announcementsTable">
    <thead>
        <tr>
            <th>General ID</th>
            <th>Announcement ID</th>
            <th>Item ID</th>
            <th>Item Name</th>
            <th>Quantity</th>
            <th>Civilian ID</th>
            <th>Status</th>
            <th>Created at</th>
            <th>Updated at</th>
        </tr>
    </thead>
    <tbody id="announcementsList"></tbody>
</table>


<table id="announcementsTable">


<script>
    // Fetch announcements using the fetch API
    fetch("announc_fetch.php")
        .then(response => response.json())
        .then(announcements => {
            const announcementsList = document.getElementById("announcementsList");

            // Update the HTML with the fetched announcements
            announcements.forEach(announcement => {
                const row = document.createElement("tr");
                row.innerHTML = `
                    <td>${announcement.general_id}</td>
                    <td>${announcement.announcement_id}</td>
                    <td>${announcement.item_id}</td>
                    <td>${announcement.name}</td>
                    <td>${announcement.quantity}</td>
                    <td>${announcement.civilian_id}</td>
                    <td>${announcement.announ_status}</td>
                    <td>${announcement.created_at}</td>
                    <td>${announcement.updated_at}</td>
                `;
                announcementsList.appendChild(row);

                // Add click event listener to the row
                row.addEventListener('click', () => showOfferPopup(announcement));
            });
        })
        .catch(error => console.error('Error fetching announcements:', error));

    function showOfferPopup(announcement) {
        // Create a pop-up with a message and an input field for quantity
        const quantity = prompt(`Make your offer for the item ${announcement.name} with general id ${announcement.general_id}.\n Enter quantity:`);

        // Check if the user clicked "OK" and entered a quantity
        if (quantity !== null && quantity.trim() !== "") {
            // Make an API call to insert_offer.php
            fetch('insert_offer.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: `item_id=${announcement.item_id}&quantity=${quantity}&general_id=${announcement.general_id}`,
            })
                .then(response => response.json())
                .then(data => {
                    // Handle the response from insert_offer.php
                    if (data.success) {
                        alert(`Offer for ${quantity}x ${announcement.name} submitted successfully.`);
                    } else {
                        alert('Failed to submit offer. Please try again.');
                    }
                })
                .catch(error => console.error('Error submitting offer:', error));
        }else alert('Failed to submit offer. Please enter quantity!');
    }


</script>

<style>
  .center-container {
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    height: 35vh; /* Adjust as needed */
  }

  label, input {
    margin-bottom: 10px;
  }
</style>

<!--div class="center-container">
  <label for="general_id">Enter the General ID of the Announcement:</label>

  <form action="insert_offer.php" method="post">
    <input type="number" id="general_id" name="general_id" required>

    <label for="quantity">Enter the quantity of the item you want in the chosen announcement:</label>
    <input type="number" id="quantity" name="quantity" required>

    <label for="item_id">Enter the id of the item you want in the chosen announcement:</label>
    <input type="number" id="item_id" name="item_id" required>

    <button onclick="submitOffer()">Submit Offer</button>
  </form>
</div-->


<script>

function submitOffer() {
 // Get the entered general ID
 var general_id = document.getElementById('general_id').value;
 var quantity = document.getElementById('quantity').value;
 var item_id = document.getElementById('item_id').value;

// Show a pop-up alert with the values (optional)
alert(`General ID: ${general_id}\nQuantity: ${quantity}\nItem ID: ${item_id}`);

 // Log the generalId to the console
 console.log('General ID:', general_id);
 console.log('Quantity:', quantity);
 console.log('Item ID:', item_id);


// Show a pop-up alert with the message "OK" // O KANEI KOMPLE
//alert('OK');
//--------------------------------------------------------------------------------------------------------
/*
console.log("Data to be sent:", {
       general_id: general_id,
       quantity: quantity,
       item_id: item_id
     });

     // Use jQuery to submit the form data via AJAX
     $.ajax({
         type: 'POST',
         url: 'http://localhost/web2023-24/insert_offer.php',
         data: {
             general_id: general_id,
             quantity: quantity,
             item_id: item_id
         },
         success: function (response) {
             // Handle the success response if needed
             alert("Offer created successfully!");
             //reload the page after succesfull request
             location.reload();
         },
         error: function (error) {
             console.error('Error creating request:', error);
         }
     });
//--------------------------------------------------------------------------------------------------------
// Make an API call to insert_offer.php
fetch('insert_offer.php', {
 method: 'POST',
 headers: {
   'Content-Type': 'application/x-www-form-urlencoded', 
 },

 body: `general_id=${general_id}&quantity=${quantity}&item_id=${item_id}`,
// body: JSON.stringify({ general_id: general_id, quantity: quantity, item_id: item_id}),
})
 .then(response => response.json())
 .then(data => {
     // Handle the response from insert_offer.php

     if (data.success) {
         alert(`Offer for ${quantity}x ${announcement.name} submitted successfully.`);
     } else {
         alert('Failed to submit offer. Please try again.');
     }
 })
 .catch(error => console.error('Error submitting offer:', error));

 }
*/}
</script>













<br><br><br> <h2>Offers List</h2>

<table border="1">
  <thead>
    <tr>
      <th>Offer ID</th>
      <th>Takeaway Date</th>
      <th>Submission Date</th>
      <th>Status</th>
      <th>Action</th>
    </tr>
  </thead>
  <tbody id="offersTableBody"></tbody>
</table> <br> <br>

<table border="1">
  <thead>
    <tr>
      <th>Offer ID</th>
      <th>Takeaway Date</th>
      <th>Submission Date</th>
      <th>Status</th>
      
    </tr>
  </thead>
  <tbody id="offers2TableBody"></tbody>
</table> <br> <br>



<script> 
$(document).ready(function() {
    // Fetch data from the server using AJAX
    $.ajax({
        url: 'offers_fetch.php',
        method: 'GET',
        dataType: 'json', // Assuming your server returns JSON data
        success: function(data) {
            // Update the table with the fetched data
            updateTable(data, '#offersTableBody');
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
        $.each(data, function(index, offer) {
            // Declare row as a block-scoped variable
            let row = $('<tr>');

            row.append($('<td>').text(offer.offers_id));
            row.append($('<td>').text(offer.takeaway_date));
            row.append($('<td>').text(offer.submission_date));
            row.append($('<td>').text(offer.tasks_status));

            // Add "Cancel" button
            var cancelButton = $('<button>').text('Cancel');
            cancelButton.click(function() {
                // Add logic for canceling the task
                // You can make an AJAX request to update the server
                // and then update the UI accordingly
                $.ajax({
                    url: 'cancel_offer.php',
                    method: 'POST',
                    dataType: 'json', // Assuming your server returns JSON data
                    data: { offer_id: offer.offers_id },
                    success: function(response) {
                        // Handle the response from the server
                        console.log('Offer canceled successfully:', response);

                        // Assuming you want to remove the canceled offer from the table
                        row.remove();
                    },
                    error: function(error) {
                        console.error('Error canceling offer:', error);
                    }
                });
            });

            row.append($('<td>').append(cancelButton));


            // Append the row to the tableBody
            tableBody.append(row);
        });
    }
});
    

// another call - another table 
  $(document).ready(function() {
    // Fetch data from the server using AJAX
    $.ajax({
      url: 'offers_fetch_not_pending.php',
      method: 'GET',
      dataType: 'json', // Assuming your server returns JSON data
      success: function(data) {
        // Update the table with the fetched data
        updateTable(data, '#offers2TableBody');
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
      $.each(data, function(index, offer) {
        var row = $('<tr>');
        row.append($('<td>').text(offer.offers_id));
        row.append($('<td>').text(offer.takeaway_date));
        row.append($('<td>').text(offer.submission_date));
        row.append($('<td>').text(offer.tasks_status));
        tableBody.append(row);
      });
    }
  });
  
</script>



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


</body>
</html>