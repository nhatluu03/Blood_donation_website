<?php
include('./db/connect.php');
if (isset($_GET['delete_calendar_id'])) {
    $donation_calendar_id = $_GET['delete_calendar_id'];
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

<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]) ?>" method="POST" class="delete-calendar-form toggle-form">
    <h2 class="form-name">Delete donation campaign</h2>
    <i class="fa-solid fa-xmark close-ic" onclick="closeDeleteCalendarForm()"></i>
    <input type="hidden" name="delete_donation_calendar_id" value="<?php echo $donation_calendar_id ?>">
    <div class="form-field">
        <p class="sys-msg">All relevant information of this donation campaign will be removed, including the appointment list.</p>
    </div>
    <div class="form-field">
        <input type="submit" name="delete_calendar_btn" id="delete-calendar-btn" class="btn-hover color-4" value="Accept">
    </div>
</form>

<script src="./assets/js/toggleDisplayForm.js"></script>
<script src="./assets/js/updateUrl.js"></script>
<script>
    document.querySelector('.overlay').classList.remove('hide');
    function closeDeleteCalendarForm() {
        updateUrl('./campaign.php');
        document.querySelector('.delete-calendar-form').classList.add('hide');
        document.querySelector('.overlay').classList.add('hide');
    }

    document.querySelector('#delete-calendar-btn').onclick = function() {
        let deleteCalendarForm = document.querySelector('.delete-calendar-form');
        let fd = new FormData(deleteCalendarForm);

        $.ajax({
            url: "./update_donation_calendar.php",
            type: "POST",
            data: fd,
            processData: false,
            contentType: false,
            success: function(response) {
                if (response == "1") {
                    closeDeleteCalendarForm();
                    createPopupMsg('success', "Successfully deleted the donation campaign.")
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