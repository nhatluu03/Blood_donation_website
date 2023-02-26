<!DOCTYPE html>
<html lang="en">

<head>
    <style>
        /* Set the size of the map container */
        #map {
            width: 500px;
            height: 400px;
        }
    </style>
</head>

<body>
    <!-- Add a div to hold the map -->
    <div id="map"></div>
    <!-- Add a div to hold the input field and autocomplete -->
    <div id="location-form">
        <input id="location-input" type="text" placeholder="Enter your location">
        <p class="psubmit">SUBMIT</p>
    </div>

    <script type="text/javascript" src="https://unpkg.com/default-passive-events@2.0.0/dist/index.umd.js"></script>
    </script>

    <!-- <script src="./assets/js/map.js"></script> -->
    <!-- Call the initMap function when the page loads -->
    <script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAWd9Wx6tr76oMUe4pWLQ8-FOJZfdkrNus&libraries=places,geometry&callback=initMap">
    </script>

    <!-- <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyD5gsTNEfqLgbnuVhYVzoybUoBpVMUN63I"></script> -->
    <script>
        function initMap() {
            // First, create a Map object and specify the DOM element that will contain the map
            var map = new google.maps.Map(document.getElementById('map'), {
                zoom: 4,
                center: {
                    lat: 41.85,
                    lng: -87.65
                }
            });

            // Next, create a DirectionsService object and specify the map object as the map on which the directions will be displayed
            var directionsService = new google.maps.DirectionsService();
            var directionsRenderer = new google.maps.DirectionsRenderer({
                map: map
            });

            var start = new google.maps.LatLng(37.7749, -122.4194); // San Francisco, CA
            var end = new google.maps.LatLng(34.0522, -118.2437); // Los Angeles, CA

            // Create a request object and specify the start and end points, as well as the travel mode
            var request = {
                origin: start,
                destination: end,
                travelMode: 'DRIVING'
            };

            // Call the route() method of the DirectionsService object to retrieve the route
            directionsService.route(request, function(response, status) {
                if (status == 'OK') {
                    // If the route was successfully retrieved, display it on the map using the DirectionsRenderer object
                    directionsRenderer.setDirections(response);
                }
            });
        }
    </script>
</body>

</html>