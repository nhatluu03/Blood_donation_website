<?php
session_start();
include('./db/connect.php');
if (!(isset($_SESSION['is_logged']) && $_SESSION['is_logged'] && $_SESSION['user']['role'] == "donor")) {
    header('Location: ./index.php');
}
// print_r($_SESSION['user']);
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
    <link rel="stylesheet" href="./assets/css/form.css">
    <!-- css for header and footer -->
    <link rel="stylesheet" href="./assets/css/headernfooter.css">
    <link rel="stylesheet" href="./assets/css/donor.css">
    <style>
        .ver-nav-item:nth-of-type(2) {
            background-color: #ffddcb;
            color: #c64444;
        }
    </style>
</head>

<body>
    <!-- Header section -->
    <div class="overlay hide"></div>
    <!-- Header section -->
    <?php
    include('./header.php')
    ?>

    <!-- Main section -->
    <main class="main">
        <section class="donation-appointment">
            <div class="section-header">
                <h2 class="section-heading">Donation appoinment</h2>
                <button class="donate-btn">Donate</button>
            </div>
            <div class="donation-appointment-container">
                <!-- Donaton appointments will be rendered here -->
            </div>
        </section>

        <section class="donation-history">
            <div class="section-header">
                <h2 class="section-heading">Donation history</h2>
            </div>
            <table class="donation-hisotry__table">
                <thead>
                    <tr>
                        <th class="phone-hide">Order</th>
                        <th>Blood group</th>
                        <th>Quantity</th>
                        <th>Donation Centre</th>
                        <th>Donated at</th>
                    </tr>
                </thead>
                <tbody class="donation-history-list">
                    <!-- Donation history will be rendered here -->
                </tbody>
            </table>
        </section>
        <!-- Add a div to hold the map -->
        <div id="map" style="display: none"></div>
        <!-- Add a div to hold the input field and autocomplete -->
        <div id="location-form" style="display: none">
            <input id="location-input" type="text" placeholder="Enter your location">
            <p class="psubmit">SUBMIT</p>
        </div>
    </main>

    <!-- Footer section -->
    <div class="overlay hide"></div>
    <form method="POST" class="form book-form hide">
        <h2 class="form-name">Book form</h2>
        <i class="fa-solid fa-xmark close-ic"></i>
        <input type="hidden" name="user_id" value="<?php echo $_SESSION['user']['id'] ?>">
        <div class="form-field">
            <label for="book-donation-centre-id" class="form-field__label">Hospital</label>
            <select name="donation_centre_id" id="book-donation-centre-id" class="form-field__input">
                <option value="selectcard" selected>-- Please select donation centre --</option>
                <?php
                $query = "SELECT id, name, address, latitude, longitude
                        FROM donation_centre, hospital 
                        WHERE donation_centre.hospital_id = hospital.id";
                $res = mysqli_query($conn, $query);
                $coor_arr = array();
                if (mysqli_num_rows($res) > 0) {
                    while ($row = mysqli_fetch_assoc($res)) {
                        if ($row['latitude'] && $row['longitude']) {
                            $coor_arr[] = [
                                [
                                    "lat" => (float)$row['latitude'],
                                    "lng" => (float)$row["longitude"],
                                ],
                                [
                                    "id" => $row['id'],
                                    "name" => $row['name'],
                                    "address" => $row['address']
                                ]
                            ];
                        }
                    }
                }
                $jsonData = json_encode($coor_arr);
                ?>
            </select>
            <span class="form-field__message"></span>
        </div>

        <div class="form-field">
            <label for="book-calendar-id" class="form-field__label">Date</label>
            <select name="book_calendar_id" id="book-calendar-id" class="form-field__input">
                <option value="selectcard">-- Please book donation calendar --</option>
            </select>
            <span class="form-field__message"></span>
        </div>
        <div class="form-field">
            <label for="book-amount" class="form-field__label">Amount</label>
            <select name="book_amount" id="book-amount" class="form-field__input">
                <option value="selectcard">-- Please select amount --</option>
                <option value="250">250ml</option>
                <option value="300">300ml</option>
                <option value="450">450ml</option>
                <option value="500">500ml</option>
            </select>
            <span class="form-field__message"></span>
        </div>
        <div class="form-field">
            <input type="submit" name="book_btn" id="book-btn" class="form-field__input btn-hover color-4" value="Accept">
        </div>
    </form>

    <form action="" class="cancel-appointment-form toggle-form hide">
        <h2 class="form-name">Cancel appointment</h2>
        <i class="fa-solid fa-xmark close-ic" onclick="closeCancelAppointmentForm()"></i>
        <input type="hidden" name="cancel_donation_calendar_id" id="cancel-donation-calendar-id">
        <input type="hidden" name="cancel_appointment_donor_id" id="cancel-appointment-donor-id" value="<?php echo $_SESSION['user']['id'] ?>">
        <p class="sys-msg center">Are you sure to cancel the appointment?</p>
        <br>
        <div class="form-field">
            <input type="submit" name="cancel_appointment_btn" id="cancel-appointment-btn" class="donate-btn" value="Accept">
        </div>
    </form>

    <script>
        var data = Array.from(<?= $jsonData ?>);
        console.log(data); // or whatever you need to do with the object
    </script>
    <script src="./assets/js/toggleVerNavDb.js"></script>
    <script src="./assets/js/preventDefaultSubmission.js"></script>
    <script src="./assets/js/popupMsg.js"></script>
    <script src="./assets/js/validator.js"></script>
    <script src="./assets/js/toggleDisplayForm.js"></script>
    <!-- <script type="text/javascript" src="https://unpkg.com/default-passive-events@2.0.0/dist/index.umd.js"></script> -->
    <!-- <script src="./assets/js/map.js"></script> -->
    <script>
        // Copy paste map.js vào đây thì k chạy
        function initMap() {
            var providedLocation = {
                lat: <?php echo (float)$_SESSION['user']['latitude'] ?>,
                lng: <?php echo (float)$_SESSION['user']['longitude'] ?>
            };
            const locations = data;
            console.log(data);
            console.log(providedLocation);


            const map = new google.maps.Map(document.getElementById("map"), {
                center: providedLocation,
                zoom: 16,
            });
            const marker = new google.maps.Marker({
                map: map,
                position: providedLocation,
            });

            document.getElementById("location-input").onclick = function() {
                let map1 = document.getElementById("map");
                map1.style.display = "block";
            };

            // Initialize the autocomplete input field
            const input = document.getElementById("location-input");
            const autocomplete = new google.maps.places.Autocomplete(input);
            autocomplete.addListener("place_changed", function() {
                var place = autocomplete.getPlace();
                var lat = place.geometry.location.lat();
                var lng = place.geometry.location.lng();
                if (document.body.contains(document.querySelector(".edit-hospital-form"))) {
                    document.querySelector("#edit-hospital-latitude").value = lat;
                    document.querySelector("#edit-hospital-longitude").value = lng;
                } else if (
                    document.body.contains(document.querySelector(".edit-donor-form"))
                ) {
                    document.querySelector("#edit-donor-latitude").value = lat;
                    document.querySelector("#edit-donor-longitude").value = lng;
                }
                console.log("Latitude: " + lat + ", Longitude: " + lng);
            });

            // Add a listener to update the map and marker when a place is selected
            autocomplete.addListener("place_changed", () => {
                const place = autocomplete.getPlace();
                if (place.geometry) {
                    map.panTo(place.geometry.location);
                    marker.setPosition(place.geometry.location);
                }
            });

            if (document.body.contains(document.querySelector("#book-donation-centre-id"))) {
                document.querySelector("#book-donation-centre-id").onclick = function() {
                    var disArr = [];
                    var count = 0;
                    locations.forEach((location) => {
                        const distance = google.maps.geometry.spherical.computeDistanceBetween(
                            new google.maps.LatLng(location[0]),
                            new google.maps.LatLng(providedLocation)
                        );
                        disArr.push([location[1].name, distance, location[1].id]);
                    });
                    disArr.sort(function(a, b) {
                        return a[1] - b[1];
                    });

                    // <option value="selectcard">-- Please select donation centre --</option>
                    // <option disabled selected value="">Select User Name</option>
                    hospitalOptions = '<option value="selectcard">-- Please select donation centre --</option>';
                    // hospitalOptions = '<option value="selectcard">-- Please select donation centre --</option>';
                    while (disArr[count]) {
                        if (count >= 3) {
                            break;
                        }
                        hospitalOptions += `<option value="${disArr[count][2]}"> ${disArr[count][0]} </option>`;
                        count++;
                    }

                    document.querySelector("#book-donation-centre-id").innerHTML = hospitalOptions;
                };
            }
        }
    </script>
    <script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyD5gsTNEfqLgbnuVhYVzoybUoBpVMUN63I&libraries=places,geometry&callback=initMap">
    </script>
    <script>
        var cancelAppointmentForm = document.querySelector('.cancel-appointment-form');

        function openCancelAppointmentForm(calendarId) {
            cancelAppointmentForm.classList.remove('hide');
            document.querySelector('.overlay').classList.remove('hide');
            cancelAppointmentForm.querySelector('#cancel-donation-calendar-id').value = calendarId;
        }

        function closeCancelAppointmentForm() {
            cancelAppointmentForm.classList.add('hide');
            document.querySelector('.overlay').classList.add('hide');
        }

        document.querySelector('#cancel-appointment-btn').onclick = function() {
            let fd = new FormData(cancelAppointmentForm);
            $.ajax({
                url: "./cancel_appointment.php",
                type: "POST",
                data: fd,
                processData: false,
                contentType: false,
                success: function(response) {
                    // alert(response)
                    closeCancelAppointmentForm();
                    createPopupMsg("success", "Successfully cancelled the appointment")
                    renderProcessingAppointment();
                },
                fail: function() {
                    alert("Something went wrong. Please try again!")
                },
                error: function() {
                    alert("Something went wrong. Please try again!")
                }
            })
        }
    </script>


    <script>
        let donateForm = document.querySelector('.book-form');
        let openDonateBtn = document.querySelector('.donate-btn');
        let closeDonateBtn = document.querySelector('.book-form .close-ic');

        openDonateBtn.onclick = function() {
            // Check if donation_centre has specified an address
            <?php
            if (!$_SESSION['user']['latitude'] || !$_SESSION['user']['longitude']) {
                echo "closeForm(document.querySelector('.book-form'));
                    createPopupMsg('fail', 'Please update your address before booking appointment'); 
                    return false;";
            }
            ?>
            openForm(donateForm)
        }

        closeDonateBtn.onclick = function() {
            closeForm(donateForm)
        }
        // toggleDisplayForm(donateForm, openDonateBtn, closeDonateBtn);
    </script>

    <!-- Rendering -->
    <script>
        // Render donation calendar of selected donation centre
        document.querySelector('#book-donation-centre-id').onchange = function() {
            let donationCentreId = document.querySelector('#book-donation-centre-id').value;
            let fd = new FormData();
            fd.append("donation_centre_id", donationCentreId);
            fd.append("donor_id", "<?php echo $_SESSION['user']['id'] ?>");

            // console.log(donationCentreId)
            document.querySelectorAll("#book-donation-centre-id option").forEach(item => {
                if (item.value == donationCentreId) {
                    item.setAttribute("selected", "bselected")
                    // document.querySelector('#book-donation-centre-id').innerHTML = item.innerHTML;
                    console.log(item);
                }
            })
            $.ajax({
                url: "./render_donation_options.php",
                type: "POST",
                data: fd,
                processData: false,
                contentType: false,
                success: function(response) {
                    // alert(response);
                    document.querySelector('#book-calendar-id').innerHTML = response;
                },
                fail: function() {
                    alert("Something went wrong. Please try again!")
                },
                error: function() {
                    alert("Something went wrong. Please try again!")
                }
            })
        }

        // Render donation calendar of selected donation centre
        function renderDonationHistory() {
            let fd = new FormData();
            fd.append("donor_id", "<?php echo $_SESSION['user']['id'] ?>");

            $.ajax({
                url: "./render_donation_history.php",
                type: "POST",
                data: fd,
                processData: false,
                contentType: false,
                success: function(response) {
                    document.querySelector('.donation-history-list').innerHTML = response;
                },
                fail: function() {
                    alert("Something went wrong. Please try again!")
                },
                error: function() {
                    alert("Something went wrong. Please try again!")
                }
            })
        }
        renderDonationHistory();
    </script>
    <!--Start of Fchat.vn-->
    <script type="text/javascript" src="https://cdn.fchat.vn/assets/embed/webchat.js?id=63a687a0fc11844e7c5cd1e2" async="async"></script><!--End of Fchat.vn-->

    <!-- Requesting -->
    <script>
        function validateBookForm() {
            // let bookDonationCentreId = document.querySelector('#book-donation-centre-id');
            let bookCalendarId = document.querySelector('#book-calendar-id');
            let bookAmount = document.querySelector('#book-amount');

            // let isValidBookDonationCentreId = isValidBookCalendarId = isBookAmount = false;
            let isValidBookCalendarId = isBookAmount = false;

            // isValidBookDonationCentreId = checkSelect(bookDonationCentreId);
            isValidBookCalendarId = checkSelect(bookCalendarId);
            isBookAmount = checkSelect(bookAmount);

            // return isValidBookDonationCentreId && isValidBookCalendarId && isBookAmount;
            return isValidBookCalendarId && isBookAmount;
        }

        // Book donation
        document.querySelector('#book-btn').onclick = function() {
            let bookDonationForm = document.querySelector('.book-form');
            let isValidBook = validateBookForm();

            // Validate the field while entering input
            document.querySelectorAll('.calendar-form .form-field__input').forEach(item => {
                item.oninput = function() {
                    isValidBook = validateBookForm();
                }
            });

            if (isValidBook) {
                let fd = new FormData(bookDonationForm);
                $.ajax({
                    url: "./book_donation.php",
                    type: "POST",
                    data: fd,
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        // alert(response);
                        closeForm(donateForm);
                        createPopupMsg("success", "Successfully booked an appoinment")
                        renderProcessingAppointment();
                        // document.querySelector('.donation-appointment-container').innerHTML = response;
                    },
                    fail: function() {
                        alert("Something went wrong. Please try again!")
                    },
                    error: function() {
                        alert("Something went wrong. Please try again!")
                    }
                })
            }
        }

        function renderProcessingAppointment() {
            let fd = new FormData();
            fd.append("donor_id", "<?php echo $_SESSION['user']['id'] ?>")
            $.ajax({
                url: "./render_processing_appoinment.php",
                type: "POST",
                data: fd,
                processData: false,
                contentType: false,
                success: function(response) {
                    document.querySelector('.donation-appointment-container').innerHTML = response;
                },
                fail: function() {
                    alert("Something went wrong. Please try again!")
                },
                error: function() {
                    alert("Something went wrong. Please try again!")
                }
            })
        }
        renderProcessingAppointment();
    </script>
</body>

</html>