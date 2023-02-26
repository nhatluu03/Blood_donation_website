<?php
session_start();
include('./db/connect.php');
// print_r($_SESSION['user']);

// Get hospital info 
$hospital_id = $_SESSION['user']['hospital_id'];
$stmt1 = $conn->prepare("SELECT name, address
                    FROM hospital WHERE hospital.id = ?");
$stmt1->bind_param('s', $hospital_id);
$stmt1->execute();
$stmt1->store_result();
$stmt1->bind_result($hospital_name, $hospital_address);
$stmt1->fetch();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hospital HR</title>
    <!-- CDN -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

    <!-- css for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css" integrity="sha512-xh6O/CkQoPOWDdYTDqeRdPCVd1SpvCA9XXcUnZS2FmJNp1coAFzvtCN9BmamE+4aHK8yyUHUSCcJHgXloTyT2A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <!-- css for font -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans&display=swap" rel="stylesheet">

    <!-- <link rel="stylesheet" href="./assets/css/minh_base.css"> -->
    <link rel="stylesheet" href="./assets/css/base.css">
    <link rel="stylesheet" href="./assets/css/form.css">
    <link rel="stylesheet" href="./assets/css/hospital.css">
    <!-- css for header and footer -->
    <link rel="stylesheet" href="./assets/css/headernfooter.css">
    <style>
        .ver-nav-item:nth-of-type(2) {
            background-color: #ffdcd1;
            color: #c64444;
        }

        .ver-nav-item:nth-of-type(2) i {
            color: #c64444;
        }
    </style>
</head>

<body>
    <!-- Header section -->
    <?php
    include('./header.php');
    ?>

    <main class="main">
        <div class="general_info">
            <div class="general_info__hospital">
                <!-- <label for="edit_check" class="general_info__edit_button"><i class="fa-regular fa-pen-to-square"></i></label> -->
                <section class="general_info__hospital_name">
                    <?php echo $hospital_name ?>
                </section>
                <section class="general_info__hospital_details">
                    <p class="hospital_details"> <i class="fa-solid fa-phone"></i> <?php echo isset($SESSION['user']['phone']) ? $SESSION['user']['email'] : "Unset" ?> </p>
                    <p class="hospital_details"><i class="fa-solid fa-envelope"></i> <?php echo isset($SESSION['user']['email']) ? $SESSION['user']['email'] : "Unset" ?></p>
                    <p class="hospital_details"><i class="fa-solid fa-location-dot"></i> <?php echo $hospital_address ?></p>
                </section>
            </div>

            <div class="general_info__blood">
                <div class="blood_group">
                    <section class="blood_name">
                        HR manager
                    </section>
                    <section class="blood_quantity">
                        <?php
                        $stmt = $conn->prepare("SELECT *
                                FROM administrative_manager
                                WHERE administrative_manager.hospital_id = ?");
                        $stmt->bind_param("s", $hospital_id);
                        $stmt->execute();
                        $stmt->store_result();
                        echo $stmt->num_rows() > 1 ?  $stmt->num_rows() . ' employees' : $stmt->num_rows() . ' employee';
                        ?>
                    </section>
                </div>
                <div class="blood_group">
                    <section class="blood_name">
                        Database officer
                    </section>
                    <section class="blood_quantity">
                        <?php
                        $stmt = $conn->prepare("SELECT *
                                FROM database_officer
                                WHERE database_officer.hospital_id = ?");
                        $stmt->bind_param("s", $hospital_id);
                        $stmt->execute();
                        $stmt->store_result();
                        echo $stmt->num_rows() > 1 ?  $stmt->num_rows() . ' employees' : $stmt->num_rows() . ' employee';
                        ?>
                    </section>
                </div>
                <div class="blood_group">
                    <section class="blood_name">
                        Delivery officer
                    </section>
                    <section class="blood_quantity">
                        <?php
                        $stmt = $conn->prepare("SELECT *
                                FROM delivery_officer
                                WHERE delivery_officer.hospital_id = ?");
                        $stmt->bind_param("s", $hospital_id);
                        $stmt->execute();
                        $stmt->store_result();
                        echo $stmt->num_rows() > 1 ?  $stmt->num_rows() . ' employees' : $stmt->num_rows() . ' employee';
                        ?>
                    </section>
                </div>
                <div class="blood_group">
                    <section class="blood_name">
                        Entry-level staff
                    </section>
                    <section class="blood_quantity">
                        10 employees
                    </section>
                </div>
            </div>
            <!-- <div class="edit_form"> -->
            <form action="" method="" id="general_info__edit_form" class="pop_up_form">
                <div class="form_header">
                    <h2>Edit form</h2>
                </div>
                <div class="fields">
                    <!-- <div class="labels"> -->
                    <label class="labels  labels_edit" for="hospital_name">Hospital name:</label>
                    <!-- </div> -->
                    <!-- <div class="inputs"> -->
                    <input class="inputs" type="text" id="hospital_name" name="hospital_name">
                    <!-- </div> -->
                </div>
                <div class="fields">
                    <!-- <div class="labels"> -->
                    <label class="labels  labels_edit" for="hospital_phone">Phome number:</label>
                    <!-- </div> -->
                    <!-- <div class="inputs"> -->
                    <input class="inputs" type="phone" id="hospital_phone" name="hospital_phone">
                    <!-- </div> -->
                </div>
                <div class="fields">
                    <!-- <div class="labels"> -->
                    <label class="labels labels_edit" for="hospital_email">Hospital email:</label>
                    <!-- </div> -->
                    <!-- <div class="inputs"> -->
                    <input class="inputs" type="email" id="hospital_email" name="hospital_email">
                    <!-- </div> -->
                </div>
                <div class="fields">
                    <!-- <div class="labels"> -->
                    <label class="labels labels_edit" for="hospital_address">Hospital addess:</label>
                    <!-- </div> -->
                    <!-- <div class="inputs"> -->
                    <input class="inputs" type="text" id="hospital_address" name="hospital_address">
                    <!-- </div> -->
                </div>
                <br>
                <label class="close_button" for="edit_check"><i class="fa-solid fa-xmark"></i></label>
                <input type="submit" value="Change" class="submit_button">
            </form>
            <!-- </div> -->
        </div>

        <div class="info_section" id="staff_info">
            <form action="" method="" id="add_shipper_form" class="pop_up_form">
                <div class="form_header">
                    <h2>Add Delivery Man</h2>
                </div>
                <div class="fields">
                    <label class="labels" for="shipper_name">Name:</label>
                    <input class="inputs" type="text" id="shipper_name" name="shipper_name">
                </div>
                <div class="fields">
                    <label class="labels" for="shipper_phone">Phone:</label>
                    <input class="inputs" type="tel" id="shipper_phone" name="shipper_phone">
                </div>
                <div class="fields">
                    <label class="labels" for="shipper_email">Email:</label>
                    <textarea class="inputs" name="shipper_email" id="shipper_email"></textarea>
                </div>
                <br>
                <label class="close_button" for="add_shipper_button_check"><i class="fa-solid fa-xmark"></i></label>
                <input type="submit" value="Add" class="submit_button">
            </form>

            <form action="" method="" id="add_staff_form" class="pop_up_form">
                <div class="form_header">
                    <h2>Add Employee</h2>
                </div>
                <div class="fields">
                    <label class="labels" for="staff_name">Name:</label>
                    <input class="inputs" type="text" id="staff_name" name="staff_name">
                </div>
                <div class="fields">
                    <label class="labels" for="staff_phone">Phone:</label>
                    <input class="inputs" type="tel" id="staff_phone" name="staff_phone">
                </div>
                <div class="fields">
                    <label class="labels" for="staff_email">Email:</label>
                    <textarea class="inputs" name="staff_email" id="staff_email"></textarea>
                </div>
                <br>
                <label class="close_button" for="add_staff_button_check"><i class="fa-solid fa-xmark"></i></label>
                <input type="submit" value="Add" class="submit_button">
            </form>

            <div class="hospital-nav">
                <div class="hospital-nav--left">
                    <div class="hospital-nav--left__item" id="*">All</div>
                    <div class="hospital-nav--left__item" id="database_task">Database officer</div>
                    <div class="hospital-nav--left__item" id="delivery_task">Delivery officer</div>
                </div>
                <div class="hospital-nav--right">
                    <a href="./database_officer_registration.php" class="add-staff-btn">Add database staff</a>
                    <a href="./delivery_officer_registration.php" class="add-staff-btn">Add delivery staff</a>
                    <!-- <button class="open-request-form-btn btn-hover color-4">Add delivery staff</button>
                    <button class="open-request-form-btn btn-hover color-4">Add delivery staff</button> -->
                </div>
            </div>

            <section class="blood_info__details" id="staff_info__details">
                <table class="details_table" id="staff_table">
                    <thead class="details_table__head">
                        <tr>
                            <th class="mobile_hide">Order</th>
                            <th>Full name</th>
                            <th>Phone</th>
                            <th>Email</th>
                            <th>Salary</th>
                            <th>Working since</th>
                        </tr>
                    </thead>
                    <tbody class="details_table__body staff-list">
                        <!-- Staff info will be rendered here -->
                    </tbody>
                    <!-- <tfoot>
                        <tr>
                            <td id="button_row" colspan="8"><button class="load_more_button test_button">Load more</button></td>
                        </tr>
                    </tfoot> -->
                </table>
            </section>
        </div>
    </main>
    <div class="overlay hide"></div>

    <script src="./assets/js/toggleVerNavDb.js"></script>

    <!-- Render staff records by task -->
    <script>
        function renderStaffByTask(task) {
            let fd = new FormData();
            fd.append("hospital_id", "<?php echo $_SESSION['user']['hospital_id'] ?>")
            fd.append(task, true);
            console.log(fd.get(task));

            $.ajax({
                url: "./render_staff_by_task.php",
                type: "POST",
                data: fd,
                processData: false,
                contentType: false,
                success: function(response) {
                    // alert(response);
                    document.querySelector('.staff-list').innerHTML = response;
                },
                fail: function() {
                    document.querySelector('.staff-list').innerHTML = "Something went wrong. Reload the page!";
                },
                error: function() {
                    document.querySelector('.staff-list').innerHTML = "Something went wrong. Reload the page!";
                }
            })
        }
        document.querySelectorAll('.hospital-nav--left__item').forEach(item => {
            item.addEventListener('click', function() {
                renderStaffByTask(item.id);
            })
        })
        renderStaffByTask("*")
    </script>
</body>

</html>