mapboxgl.accessToken =
  "pk.eyJ1IjoibGF1cmVudDE3IiwiYSI6ImNsaWx3YzNyOTAybXozZ21vbXZsYXl0MjYifQ.7AoDa2IW0t9B_JUYDIKLyg"

navigator.geolocation.getCurrentPosition(successLocation, errorLocation, {
  enableHighAccuracy: true
})

function successLocation(position) {
  setupMap([position.coords.longitude, position.coords.latitude])
}

function errorLocation() {
  setupMap([120.91887015317525,14.954060686064324])
}

function setupMap(center) {
  const map = new mapboxgl.Map({
    container: "map",
    style: "mapbox://styles/mapbox/streets-v11",
    center: center,
    zoom: 13
  })

  const nav = new mapboxgl.NavigationControl()
  map.addControl(nav)

  var directions = new MapboxDirections({
    accessToken: mapboxgl.accessToken
  })

  map.addControl(directions, "top-left")
}