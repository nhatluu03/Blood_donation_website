<?php
session_start();
include('./db/connect.php');
// print_r($_SESSION['user']);
$hospital_id = $_SESSION['user']['hospital_id'];
$is_donation_centre = false;

$stmt = $conn->prepare("SELECT hospital.name, hospital.address 
                                    FROM hospital, donation_centre
                                    WHERE donation_centre.hospital_id = hospital.id
                                    AND hospital.id = ?");
$stmt->bind_param("s", $hospital_id);
$stmt->execute();
$stmt->store_result();
$stmt->bind_result($hospital_name, $hospital_address);
$stmt->fetch();

if ($stmt->num_rows() > 0) {
    $is_donation_centre = true;
}

if (!$is_donation_centre) {
    exit;
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
</head>

<body>
    <!-- Header section -->
    <header>
        <nav class="hor-nav">
            <a href="./index.php" class="brand">
                <img src="./assets/img/logo.png" alt="" class="brand__logo">
                <span class="brand__name">Blood Mana</span>
            </a>
            <div class="hor-nav-container">
                <a href="./index.php" class="hor-nav-item">Home</a>
                <a href="./about.html" class="hor-nav-item">About</a>
                <a href="./policies.html" class="hor-nav-item">Terms</a>
            </div>
        </nav>
    </header>

    <nav>
        <div class="ver-nav-container">
            <a href="database_officer_profile.php" class="ver-nav-item">
                <img src="./assets/img/avatar.png" alt="Avatar" class="ver-nav-item__user-avt">
                <div class="ver-nav-item__details">
                    <span class="ver-nav-item__username"><?php echo $_SESSION['user']['name'] ?></span>
                    <span class="ver-nav-item__user-role"><?php echo $_SESSION['user']['role'] ?></span>
                </div>
            </a>
            <i class="fa-solid fa-chevron-left close-ver-nav-ic"></i>
            <i class="fa-solid fa-chevron-right open-ver-nav-ic hide"></i>
            <a href="./database_officer_workspace.php" class="ver-nav-item"> <i class="fa-solid fa-hospital"></i> <span>Hospital</span> </a>
            <a href="./donation_calendar.php" class="ver-nav-item"> <i class="fa-solid fa-calendar-days"></i> <span>Donation campaigns</span> </a>
            <a href="./account_setting.php" class="ver-nav-item"><i class="fa-solid fa-gear"></i> <span>Settings</span></a>
        </div>
    </nav>

    <main class="main">
        <!-- Donation calendar -->
        <?php
        if (isset($_GET['view_calendar_id'])) {
            include('./view_calendar_donation.php');
        } else {
            echo ' 
            <form method="POST" class="filter-donation-calendar-form filter-form">
            <input type="hidden" name="donation_centre_id" value="' . $_SESSION["user"]["hospital_id"] . '">
            <label for="" class="form-field__label">From</label>
            <input type="date" name="calendar_start_date">
            <label for="" class="form-field__label">To</label>
            <input type="date" name="calendar_end_date">
            <input type="submit" name="calendar_filter_btn" id="calendar-filter-btn" class="filter-btn" value="Filter">
        </form>
        <section class="info_section__details" id="blood_info__details">
                                <table class="details_table" id="blood_table">
                                    <thead class="details_table__head">
                                        <tr>
                                            <th>Order</th>
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
                            </section>';
        }

        if (isset($_GET['edit_calendar_id'])) {
            include('./edit_donation_calendar.php');
        } else if (isset($_GET['delete_calendar_id'])) {
            include('./delete_donation_calendar.php');
        }
        ?>
    </main>
    <div class="overlay hide"></div>

    <?php
    require('footer.php');
    ?>


    <script src="./assets/js/toggleDisplayForm.js"></script>
    <script src="./assets/js/toggleVerNavDb.js"></script>
    <script src="./assets/js/updateUrl.js"></script>
    <script src="./assets/js/popupMsg.js"></script>
    <script src="./assets/js/preventDefaultSubmission.js"></script>

    <script>
        function renderDonationCalendar() {
            let fd = new FormData();
            fd.append("donation_centre_id", <?php echo $hospital_id ?>)
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