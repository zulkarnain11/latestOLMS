<?php

if(isset($_POST['submit'])){
    include 'dbh.php';
    include 'function.inc.php';

    date_default_timezone_set('Asia/Kuala_Lumpur');
    $year = date('Y');
    $userid = $_POST['userid'];
    $total_date = $_POST['total_studies_leave'];
    $start_date = $_POST['studies_start_date'];
    $end_date = $_POST['studies_end_date'];

    $sql =  "INSERT INTO studies_leave (year,total_studies_leave, studies_start_date, studies_end_date, userid)
    VALUES ('$year','$total_date', '$start_date', '$end_date', '$userid');";

    if(mysqli_query($conn, $sql)){
        header("Location: ../studiesLeave.php?msg=success");
    }else{
        header("Location: ../studiesLeave.php?msg=failed");
    }


}else{
    header("Location: ../login.php");
}