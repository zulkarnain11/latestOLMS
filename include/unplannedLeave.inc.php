<?php

if(isset($_POST['submit'])){
    include 'dbh.php';
    include 'function.inc.php';

    date_default_timezone_set('Asia/Kuala_Lumpur');
    $year = date('Y');
    $userid = $_POST['userid'];
    $total_date = $_POST['total_unplanned_leave'];
    $start_date = $_POST['unplanned_start_date'];
    $end_date = $_POST['unplanned_end_date'];

    $sql =  "INSERT INTO unplanned_leave (year,total_unplanned_leave, unplanned_start_date, unplanned_end_date, userid)
    VALUES ('$year','$total_date', '$start_date', '$end_date', '$userid');";

    if(mysqli_query($conn, $sql)){
        header("Location: ../unplannedLeave.php?msg=success");
    }else{
        header("Location: ../unplannedLeave.php?msg=failed");
    }


}else{
    header("Location: ../login.php");
}