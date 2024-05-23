<?php 
    session_start();
    $con = mysqli_connect("localhost", "root", "", "clients");
    if (mysqli_connect_errno()) {
        echo "Failed to connect to MySQL: " . mysqli_connect_error();
        exit();
    }
    /*************************************IMPORT CSV FOR ADMIN**************************************** */
    if($_SESSION['role']==="admin"){
    $query = "SELECT * FROM client";}
    /*************************************IMPORT CSV FOR USER*************************************** */
    else{
        $query = "SELECT * FROM client where idUser=".$_SESSION['id'];

    }
    $result = mysqli_query($con, $query);
    header('Content-Type: text/csv');
    header('Content-Disposition: attachment; filename="clients.csv"');
    $output = fopen('php://output', 'x'); 
    fputcsv($output, array('IDCLIENT', 'FIRST NAME', 'LAST NAME','REGISTRATION DATE','EMAIL','PHONE NUMBER','ADDRESS'));
    while ($row = mysqli_fetch_assoc($result)) {
        fputcsv($output, $row);
    }
    fclose($output);
    mysqli_close($con);
    exit;
    


?>