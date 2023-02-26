<a href="./donation_calendar.php" class="func-btn"> <i class="fa-solid fa-arrow-left"></i>  Back</a>
<section class="info_section__details" id="blood_info__details">
    <table class="details_table" id="blood_table">
        <thead class="details_table__head">
            <tr>
                <th>Order</th>
                <th>Full name</th>
                <th>Blood group</th>
                <th>Amount</th>
                <th>Phone</th>
                <th>Height x Weight</th>
                <th>Alcohol addiction</th>
                <th>Drug addiction</th>
                <th>Verification</th>
            </tr>
        </thead>
        <tbody class="details_table__body donation-book-list">
        </tbody>
    </table>
</section>

<script>
    function renderDonationList() {
        let fd = new FormData();
        fd.append("view_calendar_id", "<?php echo isset($_GET['view_calendar_id']) ? $_GET['view_calendar_id'] : "1" ?>")
        $.ajax({
            url: "./render_donation_list.php",
            type: "POST",
            data: fd,
            processData: false,
            contentType: false,
            success: function(response) {
                document.querySelector('.donation-book-list').innerHTML = response;
            },
            fail: function() {
                createPopupMsg("fail", "Something went wrong. Please try again!");
            },
            error: function() {
                createPopupMsg("fail", "Something went wrong. Please try again!");
            }
        })
    }
    renderDonationList();
</script>

<script>
        function verifyDonation(donorId) {
            let fd = new FormData();
            fd.append("donor_id", donorId);
            fd.append("donation_calendar_id", "<?php echo $_GET['view_calendar_id'] ?>");
            $.ajax({
                url: "./verify_donation.php",
                type: "POST",
                data: fd,
                processData: false,
                contentType: false,
                success: function(response) {
                    // alert(response);
                    if (response == 1) {
                        createPopupMsg("success", "Successfully verified the donation")
                        renderDonationList();
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