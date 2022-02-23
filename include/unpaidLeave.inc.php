<?php

if(isset($_POST['submit'])){
    include 'dbh.php';
    include 'function.inc.php';

    date_default_timezone_set('Asia/Kuala_Lumpur');
    $year = date('Y');
    $userid = $_POST['userid'];
    $total_date = $_POST['total_unpaid_leave'];
    $start_date = $_POST['unpaid_start_date'];
    $end_date = $_POST['unpaid_end_date'];

    $sql =  "INSERT INTO unpaid_leave (year,total_unpaid_leave, unpaid_start_date, unpaid_end_date, userid)
    VALUES ('$year','$total_date', '$start_date', '$end_date', '$userid');";

    if(mysqli_query($conn, $sql)){
        header("Location: ../unpaidLeave.php?msg=success");
    }else{
        header("Location: ../unpaidLeave.php?msg=failed");
    }


}else{
    header("Location: ../login.php");
}