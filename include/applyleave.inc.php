<?php

if(isset($_POST['submit'])){
    include 'dbh.php';
    include 'function.inc.php';

    $filename = $_FILES["document"]["name"];
    $tempname = $_FILES["document"]["tmp_name"];
    $fileError = $_FILES["document"]["error"];
    $fileSize = $_FILES["document"]["size"];
        
    $fileExt = explode('.', $filename);
    $fileActualExt = strtolower(end($fileExt));

    $allowed = array('jpg', 'jpeg', 'png', 'pdf');

    date_default_timezone_set('Asia/Kuala_Lumpur');
    $year = date('Y');
    $applydate = date('Y-m-d');
    $applytime = date("H:i:s");
    $leave_start_date = $_POST['leave_start_date'];
    $leave_end_date = $_POST['leave_end_date'];
    $total_leave_taken = $_POST['total_leave_taken'];
    $leave_type = $_POST['leave_type'];
    $venue = $_POST['venue'];
    $organizer = $_POST['organizer'];
    $reason = $_POST['reason'];
    $userid = $_POST['userid'];
    $managerName = $_POST['managername'];

    $strReason = str_replace("'", '', $reason);
    $strVenue = str_replace("'" , "" , $venue);
    $strOrganizer = str_replace("'" , "", $organizer);

    $result2 = getManagerEmail($conn, $managerName);
    $email = mysqli_fetch_assoc($result2);
    $to = $email['email'];

    $url = "www.olms.amsxktd.edu.my";
    $subject = "Leave request";
    $message = "<b>A staff member has applied for leave please check in the website.</b><br>";
    $message .= "Go to this website to view the application: <a href='".$url."'>".$url."</a>";
      
    $header = "From:noreply@somedomain.com \r\n";
    $header .= "MIME-Version: 1.0\r\n";
    $header .= "Content-type: text/html\r\n";
    
    $start_time = $leave_start_date . ' ' ."00:00:00";
    $applydatetime = $applydate. ' ' .$applytime;
    $timestamp1 = strtotime($start_time);
    $timestamp2 = strtotime($applydatetime);
    $hourminute = abs($timestamp2 - $timestamp1)/(60*60);

    $parsehour = (float)$hourminute;
    $hour = ceil($parsehour);


    if($filename == ""){
        $sql = "INSERT INTO leave_application (year,applydate,startdate,enddate,total_leave_taken,leave_type,venue,organizer,reason,leave_approval,manager_name,available,userid)
        VALUE ('$year','$applydatetime','$leave_start_date','$leave_end_date','$total_leave_taken','$leave_type','$strVenue','$strOrganizer','$strReason','in review','$managerName',1,'$userid');";

        if(mysqli_query($conn, $sql)){
            mail ($to,$subject,$message,$header);
            header("Location: ../mohoncuti.php?msg=applicationsubmittedwithdoc");
           //echo "success";
        }else{
            header("Location: ../mohoncuti.php?msg=failwithoutdoc");
        }
    }else{
        if(in_array($fileActualExt, $allowed)){
            if($fileSize < 6000000){
                $fileNameNew = uniqid('', true).".".$fileActualExt;

                $folder = "../document/".$fileNameNew;

                if(move_uploaded_file($tempname, $folder)){

                    $sql = "INSERT INTO leave_application (year,applydate,startdate,enddate,total_leave_taken,leave_type,venue,organizer,reason,document,leave_approval,manager_name,available,userid)
                    VALUE ('$year','$applydatetime','$leave_start_date','$leave_end_date','$total_leave_taken','$leave_type','$strVenue','$strOrganizer','$strReason','$fileNameNew','in review','$managerName',1,'$userid');";

                    if(mysqli_query($conn,$sql)){
                        mail ($to,$subject,$message,$header);
                        header("Location: ../mohoncuti.php?msg=applicationsubmitted");
                       //echo "success with doc";
                    }else{
                        header("Location: ../mohoncuti.php?msg=failwithdoc");
                    }
                }else{
                    header("Location: ../mohoncuti.php?msg=errorhappen");
                }
            }else{
                header("Location: ../mohoncuti.php?msg=cannotsubmitfiletoobig");
            }
        }else{
            header("Location: ../mohoncuti.php?msg=filenotallowed");
        }
    }

   // echo $applydate."<br>";
   // echo $applytime."<br>";
   // echo $leave_start_date."<br>";
   // echo $leave_end_date."<br>";
   // echo $total_leave_taken."<br>";
   // echo $leave_type."<br>";
   // echo $venue."<br>";
   // echo $organizer."<br>";
   // echo $reason."<br>";
   // echo $userid."<br>";

   // echo $start_time."<br>";
   // echo $applydatetime."<br>";
   // echo $hourminute."<br>";

   // echo $parsehour."<br>";
   // echo $hour."<br>";
   // echo $merit."<br>";
   // echo $year;
   // echo $managerName;
}else{
    header("Location: ../login.php");
}