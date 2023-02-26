<?php
session_start();
include('./db/connect.php');
include('./php/format.php');
// print_r($_SESSION['user']);
$hospital_id = $_SESSION['user']['hospital_id'];
$is_donation_centre = false;

$stmt = $conn->prepare("SELECT hospital.name, hospital.address, hospital.hotline, hospital.email, hospital.latitude, hospital.longitude
                                    FROM hospital, donation_centre
                                    WHERE donation_centre.hospital_id = hospital.id
                                    AND hospital.id = ?");
$stmt->bind_param("s", $hospital_id);
$stmt->execute();
$stmt->store_result();
$stmt->bind_result($hospital_name, $hospital_address, $hospital_hotline, $hospital_email, $hospital_latitude, $hospital_longitude);
$stmt->fetch();
$hospital_name = $hospital_name ? $hospital_name : "Unset";
$hospital_address = $hospital_address ? $hospital_address : "Unset";
$hospital_hotline = $hospital_hotline ? $hospital_hotline : "Unset";
$hospital_email = $hospital_email ? $hospital_email : "Unset";


if ($stmt->num_rows() > 0) {
    $is_donation_centre = true;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Database Officer</title>
    <!-- CDN -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

    <!-- css for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css" integrity="sha512-xh6O/CkQoPOWDdYTDqeRdPCVd1SpvCA9XXcUnZS2FmJNp1coAFzvtCN9BmamE+4aHK8yyUHUSCcJHgXloTyT2A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <!-- css for font -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans&display=swap" rel="stylesheet">

    <!-- css for main -->
    <link rel="stylesheet" href="./assets/css/base.css">
    <link rel="stylesheet" href="./assets/css/form.css">
    <link rel="stylesheet" href="./assets/css/hospital.css">
    <!-- css for header and footer -->
    <link rel="stylesheet" href="./assets/css/headernfooter.css">
    <style>
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

    <div class="overlay hide"></div>
    <main class="main">
        <div class="general_info">
            <div class="general_info__hospital">
                <label for="edit_check" class="general_info__edit_button"><i class="fa-regular fa-pen-to-square edit-hospital-ic"></i></label>
                <section class="general_info__hospital_name">
                    <?php echo $hospital_name ?>
                </section>
                <section class="general_info__hospital_details">
                    <p class="hospital_details"> <i class="fa-solid fa-phone"></i> <?php echo $hospital_hotline ? $hospital_hotline : "Unset" ?> </p>
                    <p class="hospital_details"><i class="fa-solid fa-envelope"></i> <?php echo $hospital_email ? $hospital_email : "Unset" ?></p>
                    <p class="hospital_details"><i class="fa-solid fa-location-dot"></i> <?php echo $hospital_address ?></p>
                </section>
            </div>

            <div class="general_info__blood">
                <?php
                include('./db/connect.php');
                $stmt = $conn->prepare("SELECT blood_group.name, COUNT(tbl2.blood_group_id) as no_blood, SUM(store.amount)
                                    FROM (blood_group LEFT JOIN (SELECT donor.blood_group_id, donate.amount
                                                                FROM donor, donation_calendar, donation_centre, donate
                                                                WHERE donate.donor_id = donor.user_id
                                                                AND donate.is_verified = '1'
                                                                AND donation_centre.hospital_id = ?
                                                                AND donate.donation_calendar_id = donation_calendar.id
                                                                AND donation_calendar.donation_centre_id = donation_centre.hospital_id) as tbl2
                                    ON blood_group.id = tbl2.blood_group_id) LEFT JOIN store
                                    ON blood_group.id = store.blood_group_id AND store.hospital_id = ?
                                    GROUP BY blood_group.id");
                $stmt->bind_param("ss", $hospital_id, $hospital_id);
                $stmt->execute();
                $stmt->store_result();
                $stmt->bind_result($blood_group_name, $no_records, $total_amount);
                if ($stmt->num_rows() > 0) {
                    while ($stmt->fetch()) {
                        $total_amount = (float)$total_amount > 0 ? $total_amount : "0";
                        echo ' <div class="blood_group" id="blood_a">
                                    <h4 class="blood_name">
                                        GROUP ' . strtoupper($blood_group_name) . '
                                    </h4>
                                    <p class="blood_quantity">
                                        ' . $no_records . ' units - ' . $total_amount . ' ml
                                    </p>
                                </div>';
                    }
                }
                ?>
            </div>

            <?php
            if (isset($_GET['view_calendar_id'])) {
                include('./donation_list.php');
                exit;
            } else if (isset($_GET['edit_calendar_id'])) {
            }
            ?>

            <form action="" method="POST" class="edit-hospital-form toggle-form hide">
                <i class="fa-solid fa-xmark close-ic"></i>
                <h2 class="form-name">Edit hospital information</h2>
                <input type="hidden" name="edit_hospital_id" id="edit-hospital-id" value="<?php echo $_SESSION['user']['hospital_id'] ?>">
                <input type="hidden" name="edit_hospital_latitude" id="edit-hospital-latitude" value="">
                <input type="hidden" name="edit_hospital_longitude" id="edit-hospital-longitude" value="">
                <div class="form-field">
                    <label for="edit-hospital-name" class="form-field__label">Name</label>
                    <input type="text" name="edit_hospital_name" id="edit-hospital-name" class="form-field__input" placeholder="Enter hospital name" value="<?php echo $hospital_name ? $hospital_name : "" ?>">
                    <span class="form-field__message"></span>
                </div>
                <div class="form-field">
                    <label for="edit-hospital-hotline" class="form-field__label">Hotline</label>
                    <input type="text" name="edit_hospital_hotline" id="edit-hospital-hotline" class="form-field__input" placeholder="Enter hospital hotline" value="<?php echo $hospital_hotline ? $hospital_hotline : "" ?>">
                    <span class="form-field__message"></span>
                </div>
                <div class="form-field">
                    <label for="edit-hospital-email" class="form-field__label">Email</label>
                    <input type="text" name="edit_hospital_email" id="edit-hospital-email" class="form-field__input" placeholder="Enter hospital email" value="<?php echo $hospital_email ? $hospital_email : "" ?>">
                    <span class="form-field__message"></span>
                </div>
                <div class="form-field">
                    <label for="edit-hospital-address" class="form-field__label">Address</label>
                    <input type="text" name="edit_hospital_address" id="location-input" class="form-field__input" placeholder="Enter hospital address" value="<?php echo $hospital_address ? $hospital_address : "" ?>">
                    <span class="form-field__message"></span>
                </div>
                <!-- Add a div to hold the input field and autocomplete -->
                <div id="map"></div>
                <div class="form-field">
                    <input type="submit" name="edit_hospital_btn" id="edit-hospital-btn" class="btn-hover color-4" value="Accept changes">
                </div>
            </form>
        </div>

        <!-- Donation storage -->
        <section class="info_section__details" id="blood_info__details">
            <div class="hospital-nav">
                <div class="hospital-nav--left">
                    <?php
                    $query = "SELECT * FROM blood_group";
                    $res = mysqli_query($conn, $query);
                    if (mysqli_num_rows($res) > 0) {
                        while ($row = mysqli_fetch_assoc($res)) {
                            $blood_group_id = $row['id'];
                            $blood_group_name = $row['name'];
                            if (strtolower($blood_group_name) == "a") {
                                $default_blood_group_id = $blood_group_id;
                            }
                            echo '<div id="' . $blood_group_id . '" class="hospital-nav--left__item">Group <span>' . strtoupper($blood_group_name) . '</span> </div>';
                        }
                    }
                    ?>
                </div>
                <div class="hospital-nav--right">
                </div>
            </div>
            <table class="details_table" id="blood_table">
                <thead class="details_table__head">
                    <tr>
                        <th class="mobile-hide">Order</th>
                        <th>Blood group</th>
                        <th>Quantity</th>
                        <th class="mobile-hide">Donor phone</th>
                        <th class="mobile-hide">Donator ID</th>
                        <th class="mobile-hide">Donator at</th>
                        <th>Expiry date</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody class="details_table__body blood_storage">
                    <!-- Blood records in storage will bed rendered here -->
                </tbody>
                <!-- <tfoot>
                        <tr>
                            <td id="button_row" colspan="8"><button class="load_more_button">Load more</button></td>
                        </tr>
                    </tfoot> -->
            </table>
        </section>
    </main>

    <script src="./assets/js/toggleDisplayForm.js"></script>
    <script>
        var editHospitalInfoFormSelector = document.querySelector(".edit-hospital-form");
        var openEditHospitalInfoFormSelector = document.querySelector(".edit-hospital-ic");
        var closeEditHospitalInfoFormSelector = editHospitalInfoFormSelector.querySelector(".close-ic");
        toggleDisplayForm(editHospitalInfoFormSelector, openEditHospitalInfoFormSelector, closeEditHospitalInfoFormSelector)
    </script>

    <script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAWd9Wx6tr76oMUe4pWLQ8-FOJZfdkrNus&libraries=places,geometry&callback=initMap">
    </script>
    <script src="./assets/js/map.js"></script>
    <script src="./assets/js/toggleVerNavDb.js"></script>
    <script src="./assets/js/updateUrl.js"></script>
    <script src="./assets/js/popupMsg.js"></script>
    <script src="./assets/js/preventDefaultSubmission.js"></script>
    <script src="./assets/js/validator.js"></script>

    <script>
        function validateEditHospitalForm() {
            let name = document.querySelector('#edit-hospital-name');
            let hotline = document.querySelector('#edit-hospital-hotline');
            let email = document.querySelector('#edit-hospital-email');
            let address = document.querySelector('#location-input');
            let lat = document.querySelector('#edit-hospital-latitude');
            let lng = document.querySelector('#edit-hospital-longitude');

            let nameVal = name.value.trim();
            let hotlineVal = hotline.value.trim();
            let emailVal = email.value.trim();
            let addressVal = address.value.trim();
            let latVal = lat.value.trim();
            let lngVal = lng.value.trim();

            let isValidName = isValidHotLine = isValidEmail = isValidAddress = false;

            // Hospital name validation
            if (!nameVal) {
                showError(name, "This field cannot be empty")
            } else if (nameVal.length < 10 || name.length > 80) {
                showError(name, "Invalid hospital name")
            } else {
                isValidName = true;
                showSuccess(name);
            }

            // Hospital hotline validation
            if (hotlineVal) {
                console.log("kkk")
                if (hotlineVal.length != 10) {
                    showError(hotline, "Invalid hotline number")
                } else {
                    isValidHotLine = true;
                    showSuccess(hotline);
                }
            } else {
                console.log("ddd")
                isValidHotLine = true;
                showSuccess(hotline)
            }


            // Email address Validation
            if (emailVal) {
                if (!checkEmail(emailVal)) {
                    showError(email, "Invalid email address");
                } else {
                    isValidEmail = true;
                    showSuccess(email)
                }
            } else {
                isValidEmail = true;
                showSuccess(email)
            }

            // Hospital address validation
            if (addressVal) {
                console.log(latVal)
                console.log(lngVal)

                if (!latVal || !lngVal) {
                    showError(address, "Invalid hospital address")
                } else {
                    isValidAddress = true;
                    showSuccess(address)
                }
            } else {
                isValidAddress = true;
                showSuccess(address)
            }

            return isValidName && isValidHotLine && isValidEmail && isValidAddress
        }

        document.querySelector('#edit-hospital-btn').onclick = function() {
            let editHospitalInfoForm = document.querySelector('.edit-hospital-form');
            let fd = new FormData(editHospitalInfoForm);
            console.log(fd.get("edit_hospital_address"))
            console.log(fd.get("edit_hospital_latitude"))
            console.log(fd.get("edit_hospital_longitude"))

            // return { lat: lat, lng: lng };
            // Validation
            let isValidEditHospitalForm = validateEditHospitalForm();
            editHospitalInfoForm.querySelectorAll('.form-field__input').forEach(item => {
                item.oninput = function() {
                    isValidEditHospitalForm = validateEditHospitalForm();
                }
            });

            if (isValidEditHospitalForm) {
                $.ajax({
                    url: "./edit_hospital_info.php",
                    type: "POST",
                    data: fd,
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        // alert(response)
                        closeForm(editHospitalInfoFormSelector)
                        if (response == "1") {
                            createPopupMsg("success", "Successfully edited hospital information");
                        } else {
                            createPopupMsg("fail", "Something went wrong. Please try again!");
                        }
                    },
                    fail: function() {
                        createPopupMsg("fail", "Something went wrong. Please try again!");
                    },
                    error: function() {
                        createPopupMsg("fail", "Something went wrong. Please try again!");
                    }
                })
            }
        }
    </script>

    <script>
        document.querySelectorAll('.hospital-nav--left__item').forEach(item => {
            item.addEventListener("click", function() {
                renderBloodByGroup(this.id);
            })
        })

        function renderBloodByGroup(blood_group_id) {
            let fd = new FormData();
            fd.append("blood_group_id", blood_group_id);
            fd.append("donation_centre_id", "<?php echo $_SESSION['user']['hospital_id'] ?>");
            $.ajax({
                url: "./render_blood_by_group.php",
                type: "POST",
                data: fd,
                processData: false,
                contentType: false,
                success: function(response) {
                    document.querySelector('.blood_storage').innerHTML = response;
                },
                fail: function() {
                    createPopupMsg("fail", "Something went wrong. Please try again!");
                },
                error: function() {
                    createPopupMsg("fail", "Something went wrong. Please try again!");
                }
            })
        }
        renderBloodByGroup("<?php echo $default_blood_group_id ?>");
    </script>
</body>

</html>