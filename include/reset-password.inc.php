<?php

if(isset($_POST['reset-password'])){

    $selector = $_POST['selector'];
    $validator = $_POST['validate'];
    $pass = $_POST['pwd'];
    $repass = $_POST['repwd'];

    if(empty($pass) || empty($repass)){
        header("Location: ../login.php?msg=startover");
    }


    date_default_timezone_set('Asia/Kuala_Lumpur');

    $currentDate = date('U');

    include 'dbh.php';

    $sql = "SELECT * FROM passwordReset 
    WHERE pwdResetSelector = '$selector' AND pwdResetExpire >= '$currentDate';";

    $result = mysqli_query($conn,$sql);

    if(mysqli_num_rows($result) < 1){
        header('Location: ../forgetpassword.php?msg=rowfetch');
    }

    $row = mysqli_fetch_assoc($result);

    $tokenDatabase = $row['pwdResetToken'];
    $tokenEmail = $row['pwdResetEmail'];

    if($tokenDatabase !== $validator){
        echo "You need re-submit your reset request. - ";
        echo "tokencheck";
        exit();
    }elseif($tokenDatabase === $validator){
        $sql2 = "SELECT * FROM user WHERE email = '$tokenEmail';";
        $result2 = mysqli_query($conn,$sql2);

        if(mysqli_num_rows($result2) < 1){
            echo "There was an error!";
            exit();
        }else{
            $newHashedPass = password_hash($pass, PASSWORD_DEFAULT);
            $sql3 = "UPDATE user
            SET userpassword = '$newHashedPass'  WHERE email = '$tokenEmail';";

            $result3 = mysqli_query($conn,$sql3);

            if($result3){
                $sql4 = "DELETE FROM passwordReset WHERE pwdResetEmail = '$tokenEmail';";
                if(mysqli_query($conn,$sql4)){
                    header("Location: ../login.php?msg=passwordUpdate");
                }else{
                    header('Location: ../forgetpassword.php?msg=passwordError');
                }
            }
            


        }

    }


}else{
    header("Location: ../login.php");
}