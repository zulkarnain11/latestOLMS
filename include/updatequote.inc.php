<?php

if(isset($_POST['update'])){

    include 'dbh.php';
    include 'function.inc.php';

    $year = $_POST['year'];
    $annual_leave = $_POST['annual_leave'];
    $hospitalisation_leave = $_POST['hospitalisationleave'];
    $medical_leave = $_POST['medical_leave'];
    $userid = $_POST['userid'];

    $yearleavequota = getYear($conn,$userid,$year);
    if(mysqli_num_rows($yearleavequota) < 1){
        $sql = "INSERT INTO leave_quota (year,total_annual_leave,total_medical_leave,total_hospitalization_leave,userid)
        VALUES ('$year','$annual_leave','$medical_leave','$hospitalisation_leave','$userid');";

        if(mysqli_query($conn,$sql)){
            $sql2 = "INSERT INTO leave_available (year,balance_annual_leave,userid)
            VALUES ('$year','$annual_leave','$userid');";

            if(mysqli_query($conn,$sql2)){
                $sql3 = "INSERT INTO medical_leave_available (year,balance_medical_leave,userid)
                VALUES ('$year','$medical_leave','$userid');";

                if(mysqli_query($conn, $sql3)){
                    $sql4 = "INSERT INTO hospitalisation_leave (year,balance_hospitalisation_leave,userid)
                    VALUES ('$year','$hospitalisation_leave','$userid');";

                    if(mysqli_query($conn,$sql4)){
                        header("Location: ../leavequota.php?msg=Inserthospitalsucces");
                    }else{
                        header("Location: ../leavequota.php?msg=inserthospitalfailed");
                    }
                }else{
                    header("Location: ../leavequota.php?msg=insertmedicalfailed");
                }
            }else{
                header("Location: ../leavequota.php?msg=insertleavefailed");
            }

        }else{
            header("Location: ../leavequota.php?msg=insertquotafail");
        }
    }else if(mysqli_num_rows($yearleavequota) > 0){
        $sql = "UPDATE leave_quota
        SET total_annual_leave = '$annual_leave', total_medical_leave = '$medical_leave', total_hospitalization_leave = '$hospitalisation_leave' 
        WHERE userid = '$userid' AND year = '$year';";

        if(mysqli_query($conn, $sql)){
           $yearLeaveAvailable = getYearLeaveAvailable($conn, $userid, $year);
           if(mysqli_num_rows($yearLeaveAvailable) < 1){
              $sql = "INSERT INTO leave_available (year,balance_annual_leave,userid)
              VALUES ('$year','$annual_leave','$userid');";

              if(!mysqli_query($conn,$sql)){
                header("Location: ../leavequota.php?msg=insertleave1failed");
              }
           }else{
               $sql = "UPDATE leave_available
               SET balance_annual_leave = '$annual_leave'
               WHERE year = '$year' AND userid = '$userid';";

               if(!mysqli_query($conn,$sql)){
                 header("Location: ../leavequota.php?msg=updateleave1failed");
               }
           }

           $yearMedicalAvailable = getYearMedicalAvailable($conn, $userid, $year);
           if(mysqli_num_rows($yearMedicalAvailable) < 1){
            $sql = "INSERT INTO medical_leave_available (year,balance_medical_leave,userid)
            VALUES ('$year','$medical_leave','$userid');";

            if(!mysqli_query($conn,$sql)){
                header("Location: ../leavequota.php?msg=insertmedical1failed");
            }
           }else{
            $sql = "UPDATE medical_leave_available
            SET balance_medical_leave = '$medical_leave'
            WHERE year = '$year' AND userid = '$userid';";

            if(!mysqli_query($conn,$sql)){
                header("Location: ../leavequota.php?msg=updatemedical1failed");
            }
           }

           $yearHospitalizationAvailable = getYearHospitalizationAvailable($conn, $userid, $year);

           if(mysqli_num_rows($yearHospitalizationAvailable) < 1){
            $sql = "INSERT INTO hospitalisation_leave (year,balance_hospitalisation_leave,userid)
            VALUES ('$year','$hospitalisation_leave','$userid');";

            if(!mysqli_query($conn,$sql)){
                header("Location: ../leavequota.php?msg=Inserthospital1success");
            }
           }else{
            $sql = "UPDATE hospitalisation_leave
            SET balance_hospitalisation_leave = '$hospitalisation_leave'
            WHERE year = '$year' AND userid = '$userid';";

            if(mysqli_query($conn,$sql)){
                header("Location: ../leavequota.php?msg=updatesuccess");
            }else{
                header("Location: ../leavequota.php?msg=updatehospital1failed");
            }
           }
        }else{
            header("Location: ../leavequota.php?msg=updatequotafailed");
        }
    }
}else{
    header("Location: ../login.php");
}