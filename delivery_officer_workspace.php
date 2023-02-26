<?php
session_start();
if (!(isset($_SESSION['is_logged']) && $_SESSION['is_logged'] && $_SESSION['user']['role'] == "delivery_officer")) {
    header('Location: ./index.php');
}
include('./db/connect.php');
$hospital_demand_id = "1"  // echo $_SESSION['user]['hospital_id];
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>

    <!-- CDN -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

    <!-- css for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css" integrity="sha512-xh6O/CkQoPOWDdYTDqeRdPCVd1SpvCA9XXcUnZS2FmJNp1coAFzvtCN9BmamE+4aHK8yyUHUSCcJHgXloTyT2A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <!-- css for font -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans&display=swap" rel="stylesheet">

    <!-- CSS -->
    <link rel="stylesheet" href="./assets/css/base.css">
    <link rel="stylesheet" href="./assets/css/profile.css">
    <link rel="stylesheet" href="./assets/css/delivery_off_profile.css">
    <link rel="stylesheet" href="./assets/css/delivery_officer.css">
    <link rel="stylesheet" href="./assets/css/headernfooter.css">
    <style>
        #map {
            display: block;
        }

        .ver-nav-item:nth-of-type(2) {
            background-color: #ffddcb;
            color: #c64444;
        }
    </style>
</head>

<body>
    <!-- Header section -->
    <?php
    include('./header.php');
    ?>
    <!-- Main section -->
    <main class="main">


        <section class="donation-history">
            <div class="section-header">
                <h2 class="section-heading">On delivering</h2>
            </div>
            <div class="delivery-content">
                <?php
                $shipper_id = $_SESSION['user']['id'];
                $stmt = $conn->prepare("SELECT request.id, h1.latitude, h1.longitude, h2.name, h2.address, h2.latitude, h2.longitude, request.temperature_before, blood_group.name, request.amount
                                    FROM request, hospital h1, hospital h2, delivery_officer, blood_group
                                    WHERE request.hospital_supply_id = h1.id
                                    AND request.hospital_demand_id = h2.id
                                    AND request.delivery_officer_id = delivery_officer.user_id
                                    AND delivery_officer.user_id = ?
                                    AND request.status = 'delivering'
                                    AND request.blood_group_id = blood_group.id");
                $stmt->bind_param("s", $shipper_id);
                $stmt->execute();
                $stmt->store_result();
                $stmt->bind_result(
                    $request_id,
                    $hospital_supply_latitude,
                    $hospital_supply_longitude,
                    $hospital_demand_name,
                    $hospital_demand_address,
                    $hospital_demand_latitude,
                    $hospital_demand_longitude,
                    $request_temperature_before,
                    $request_blood_group,
                    $request_amount
                );

                if ($stmt->num_rows() > 0) {
                    $stmt->fetch();
                    $request_temperature_before = $request_temperature_before ? $request_temperature_before : "40";
                    echo ' <div class="delivery-content__map">
                            <div style="width: 100%; height: 400px;" id="map"></div>
                        </div>  

                        <span style="display: none" id="src-lat">' . $hospital_supply_latitude . '</span>
                        <span style="display: none" id="src-lng">' . $hospital_supply_longitude . '</span>
                        <span style="display: none" id="des-lat">' . $hospital_demand_latitude . '</span>
                        <span style="display: none" id="des-lng">' . $hospital_demand_longitude . '</span>

                        <script> </script>
                        <div class="delivery-content-container">
                            <h3 class="delivery-content__heading">Delivery info</h3>
                            <p class="delivery-content__item">
                                <span>Hospital in need: </span>
                                <span>' . $hospital_demand_name . '</span>
                            </p>
                            <p class="delivery-content__item">
                                <span>Destination: </span>
                                <span>' . $hospital_demand_address . '</span>
                            </p>
                            <p class="delivery-content__item">
                                <span>Blood group: </span>
                                <span>' . strtoupper($request_blood_group) . '</span>
                            </p>
                            <p class="delivery-content__item">
                                <span>Amount: </span>
                                <span>' . $request_amount . ' ml</span>
                            </p>
                            <p class="delivery-content__item">
                                <span>Temperature before: </span>
                                <span>' . $request_temperature_before . '"C</span>
                            </p>
                            <strong> Blood temperature must be in range 0 - 10℃ </strong>
                        </div>';
                } else {
                    echo '<p class="sys-msg"> Temporarily not in charge of any shipping requests </p>';
                }
                ?>
            </div>
        </section>


        <section class="donation-history">
            <div class="section-header">
                <h2 class="section-heading">Delivery history</h2>
                <!-- <button class="donate-btn btn-hover color-4">Donate</button> -->
            </div>
            <table class="donation-hisotry__table">
                <thead>
                    <tr>
                        <th class="phone-hide">Order</th>
                        <th>Blood group</th>
                        <th>Amount</th>
                        <th class="mobile-hide">Temperature</th>
                        <th>Hospital in need</th>
                        <th>Destination</th>
                    </tr>
                </thead>
                <tbody>

                    <?php
                    $delivery_officer_id = $_SESSION['user']['id'];
                    $stmt = $conn->prepare("SELECT request.id, hospital.name, hospital.address, blood_group.name, request.amount, request.temperature_after
                                FROM request, hospital, delivery_officer, blood_group
                                WHERE request.hospital_demand_id = hospital.id
                                AND request.delivery_officer_id = delivery_officer.user_id
                                AND delivery_officer.user_id = ?
                                AND request.status = 'delivered'
                                AND request.blood_group_id = blood_group.id;");
                    $stmt->bind_param("s", $delivery_officer_id);
                    $stmt->execute();
                    $stmt->store_result();
                    $stmt->bind_result($request_id, $hospital_demand_name, $hospital_demand_address, $request_blood_group, $request_amount, $temperature_after);
                    if ($stmt->num_rows() > 0) {
                        $count = 1;
                        while ($stmt->fetch()) {
                            $request_blood_group = $request_blood_group ? strtoupper($request_blood_group) : "Undefined";
                            $request_amount = $request_amount ? $request_amount : "Undefined";
                            $temperature_after = $temperature_after ? $temperature_after : "Undefined";
                            $hospital_demand_name = $hospital_demand_name ? $hospital_demand_name : "Undefined";
                            $hospital_demand_address = $hospital_demand_address ? $hospital_demand_address : "Undefined";

                            echo ' <tr>
                                <td class="phone-hide">' . $count++ . '</td>
                                <td>' . $request_blood_group . '</td>
                                <td>' . $request_amount . 'ml</td>
                                <td class="mobile-hide">' . $temperature_after . '</td>
                                <td>' . $hospital_demand_name . '</td>
                                <td>' . $hospital_demand_address . '</td>
                            </tr>';
                        }
                    } else {
                        echo ' <tr> 
                                <td> No delivery found</td>
                            </tr>';
                    }
                    ?>
                </tbody>
            </table>
        </section>
    </main>
    <div class="overlay hide"></div>
    <script type="text/javascript" src="https://unpkg.com/default-passive-events@2.0.0/dist/index.umd.js"></script>
    </script>
    
    <!-- Call the initMap function when the page loads -->
    <script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAWd9Wx6tr76oMUe4pWLQ8-FOJZfdkrNus&libraries=places,geometry&callback=initMap">
    </script>

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

            // Next, create a DirectionsService object and specify the map object as the map 
            // on which the directions will be displayed
            var directionsService = new google.maps.DirectionsService();
            var directionsRenderer = new google.maps.DirectionsRenderer({
                map: map
            });

            let srcLat = document.querySelector('#src-lat').innerText;
            let srcLng = document.querySelector('#src-lng').innerText;
            let desLat = document.querySelector('#des-lat').innerText;
            let desLng = document.querySelector('#des-lng').innerText;

            // Specifying coordinates of source and destination
            var start = new google.maps.LatLng(srcLat, srcLng);
            var end = new google.maps.LatLng(desLat, desLng);

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
    <script src="./assets/js/preventDefaultSubmission.js"></script>
    <script src="./assets/js/popupMsg.js"></script>
    <script src="./assets/js/validator.js"></script>
    <script src="./assets/js/toggleVerNavDb.js"></script>
    <script src="./assets/js/toggleDisplayForm.js"></script>
</body>

</html>