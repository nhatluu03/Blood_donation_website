<?php
session_start();
ob_start();
include('./check_login.php')
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>

    <!-- CDN -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

    <!-- Fonts -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css" integrity="sha512-xh6O/CkQoPOWDdYTDqeRdPCVd1SpvCA9XXcUnZS2FmJNp1coAFzvtCN9BmamE+4aHK8yyUHUSCcJHgXloTyT2A==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <!-- CSS -->
    <link rel="stylesheet" href="./assets/css/base.css">
    <!-- <link rel="stylesheet" href="./assets/css/main.css"> -->
    <link rel="stylesheet" href="./assets/css/registration.css">
    <style>
        .main {
            background-image: unset;
            margin: 0 6%;
            position: absolute;
            top: 50%;
            transform: translateY(-50%);
        }

        .login-form {
            background-color: white;
            width: 100%;
        }
    </style>
</head>

<body>
    <!-- Header section -->
    <header>
        <!-- <?php include 'header.php' ?> -->
    </header>

    <!-- Main section -->
    <div class="main">
        <?php
        include('./login.php')
        ?>
    </div>
</body>

</html>