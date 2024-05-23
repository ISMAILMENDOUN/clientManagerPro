<?php 
session_start();
setcookie("remember_email", $_SESSION['email'], time() + 3600, "/");
setcookie("remember_password", $_SESSION['password'], time() + 3600, "/");
header('Location:user.php');
?>