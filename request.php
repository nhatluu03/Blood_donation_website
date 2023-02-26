<?php
session_start();
include('./db/connect.php');
include('./php/format.php');
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
    <link rel="stylesheet" href="./assets/css/headernfooter.css">
    <link rel="stylesheet" href="./assets/css/base.css">
    <link rel="stylesheet" href="./assets/css/form.css">
    <link rel="stylesheet" href="./assets/css/hospital.css">
    <link rel="stylesheet" href="./assets/css/database_officer.css">
    <style>
        .ver-nav-item:nth-of-type(3) {
            background-color: #ffddcb;
            color: #c64444;
        }
    </style>
</head>

<body>
    <div class="overlay hide"></div>
    <?php
    require('./header.php');
    include('./ver_nav_bar.php')
    ?>

    <main class="main">
        <!-- Your request -->
        <section class="info_section__details your-request">
            <div class="section-header">
                <h2 class="section-header__heading">Your processing requests</h2>
                <button class="open-request-form-btn">Request</button>
            </div>
            <div class="your-request-content">
                <!-- Your requests will be rendered here -->
            </div>
        </section>

        <!-- Donation requests -->
        <section class="info_section__details">
            <div class="section-header">
                <h2 class="section-header__heading">Other requests</h2>
            </div>
            <table class="details_table" id="blood_table">
                <thead class="details_table__head">
                    <tr>
                        <th class="mobile-hide">Order</th>
                        <th>Hospital in need</th>
                        <th>Blood Group</th>
                        <th>Amount</th>
                        <th>Request at</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody class="waiting-request-list details_table__body">
                    <!-- Other requests will be rendered here -->
                </tbody>
            </table>
        </section>
        <form action="" method="POST" class="choose-shipper-form toggle-form hide">
            <h2 class="form-name">Choose shipping options</h2>
            <i class="fa-solid fa-xmark close-ic"></i>
            <!-- <div class="form-field">
                <label for="choose-blood-unit" class="form-field__label">In storage: </label>
                <?php
                // $blood_group_id = '3';
                // $stmt = $conn->prepare("SELECT amount FROM store 
                //                         WHERE hospital_id = ?
                //                         AND blood_group_id = ?");
                // $stmt->bind_param("ss", $hospital_id, $blood_group_id);
                // $stmt->execute();
                // $stmt->store_result();
                // $stmt->bind_result($amount);
                // if ($stmt->num_rows()) {
                //     $stmt->fetch();
                //     echo '<input type="text" readonly class="form-field__input" value="'.$amount.' ml">';;
                // }
                ?>
                
            </div> -->
            <div class="form-field">
                <label for="delivery-officer-id" class="form-field__label">Officer</label>
                <select name="delivery_officer_id" id="delivery-officer-id" class="form-field__input">
                    <?php
                    $stmt = $conn->prepare("SELECT delivery_officer.user_id, user.name
                                    FROM hospital, delivery_officer, user
                                    WHERE delivery_officer.hospital_id = hospital.id
                                    AND hospital.id = ?
                                    AND delivery_officer.user_id = user.id
                                    AND delivery_officer.user_id NOT IN (SELECT delivery_officer.user_id 
                                                                        FROM delivery_officer, request
                                                                        WHERE request.delivery_officer_id = delivery_officer.user_id
                                                                        AND request.status = 'delivering')");
                    $stmt->bind_param("s", $hospital_id);
                    $stmt->execute();
                    $stmt->store_result();
                    $stmt->bind_result($delivery_officer_id, $delivery_officer_name);
                    if ($stmt->num_rows() > 0) {
                        echo '<option value="selectcard">-- Please choose a delivery officer --</option>';
                        while ($stmt->fetch()) {
                            echo ' <option value="' . $delivery_officer_id . '">' . $delivery_officer_name . '</option>';
                        }
                    } else {
                        echo '<option value="selectcard">-- No delivery officer available --</option>';
                    }
                    ?>
                </select>
            </div>
            <div class="form-field">
                <input type="submit" name="choose_shipper_btn" id="choose-shipper-btn" class="form-field__input btn-hover color-4" value="Accept">
            </div>
        </form>

        <form action="" method="POST" class="confirm-shipping-request-form toggle-form hide">
            <h2 class="form-name">Order confirmation</h2>
            <i class="fa-solid fa-xmark close-ic"></i>
            <div class="form-field">
                <label for="confirm-blood-group" class="form-field__label">Blood group: </label>
                <input type="text" class="form-field__input" id="confirm-blood-group" value="" readonly style="background-color: transparent; border: none">
            </div>
            <div class="form-field">
                <label for="confirm-blood-amount" class="form-field__label">Blood amount: </label>
                <input type="text" class="form-field__input" id="confirm-blood-amount" value="" readonly style="background-color: transparent; border: none">
            </div>
            <div class="form-field">
                <label for="confirm-temperature-after" class="form-field__label">Temperature: </label>
                <input type="number" name="confirm_temperature_after" id="confirm-temperature-after" class="form-field__input" placeholder="Temperature of Blood at receiving moment">
                <span class="form-field__message"></span>
            </div>
            <div class="form-field">
                <input type="submit" name="discard_shipping_request_btn" id="discard-shipping-request-btn" class="form-field__input" value="Discard">
                <input type="submit" name="confirm_shipping_request_btn" id="confirm-shipping-request-btn" class="form-field__input" value="Accept">
            </div>
        </form>

        <form method="POST" class="request-form toggle-form hide">
            <i class="fa-solid fa-xmark close-ic"></i>
            <h2 class="form-name">Request form</h2>
            <div class="form-field">
                <label for="request-blood-group" class="form-field__label">Blood group</label>
                <select name="blood_group_id" id="request-blood-group" class="form-field__input">
                    <option value="selectcard">-- Please select Blood group --</option>
                    <?php
                    $query = "SELECT id, name FROM blood_group";
                    $res = mysqli_query($conn, $query);
                    if (mysqli_num_rows($res) > 0) {
                        while ($row = mysqli_fetch_assoc($res)) {
                            echo '<option value="' . $row['id'] . '">' . strtoupper($row['name']) . '</option>';
                        }
                    }
                    ?>
                </select>
                <span class="form_field__message"></span>
            </div>
            <div class="form-field">
                <label for="request-blood-group" class="form-field__label">Amount</label>
                <select name="amount" id="request-amount" class="form-field__input">
                    <option value="selectcard">-- Please select amount --</option>
                    <option value="350">350ml</option>
                    <option value="500">500ml</option>
                    <option value="1000">1000ml</option>
                    <option value="1500">1500ml</option>
                    <option value="2000">2000ml</option>
                </select>
                <span class="form_field__message"></span>
            </div>
            <div class="form-field">
                <label for="request-blood-group" class="form-field__label">Description</label>
                <textarea name="message" id="request-message" rows="3" class="form-field__input" placeholder="Describe your needs"></textarea>
                <span class="form_field__message"></span>
            </div>
            <div class="form-field">
                <input type="submit" name="request_btn" id="request-btn" class="form-field__input btn-hover color-4" value="Send request">
            </div>
        </form>
    </main>

    <script src="./assets/js/toggleVerNavDb.js"></script>
    <script src="./assets/js/updateUrl.js"></script>
    <script src="./assets/js/popupMsg.js"></script>
    <script src="./assets/js/preventDefaultSubmission.js"></script>
    <script src="./assets/js/toggleDisplayForm.js"></script>
    <script src="./assets/js/validator.js"></script>

    <script>
        var requestFormSelector = document.querySelector(".request-form");
        var openRequestFormSelector = document.querySelector(".open-request-form-btn");
        var closeRequestFormSelector = requestFormSelector.querySelector(".close-ic");
        toggleDisplayForm(requestFormSelector, openRequestFormSelector, closeRequestFormSelector)

        document.querySelector('#request-btn').onclick = function() {
            let requestForm = document.querySelector('.request-form');
            let fd = new FormData(requestForm);
            let hospitalDemandId = "<?php echo $_SESSION['user']['hospital_id'] ?>";
            fd.append("hospital_demand_id", hospitalDemandId);
            $.ajax({
                url: "./request_form.php",
                type: "POST",
                data: fd,
                processData: false,
                contentType: false,
                success: function(response) {
                    closeForm(requestFormSelector)
                    if (response == "1") {
                        createPopupMsg("success", "Successfully send the request");
                        renderYourRequest();
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
        function renderRequestRecords() {
            let fd = new FormData();
            fd.append("hospital_id", "<?php echo $_SESSION['user']['hospital_id'] ?>");
            $.ajax({
                url: "./render_request_records.php",
                type: "POST",
                data: fd,
                processData: false,
                contentType: false,
                success: function(response) {
                    // alert(response);
                    document.querySelector('.waiting-request-list').innerHTML = response;
                },
                fail: function() {
                    createPopupMsg("fail", "Something went wrong. Please try again!");
                },
                error: function() {
                    createPopupMsg("fail", "Something went wrong. Please try again!");
                }
            })
        }

        function acceptRequest(requestId) {
            let chooseBloodForm = document.querySelector('.choose-shipper-form');
            openForm(chooseBloodForm)
            chooseBloodForm.querySelector('.close-ic').onclick = function() {
                closeForm(chooseBloodForm);
            }

            let fd = new FormData();
            let hospitalSupplyId = "<?php echo $_SESSION['user']['hospital_id'] ?>";
            fd.append("request_id", requestId)
            fd.append("hospital_supply_id", hospitalSupplyId)

            document.querySelector('#choose-shipper-btn').onclick = function() {
                let deliveryOfficerId = chooseBloodForm.querySelector('#delivery-officer-id').value;
                fd.append("delivery_officer_id", deliveryOfficerId);

                console.log(fd.get("request_id"))
                console.log(fd.get("delivery_officer_id"))
                console.log(fd.get("hospital_supply_id"))

                $.ajax({
                    url: "./accept_request.php",
                    type: "POST",
                    data: fd,
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        // alert(response)
                        if (response == "1") {
                            renderRequestRecords();
                            createPopupMsg("success", "Thanks for accepting the request!");
                        } else if (response == "0") {
                            createPopupMsg("fail", "The amount of blood in the inventory is not enough to supply");
                        } else {
                            createPopupMsg("fail", "Something went wrong. Please try again!");
                        }
                        chooseBloodForm.classList.add('hide');
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

        function validateConfirmRequest() {
            let tempAfter = document.querySelector('#confirm-temperature-after');
            let tempAfterVal = tempAfter.value.trim();
            let isValidTempAfter = false;
            if (!tempAfterVal) {
                showError(tempAfter, "Please specify the temperature at receiving moment");
            } else if (parseInt(tempAfterVal) > 10 || parseInt(tempAfterVal) < 1) {
                showError(tempAfter, "Blood temperature exceeds the permissible limit (1-10 °C)");
            } else {
                isValidTempAfter = true;
                showSuccess(tempAfter);
            }
            return isValidTempAfter;
        }

        function confirmShippingRequest(requestId, requestBlood, requestAmount) {
            let confirmShippingRequestForm = document.querySelector('.confirm-shipping-request-form');
            confirmShippingRequestForm.querySelector('#confirm-blood-group').value = requestBlood;
            confirmShippingRequestForm.querySelector('#confirm-blood-amount').value = requestAmount + " ml";

            openForm(confirmShippingRequestForm)
            confirmShippingRequestForm.querySelector('.close-ic').onclick = function() {
                closeForm(confirmShippingRequestForm);
            }

            // Validation here

            let fd = new FormData();
            fd.append("request_id", requestId)
            // fd.append("hospital_supply_id", hospitalSupplyId)

            document.querySelector('#discard-shipping-request-btn').onclick = function() {
                $.ajax({
                    url: "./discard_shipping_request.php",
                    type: "POST",
                    data: fd,
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        // alert(response)
                        if (response == "1") {
                            createPopupMsg("success", "Successfully cancel the order. The request will be resent to the hospitals");
                        } else {
                            createPopupMsg("fail", "Something went wrong. Please try again!");
                        }
                        confirmShippingRequestForm.classList.add('hide');
                        renderYourRequest();
                    },
                    fail: function() {
                        createPopupMsg("fail", "Something went wrong. Please try again!");
                    },
                    error: function() {
                        createPopupMsg("fail", "Something went wrong. Please try again!");
                    }
                })
            }

            document.querySelector('#confirm-shipping-request-btn').onclick = function() {
                // Validation
                let isValidConfirm = validateConfirmRequest();

                if (isValidConfirm) {
                    fd.append("confirm_temperature_after", document.querySelector('#confirm-temperature-after').value)
                    $.ajax({
                        url: "./confirm_shipping_request.php",
                        type: "POST",
                        data: fd,
                        processData: false,
                        contentType: false,
                        success: function(response) {
                            // alert(response)
                            if (response == "1") {
                                createPopupMsg("success", "Successfully confirmed shipping request");
                            } else {
                                createPopupMsg("fail", "Something went wrong. Please try again!");
                            }
                            confirmShippingRequestForm.classList.add('hide');
                            renderYourRequest();
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
        }
        renderRequestRecords();
    </script>

    <script>
        function renderYourRequest() {
            let fd = new FormData();
            fd.append("hospital_id", "<?php echo $_SESSION['user']['hospital_id'] ?>")
            $.ajax({
                url: "./render_your_request.php",
                type: "POST",
                data: fd,
                processData: false,
                contentType: false,
                success: function(response) {
                    document.querySelector(".your-request-content").innerHTML = response;
                },
                fail: function() {
                    alert("Something went wrong. Please try again!")
                },
                error: function() {
                    alert("Something went wrong. Please try again!")
                }
            })
        }
        renderYourRequest();
    </script>
</body>

</html>