<?php

$DBserverName = "localhost";
$DBUserName = "root";
$DBserverPwd = "";
$DBName = "sistemcuti";

//$DBserverName = "olms.amsxktd.edu.my";
//$DBUserName = "amsxktd_amsxktd";
//$DBserverPwd = "@ams2021ktd";
//DBName = "amsxktd_sistemcuti";

$conn = mysqli_connect($DBserverName,$DBUserName,$DBserverPwd,$DBName);

if (!$conn){
    die("Connect to database failed 2021".mysqli_connect_error());
}

//CHeck connection
//if($conn->connect_error){
//    die("Connection failed:".
//    $conn->connect_error);
//}else{
//    echo "no connection";
//}

