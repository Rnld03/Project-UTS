<?php 
include 'connect.php';
session_start();
session_destroy();
setcookie('username','',time() - (3600 * 365 * 24 * 60 * 60));
echo '<script>window.location.href="login.php"</script>'
?>