<?php

if(isset($_POST['submit'])){
    include 'dbh.php';
    include 'function.inc.php';

    date_default_timezone_set('Asia/Kuala_Lumpur');
    $year = date('Y');
    $userid = $_POST['userid'];
    $total_date = $_POST['total_maternity_leave'];
    $start_date = $_POST['maternity_start_date'];
    $end_date = $_POST['maternity_end_date'];

    $sql =  "INSERT INTO maternity_leave (year,total_maternity_leave, maternity_start_date, maternity_end_date, userid)
    VALUES ('$year','$total_date', '$start_date', '$end_date', '$userid');";

    if(mysqli_query($conn, $sql)){
        header("Location: ../maternityLeave.php?msg=success");
    }else{
        header("Location: ../maternityLeave.php?msg=failed");
    }


}else{
    header("Location: ../login.php");
}