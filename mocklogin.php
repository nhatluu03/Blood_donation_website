<?php
    session_start();
    include('./db/connect.php');
    if (isset($_POST["log_username"])) {
        $log_username = $_POST['log_username'];
        $log_password = $_POST['log_password'];

        $stmt = $conn->prepare("SELECT id, full_name, avatar, email, phone, created_at
                        FROM users WHERE username = ? AND hashed_pwd = ?; ");
        $stmt->bind_param("ss", $log_username, $log_password);
        $stmt->execute();

        $stmt->store_result();
        $stmt->bind_result($id, $full_name, $avatar, $email, $phone, $created_at);
        $rows = [];
        $tmp_avatar = $avatar;
        if (!$tmp_avatar) {
            $tmp_avatar = 'default_avt.png';
        } 
        if ($stmt->num_rows() < 1) {
            $login_err = "Tài khoản hoặc mật khẩu không chính xác!";
        } else {
            $login_err = "";
            $row = $stmt->fetch();
            echo "<script> alert('".$id."') </script>";
            $_SESSION['logged_in'] = true;
            $_SESSION['user'] = [
                "id" => $id,
                "full_name" => $full_name,
                "avatar" => $tmp_avatar,
                "email" => $email,
                "phone" => $phone,
                "created_at" => $created_at,
            ];

            // Examine user role
            $stmt2 = $conn->prepare("SELECT user_id FROM admins WHERE user_id = ?");
            
            $stmt2->bind_param("s", $id);
            $stmt2->execute();

            $stmt2->store_result();
            $stmt2->bind_result($id);
            $rows = [];
            
            if ($stmt2->num_rows() > 0) {
                $_SESSION['user']['role'] = "admin";
            } else {
                $_SESSION['user']['role'] = "member";
            }
            header("location: ./profile.php");
            exit;
        }
    }
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>QTCrypto</title>

    <!-- Fonts -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css"
        integrity="sha512-xh6O/CkQoPOWDdYTDqeRdPCVd1SpvCA9XXcUnZS2FmJNp1coAFzvtCN9BmamE+4aHK8yyUHUSCcJHgXloTyT2A=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />

    <!-- CSS -->
    <link rel="stylesheet" href="assets/css/base.css">
    <link rel="stylesheet" href="assets/css/authentication.css">
</head>

<body>
    <!-- Header -->
    <?php include('./php/header.php') ?>
    
    <!-- Main content -->
    <main>
        <section class="authentication">
            <div class="authentication--left">
                <h2>CỘNG ĐỒNG QTCRYPTO</h2>
                <ol>
                    <li> Chia sẻ kinh nghiệm thực tế với hơn <span>  100+ </span> bài học </li>
                    <li> Cộng đồng  lớn mạnh với hơn <span>10.000+</span>  users </li>
                    <li> Hơn <span>400+</span> giao dịch được thực hiện mỗi ngày </li>
                    <li> Hỗ trợ mọi thắc mắc <span>24/7</span> </li>
                </ol>

                <h4>Theo dõi chúng tôi tại</h4>
                <div class="follow-container">
                    <a href="facebook.com" class="follow-item"><i class="fa-brands fa-facebook-f"></i></a>
                    <a href="facebook.com" class="follow-item"><i class="fa-brands fa-twitter"></i></a>
                    <a href="facebook.com" class="follow-item"><i class="fa-brands fa-instagram"></i></a>
                    <a href="facebook.com" class="follow-item"><i class="fa-brands fa-youtube"></i></a>
                </div>
            </div>

            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST" class="form log-form authentication--right">
                <h2 class="form-name">Đăng nhập</h2>
                <div class="form-field">
                    <label for="log-username" class="form-field__label"><i class="fa-regular fa-user"></i></label>
                    <input type="text" name="log_username" id="log-username" class="form-field__input" placeholder="Tên đăng nhập">
                </div>
                <div class="form-field">
                    <label for="log-password" class="form-field__label">
                        <i class="fa-solid fa-lock"></i>
                    </label>
                    <input type="text" name="log_password" id="log-password" class="form-field__input" placeholder="Mật khẩu">
                </div>
                <div class="form-field">
                    <input type="checkbox" name="log_submit" id="log-submit" class="form-field__input" checked> 
                    <span class="form-extra-msg">Ghi nhớ đăng nhập</span>
                </div>
                <p class="form-field__msg" style="color: #ff4e62; font-size: 1.4rem;"> <?php echo isset($login_err) ? $login_err : ""; ?> </p>
                <div class="form-field">
                    <input type="submit" name="log_submit" id="log-submit" class="form-field__input" value="Đăng nhập">
                </div>
                <span class="form-extra-msg">
                    <p>Chưa có tài khoản? <a href="registration.html">Đăng kí</a></p>
                </span>
            </form>
        </section>
    </main>

    <!-- Prevent default resubmission -->
    <script>
        if ( window.history.replaceState ) {
            window.history.replaceState( null, null, window.location.href );
        } 
    </script>
</body>
</html>

<?php ob_end_flush(); ?>