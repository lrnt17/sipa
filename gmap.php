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
    <script src="https://kit.fontawesome.com/324d76b648.js" crossorigin="anonymous"></script>
    <style>
        body {
            overflow-x: hidden;
            margin: 0;
            top:0!important;
        }
        .skiptranslate iframe  {
        visibility: hidden !important;
        }
		
    /*#map { position: absolute; left: 60%; top: 25%; bottom: 20%; width: 26%; height: 40%; } Adjusted width and centered */
    #map {
        min-height: 300px;
        min-width: 330px;
        width:600px;
    }


	
    textarea:focus, input:focus{
        outline: none;
    }
    </style>
</head>
<body style="background: #F2F5FF;">

 <!-- navigation bar with logo -->
 <?php include('header.php') ?>

    <div class="container rounded-5" style="background: #D2E0F8;">
            <div class="row mx-5 justify-content-center" style="text-align:center; padding: 4%;">
            
                <div class="col-auto"><p style="font-size: 3.5rem;">Find a</p></div>
                <div class="col-auto"><p style="font-size: 3.5rem; font-weight:bolder;" >Health Care</p></div>
            </div>
        </div>

    <div class="container">

                <div class="row height d-flex justify-content-center align-items-center">

                <div class="col-md-6">

                    <div class="cap p-3 rounded-4 shadow-sm rounded" style="position: relative; top: -40px; background:#ffff; text-align:center;">
                       Access the care you need.
                    </div>
                    
                </div>
                </div>
        

            <div class="row" style="align-items: center;">
                <div class="col-auto">
                    <div class="vl" style="width: 10px;
                    background-color: #1F6CB5;
                    border-radius: 99px;
                    height: 70px;
                    display: -webkit-inline-box;"></div>
                </div>
            
                <div class="col-auto mt-3">
                    <div class="row">
                        <div class="col-auto">
                            <h2 style="font-weight: 400;"><b>Find</b> a health care</h2>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row ms-1">
                <p class="ms-4">We will assist you in finding a nearby healthcare facility whether you require new birth control prescription, STI testing, or any other reproductive health service.</p>
            </div>


            <div class="container my-4" style="display: flex; justify-content: center;">
    <div id="search-container" class="row rounded-pill shadow-sm" style="background: #B6CCF5;width: 70%;">
        <div class="col-auto ms-3 mt-3 mb-3">
            <i class="fa-solid fa-location-dot" style="font-size: larger; color: #2B436F;"></i>
        </div>
        <div class="col me-auto">
            <input type="text" id="search-input" placeholder="Enter address, city or zip code" style="width: 90%; border: none; background: transparent;" class="p-3" required>
        </div>
        <div class="col-auto">
            <button class="btn rounded-pill p-3 px-5" style="background-color:#5887DE; color:white; margin-right: -13px;" id="search-button">Find</button>
        </div>
    </div>
</div>

<div class="container rounded-5 mt-5 mb-3 p-5" id="container" style="background: #D2E0F8; display: none;">
    <div class="row">
        <div class="col-lg-6">
        <p style="text-align: center; font-weight:500;">Showing results</p>

        <div id="hospital-info-container"> <!-- Wrap the hospital info in a container -->
            <div id="hospital-list">
                <!-- Hospital details will be displayed here -->
            </div>
            
        </div>

        </div>
        <div class="col-lg-6">
            <div class="row">
                <div class="col-12">
                <p style="text-align: center; font-weight:500;">Maps</p>
                </div>
                <div class="col" style="display: flex;justify-content: center;">
                    <div id="map-container" style="display: flex;
                justify-content: center; width:400px;">
                        <div id="map" class="rounded-5 shadow-sm"></div>
                    </div>
                    
                </div>
            </div>


        </div>
    </div>
       
    </div>

    <br><br><br>
    <!-- footer -->
    <?php include('footer.php') ?>


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

    // Add a click event listener to the marker
    marker.getElement().addEventListener('click', function () {
        // Zoom the map to level 17 when the marker is clicked
        map.flyTo({
            center: [hospital.Longitude, hospital.Latitude],
            zoom: 17
        });
    });

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
            hospitalDiv.style.minWidth="360px";

            // Fill the div with hospital information
            hospitalDiv.innerHTML = `
            <div class="p-3 rounded-4 my-4 shadow-sm" style="background-color: white;">
                <h5> <i class="fa-solid fa-location-dot me-2" style="color: #2B436F;"> </i> ${hospital.Hospitalname}</h5>
                <p>${hospital.Address}</p>
                <p><i class="fa-solid fa-phone" style="color: #2B436F;"> </i> +63${hospital.ContactNumber}</p>
            </div>
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


    // Add a click event listener to the "Find" button
    document.getElementById('search-button').addEventListener('click', function () {
        var searchTerm = document.getElementById('search-input').value.toLowerCase(); // Convert input to lowercase

        // Check if the input field is empty
        if (searchTerm.trim() === "") {
            alert("Please enter address, city, or zip code."); // Display an alert or handle the empty input in your preferred way
            return; // Exit the function early if the input is empty
        }

        // Display the map and search results
        var mapContainer = document.getElementById('container');
        mapContainer.style.display = 'block';

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
            noResultsMessage.innerHTML = '<center><h5 class="mt-5">No results found.</h5></center>';

            // Append the "No record found" message to the hospital list container
            hospitalListContainer.appendChild(noResultsMessage);
        }
    });



</script>
</body>
</html>