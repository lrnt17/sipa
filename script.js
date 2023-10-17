mapboxgl.accessToken = "pk.eyJ1IjoibGF1cmVudDE3IiwiYSI6ImNsaWx3YzNyOTAybXozZ21vbXZsYXl0MjYifQ.7AoDa2IW0t9B_JUYDIKLyg";

let selectedProfile = "driving"; // Default profile mode

function setupMap(center) {
  const map = new mapboxgl.Map({
    container: "map",
    style: "mapbox://styles/mapbox/streets-v11",
    center: center,
    zoom: 14
  });

  map.on("load", function() {
    const marker1 = new mapboxgl.Marker({ color: "#FF0000" }) // Red color
      .setLngLat([120.918945, 14.9525580])
      .addTo(map);

    // Create a Popup with your custom content
    const popup = new mapboxgl.Popup({ closeButton: true, closeOnClick: false })
      .setHTML("<center><h5>Bustos RHU</h5></center><p>SiPa Partnered Healthcare Facility.\nXW39+5RV, Domingo st., Bustos, Bulacan</p>")
      .addTo(map);

    // Associate the popup with the marker
    marker1.setPopup(popup);

    // Close the popup when the close button is clicked
    popup.on("close", function() {
      // Handle close event if needed
    });
  });

  map.addControl(directions, "top-left");
}

// Call the setupMap function with default coordinates
setupMap([120.918945, 14.9525580]);