<?php
$donor_id ="abc";
$donor_full_name ="def";
echo '<button id="' . $donor_id . '"  class="verify-donation-btn" onclick="verifyDonation(\''.$donor_id.'\', \''.$donor_full_name.'\')"> Verify </button>';


?>

<script>
    function verifyDonation(donorId, donorName) {
        console.log(donorId);
        console.log(donorName);
    }
</script>