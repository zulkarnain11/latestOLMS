<?php
session_start();
$userid = $_SESSION['userid'];

if(isset($_POST['submit'])){
    include 'dbh.php';
    $pass = mysqli_real_escape_string($conn,$_POST["password"]);
    $repass = mysqli_real_escape_string($conn,$_POST["repassword"]);

    if($pass != $repass){
        header("Location: ../account.php?msg=passnotmatch");
    }else if($pass === $repass){
        $hashPassword = password_hash($pass,PASSWORD_DEFAULT);
        $sql = "UPDATE user
        SET userpassword = '$hashPassword'
        WHERE userid = '$userid';";

        if(mysqli_query($conn, $sql)){
            header("Location: ../account.php?msg=changesuccess");
        }else{
            header("Location: ../account.php?msg=changefailed");
        }

    }


}else{
    header("Location: ../login.php");
}