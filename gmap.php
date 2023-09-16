<?php
require("connect.php");
require('functions.php');
    

// Get the search term from the GET request
$searchTerm = isset($_GET['search']) ? $_GET['search'] : '';

// Modify the SQL query to search for matches in Address and Hospitalname
// Modify the SQL query to search for matches in City, Address, and Hospitalname
$query = "SELECT City, Address, Hospitalname, ContactNumber, Latitude, Longitude FROM maps WHERE 
    City LIKE '%$searchTerm%' OR 
    Address LIKE '%$searchTerm%' OR 
    Hospitalname LIKE '%$searchTerm%'";

$result = $conn->query($query);

if (!$result) {
    die("Query failed: " . $conn->error);
}

// Prepare an array to store hospital data
$hospitalsData = array();

// Fetch and store hospital data
while ($row = $result->fetch_assoc()) {
    $hospitalsData[] = $row;
}


// Close the database connection
$conn->close();
?>

<!DOCTYPE html>
<html>
<head>
    <title>SiPa | Hospital Finder</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://api.mapbox.com/mapbox-gl-js/v2.3.1/mapbox-gl.js"></script>
    <link rel="icon" href="favicon.ico" type="image/x-ico">
    <link href="https://api.mapbox.com/mapbox-gl-js/v2.3.1/mapbox-gl.css" rel="stylesheet">
    <script src="https://api.mapbox.com/mapbox-gl-js/plugins/mapbox-gl-geocoder/v4.7.0/mapbox-gl-geocoder.min.js"></script>
    <link rel="stylesheet" href="https://api.mapbox.com/mapbox-gl-js/plugins/mapbox-gl-geocoder/v4.7.0/mapbox-gl-geocoder.css" type="text/css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/leaflet/1.7.1/leaflet.css" />
    <style>
        body {
            overflow-x: hidden;
            margin: 0;
            top:0!important;
        }
        .skiptranslate iframe  {
        visibility: hidden !important;
        }
		
    #map { position: absolute; left: 60%; top: 25%; bottom: 20%; width: 26%; height: 40%; } /* Adjusted width and centered */
	
    #search-container { position: absolute; top: 100px; left: 550px; z-index: 1; display: flex; align-items: center; }
    #search-input { width: 300px; padding: 10px; border-radius: 20px 0 0 20px; border: none; }
    #search-button { background-color: #0074D9; color: white; border: none; padding: 10px 20px; border-radius: 0 20px 20px 0; cursor: pointer; }
    .mapboxgl-ctrl-geocoder { position: absolute; top: 73px; left: 500px; width: 400px; border-radius: 20px; } /* Adjusted positioning */
    .container {
          margin-top: 270px;
		  margin: 20px;
		  height: 700px;
		  background-color: #d2e1f8;
		  border-radius: 10px;
            }
        #hospital-list {
             position: absolute;
		  top: 180px; /* Adjust the top position as needed */
		  left: 100px; /* Adjust the left position as needed */
		  width: 700px;
		  height: 950px;
		  padding: 10px;
		  background-color: #f0f0f0;
		  border: 1px solid #ccc;
		  border-radius: 5px;
		  overflow-y: scroll;
            max-height: 437px; /* Add a max height to enable scrolling if many hospitals are displayed */
        }
       .hospital-item {
		  margin-bottom: 10px;
		  padding: 5px;
		  border: 1px solid #ddd;
		  border-radius: 5px;
		  background-color: #fff;
		}
    </style>
</head>
<body style="background: #F2F5FF;">

 <!-- navigation bar with logo -->
 <?php include('header.php') ?>


    <div id="search-container">
        <input type="text" id="search-input" placeholder="Enter address, city or zip code">
        <button id="search-button">Find</button>
    </div>

    

    <div class="container" id ="container" style="display: none;">
        <p>Showing results</p>
        <p>Maps</p>
            <div id="map-container">
                <div id="map"></div>
            </div>
        <div id="hospital-info-container"> <!-- Wrap the hospital info in a container -->
            <div id="hospital-list">
                <!-- Hospital details will be displayed here -->
            </div>
            
        </div>
    </div>


<script>
    mapboxgl.accessToken = 'pk.eyJ1Ijoicm9seWZsb3JlbnRpbm82IiwiYSI6ImNsbHFpcDFoNzBlOHYza3BpMzN3NnRyb2EifQ.n12r_Sm2lQGDPXAXB9l9uQ';

    //pag nag enter key yung user, masesearch na yung tinype if ever natamad pindutin button
    document.getElementById('search-input').addEventListener('keydown', function (event) {
        if (event.key === 'Enter') {
            event.preventDefault(); // Prevent the default form submission
            document.getElementById('search-button').click(); // Trigger the button click event
        }
    });


    var defaultLocation = [120.884452, 14.96654]; // Baliuag, Bulacan, Philippines

    var map = new mapboxgl.Map({
        container: 'map',
        style: 'mapbox://styles/mapbox/streets-v11',
        center: defaultLocation,
        zoom: 12.5
    });

    // Add zoom controls
    map.addControl(new mapboxgl.NavigationControl());

    // Function to create a marker for a hospital
    // Function to create a marker for a hospital
	function createMarkerForHospital(hospital) {
    // Create a marker for the hospital and customize its appearance with a blue marker icon.
    var marker = new mapboxgl.Marker({
        color: "#0074D9", // Blue color
        scale: 0.6 // Adjust the scale as needed
    })
        .setLngLat([hospital.Longitude, hospital.Latitude]) // Use Latitude and Longitude
        .addTo(map);

    // Create a popup for the hospital with its information.
    var popup = new mapboxgl.Popup()
        .setHTML('<h3>' + hospital.Hospitalname + '</h3><p>' + hospital.Address + '</p><p>' + hospital.ContactNumber + '</p>');

    marker.setPopup(popup);

    return marker;
}


    // Function to display hospitals on the map
    function displayHospitals(hospitals) {
        hospitals.forEach(function (hospital) {
            createMarkerForHospital(hospital);
        });
    }

    // Function to display hospital details in the #hospital-list element
    function displayHospitalDetails(hospitals) {
        var hospitalList = document.getElementById('hospital-list');

        hospitals.forEach(function (hospital) {
            // Create a new div element to display hospital details
            var hospitalDiv = document.createElement('div');
            hospitalDiv.classList.add('hospital-item');

            // Fill the div with hospital information
            hospitalDiv.innerHTML = `
                <h3>${hospital.Hospitalname}</h3>
                <p>${hospital.Address}</p>
                <p>${hospital.ContactNumber}</p>
            `;

            // Append the hospital div to the #hospital-list element
            hospitalList.appendChild(hospitalDiv);
        });
    }

    // Replace this block of code in your JavaScript
    var hospitalsData = <?php echo json_encode($hospitalsData); ?>;

    var hospitalMarkers = [];

	// Function to display hospitals on the map
	function displayHospitals(hospitals) {
    // Remove existing hospital markers from the map
    hospitalMarkers.forEach(function (marker) {
        marker.remove();
    });
    hospitalMarkers = [];

    hospitals.forEach(function (hospital) {
        var marker = createMarkerForHospital(hospital);
        hospitalMarkers.push(marker);
    });
}

    // Function to filter hospitals by location
    function filterHospitalsByLocation(hospitals, location) {
        return hospitals.filter(function (hospital) {
            // Implement your filtering logic here based on the location
            // Here, we assume the "location" argument is a city name or similar
            return hospital.City.toLowerCase() === location.toLowerCase();
        });
    }


    document.getElementById('search-button').addEventListener('click', function () {
    var searchTerm = document.getElementById('search-input').value.toLowerCase(); // Convert input to lowercase

    // Filter hospitals by location (City, Address, or Hospitalname)
    var filteredHospitals = hospitalsData.filter(function (hospital) {
        return (
            hospital.City.toLowerCase().includes(searchTerm) ||
            hospital.Address.toLowerCase().includes(searchTerm) ||
            hospital.Hospitalname.toLowerCase().includes(searchTerm)
        );
    });

    // Clear previous hospital list and hide all hospitals on the map
    document.getElementById('hospital-list').innerHTML = '';
    hospitalMarkers.forEach(function (marker) {
        marker.remove();
    });

    // Create a variable for the hospital list container
    var hospitalListContainer = document.getElementById('hospital-list');

        if (filteredHospitals.length > 0) {
            // Display hospitals in the selected location on the map
            displayHospitals(filteredHospitals);

            // Display hospital details in the #hospital-list element
            displayHospitalDetails(filteredHospitals);

            // Center the map on the first hospital in the filtered list
            map.flyTo({
                center: [filteredHospitals[0].Longitude, filteredHospitals[0].Latitude],
                zoom: 15
            });
        } else {
            // Create a "No record found" message as a hospital-item
            var noResultsMessage = document.createElement('div');
            noResultsMessage.classList.add('hospital-item');
            noResultsMessage.innerHTML = '<h3>No results found.</h3>';

            // Append the "No record found" message to the hospital list container
            hospitalListContainer.appendChild(noResultsMessage);
        }
    });

	
	document.getElementById('search-button').addEventListener('click', function () {
    var Container = document.getElementById('container');
   Container.style.display = 'block'; // Always show the map
  });



</script>
</body>
</html>
