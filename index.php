<?php
session_start();
include('./db/connect.php');
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="icon" href="http://example.com/favicon.png">

    <!-- CDN -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <!-- css for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css" integrity="sha512-xh6O/CkQoPOWDdYTDqeRdPCVd1SpvCA9XXcUnZS2FmJNp1coAFzvtCN9BmamE+4aHK8yyUHUSCcJHgXloTyT2A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <!-- css for font -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans&display=swap" rel="stylesheet">

    <!-- CSS -->
    <link rel="stylesheet" href="./assets/css/base.css">
    <link rel="stylesheet" href="./assets/css/headernfooter.css">
    <link rel="stylesheet" href="./assets/css/main_01.css">
    <link rel="stylesheet" href="./assets/css/form.css">

    <style>
        .hor-nav-item:nth-of-type(1) {
            font-weight: bold;
        }
    </style>
</head>

<body>
    <!-- Header section -->
    <?php
    include('./ex_header.php')
    ?>

    <!-- Main content -->
    <main class="main">
        <!-- Landing section -->
        <section class="landing">
            <div class="landing--left">
                <div class="landing-header">
                    <h2 class="landing-header__heading">
                        Blood Mana is setting the new standard for blood transaction and communication in the healthcare industry.
                    </h2>
                </div>
                <div class="landing-content">
                    <p class="landing-content__desc">Blood Mana is pursuing a B2B business model, with target customers being hospitals.
                        The project strives to aid hospitals in managing, sending, and receiving blood transfusion data with each other with better reliability and precision.
                    </p>
                    <button class="landing-button">
                        <img src="./assets/img/apple_ic.png" alt="" class="landing-button__ic">
                        <span>Appstore</span>
                    </button>
                    <button class="landing-button">
                        <img src="./assets/img/gg_play_ic.png" alt="" class="landing-button__ic">
                        <span>Google Play</span>
                    </button>
                </div>
            </div>

            <div class="landing--right">
                <img src="./assets/img/mock_mobile.png" alt="" class="landing--right__img">
            </div>
        </section>

        <!-- About section -->
        <section class="about">
            <div class="section-header">
                <h4 class="section-header__heading">ABOUT</h4>
                <p class="section-header__sub-heading">The biggest blood mana community worldwide</p>
            </div>
            <div class="section-content about-content">
                <img src="./assets/img/community_bg.png" alt="" class="about-content__bg-img">
            </div>

            <div class="mobile-about-container pc-hide ipad-hide">
                <div class="mobile-about-item">
                    <img src="./assets/img/avt1.png" alt="" class="mobile-about-item__img">
                    <p class="mobile-about-item__title">NGUYEN VAN A</p>
                    <p class="mobile-about-item__desc">The biggest blood mana community worldwide The biggest blood mana community worldwide</p>
                </div>
                <div class="mobile-about-item">
                    <img src="./assets/img/avt2.png" alt="" class="mobile-about-item__img">
                    <p class="mobile-about-item__title">NGUYEN VAN B</p>
                    <p class="mobile-about-item__desc">The biggest blood mana community worldwide The biggest blood mana community worldwide</p>
                </div>
                <div class="mobile-about-item">
                    <img src="./assets/img/avt3.png" alt="" class="mobile-about-item__img">
                    <p class="mobile-about-item__title">NGUYEN VAN C</p>
                    <p class="mobile-about-item__desc">The biggest blood mana community worldwide The biggest blood mana community worldwide</p>
                </div>
            </div>
        </section>

        <!-- Service section -->
        <section class="service">
            <div class="section-content service-content">
                <div class="service-content--left">
                    <div class="section-header">
                        <h4 class="section-header__heading">SERVICES WE PROVIDE</h4>
                        <p class="section-header__sub-heading">Connect donors and patients in need</p>
                    </div>
                    <p class="service-content__desc">
                        Blood Mana allows hospitals to request emergency blood supplies from nearby hospitals. The system fastens the ordinary blood transaction process by providing a local blood supply instead of having to connect with major institutes.
                    </p>
                    <a href="" class="service-content__path">Contact now</a>
                </div>
                <div class="service-content--light">
                    <img src="./assets/img/service_bg.png" alt="" class="service-content__bg-img">
                </div>
            </div>
        </section>

        <!-- Community -->
        <section class="community">
            <div class="section-header">
                <h4 class="section-header__heading">AROUND US</h4>
                <p class="section-header__sub-heading">The blood mana community</p>
            </div>
            <div class="section-content community-content">
                <ul class="community-container">
                    <li class="community-item">
                        <p class="community-item__number">60000+</p>
                        <p class="community-item__title">Facebook</p>
                    </li>
                    <li class="community-item">
                        <p class="community-item__number">120+</p>
                        <p class="community-item__title">Facebook</p>
                    </li>
                    <li class="community-item">
                        <p class="community-item__number">50+</p>
                        <p class="community-item__title">Facebook</p>
                    </li>
                    <li class="community-item">
                        <p class="community-item__number">71000 +</p>
                        <p class="community-item__title">Facebook</p>
                    </li>
                </ul>
            </div>
        </section>

        <!-- Back-to-top button -->
        <button class="back-to-top hidden mobile-hide">
            <i class="fa-solid fa-angles-up back-to-top-icon"></i>
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 11l5-5m0 0l5 5m-5-5v12" />
            </svg>
        </button>
    </main>

    <?php include('./footer.php') ?>
    <script>
        // Counter up
        var communityContainer = document.querySelector(".community-container");
        var communityList = document.querySelectorAll(".community-item");

        function formatNumber(x) {
            return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
        }

        function counterUp(el) {
            var numberEl = el.querySelector(".community-item__number");
            numberEl.classList.add("finish");
            var end = parseInt(numberEl.innerText);
            var count = 0;
            var time = 150;
            var step = end / time;

            let counting = setInterval(() => {
                count += step;
                if (count > end) {
                    clearInterval(counting);
                    numberEl.innerText = formatNumber(end + " +");
                } else {
                    numberEl.innerText = Math.round(count) + " +";
                }
            }, 5);
        }

        window.onscroll = function() {
            var rectStatistic = communityContainer.getBoundingClientRect();
            var heightScreen = window.innerHeight;
            if (!document.querySelector(".community-item__number").classList.contains('finish')) {
                if (!(rectStatistic.bottom < 0 || rectStatistic.top > heightScreen)) {
                    communityList.forEach((item) => {
                        counterUp(item);
                    });
                }
            }
        };
    </script>

    <!-- Back-to-top JS -->
    <script>
        const showOnPx = 100;
        const backToTopButton = document.querySelector(".back-to-top");
        const scrollContainer = () => {
            return document.documentElement || document.body;
        };

        const goToTop = () => {
            document.body.scrollIntoView({
                behavior: "smooth"
            });
        };

        document.addEventListener("scroll", () => {
            console.log("Scroll Height: ", scrollContainer().scrollHeight);
            console.log("Client Height: ", scrollContainer().clientHeight);

            const scrolledPercentage =
                (scrollContainer().scrollTop /
                    (scrollContainer().scrollHeight - scrollContainer().clientHeight)) * 100;


            if (scrollContainer().scrollTop > showOnPx) {
                backToTopButton.classList.remove("hidden");
            } else {
                backToTopButton.classList.add("hidden");
            }
        });

        backToTopButton.addEventListener("click", goToTop);
    </script>
</body>

</html>