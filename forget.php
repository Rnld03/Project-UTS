<?php 
error_reporting(0);
include 'connect.php';

session_start();
if(isset($_SESSION['username'])){
    echo '<script>window.location.href="profil.php"</script>';
}

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require './vendor/phpmailer/phpmailer/src/Exception.php';
require './vendor/phpmailer/phpmailer/src/PHPMailer.php';
require './vendor/phpmailer/phpmailer/src/SMTP.php';

$errors = array();

if(isset($_POST['reset_pass'])){
    $emailTo = htmlspecialchars($_POST['email']);
    $emailTo = mysqli_real_escape_string($connect, $emailTo);
    $code = uniqid(true);

    if(empty($emailTo)){
        array_push($errors, '<div class="alert alert-danger" role="alert">Masukkan alamat email!</div>');
    }else{
        $result = mysqli_query($connect, "SELECT * FROM tb_users_1 WHERE email='$emailTo'");
        $cek_email = mysqli_num_rows($result);
        if($cek_email == null){
            array_push($errors, '<div class="alert alert-danger" role="alert">Maaf alamat email tidak terdaftar!</div>');
        }else{
            $insert = mysqli_query($connect, "INSERT INTO reset_password VALUES ('','$emailTo','$code')");
        try{
                $mail = new PHPMailer(true);
                $mail->SMTPDebug = 2;
                $mail->isSMTP();
                $mail->Host = 'smtp.gmail.com';
                $mail->SMTPAuth = true;
                $mail->Username = 'prayogaea253@gmail.com';
                $mail->Password = '123abc..';
                $mail->SMTPSecure = 'tls';
                $mail->Port = 587;
                $mail->setFrom('prayogaea253@gmail.com', 'prayogaea');
                $mail->addAddress($emailTo);
                $mail->addReplyTo('prayogaea253@gmail.com', 'prayogaea');
                $url = "http://" . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']) . "/reset.php?reset_pass=$code";
                $mail->isHTML(true);
                $mail->Subject = 'Link Reset Password';
                $mail->Body = "<h1>Permintaan Reset Password User</h1>
                                <p>Klik Link <a href='$url'>Reset Password</a> Untuk Mereset Password</p>";
                $mail->send();
                echo "<script>alert('Link Reset Password berhasil dikirim ke Email Anda')</script>";
                echo '<script>window.location.href="login.php"</script>';
                exit();
            }catch (Exception $e){
                echo "<script>alert('Maaf terjadi masalah saat mengirim pesan ke Email Anda!')</script>";
                echo '<script>window.location.href="forget.php"</script>';
                exit();
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Reset Password</title>

    <!-- Custom fonts for this template-->
    <link href="./assets/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="./assets/css/sb-admin-2.min.css" rel="stylesheet">

    <!-- sweet alert -->
    <link rel="stylesheet" href="./assets/css/sweetalert.css">

</head>

<body class="bg-gradient-white">

            <!-- Topbar -->
            <nav class="navbar navbar-expand navbar-light bg-white topbar mb-2 static-top">

            </nav>
            <!-- End of Topbar -->

            <div class="container">

                <!-- Outer Row -->
                <div class="row justify-content-center">

                    <div class="col-xl-5 col-lg-5 col-md-5">

                        <div class="card o-hidden border-0 shadow my-5">
                            <div class="card-body p-0">
                                <!-- Nested Row within Card Body -->
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="p-5">
                                            <div class="text-center">
                                                <h1 class="h2 text-gray-900 mb-2">Reset Password?</h1>
                                                <p class="mb-4">Masukkan alamat email anda di bawah ini untuk mengatur ulang password Anda!</p>
                                            </div>
                                            <?php include 'errors.php'; ?>
                                            <form class="user" method="POST">
                                                <div class="form-group">
                                                    <input type="email" name="email" class="form-control" placeholder="Alamat Email">
                                                </div>
                                                <input type="submit" name="reset_pass" class="btn btn-primary btn-block" value="Kirim Email">
                                            </form>
                                            <hr>
                                            <div class="text-center">
                                                Sudah punnya akun?<a class="small" href="login.php">Login</a>
                                            </div>
                                            <div class="text-center">
                                                Belum punya akun?<a class="small" href="register.php">Register</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>

                </div>

            </div>


    <!-- Bootstrap core JavaScript-->
    <script src="./assets/vendor/jquery/jquery.min.js"></script>
    <script src="./assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="./assets/vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="./assets/js/sb-admin-2.min.js"></script>

    <!-- sweet alert -->
    <script src="./assets/js/jquery-2.1.4.min.js"></script>
    <script src="./assets/js/sweetalert.min.js"></script>

</body>

</html>