<?php
session_start();
if (isset($_POST["submit"])){

    require_once 'dbh.php';
    require_once 'function.inc.php';

    $adminUser = mysqli_real_escape_string($conn,$_POST["UserId"]);
    $adminpwd = mysqli_real_escape_string($conn,$_POST["UserPassword"]);



    //if (notMatch($conn, $adminUser, $adminpwd) !== false){
    //    header("Location: ../adminlogin.php?error=passwordnotmatch");
    //}
   
    $sql = "SELECT * FROM admin WHERE adminUsername = ?";
    $stmt = mysqli_prepare($conn, $sql);

    mysqli_stmt_bind_param($stmt, 's', $adminUser);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if(mysqli_num_rows($result) < 1){
        header("Location: ../adminlogin.php?error=usernamewrong");
        exit();
    }
    
    while($row = mysqli_fetch_assoc($result)){
        
        $user = $row["adminUsername"];
        $pwd = $row["adminPassword"];

        $verify = password_verify($adminpwd, $pwd);

        if($verify){
            $_SESSION["user"] = $adminUser;
            header("Location: ../adminPanel.php?loginSuccess");
            exit();
        }else{
            header("Location: ../adminlogin.php?error=passwordnotmatch");
            exit();
        }
        
    }
}else{
    header("Location: ../adminlogin.php?error=enterInput");
}

