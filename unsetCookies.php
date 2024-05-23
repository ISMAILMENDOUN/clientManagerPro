<?php 
setcookie("remember_email", "", time() - 3600, "/");
setcookie("remember_password", "", time() - 3600, "/");
header('Location:user.php');
?>