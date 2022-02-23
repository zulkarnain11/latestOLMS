<?php

if (isset($_POST['submit'])){

    include 'dbh.php';
    include 'function.inc.php';

    function generateRandomString($length) {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }
    
    
    $selector = generateRandomString(10);
    $token = generateRandomString(10);
    
    $url = "www.olms.amsxktd.edu.my/create-new-pass.php?selector=".$selector."&validate=".$token."";

    date_default_timezone_set('Asia/Kuala_Lumpur');
    $expire = date('U') + 1800;
    $userEmail = $_POST['email'];


    //delete existing token
    $sql = "DELETE FROM passwordReset WHERE pwdResetEmail = '$userEmail';";
    mysqli_query($conn,$sql);

    //insert into passwordreset
    $sql2 = "INSERT INTO passwordReset (pwdResetEmail,pwdResetSelector,pwdResetToken,pwdResetExpire) VALUES ('$userEmail','$selector','$token','$expire');";
    mysqli_query($conn,$sql2);



    $to = $userEmail;

    $subject = "Reset your password";

    $message = "<p>We received a password reset request. The link to reset your password is below. If you not make this request, you can ignore this email</p>";
    $message .= "<p> Your password reset link: <br>";
    $message .= "<a href='".$url."'>".$url."</a></p>";

    $header = "From:noreply@amsxktd.edu.my \r\n";
    $header .= "MIME-Version: 1.0\r\n";
    $header .= "Content-type: text/html\r\n";

    mail($to, $subject, $message, $header);

    header('Location: ../forgetpassword.php?msg=succes');

    


    /*
    $result = getPassword($conn,$to);
    if(mysqli_num_rows($result) < 1){
        header('Location: ../forgetpassword.php?msg=emailerror');
    }else{

        $row = mysqli_fetch_assoc($result);
        $pass = $row['userpassword'];
        $subject = "Forgotten password";
        $txt = "This is your current password:  ". $pass ."   Please change the password after logging in, to prevent problems";

        //$header  = "From: webmaster@example.com" . "\r\n" .
        //"CC: somebodyelse@example.com";

        $header = "From:noreply@amsxktd.edu.my \r\n";
        $header .= "MIME-Version: 1.0\r\n";
        $header .= "Content-type: text/html\r\n";

        mail($to,$subject,$txt,$header);
        header('Location: ../forgetpassword.php?msg=send');
    
    }*/

  
}else{
    header("Location: ../login.php");
}