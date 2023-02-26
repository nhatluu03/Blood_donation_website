<?php
include('./db/connect.php');
if (isset($_GET['edit_calendar_id'])) {
    $donation_calendar_id = $_GET['edit_calendar_id'];
    $stmt = $conn->prepare("SELECT date_time, capacity FROM donation_calendar  WHERE id = ?");
    $stmt->bind_param("s", $donation_calendar_id);
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($date_time, $capacity);
    $stmt->fetch();
} else {
    exit;
}
?>

<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]) ?>" method="POST" class="edit-calendar-form toggle-form">
    <h2 class="form-name">Edit donation campaign</h2>
    <i class="fa-solid fa-xmark close-ic" onclick="closeEditCalendarForm()"></i>
    <input type="hidden" name="edit_donation_calendar_id" value="<?php echo $donation_calendar_id ?>">
    <div class="form-field">
        <label for="edit-calendar-date-time" class="form-field__label">Date time:</label>
        <input type="datetime-local" name="edit_calendar_date_time" id="edit-calendar-date-time" class="form-field__input" value="<?php echo $date_time ?>">
        <span class="form-field__message"></span>
    </div>
    <div class="form-field">
        <label for="edit-calendar-capacity" class="form-field__label">Capacity: </label>
        <input type="text" name="edit_calendar_capacity" id="edit-calendar-capacity" class="form-field__input" value="<?php echo $capacity ?>">
        <span class="form-field__message"></span>
    </div>
    <div class="form-field">
        <input type="submit" name="edit_calendar_btn" id="edit-calendar-btn" class="btn-hover color-4" value="Accept changes">
    </div>
</form>

<script src="./assets/js/toggleDisplayForm.js"></script>
<script src="./assets/js/updateUrl.js"></script>
<script>
    document.querySelector('.overlay').classList.remove('hide');
    function closeEditCalendarForm() {
        updateUrl('./campaign.php');
        document.querySelector('.edit-calendar-form').classList.add('hide');
        document.querySelector('.overlay').classList.add('hide');
    }


    document.querySelector('#edit-calendar-btn').onclick = function() {
        let editCalendarForm = document.querySelector('.edit-calendar-form');
        let fd = new FormData(editCalendarForm);

        $.ajax({
            url: "./update_donation_calendar.php",
            type: "POST",
            data: fd,
            processData: false,
            contentType: false,
            success: function(response) {
                if (response == "1") {
                    closeEditCalendarForm();
                    createPopupMsg('success', "Successfully edited the donation campaign.")
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