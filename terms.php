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
    <link rel="stylesheet" href="./assets/css/static_pages.css">
    <style>
        .hor-nav-item:nth-of-type(4) {
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
        <section class="terms">
            <h1>TERMS AND POLICIES</h1>
            <strong>Last updated on Jan 02nd 2023</strong>
            <p>
                Below is the agreement between you and our services. Please read these Terms and Conditions carefully before join the Blood mana community.
            </p>
            <p>
                1. I certify that the referral information I supplied is genuine and full to the best of my knowledge, and I give permission to contact the referral directly.
            </p>
            <p>
                2. I acknowledge and accept that the referral incentive is only available for successful referrals. To put it another way, referrals who signed the contract and started working.
            </p>
            <p>
                3. The referral incentive is only granted when the referral has worked for 60 days.
            </p>
            <p>
                4. The Company reserves the right to approve or reject any referral/bonus at its sole discretion.
            </p>
            <p>
                5. You accept and acknowledge that EWEHK may transmit data about me or the referral(s) to other countries (including places outside Hong Kong) at any time and from time to time as EWEHK considers necessary.
            </p>
            <p>
                6. I also authorize English World Education Limited to disclose any information about you and/or the referral(s) to EWEHK's employees, agents, partners, associates, and contractors for the purposes of processing and verifying the application.
            </p>

            <p>
                7. The Company values personal data privacy and pledges to follow the Personal Data (Privacy) Ordinance's guidelines. For more information, please visit our company’s privacy policy statement on our website.
            </p>

            <p>
                8. You agree to submit to the nonexclusive jurisdiction of the courts of Hong Kong for any dispute arising out of or in connection with these terms and conditions.
            </p>
            <p>
                9. You will indemnify us for any act or omission by you or your referral(s), including any breach of these Conditions or the terms, conditions, or rules applicable to a referral, service, or your failure to provide valid, true, complete, accurate, and up-to-date information requested by us in carrying out our regulatory or legal duties.
            </p>
            <p>
                10. Subject to Clause 14, a person who is not a party to these terms and conditions has no right to enforce or profit from any provision of these terms and conditions under the Contracts (Rights of Third Parties) Ordinance (Cap. 623 of the Laws of Hong Kong) (the "Third Parties Ordinance").
            </p>
            <p>
                11. The approval of any person who is not a party to these terms and conditions is not necessary to withdraw or change these terms and conditions at any time, notwithstanding any term of these terms and conditions.
            </p>
            <p>
                12. The Company and any of its directors, officers, employees, affiliates, or agents may rely on any part of these terms and conditions (including, without limitation, any responsibility) that expressly confers rights or advantages on such person under the Third Parties Ordinance.
            </p>
            <p>
                13. If any part of this agreement becomes unlawful, void, or unenforceable in any manner, the other sections of this agreement will not be affected or hindered.
            </p>
            <p>
                14. The Company may at its discretion add, amend, suspend or terminate the offer and its terms and conditions at any time without prior notice. In case of any disputes, the decision of the Company shall be final.
            </p>
            <p>
                15. The Company may, at any time and without notice, add, change, suspend, or terminate the offer and its terms and conditions. In the event of a disagreement, the Company's decision shall be final.
            </p>
            <p>If you have any questions, feel free to contact us <a href="">here</a>.</p>
        </section>


        <!-- Back-to-top button -->
        <button class="back-to-top hidden mobile-hide">
            <i class="fa-solid fa-angles-up back-to-top-icon"></i>
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 11l5-5m0 0l5 5m-5-5v12" />
            </svg>
        </button>
    </main>

    <?php
    include('./footer.php');
    ?>
    <script src="./assets/js/backToTop.js"></script>
</body>

</html>