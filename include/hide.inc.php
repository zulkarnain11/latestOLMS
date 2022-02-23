<?php
session_start();

if(isset($_GET['apply'])){

    include "dbh.php";
    include "function.inc.php";

    $hashApplyId = $_GET['apply'];
    $applyId = base64_decode($hashApplyId);

    $sql = "UPDATE leave_application
    SET available = 0
    WHERE id = '$applyId';";

    if(mysqli_query($conn,$sql)){
        header("Location: ../semakpermohonan.php?msg=hidesuccess");
    }else{
        header("Location: ../semakpermohonan.php?msg=hidefailed");
    }
}else{
    header("Location: ../login.php");
}