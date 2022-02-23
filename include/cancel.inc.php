<?php
session_start();

if(isset($_GET['apply'])){

    include 'dbh.php';
    include 'function.inc.php';

    $hashApplyId = $_GET['apply'];
    $applyId = base64_decode($hashApplyId);

    $sql = "DELETE FROM leave_application
    WHERE id = '$applyId';";

    $result = getDocumentName($conn,$applyId);

    $row = mysqli_fetch_assoc($result);

    $documentName = $row['document'];

    if(mysqli_query($conn,$sql)){
        $path = "../document/".$documentName."";
        unlink($path);

        header("Location: ../semakpermohonan.php?msg=cancelsuccess");
    }else{
        header("Location: ../semakpermohonan.php?msg=cancelfailed"); 
    }



}else{
    header("Location: ../login.php");
}