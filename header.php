<?php
include('./db/connect.php');
$user_role = $_SESSION['user']['role'];
$user_name = $_SESSION['user']['name'];
$is_donation_centre = false;
if (isset($_SESSION['user']['hospital_id'])) {
    $hospital_id = $_SESSION['user']['hospital_id'];
    $stmt = $conn->prepare("SELECT * FROM donation_centre WHERE hospital_id = ?");
    $stmt->bind_param("s", $hospital_id);
    $stmt->execute();
    $stmt->store_result();
    if ($stmt->num_rows() > 0) {
        $is_donation_centre = true;
    }
}
?>

<style>
    header {
        position: fixed;
    }
    @media only screen and (max-width: 1023px) {
        header {
            z-index: 1000001;
        }
    }
</style>
<header>
    <nav class="hor-nav">
        <?php
        if ($user_role == "admin") {
            echo '<a href="../index.php" class="brand">
                <img src="../assets/img/logo.png" alt="" class="brand__logo">
                <span class="brand__name">Blood Mana</span>
            </a>
            <div class="hor-nav-container mobile-hide">
                <a href="../index.php" class="hor-nav-item">Home</a>
                <a href="../about.php" class="hor-nav-item">About</a>
                <a href="../terms.php" class="hor-nav-item">Terms</a>
                <a href="../qna.php" class="hor-nav-item">Q&A</a>
            </div>';
        } else {
            echo '<a href="./index.php" class="brand">
                <img src="./assets/img/logo.png" alt="" class="brand__logo">
                <span class="brand__name">Blood Mana</span>
            </a>
            <div class="hor-nav-container mobile-hide">
                <a href="./index.php" class="hor-nav-item">Home</a>
                <a href="./about.php" class="hor-nav-item">About</a>
                <a href="./terms.php" class="hor-nav-item">Terms</a>
                <a href="./qna.php" class="hor-nav-item">Q&A</a>
            </div>';
        }
        ?>
        <i class="open-menu-ic fa-solid fa-bars pc-hide" onclick="openMobileNav()"></i>
        <i class="close-menu-ic fa-solid fa-xmark hide pc-hide" onclick="hideMobileNav()"></i>
        <div class="mobile-hor-nav-container hide pc-hide">
            <a href="./index.php" class="mobile-hor-nav-item">Home</a>
            <?php
            switch ($user_role) {
                case "donor":
                    echo '<a href="./donor_profile.php" class="mobile-hor-nav-item">Profile</a>
                        <a href="./donation.php" class="mobile-hor-nav-item">Donation</a>';
                    break;
                case "hr":
                    echo '<a href="./hr_officer_profile.php" class="mobile-hor-nav-item">Profile</a>
                        <a href="./hr_officer_workspace.php" class="mobile-hor-nav-item">Workspace</a>';
                    break;
                case "database_officer":
                    echo '<a href="./database_officer_profile.php" class="mobile-hor-nav-item">Profile</a>
                        <a href="./database_officer_workspace.php" class="mobile-hor-nav-item">Workspace</a>
                        <a href="./request.php" class="mobile-hor-nav-item">Request</a>
                        <a href="./campaign.php" class="mobile-hor-nav-item">Campaign</a>';
                    break;
                case "delivery_officer":
                    echo '<a href="./delivery_officer_profile.php" class="mobile-hor-nav-item">Profile</a>
                        <a href="./delivery_officer_workspace.php" class="mobile-hor-nav-item">Workspace</a>';
                    break;
                case "admin":
                    echo '<a href="./user_db.php" class="mobile-hor-nav-item">Community</a>
                    <a href="./hospital_db.php" class="mobile-hor-nav-item">Hospitals</a>
                    <a href="./contact_db.php" class="mobile-hor-nav-item">Contacts</a>';
                    break;
            }
            ?>
            <a href="./log_out.php" class="mobile-hor-nav-item">Log out</a>
        </div>
    </nav>
    <nav>
        <div class="ver-nav-container">
            <?php
            $avatar = $_SESSION['user']['avatar'] ? $_SESSION['user']['avatar'] : "default_avatar.png";
            switch ($user_role) {
                case "donor":
                    echo '<a href="./donor_profile.php" class="ver-nav-item">
                            <img src="./db/uploads/users/' . $avatar . '" alt="Avatar" class="ver-nav-item__user-avt">
                            <div class="ver-nav-item__details">
                                <span class="ver-nav-item__username">' . $user_name . '</span>
                                <span class="ver-nav-item__user-role">Donor</span>
                            </div>
                        </a>
                        <i class="fa-solid fa-chevron-left close-ver-nav-ic"></i>
                        <i class="fa-solid fa-chevron-right open-ver-nav-ic hide"></i>
                        <a href="./donation.php" class="ver-nav-item"> <i class="fa-solid fa-hospital"></i> <span>Donation</span></a>';
                    break;
                case "hr":
                    echo '<a href="hr_officer_profile.php" class="ver-nav-item">
                            <img src="./db/uploads/users/' . $avatar . '" alt="Avatar" class="ver-nav-item__user-avt">
                            <div class="ver-nav-item__details">
                                <span class="ver-nav-item__username">' . $user_name . '</span>
                                <span class="ver-nav-item__user-role">HR officer</span>
                            </div>
                        </a>
                        <i class="fa-solid fa-chevron-left close-ver-nav-ic"></i>
                        <i class="fa-solid fa-chevron-right open-ver-nav-ic hide"></i>
                        <a href="./hr_officer_workspace.php" class="ver-nav-item"> <i class="fa-solid fa-user-nurse"></i> <span>Human resources</span> </a>';
                    break;
                case "database_officer":
                    echo '<a href="database_officer_profile.php" class="ver-nav-item">
                            <img src="./db/uploads/users/' . $avatar . '" alt="Avatar" class="ver-nav-item__user-avt">
                            <div class="ver-nav-item__details">
                                <span class="ver-nav-item__username">' . $user_name . '</span>
                                <span class="ver-nav-item__user-role">Database officer</span>
                            </div>
                        </a>
                        <i class="fa-solid fa-chevron-left close-ver-nav-ic"></i>
                        <i class="fa-solid fa-chevron-right open-ver-nav-ic hide"></i>
                        <a href="./database_officer_workspace.php" class="ver-nav-item"> <i class="fa-solid fa-hospital"></i> <span>Hospital</span> </a>
                        <a href="./request.php" class="ver-nav-item"> <i class="fa-solid fa-hand-holding-medical"></i> <span>Requests</span> </a>';
                    if ($is_donation_centre) {
                        echo '<a href="./campaign.php" class="ver-nav-item"> <i class="fa-solid fa-calendar-days"></i> <span>Donation campaigns</span> </a>';
                    }
                        break;
                case "delivery_officer":
                    echo '<a href="delivery_officer_profile.php" class="ver-nav-item">
                            <img src="./db/uploads/users/' . $avatar . '" alt="Avatar" class="ver-nav-item__user-avt">
                            <div class="ver-nav-item__details">
                                <span class="ver-nav-item__username">' . $user_name . '</span>
                                <span class="ver-nav-item__user-role">Delivery officer</span>
                            </div>
                        </a>
                        <i class="fa-solid fa-chevron-left close-ver-nav-ic"></i>
                        <i class="fa-solid fa-chevron-right open-ver-nav-ic hide"></i>
                        <a href="./delivery_officer_workspace.php" class="ver-nav-item"> <i class="fa-solid fa-hospital"></i> <span>Delivery</span> </a>';
                    break;
                case "admin":
                    echo '<a href="#" class="ver-nav-item">
                            <img src="../db/uploads/users/' . $avatar . '" alt="Avatar" class="ver-nav-item__user-avt">
                            <div class="ver-nav-item__details">
                                <span class="ver-nav-item__username">' . $user_name . '</span>
                                <span class="ver-nav-item__user-role">Admin</span>
                            </div>
                        </a>
                        <i class="fa-solid fa-chevron-left close-ver-nav-ic"></i>
                        <i class="fa-solid fa-chevron-right open-ver-nav-ic hide"></i>
                        <a href="./user_db.php" class="ver-nav-item"> <i class="fa-solid fa-users"></i> <span>Community</span> </a>
                        <a href="./hospital_db.php" class="ver-nav-item"> <i class="fa-solid fa-hospital"></i> <span>Hospitals</span> </a>
                        <a href="./contact_db.php" class="ver-nav-item"> <i class="fa-solid fa-calendar-days"></i> <span>Contacts</span> </a>';
                    break;
                default:
                    // header('location: ../index.php');
            }

            ?>

            <?php
            if ($user_role == "admin") {
                echo '<a href="../log_out.php" class="ver-nav-item"><i class="fa-solid fa-right-from-bracket"></i> <span>Log out</span></a>';
            } else {
                echo '<a href="./log_out.php" class="ver-nav-item"><i class="fa-solid fa-right-from-bracket"></i> <span>Log out</span></a>';
            }

            ?>

        </div>
    </nav>
</header>
<div class="overlay hide"></div>
<div class="nav-overlay hide"></div>

<script>
    let mobileNavContainer = document.querySelector('.mobile-hor-nav-container');
    let overlayNav = document.querySelector('.nav-overlay');
    let openMenuIc = document.querySelector('.open-menu-ic');
    let closeMenuIc = document.querySelector('.close-menu-ic');

    function openMobileNav() {
        mobileNavContainer.classList.remove('hide');
        overlayNav.classList.remove('hide');
        closeMenuIc.classList.remove('hide');
        openMenuIc.classList.add('hide');
    }

    function hideMobileNav() {
        mobileNavContainer.classList.add('hide');
        overlayNav.classList.add('hide');
        openMenuIc.classList.remove('hide');
        closeMenuIc.classList.add('hide');
    }
    overlayNav.onclick = hideMobileNav;
</script>