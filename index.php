
<html>


<head>
<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>home</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/css/bootstrap.min.css" 
    integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <script src="https://kit.fontawesome.com/f124013f63.js" crossorigin="anonymous"></script>

</head>


<body class="bg-secondary">
    <h1 class="d-flex justify-content-center mt-5"><i class="fa-solid fa-people-roof"></i></h1>
    <h1 class="d-flex justify-content-center" > CLIENT MANAGER PRO</h1>
    <section class="login">
    <div class="loginForm w-25 bg-dark py-5 rounded mx-auto mt-5 d-flex flex-column justify-content-center align-items-center">
    <form  action="index.php" method="POST">
    <input class="rounded"name="lEmail" type="email" placeholder="Email"value="<?php echo isset($_COOKIE['remember_email']) ? htmlspecialchars($_COOKIE['remember_email']) : ''; ?>"><br><br>
    <input class="rounded" name="lPassword"type="password" placeholder="Password" value="<?php echo isset($_COOKIE['remember_password']) ? htmlspecialchars($_COOKIE['remember_password']) : ''; ?>"><br><br>
    <input class="mx-5 rounded btn-success"  type="submit" value="LogIn"><br>
    <a class="mx-5 btn-dark" href="index.php?signup=s">SignUp</a>
    </form>
    </div>
</section>
</body>
    </html>

    <?php
/**********************************************HANDLE WARNING******************************** */
error_reporting(0);
/***************************************HANDLE LOGIN ***************************************/

if($_POST['lEmail']&&$_POST['lPassword']){
$con=mysqli_connect("localhost","root","","clients");
$req="select * from user where email= ? and password= ?";
$login=$con->prepare($req);
$lEmail=$_POST['lEmail'];
$lPassword=$_POST['lPassword'];
$login->bind_param("ss",$lEmail,$lPassword);
$login->execute();

$loged=$login->get_result();
if($loged->num_rows==1){
$user=$loged->fetch_assoc();
//var_dump($user);
session_start();
$_SESSION['id']=$user['idUser'];
$_SESSION['firstName']=$user['firstName'];
$_SESSION['lastName']=$user['lastName'];
$_SESSION['email']=$user['email'];
$_SESSION['password']=$user['password'];
$_SESSION['role']=$user['role'];
//COOKIE_BEGIN
echo'<script>';
echo'if(confirm("Confirm Cookies")){window.location.href="setCookies.php";}';
echo'else{window.location.href="unsetCookies.php";}';
echo'</script>';
//COOKIE_END
//header("Location:user.php");



}
else{
echo'<script>alert("Email Or Password Is Wrong!!")</script>';

}


}

/***************************************HANDLE SIGNUP************************************ */
if($_GET['signup']&&$_GET['signup']==="s"){
echo'<script>document.querySelector(".login").style.display="none";</script>';
echo'<div class="signup w-25 bg-dark py-5 rounded mx-auto mt-5 d-flex flex-column justify-content-center align-items-center"><form action="index.php" method="POST">
<input class="rounded" name="lFirstName" type="text" placeholder="First Name"><br><br>
<input class="rounded" name="lLastName" type="text" placeholder="Last Name"><br><br>
<input class="rounded" name="lEmail" type="email" placeholder="Email"><br><br>
<input class="rounded" name="lPassword1"type="password" placeholder="Password"><br><br>
<input class="rounded" name="lPassword2"type="password" placeholder="Confirm Password"><br><br>
<input class="mx-5 rounded btn-success" type="submit" value="SignUp"><br>
<a class="mx-5 btn-dark" href="index.php">LogIn</a>
</form></div>';

}

if ($_SERVER["REQUEST_METHOD"] == "POST") {

if($_POST['lFirstName']&&$_POST['lLastName']&&$_POST['lEmail']&&$_POST['lPassword1']&&$_POST['lPassword2']){

if($_POST['lPassword1']===$_POST['lPassword2']){
$con=mysqli_connect("localhost","root","","clients");
$req="select count(*) from user where email=?";
$check=$con->prepare($req);
$check->bind_param("s",$_POST['lEmail']);
$check->execute();
$check->bind_result($count);
$check->store_result();
$check->fetch();
//var_dump($count);
if($count==0){
$insertUser="insert into user(firstName,lastName,email,password) values(?,?,?,?)";
$stmi=$con->prepare($insertUser);
$stmi->bind_param("ssss",$_POST['lFirstName'],$_POST['lLastName'],$_POST['lEmail'],$_POST['lPassword1']);
$stmi->execute();


$stmi->close();
}
else{

echo'<script>alert("Account Already Exist!!");</script>';

}  




}

else{

    echo'<script>alert("Passwords Do Not Match!!")</script>';

}

}



}

?>