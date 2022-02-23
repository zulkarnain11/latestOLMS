<?php
session_start();
    if(isset($_GET['apply'])){
        include 'dbh.php';
        include 'function.inc.php';
      $hashId = $_GET['apply'];
      $applyId = base64_decode($hashId);

      //get userid
      $result = getReason($conn,$applyId);
      $row = mysqli_fetch_assoc($result);
      $userid = $row['userid'];

      $result2 = getEmail($conn, $userid);
      $email = mysqli_fetch_assoc($result2);
      $to = $email['email'];
      $url = "www.olms.amsxktd.edu.my";
      $subject = "Leave application decision";
      $message = "<b>Your leave application was not accepted.</b><br>";
      $message .= "Go to this website to view the application: <a href='".$url."'>".$url."</a>";
      
      $header = "From:noreply@amsxktd.edu.my \r\n";
      $header .= "MIME-Version: 1.0\r\n";
      $header .= "Content-type: text/html\r\n";

      $sql = "UPDATE leave_application
      SET leave_approval = 'not accepted'
      WHERE id = '$applyId';";

      if(mysqli_query($conn,$sql)){

        mail ($to,$subject,$message,$header);
        header("Location: ../luluspermohonan.php?msg=notaccepted");
      }
      else{
        header("Location: ../luluspermohonan.php?msg=error");
      }

    }else{
        header("Location: ../login.php");
    }