<?php
session_start();
include('./db/connect.php');
// print_r($_SESSION['user']);
$hospital_id = $_SESSION['user']['hospital_id'];
$is_donation_centre = false;

$stmt = $conn->prepare("SELECT hospital.name, hospital.address, latitude, longitude
                                    FROM hospital, donation_centre
                                    WHERE donation_centre.hospital_id = hospital.id
                                    AND hospital.id = ?");
$stmt->bind_param("s", $hospital_id);
$stmt->execute();
$stmt->store_result();
$stmt->bind_result($hospital_name, $hospital_address, $latitude, $longitude);
$stmt->fetch();

// if ($stmt->num_rows() > 0) {
//     $is_donation_centre = true;
// }
// if (!$is_donation_centre) {
//     exit;
// }
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
        .ver-nav-item:nth-of-type(4) {
            background-color: #ffddcb;
            color: #c64444;
        }
    </style>
</head>

<body>
    <!-- Header section -->
    <?php include('./header.php') ?>

    <main class="main">
        <!-- Donation calendar -->
        <section class="donation-campaign">
            <div class="section-header">
                <h2 class="section-header__heading pc-hide ipad-hide">Campaigns</h2>
                <form method="POST" class="filter-donation-calendar-form filter-form mobile-hide">
                    <input type="hidden" name="donation_centre_id" value="<?php echo $hospital_id ?>">
                    <label for="" class="form-field__label">From</label>
                    <input type="date" name="calendar_start_date">
                    <label for="" class="form-field__label">To</label>
                    <input type="date" name="calendar_end_date">
                    <input type="submit" name="calendar_filter_btn" id="calendar-filter-btn" class="filter-btn" value="Filter">
                </form>
                <button class="open-calendar-form-btn">Donation Campaign</button>
            </div>
            <section class="info_section__details" id="blood_info__details">
                <table class="details_table" id="blood_table">
                    <thead class="details_table__head">
                        <tr>
                            <th class="mobile-hide">Order</th>
                            <th>Datetime</th>
                            <th>Quantity/Capacity</th>
                            <th>Update</th>
                        </tr>
                    </thead>
                    <tbody class="details_table__body donation-calendar-list">
                        <!-- Donation calendar records will be rendered here -->
                    </tbody>
                    <!-- <tfoot>
                                            <tr>
                                                <td id="button_row" colspan="8"><button class="load_more_button">Load more</button></td>
                                            </tr>
                                        </tfoot> -->
                </table>
            </section>


        </section>
        <?php
        if (isset($_GET['view_calendar_id'])) {
            include('./view_calendar_donation.php');
        }
        if (isset($_GET['edit_calendar_id'])) {
            include('./edit_donation_calendar.php');
        } else if (isset($_GET['delete_calendar_id'])) {
            include('./delete_donation_calendar.php');
        }
        ?>

        <form method="POST" class="calendar-form toggle-form hide">
            <i class="fa-solid fa-xmark close-ic"></i>
            <h2 class="form-name">Add donation campaign</h2>
            <input type="hidden" name="donation_centre_id" value="<?php echo $_SESSION['user']['hospital_id'] ?>">
            <div class="form-field">
                <label for="donation-datetime" class="form-field__label">Date time</label>
                <input type="datetime-local" name="donation_datetime" id="donation-datetime" class="form-field__input">
            </div>
            <div class="form-field">
                <label for="donation-capacity" class="form-field__label">Capacity</label>
                <input type="number" name="donation_capacity" id="donation-capacity" class="form-field__input" placeholder="Enter donation capacity">
            </div>
            <div class="form-field">
                <input type="submit" name="add_donation_calendar_btn" id="add-donation-calendar-btn" class="form-field__input btn-hover color-4" value="Add">
            </div>
        </form>
    </main>

    <script src="./assets/js/toggleDisplayForm.js"></script>
    <script src="./assets/js/toggleVerNavDb.js"></script>
    <script src="./assets/js/updateUrl.js"></script>
    <script src="./assets/js/popupMsg.js"></script>
    <script src="./assets/js/preventDefaultSubmission.js"></script>
    <script>
        var calendarFormSelector = document.querySelector(".calendar-form");
        var openCalendarFormSelector = document.querySelector(".open-calendar-form-btn");
        var closeCalendarFormSelector = calendarFormSelector.querySelector(".close-ic");
        toggleDisplayForm(calendarFormSelector, openCalendarFormSelector, closeCalendarFormSelector)

        document.querySelector(' #add-donation-calendar-btn').onclick = function() {
            // Check if donation_centre has specified an address
            <?php
                if (!$latitude || !$longitude) {
                    echo "closeForm(calendarFormSelector);
                        createPopupMsg('fail', 'Please select an address before launching donation campaign'); 
                        return false;";
                }
            ?>
                                                                    
            let addCalendarForm = document.querySelector('.calendar-form');
            let fd = new FormData(addCalendarForm);
            $.ajax({
                url: "./add_donation_calendar.php",
                type: "POST",
                data: fd,
                processData: false,
                contentType: false,
                success: function(response) {
                    closeForm(calendarFormSelector);
                    if (response == "1") {
                        createPopupMsg("success", "Successfully added donation calendar");
                        renderDonationCalendar();
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
    </script>
    <script>
        function renderDonationCalendar() {
            let fd = new FormData();
            fd.append("donation_centre_id", "<?php echo $hospital_id ?>")
            $.ajax({
                url: "./render_donation_calendar.php",
                type: "POST",
                data: fd,
                processData: false,
                contentType: false,
                success: function(response) {
                    document.querySelector('.donation-calendar-list').innerHTML = response;
                },
                fail: function() {
                    createPopupMsg("fail", "Something went wrong. Please try again!");
                },
                error: function() {
                    createPopupMsg("fail", "Something went wrong. Please try again!");
                }
            })
        }
        renderDonationCalendar();
    </script>

    <script>
        document.querySelector('#calendar-filter-btn').onclick = function() {
            let filterDonationCalendarForm = document.querySelector('.filter-donation-calendar-form');
            let fd = new FormData(filterDonationCalendarForm);
            $.ajax({
                url: "./filter_donation_calendar.php",
                type: "POST",
                data: fd,
                processData: false,
                contentType: false,
                success: function(response) {
                    // alert(response)
                    document.querySelector('.donation-calendar-list').innerHTML = response;
                },
                fail: function() {
                    createPopupMsg("fail", "Something went wrong. Please try again!");
                },
                error: function() {
                    createPopupMsg("fail", "Something went wrong. Please try again!");
                }
            })
        }
    </script>
</body>

</html>