mapboxgl.accessToken = "pk.eyJ1IjoibGF1cmVudDE3IiwiYSI6ImNsaWx3YzNyOTAybXozZ21vbXZsYXl0MjYifQ.7AoDa2IW0t9B_JUYDIKLyg";

navigator.geolocation.getCurrentPosition(successLocation, errorLocation, {
  enableHighAccuracy: true
});

let selectedProfile = "driving"; // Default profile mode

function successLocation(position) {
  setupMap([position.coords.longitude, position.coords.latitude]);
}

function errorLocation() {
  setupMap([120.91887015317525, 14.954060686064324]); // Default coordinates
}

function setupMap(center) {
  const map = new mapboxgl.Map({
    container: "map",
    style: "mapbox://styles/mapbox/streets-v11",
    center: center,
    zoom: 13
  });

  // Add a blue marker at the specified coordinates
  new mapboxgl.Marker({ color: "#0000FF" }) // Blue color
    .setLngLat([120.913790, 14.9685412])
    .addTo(map);

  map.on("load", function() {
    const marker1 = new mapboxgl.Marker({ color: "#FF0000" }) // Red color
      .setLngLat([120.918945, 14.9525580])
      .addTo(map);
  });

  map.on("load", function() {
    const marker1 = new mapboxgl.Marker({ color: "#FF0000", size: "small" }) // Red color
      .setLngLat([120.918200, 14.9538196])
      .addTo(map);
  });

  const marker2 = new mapboxgl.Marker({ color: "#FF0000" }) // Red color
    .setLngLat([120.919221, 14.9535776])
    .addTo(map);

  map.addControl(directions, "top-left");
}
