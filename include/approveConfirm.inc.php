<?php
session_start();
    if(isset($_GET['apply'])){
      include 'dbh.php';
      include 'function.inc.php';

      $managerUserid = $_SESSION['userid'];
      $hashId = $_GET['apply'];
      $applyId = base64_decode($hashId);


      $sql = "UPDATE leave_application
      SET leave_approval = 'approved'
      WHERE id = '$applyId';";

      if(mysqli_query($conn,$sql)){  
        $result = getDocumentName($conn,$applyId);
        $row = mysqli_fetch_assoc($result);
        date_default_timezone_set('Asia/Kuala_Lumpur');
        $currentDateTime = date("Y-m-d H:i:s");
        $year = date('Y');
        $yearApply = $row['year'];
        $applydate = $row['applydate'];
        $startdate = $row['startdate'];
        $enddate = $row['enddate'];
        $total_day = $row['total_leave_taken'];
        $leave_type = $row['leave_type'];
        $venue = $row['venue'];
        $organizer = $row['organizer'];
        $reason = $row['reason'];
        $document = $row['document'];
        $manager_name = $row['manager_name'];
        $userid = $row['userid'];

        //Annual Leave
        //Medical Leave
        //Hospitalization Leave
        //Outstation
        $result2 = getEmail($conn, $userid);
        $email = mysqli_fetch_assoc($result2);
        $to = $email['email'];
        $subject = "Leave application decision";
        $url = "www.olms.amsxktd.edu.my";
        $message = "<b>Your leave application was approved.</b>";
        $message .= "Go to this website to view the application: <a href='".$url."'>".$url."</a>";
        
        $header = "From:noreply@amsxktd.edu.my \r\n";
        $header .= "MIME-Version: 1.0\r\n";
        $header .= "Content-type: text/html\r\n";


        
        if($leave_type === "Annual Leave"){
            $annual_balance = getCurrentYearAnnualBalance($conn, $userid, $year);
            $annual = mysqli_fetch_assoc($annual_balance);
            $annualBalance = $annual['balance_annual_leave'];

            $newAnnualBalance = $annualBalance - $total_day;
            $sql2 = "UPDATE leave_available
            SET balance_annual_leave = '$newAnnualBalance'
            WHERE year = '$year' AND userid = '$userid';";
            mysqli_query($conn,$sql2);
          
        }
        if($leave_type === "Medical Leave"){
            $medical_balance = getCurrentYearMedicalBalance($conn, $userid, $year);
            $medical = mysqli_fetch_assoc($medical_balance);
            $medicalBalance = $medical['balance_medical_leave'];

            $newMedicalBalance = $medicalBalance - $total_day;
            $sql2 = "UPDATE medical_leave_available
            SET balance_medical_leave = '$newMedicalBalance'
            WHERE year = '$year' AND userid = '$userid';";
            mysqli_query($conn,$sql2);

        }
        if($leave_type === "Hospitalization Leave"){
            $hospitalization_balance = getCurrentYearHospitalizationBalance($conn, $userid, $year);
            $hospitalization = mysqli_fetch_assoc($hospitalization_balance);
            $hospitalizationBalance = $hospitalization['balance_hospitalisation_leave'];
            
            $newHospitalizationBalance = $hospitalizationBalance - $total_day;
            $sql2 = "UPDATE hospitalisation_leave
            SET balance_hospitalisation_leave = '$newHospitalizationBalance'
            WHERE year = '$year' AND userid = '$userid';";

            mysqli_query($conn,$sql2);
        }

        $sql3 = "INSERT INTO leave_application_approved (year,applydate,startdate,enddate,total_leave_taken,leave_type,venue,organizer,reason,document,manager_name,userid)
        VALUES ('$yearApply','$applydate','$startdate','$enddate','$total_day','$leave_type','$venue','$organizer','$reason','$document','$manager_name','$userid');";

        if(mysqli_query($conn,$sql3)){
            //merit untuk pelulus
           $manager_Merit = getMerit($conn, $managerUserid);
           $managerMerit = mysqli_fetch_assoc($manager_Merit);
           $meritManager = $managerMerit['merit'];

           $timestamp1 = strtotime($currentDateTime);
           $timestamp2 = strtotime($applydate);

           $hour = abs($timestamp1 - $timestamp2)/(60*60);
           $parseHour = (float)$hour;
           $managerHour = ceil($parseHour);

           $newMerit = '';
           //jika manager approve lebih dari 48 jam masa mohon
           if($managerHour > 48){
               $newMerit = $meritManager - 10;

               $sql4 = "UPDATE merit
               SET merit = '$newMerit'
               WHERE userid = '$managerUserid';";

               if(mysqli_query($conn,$sql4)){
                   $sql5 = "INSERT INTO merit_history (date,total_merit,userid)
                   VALUES ('$currentDateTime','$newMerit','$managerUserid');";

                   mysqli_query($conn,$sql5);
               }
           }else{
               $currentMerit = '';
               $newMerit = $meritManager + 10;
               if($newMerit >= 100){
                   $currentMerit = 100;
               }else{
                   $currentMerit = $newMerit;
               }

               $sql4 = "UPDATE merit
               SET merit = '$currentMerit'
               WHERE userid = '$managerUserid';";

               if(mysqli_query($conn,$sql4)){
                $sql5 = "INSERT INTO merit_history (date,total_merit,userid)
                VALUES ('$currentDateTime','$currentMerit','$managerUserid');";

                mysqli_query($conn,$sql5);
               }
           }

           //merit untuk staff
           $staff_Merit = getMerit($conn, $userid);
           $staffMerit = mysqli_fetch_assoc($staff_Merit);
           $meritStaff = $staffMerit['merit'];

           $startDateApply = $startdate . '' ."00:00:00";
           $timestampStaff1 = strtotime($startDateApply);
           $timestampStaff2 = strtotime($applydate);

           $hourStaff = abs($timestampStaff2 - $timestampStaff1)/(60*60);
           $parseHourStaff = (float)$hourStaff;
           $staffHour = ceil($parseHourStaff);

           $newMeritStaff = '';
           if($staffHour < 72){
            $newMeritStaff = $meritStaff - 10;

               $sql4 = "UPDATE merit
               SET merit = '$newMeritStaff'
               WHERE userid = '$userid';";

               if(mysqli_query($conn,$sql4)){
                $sql5 = "INSERT INTO merit_history (date,total_merit,userid)
                VALUES ('$applydate','$newMeritStaff','$userid');";

                if(mysqli_query($conn,$sql5)){
                    mail ($to,$subject,$message,$header);
                    header("Location: ../luluspermohonan.php?msg=approvedwithmerit");
                    exit();
                }
               }

           }else{
               $currentMeritStaff = '';
               $newMeritStaff = $meritStaff + 10;
               if($newMeritStaff >= 100){
                   $currentMeritStaff = 100;
               }else{
                   $currentMeritStaff = $newMeritStaff;
               }
                
                $sql4 = "UPDATE merit
                SET merit = '$currentMeritStaff'
                WHERE userid = '$userid';";

                if(mysqli_query($conn,$sql4)){
                $sql5 = "INSERT INTO merit_history (date,total_merit,userid)
                VALUES ('$applydate','$currentMeritStaff','$userid');";

                    if(mysqli_query($conn,$sql5)){
                        mail ($to,$subject,$message,$header);
                        header("Location: ../luluspermohonan.php?msg=approvedwithoutmerit");
                            exit();
                    }
                }
                   
              
           }

        }
      
        //header("Location: ../luluspermohonan.php?msg=approved");
      
        }else{
        header("Location: ../luluspermohonan.php?msg=error");
      }

    }else{
        header("Location: ../login.php");
    }

