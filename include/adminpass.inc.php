<?php
session_start();

$username = $_SESSION['user'];
if(isset($_POST['submit'])){

    include 'dbh.php';
    include 'function.inc.php';

    $password = mysqli_real_escape_string($conn,$_POST["password"]);
    $repassword = mysqli_real_escape_string($conn,$_POST["repassword"]);

    if(empty($password) || empty($repassword)){
        header("Location: ../admin-account.php?msg=inputEmpty");
    }

    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    $sql = "UPDATE admin SET adminPassword = ? WHERE adminUsername = ?;";

    $stmt = mysqli_prepare($conn,$sql);

    mysqli_stmt_bind_param($stmt, 'ss', $hashedPassword, $username);

    if(mysqli_stmt_execute($stmt)){
        header("Location: ../admin-account.php?msg=succesupdate");
    }else{
        header("Location: ../admin-account.php?msg=error");
    }

}