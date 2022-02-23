<?php

if(isset($_POST['submit'])){
    include 'dbh.php';
    include 'function.inc.php';

    date_default_timezone_set('Asia/Kuala_Lumpur');
    $year = date('Y');
    $userid = $_POST['userid'];
    $total_date = $_POST['total_compassionate_leave'];
    $start_date = $_POST['compassionate_start_date'];
    $end_date = $_POST['compassionate_end_date'];

    $sql =  "INSERT INTO compassionate_leave (year,total_compassionate_leave, compassionate_start_date, compassionate_end_date, userid)
    VALUES ('$year','$total_date', '$start_date', '$end_date', '$userid');";

    if(mysqli_query($conn, $sql)){
        header("Location: ../compassionateLeave.php?msg=success");
    }else{
        header("Location: ../compassionateLeave.php?msg=failed");
    }


}else{
    header("Location: ../login.php");
}