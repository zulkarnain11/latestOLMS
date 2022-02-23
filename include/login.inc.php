<?php
session_start();
/* user dan password input akan di validate dengan database */
if (isset($_POST['submit'])){

    require_once 'dbh.php';
    require_once 'function.inc.php';
    
    $icnumber = mysqli_real_escape_string($conn,$_POST['ic']);
    $password = mysqli_real_escape_string($conn,$_POST['UserPassword']);

    //if (notMatchLogin($conn, $username, $password) !== false){
    //    header("Location: ../login.php?error=passwordnotmatch");
    //}

    if(is_numeric($ic) != 1){
        header("Location: ../login.php?error=idnotnumeric");
    }

    $ic = str_replace("-", "", $icnumber);
    $sql = "SELECT userid,ic,username,userpassword,fullname,manager_name,available FROM user WHERE ic = ?";

    $stmt = mysqli_prepare($conn,$sql);
    mysqli_stmt_bind_param($stmt, 's', $ic);
    mysqli_stmt_execute($stmt);

    $result = mysqli_stmt_get_result($stmt);
    
    while($row = mysqli_fetch_assoc($result)){
        $useriddatabase = $row['userid'];
        $usernamedatabase = $row["username"];
        $usericdatabase = $row['ic'];
        $userpassworddatabase = $row['userpassword'];
        $fullnameDatabase = $row['fullname'];
        $managerDatabase = $row['manager_name'];
        $available = (int)$row['available'];

        if($available === 1){
           $verify = password_verify($password, $userpassworddatabase);
           if($verify){
            
            $_SESSION["userid"] = $useriddatabase;
            $_SESSION["username"] = $usernamedatabase;
            $_SESSION["fullname"] = $fullnameDatabase;
            $_SESSION["manager_name"] = $managerDatabase;
            
            header("Location: ../index.php?msgloginSuccess");
           }else{
               header("Location: ../login.php?error=passwordnotmatch");
           } 
        }else{
            header("Location: ../login.php?error=inputnotmatch");
        }
        
        //if($usericdatabase === $ic && $userpassworddatabase === $password && $available === 1 ){
        //    session_start();
         //   $_SESSION["userid"] = $useriddatabase;
         //   $_SESSION["username"] = $usernamedatabase;
        //    $_SESSION["fullname"] = $fullnameDatabase;
         //   $_SESSION["manager_name"] = $managerDatabase;
            
         //   header("Location: ../index.php?msg=loginSuccess");
                   
        //}else{
         //   header("Location: ../login.php?error=inputnotmatch");
        //}                    
        
    }

}else{
    header("Location: ../login.php");
}