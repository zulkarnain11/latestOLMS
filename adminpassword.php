<?php


///retest
include "include/dbh.php";
$pass = "admin123";
$hash = password_hash($pass, PASSWORD_DEFAULT);

$sql = "UPDATE admin SET adminPassword = '$hash' WHERE adminUsername = 'admin123';";

if(mysqli_query($conn, $sql)){
    echo 'UPDATE SUCCESS';
}else{
    echo 'Error';
}