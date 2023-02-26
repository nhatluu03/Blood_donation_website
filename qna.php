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
        .hor-nav-item:nth-of-type(5) {
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
            <h1>IMPORTANT NOTES FOR DONORS</h1>
            <strong>Last updated on Jan 02nd 2023</strong>
            <div class="qna-container">
                <div class="qna-item">
                    <p class="qna-item__question">1. Who can donate blood?</p>
                    <p class="qna-item__answer">
                        - Everyone from 18 to 60 years old, really volunteered to donate their blood to save the sick.
                        - Weight at least 45kg for women and men. The amount of blood donated each time should not exceed 9ml/kg body weight and not more than 500ml each time.
                        - Not infected or not infected with HIV and other blood-borne diseases.
                        - The time between 2 blood donations is 12 weeks for both Men and Women.
                        - Have identification documents.
                    </p>
                </div>
                <div class="qna-item">
                    <p class="qna-item__question">2. Who should not donate blood?</p>
                    <p class="qna-item__answer">
                        - People who have been infected or have performed behaviors at risk for HIV, hepatitis B, hepatitis C, and blood-borne viruses.
                        - People with chronic diseases: cardiovascular, blood pressure, respiratory, stomach ...
                    </p>
                </div>
                <div class="qna-item">
                    <p class="qna-item__question">3. What tests will my blood be done?</p>
                    <p class="qna-item__answer">
                        - All collected blood units will be tested for blood group (ABO system, Rh system), HIV, hepatitis B virus, hepatitis C virus, syphilis, malaria.
                        - You will be notified of the results, kept confidential and consulted (free of charge) when the aforementioned infections are discovered.
                    </p>
                </div>
                <div class="qna-item">
                    <p class="qna-item__question">4. Demand for blood treatment in our country today?</p>
                    <p class="qna-item__answer">
                        - Every year, our country needs about 1,800,000 units of blood for treatment.
                        - Blood is needed for daily treatment, for emergency, for prevention of disasters and accidents requiring blood transfusion in large quantities.
                        - Currently, we have met about 54% of blood needs for treatment.
                    </p>
                </div>
                <div class="qna-item">
                    <p class="qna-item__question">5. Is blood donation harmful to health?</p>
                    <p class="qna-item__answer">
                        Donating blood under the guidance of a doctor is not harmful to health. That has been proven by scientific and factual bases:.
                        Scientific basis:
                        <br>
                        - Blood has many components, each component has a certain life and is always renewed daily. Example: Red blood cells live for 120 days, plasma is regularly replaced and renewed. Scientific basis shows that if each donation is less than 1/10 of the amount of blood in the body, it is not harmful to health.
                        <br>
                        - Many studies have proven that, after donating blood, the blood indexes have slightly changed but are still within the normal physiological limits without affecting the daily activities of the body.
                        Fact base:
                        <br>
                        - In fact, millions of people have donated blood many times but their health is still perfectly fine. There are people in the world who have donated blood more than 400 times. In Vietnam, the person who donated blood the most times donated nearly 100 times, in perfect health.
                        <br>
                        - Thus, if each person is in good health, does not have blood-borne infections, and meets the blood donation criteria, he or she can donate blood 3-4 times a year, while not adversely affecting health. while ensuring blood of good quality and safety for patients.
                        <br>
                        - Every year, our country needs about 1,800,000 units of blood for treatment.
                        <br>
                        - Blood is needed for daily treatment, for emergency, for prevention of disasters and accidents requiring blood transfusion in large quantities.
                        <br>
                        - Currently, we have met about 54% of blood needs for treatment.
                    </p>
                </div>
                <div class="qna-item">
                    <p class="qna-item__question">6. Benefits for voluntary blood donors?</p>
                    <p class="qna-item__answer">
                        Benefits and regimes for voluntary blood donors according to Circular No. 05/2017/TT-BYT stipulating the maximum price and costs for determining the price of a unit of whole blood and blood products meeting the standards. standard:
                        <br>
                        - Free health check and consultation.
                        <br>
                        - To be checked and informed of results of blood tests (completely confidential): blood type, HIV, hepatitis B virus, hepatitis C virus, syphilis, malaria. In case blood donors are infected or suspected of these pathogens, they will be invited by a doctor for health consultation.
                        <br>
                        - Be trained and cared for according to current regulations:
                        <br>
                        + Serve snacks on the spot: equivalent to 30,000 VND.
                        <br>
                        + Support travel expenses (in cash): 50,000 VND.
                        <br>
                        + Choose to receive gifts in kind of value as follows:
                        <br>
                        One unit of blood volume 250 ml: 100,000 VND.
                        <br>
                        One unit of blood volume 350 ml: 150,000 VND.
                        <br>
                        One unit of blood volume 450 ml: 180,000 VND.
                        <br>
                        + Obtained a voluntary blood donation certificate from the Provincial and City Humanitarian Blood Donation Steering Committee. In addition to the honoring value, the blood donation certificate has a blood reimbursement value, the maximum amount of blood being reimbursed is equal to the amount of blood donated by the donor. This Certificate is valid at hospitals and public health facilities nationwide.
                    </p>
                </div>
                <div class="qna-item">
                    <p class="qna-item__question">7. Under what circumstances should blood donation be delayed?</p>
                    <p class="qna-item__answer">
                        - Those who have to delay donating blood for 12 months from the time:
                        <br>
                        Complete recovery after surgical interventions.
                        <br>
                        + Recovering after contracting one of malaria, syphilis, tuberculosis, tetanus, encephalitis, meningitis.
                        <br>
                        + End the course of rabies vaccination after being bitten by an animal or receiving injections, transfusions of blood, blood products and biological products derived from blood.
                        Childbirth or termination of pregnancy.
                        <br>
                        - Those who have to delay blood donation for 06 months from the time:
                        <br>
                        + Tattoos on the skin.
                        <br>
                        + Click the earlobe, press the nose, press the navel or other positions of the body.
                        Exposure to blood and body fluids from people at risk of or infected with blood-borne diseases.
                        <br>
                        + Recovering from one of the diseases of typhoid, sepsis, snakebite, arteritis, thrombophlebitis, osteomyelitis, pancreatitis.
                        <br>
                        - Those who have to delay blood donation for 04 weeks from the time:
                        <br>
                        + Being cured of one of the diseases of gastroenteritis, urinary tract infection, infectious dermatitis, bronchitis, pneumonia, measles, whooping cough, mumps, dengue fever, dysentery, rubella, cholera , mumps.
                        <br>
                        + End of vaccination against rubella, measles, typhoid, cholera, mumps, chickenpox, BCG.
                        <br>
                        - Those who have to delay blood donation for 07 days from the time:
                        <br>
                        + Recover from illness after having one of the flu, cold, nasopharyngeal allergy, sore throat, Migraine headache.
                        <br>
                        + Administer vaccines, except those specified at Point c, Clause 1 and Point b, Clause 3 of this Article.
                        <br>
                        - Some regulations related to the profession and specific activities of blood donors: those who do certain jobs and perform the following specific activities only donate blood on holidays or only perform other tasks: this activity, at least 12 hours after donating blood:
                        <br>
                        + People working at altitude or below: pilots, crane drivers, workers working at heights, mountaineers, miners, sailors, divers.
                        <br>
                        + Operators of public transport means: bus driver, train driver, ship driver.
                        <br>
                        + Other cases: professional athletes, people who exercise heavily, do heavy training.
                    </p>
                </div>
            </div>
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
    <script>
        var qnaList = document.querySelectorAll('.qna-item')
        qnaList.forEach(qnaItem => {
            qnaItem.addEventListener('click', function() {
                qnaItem.querySelector('.qna-item__answer').classList.toggle('active');
            })
        })
    </script>
</body>

</html>