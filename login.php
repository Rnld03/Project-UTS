<?php 
error_reporting(0);
include 'connect.php';
session_start();

if(isset($_SESSION['username'])){
    echo '<script>window.location.href="profil.php"</script>';
}

$email = '';
$errors = array();

if(isset($_POST['login'])){
    $email = htmlspecialchars($_POST['email']);
    $email = mysqli_real_escape_string($connect, $email);
    $password = htmlspecialchars($_POST['password']);
    $password = mysqli_real_escape_string($connect, $password);

    if(empty($email) || empty($password)){
        array_push($errors, '<div class="alert alert-danger" role="alert">Data form tidak boleh ada yang kosong!</div>');
    }elseif(!filter_var($email, FILTER_VALIDATE_EMAIL)){
        array_push($errors, '<div class="alert alert-danger" role="alert">Alamat email harus valid!</div>');
    }else{
        $user = mysqli_query($connect, "SELECT * FROM tb_users_1 WHERE email='$email'");
        $cek_user = mysqli_num_rows($user);
        if($cek_user == null){
            array_push($errors, '<div class="alert alert-danger" role="alert">Maaf Alamat email tidak terdaftar!</div>');
        }
    }

    if(count($errors) == 0){
        $query = mysqli_query($connect, "SELECT * FROM tb_users_1 WHERE email='$email'");
        $user = mysqli_num_rows($query);
        $row = mysqli_fetch_assoc($query);
        if($user > 0){
            if(password_verify($password, $row['password'])){
                $_SESSION['id_user'] = $row['id_user'];
                $_SESSION['username'] = $row['username'];
                $_SESSION['email'] = $row['email'];
                $_SESSION['password'] = $row['password'];
                if(isset($_POST['remember'])){
                    setcookie('username', $row['username'], time() + (3600 * 365 * 24 * 60 * 60));
                }
                $_SESSION['success'] = "<script type='text/javascript'>
                setTimeout(function () { 
                  swal({
                          title: 'Proses Login Berhasil',
                          type: 'success',
                          timer: 3200,
                          showConfirmButton: true
                      });   
                },10);  
                window.setTimeout(function(){ 
                  window.location.replace('profil.php');
                } ,3000); 
                </script>";
                echo '<script>window.location.href="profil.php"</script>';
            }else{
                array_push($errors, '<div class="alert alert-danger" role="alert">Maaf Password tidak terdaftar!</div>');
            } 
        }else{
            array_push($errors, '<div class="alert alert-danger" role="alert">Maaf Anda belum pernah Register!</div>');
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

    <title>Login</title>

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
    <nav class="navbar navbar-expand navbar-light bg-white topbar mb-1 static-top">

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
                                        <h1 class="h2 text-gray-900 mb-4">Login</h1>
                                    </div>

                                    <?php include 'errors.php'; ?>

                                    <form class="user" method="post" enctype="multipart/form-data">
                                        <div class="form-group">
                                            <input type="email" name="email" class="form-control" placeholder="Email" value="<?= $email; ?>">
                                        </div>
                                        <div class="form-group">
                                            <input type="password" name="password" class="form-control" placeholder="Password">
                                        </div>
                                        <div class="form-group">
                                            <div class="custom-control custom-checkbox small">
                                                <input type="checkbox" name="remember" class="custom-control-input" id="customCheck">
                                                <label class="custom-control-label" for="customCheck">Remember Me</label>
                                            </div>
                                        </div>
                                        <input type="submit" name="login" class="btn btn-primary btn-block" value="Login">
                                    </form>
                                    <hr>
                                    <div class="text-center">
                                        <a class="small" href="forget.php">Reset Password?</a>
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