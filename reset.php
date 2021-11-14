<?php 
error_reporting(0);
include 'connect.php';

$errors = array();

if(!isset($_GET['reset_pass'])){
    header('Location: forget.php');
}

$code = $_GET['reset_pass'];
$query = mysqli_query($connect, "SELECT email FROM reset_password WHERE code='$code'");
if(mysqli_num_rows($query) == 0){
    array_push($errors, '<div class="alert alert-warning" role="alert">Maaf terjadi kesalahan saat mengirim pesan</div>');
    echo "<meta http-equiv=\"refresh\"content=\"3;URL=forget.php\"/>";
    exit();
}
$row = mysqli_fetch_assoc($query);
?>
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Password baru</title>

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
                                                <h1 class="h2 text-gray-900 mb-2">Password baru?</h1>
                                                <p class="mb-4">Buat Password baru anda di bawah ini untuk mengatur ulang password Anda!</p>
                                            </div>
                                            <?php 
                                                if(isset($_POST['new_pass'])){
                                                    $email = htmlentities($_POST['email']);
                                                    $options = [
                                                        'cost' => 12
                                                    ];
                                                    $password = htmlentities(password_hash($_POST['password'], PASSWORD_DEFAULT, $options));
                                                    
                                                    $update = mysqli_query($connect, "UPDATE tb_users_1 SET password='$password' WHERE email='$email'");
                                                    if($update){
                                                        mysqli_query($connect, "DELETE FROM reset_password WHERE code='$code'");
                                                    }
                                                    echo "<script type='text/javascript'>
                                                    setTimeout(function () { 
                                                      swal({
                                                              title: 'Update Password Berhasil',
                                                              type: 'success',
                                                              timer: 3200,
                                                              showConfirmButton: true
                                                          });   
                                                    },10);  
                                                    window.setTimeout(function(){ 
                                                      window.location.replace('login.php');
                                                    } ,3000); 
                                                    </script>";
                                                    echo "<meta http-equiv=\"refresh\"content=\"3;URL=login.php\"/>";
                                                }
                                            ?>
                                            <?php include 'errors.php'; ?>
                                            <form class="user" method="POST">
                                                <div class="form-group">
                                                    <input type="hidden" name="email" value="<?= $row['email']; ?>">
                                                    <input type="password" name="password" class="form-control" placeholder="Password Baru">
                                                </div>
                                                <input type="submit" name="new_pass" class="btn btn-primary btn-block" value="Update Password">
                                            </form>
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

