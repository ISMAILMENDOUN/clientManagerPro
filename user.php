<?php
/**********************************************HANDLE WARNING******************************** */
error_reporting(0);
/**********************************************HANDLE USER********************************** */
session_start();
if(isset($_SESSION['id'])){
    if($_SESSION['role']==="admin"){

        header("Location:admin.php");
    }
//var_dump($_SESSION['id']);
}
else{

    header("Location:index.php");
}
/************************************************************************************ */
?>
<html>
<head>
<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>user</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/css/bootstrap.min.css" 
    integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <script src="https://kit.fontawesome.com/f124013f63.js" crossorigin="anonymous"></script>

  </head>
  <body class="bg-secondary">
<h1 align="center" ><b><?php echo$_SESSION['firstName'];?></b></h1>
<form name ="f1" method="POST" action="user.php" align="center" >
<input class="rounded btn-success" type="submit" name="display" value="Display_Clients">
<input class="rounded btn-primary" type="submit" name="add" value="Add_Client" >
<input class="rounded btn-info" type="submit" name="import" value="Import_Csv" >
<input class="rounded btn-dark" type="submit" name="export" value="Export_Csv" >
<input class="rounded btn-danger" type="submit" name="logout" value="Logout" >
<br><br>
</form>


<?php

/*****************************************************HIDE WARNINGS***************************************** */
error_reporting(0);
/*****************************************CSV FORM********************************************************* */

function importCsv(){

echo'<form method="POST" action="user.php" align="center" enctype="multipart/form-data">

<input  name="imported" type="file"></input>
<input class="rounded btn-success" type="submit" value="Import">
</form>';


}
/*********************************UPDATE FORM************************************************************* */
function updateForm($id){
echo "<form class='mx-auto mt-5 bg-dark w-50 py-5 rounded' name='f2' method='POST' action='user.php' align='center' >
    <input class='rounded'type='text' placeholder='Client_FirstName' name='firstNameUp'>
    <input class='rounded' type='text' name='lastNameUp' placeholder='Client_LastNameUp' ><br><br>
    <input class='rounded' type='text' placeholder='Email' name='emailUp'>
    <input class='rounded' type='text' name='phoneUp' placeholder='Phone_Number' >
<br><br>
<textarea class='rounded' type='text' name='addressUp' placeholder='Address' rows='5' cols='40' ></textarea>

<br><br>
<input class='rounded btn-success' type='hidden' name='id' value=$id>
    <input type='submit'  value='Update' ></form>";}
    
/********************************DELETE OR UPDATE CLIENT ******************************************************/
$display=false;
if(isset($_GET['delete']) ) {
    $id = $_GET['delete'];
    $con = mysqli_connect("localhost", "root", "", "clients");
    $req1 = "DELETE FROM `client` WHERE idClient=?";
    $stm = $con->prepare($req1);
    $stm->bind_param("i", $id);
    $stm->execute();
    echo '<script>alert("Client With ID:' . $id . ' Had Been Deleted successfully!!");</script>';
    $display=true;
}


if(isset($_GET['update'])|| $_POST['id']) {
    $id = $_GET['update'];
    $id1=$_POST['id'];
    if(!$_POST['id']){
     updateForm($id);

    }
    $con = mysqli_connect("localhost", "root", "", "clients");
    //UPDATE FIRST NAME
    if($_POST['firstNameUp']){
    $fnUp=$_POST['firstNameUp'];
    $req1 = "update  `client` set firstName=? WHERE idClient=?";
    $stm = $con->prepare($req1);
    $stm->bind_param("si",$fnUp,$id1);
    $stm->execute();$display=true;
    echo '<script>alert("Client With ID:' . $id1 . ' Had Been Updated successfully!!");</script>';}
    //UPDATE LAST NAME
    if($_POST['lastNameUp']){
        $lnUp=$_POST['lastNameUp'];
        $req1 = "update  `client` set lastName=? WHERE idClient=?";
        $stm = $con->prepare($req1);
        $stm->bind_param("si",$lnUp,$id1);
        $stm->execute();$display=true;
        echo '<script>alert("Client With ID:' . $id1 . ' Had Been Updated successfully!!");</script>';}
    //UPDATE EMAIL
    if($_POST['emailUp']){
        $emUp=$_POST['emailUp'];
        $req1 = "update  `client` set email=? WHERE idClient=?";
        $stm = $con->prepare($req1);
        $stm->bind_param("si",$emUp,$id1);
        $stm->execute();$display=true;
        echo '<script>alert("Client With ID:' . $id1 . ' Had Been Updated successfully!!");</script>';}



    //UPDATE PHONE
    if($_POST['phoneUp']){
        $phUp=$_POST['phoneUp'];
        $req1 = "update  `client` set phone=? WHERE idClient=?";
        $stm = $con->prepare($req1);
        $stm->bind_param("si",$phUp,$id1);
        $stm->execute();$display=true;
        echo '<script>alert("Client With ID:' . $id1 . ' Had Been Updated successfully!!");</script>';}


    //UPDATE ADDRESS
    if($_POST['addressUp']){
        $adUp=$_POST['addressUp'];
        $req1 = "update  `client` set address=? WHERE idClient=?";
        $stm = $con->prepare($req1);
        $stm->bind_param("si",$adUp,$id1);
        $stm->execute();$display=true;
        echo '<script>alert("Client With ID:' . $id1 . ' Had Been Updated successfully!!");</script>';}
    
    
}

/***********************************************************ADD CLIENT*************************************** */

if(isset($_POST['add'])){
    
    echo "<form class='mx-auto mt-5 bg-dark w-50 py-5 rounded' name='f2' method='POST' action='user.php' align='center' >
    <input class='rounded' type='text' placeholder='Client_FirstName' name='firstName'>
    <input class='rounded' type='text' name='lastName' placeholder='Client_LastName' ><br><br>
    <input class='rounded' type='text' placeholder='Email' name='email'>
    <input class='rounded' type='text' name='phone' placeholder='Phone_Number' >
<br><br>
<textarea class='rounded' type='text' name='address' placeholder='Address' rows='5' cols='40' ></textarea>

<br><br>
    <input class='rounded btn-success' type='submit' name='AjouterB' value='Add_Client' ></form>";}
    
    if(isset($_POST['AjouterB'])){
    if($_POST['firstName']!="" && $_POST['lastName']!="" && $_POST['email']!=""&&$_POST['phone']!=""&&$_POST['address']!=""){
    $con=mysqli_connect("localhost","root","","clients");
    $fn=$_POST['firstName'];
    $ln=$_POST['lastName'];
    $e=$_POST['email'];
    $ph=$_POST['phone'];
    $ad=$_POST['address'];
    $dr=date('Y-m-d H:i:s');
    $id=$_SESSION['id'];
    $req3=mysqli_query($con,"insert into client(firstName,lastName,dateRegistration,email,phone,address,idUser) values('$fn','$ln','$dr','$e','$ph','$ad',$id)");
    $display=true;
    


}
    else {echo '<script type="text/javascript">alert("Fileds are required!!");</script>';}
    
    
    }

/*****************************************DISPLAY ALL CLIENTS*********************************************** */
if(isset($_POST['display'])||$display==true){
	
	
    $con=mysqli_connect("localhost","root","","clients");
    $req1=mysqli_query($con,"Select * from client where idUser=".$_SESSION['id']);
    echo'<table class="table table-dark table-striped w-50 mx-auto">
    ';
    //echo'<table border=3 width="60%" align="center" >';
    echo'<tr>';
    echo'<td width="30%" ><b>IdClient</b></td>';
    echo'<td width="30%"><b>First Name</b></td>';
    echo '<td width="30%"><b>Last Name</b></td>';
    echo '<td width="30%"><b>Email</b></td>';
    echo '<td width="30%"><b>Phone</b></td>';
    echo '<td width="30%"><b>Address</b></td>';
    echo '<td width="30%"><b>Registration Date</b></td>';
    echo '<td width="30%"><b>Delete</b></td>';
    echo '<td width="30%"><b>Edit</b></td>';
    echo'</tr>';
   // echo'</table>';
    while($row=mysqli_fetch_array($req1)){
    //echo'<table class="table table-dark table-striped">';
    //echo'<table border=3 width="60%" align="center">';
    echo'<tr>';
    echo'<td width="30%" >'.$row[0].'</td>';
    echo'<td width="30%">'.$row[1].'</td>';
    echo '<td width="30%">'.$row[2].'</td>';
    echo '<td width="30%">'.$row[4].'</td>';
    echo '<td width="30%">'.$row[5].'</td>';
    echo '<td width="30%">'.$row[6].'</td>';
    echo '<td width="30%">'.$row[3].'</td>';
    echo '<td width="30%"><a href="user.php?delete='.$row[0].'"style="color:red"><i class="fa-solid fa-trash"></i></a></td>';
    echo '<td width="30%"><a href="user.php?update='.$row[0].'"style="color:green"><i class="fa-solid fa-pen-nib"></i></a></td>';
    echo'</tr>';
    //echo'</table>';
}
echo'</table>'; 
    }


    /*******************************************************IMPORT CSV********************************** ***/

if($_POST['import']){
importCsv();
}

if(isset($_FILES['imported'])){
$importedCsv=$_FILES['imported']['tmp_name'];
//var_dump($importedCsv);
$read = fopen($importedCsv, "r");
$con = mysqli_connect("localhost", "root", "", "clients");
while (($data = fgetcsv($read)) !== false) {
    $req="select count(*) from client where firstName=? and lastName=? and email=? ";
    $check=$con->prepare($req);
    $check->bind_param("sss",$data[0],$data[1],$data[3]);
    $check->execute();
    $check->bind_result($count);
    $check->store_result();
    $check->fetch();
    var_dump($count);
if($count==0){
    $insertData="insert into client(firstName,lastName,dateRegistration,email,phone,address,idUser) values(?,?,?,?,?,?,?)";
    $stmi=$con->prepare($insertData);
    $stmi->bind_param("ssssssi",$data[0],$data[1],$data[2],$data[3],$data[4],$data[5],$_SESSION['id']);
    $stmi->execute();


$stmi->close();
}   
    }
   
    echo'<script>alert("Imported Successfully!!")</script>';
}




    
    /*******************************************************EXPORT CSV*********************************** */
    if($_POST['export']){

header('Location:exportData.php');

    }


    /******************************************LOGOUT*****************************************************/
    
        
    if(isset($_POST['logout'])){
        session_destroy();
        header('location:index.php');
        
    }
    
    /******************************************************** ********************************************/

?>



</html>