<?php 
error_reporting(0);
include 'connect.php';
session_start();

if(!isset($_SESSION['username'])){
    echo '<script>window.location.href="login.php"</script>';
}

$username = $_SESSION['username'];
?>
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Update Password</title>

    <!-- Custom fonts for this template-->
    <link href="./assets/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="./assets/css/sb-admin-2.min.css" rel="stylesheet">

</head>

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">

        <!-- Sidebar -->
        <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

            <!-- Sidebar - Brand -->
            <a class="sidebar-brand d-flex align-items-center justify-content-center" href="profil.php">
                <div class="sidebar-brand-icon rotate-n-15">
                    <i class="fas fa-code"></i>
                </div>
                <div class="sidebar-brand-text mx-3">php<sub>Laboratory</sub></div>
            </a>

            <!-- Divider -->
            <hr class="sidebar-divider">

            <!-- Heading -->
            <div class="sidebar-heading">
                Interface
            </div>

            <!-- Nav Item - Pages Collapse Menu -->
            <li class="nav-item">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo"
                    aria-expanded="true" aria-controls="collapseTwo">
                    <i class="fas fa-fw fa-cog"></i>
                    <span>Settings</span>
                </a>
                <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <a class="collapse-item" href="update-profil.php">Update Profil</a>
                        <a class="collapse-item" href="update-password.php">Update Password</a>
                    </div>
                </div>
            </li>

        </ul>
        <!-- End of Sidebar -->

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                <!-- Topbar -->
                <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

                    <!-- Sidebar Toggle (Topbar) -->
                    <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                        <i class="fa fa-bars"></i>
                    </button>

                    <!-- Topbar Navbar -->
                    <ul class="navbar-nav ml-auto">

                        <!-- Nav Item - User Information -->
                        <li class="nav-item dropdown no-arrow">
                            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <span class="mr-2 d-none d-lg-inline text-gray-600 small"><?= $username; ?></span>
                            </a>
                            <!-- Dropdown - User Information -->
                            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in"
                                aria-labelledby="userDropdown">
                                <a class="dropdown-item" href="profil.php">
                                    <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Profile
                                </a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="#" data-toggle="modal" data-target="#logoutModal">
                                    <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Logout
                                </a>
                            </div>
                        </li>

                    </ul>

                </nav>
                <!-- End of Topbar -->

                <!-- Begin Page Content -->
                <div class="container-fluid">

                    <div class="row">
                        <div class="col-lg-5">

                            <div class="card shadow mb-4">
                                <div class="card-header py-3">
                                    <h6 class="m-0 font-weight-bold text-primary">Update Password</h6>
                                </div>
                                <div class="card-body">
                                    <?php 
                                        if(isset($_POST['update_password'])){
                                            $id_user = $_SESSION['id_user'];
                                            $password = htmlspecialchars($_POST['password']);
                                            $password_2 = htmlspecialchars($_POST['password_2']);

                                            if(empty($password) || empty($password_2)){
                                                echo '<div class="alert alert-danger" role="alert">Silahkan isikan password baru!</div>';
                                            }elseif(strlen($password) < 8){
                                                echo '<div class="alert alert-danger" role="alert">Panjang password harus 8 karakter!</div>';
                                            }elseif($password != $password_2){
                                                echo '<div class="alert alert-warning" role="alert">Konfirmasi Password tidak sama!</div>';
                                            }else{
                                                $options = [
                                                    'cost' => 12
                                                ];
                                                $update_password = mysqli_query($connect, "UPDATE tb_users_1 SET password='".password_hash($password, PASSWORD_DEFAULT, $options)."' WHERE id_user=$id_user");
                                                if($update_password){
                                                    echo '<div class="alert alert-success" role="alert">Update Password berhasil</div>';
                                                    echo "<meta http-equiv=\"refresh\"content=\"2;URL=update-password.php\"/>";
                                                }else{
                                                    echo '<div class="alert alert-danger" role="alert">Update Password gagal!</div>';
                                                }
                                            }
                                        }
                                    ?>
                                       <form method="post">
                                            <h6 class="m-0 font-weight-bold">Password Baru:</h6>
                                            <input class="form-control mb-2" type="password" name="password">
                                            <h6 class="m-0 font-weight-bold">Konfirmasi Password:</h6>
                                            <input class="form-control mb-2" type="password" name="password_2">
                                            <input type="submit" name="update_password" class="btn btn-primary btn-block" value="Update">
                                       </form>
                                </div>
                            </div>

                        </div>


            <!-- /.container-fluid -->

            </div>
            <!-- End of Main Content -->

        </div>
        <!-- End of Content Wrapper -->

    </div>
    <!-- End of Page Wrapper -->


    <!-- Logout Modal-->
    <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="h3 text-center modal-body">Apakah anda yakin mau logout!</div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                    <a class="btn btn-primary" href="logout.php">Logout</a>
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

</body>

</html>