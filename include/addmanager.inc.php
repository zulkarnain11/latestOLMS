<?php

if (isset($_POST['submit'])){

    include 'dbh.php';
    include 'function.inc.php';

    $userid = $_POST['userid'];
    $managerName = $_POST['managername'];

    if($managerName == ""){
        header("Location: ../managersetting.php?msg=emptymanager");
    }else{
        $sql = "UPDATE user
        SET manager_name = '$managerName'
        WHERE userid = '$userid';";

        if(mysqli_query($conn, $sql)){
           header("Location: ../managersetting.php?msg=addmanagersuccess"); 
        }else{
          header("Location: ../managersetting.php?msg=addmanagerfail"); 
        }
    }

}else{
    header("Location: ../login.php");
}