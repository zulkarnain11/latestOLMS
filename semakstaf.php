<?php
session_start();

if(!isset($_SESSION["userid"])){
    header("Location: login.php");
}
$username = $_SESSION['username'];
$fullname = $_SESSION['fullname'];

include 'include/dbh.php';
include 'include/function.inc.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Check staff Page</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@500&display=swap"
     rel="stylesheet">
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container-fluid">
        <a class="navbar-brand">Staff leave records</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNavDropdown">
        <ul class="navbar-nav">
            <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                Action
            </a>
            <ul class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                <li><a class="dropdown-item" href="mohoncuti.php">Apply leave</a></li>
                <li><a class="dropdown-item" href="semakpermohonan.php">View the application</a></li>
                <?php
                $result = checkManagerName($conn,$fullname);
                if($row = mysqli_num_rows($result) > 0){
                    echo '
                    <li><a class="dropdown-item" href="luluspermohonan.php">Approval</a></li>
                    <li><a class="dropdown-item" href="semakstaf.php">Check staff</a></li>                  
                    ';
                }
                ?>
                <li><a class="dropdown-item" href="rekodcuti.php">Leave records</a></li>
                <li><a class="dropdown-item" href="leave_history.php">Leave history</a></li>
                <li><a class="dropdown-item" href="account.php">Account</a></li>
                <li><a class="dropdown-item" href="logout.php" style="color:#ff0000;">Log out</a></li>
            </ul>
            </li>
        </ul>
        </div>
    </div>
</nav>



    <div style="width:350px; margin: 2em auto;">
        <form action="semakstaf.php" method="POST">
            <label style="background-color: #188466;" class="p-1 mb-2 text-light">Staff name:</label>
            <br>
            <select class="form-select" aria-label="Default select example" name="userid">
                <option selected disabled>--Please select staff--</option>
                <?php
                $staffForManager = staffForManager($conn,$fullname);
                while ($staff = mysqli_fetch_assoc($staffForManager)){
                    echo "
                    <option value='".$staff['userid']."'>".$staff['fullname']."</option>
                    
                    ";
                }
                ?>
            </select><br>
            <button class="btn btn-primary" name="submit">Submit</button>
        </form>


        <?php
        if(isset($_POST['submit'])){

            $idstaff = $_POST['userid'];
            if($idstaff == null || $idstaff == "" || $idstaff == "--Please select staff--"){
              header("Location: semakstaf.php");
            }
            
            date_default_timezone_set('Asia/Kuala_Lumpur');
            $currentYear = date('Y');

           $picname = getProfilepicname($conn, $idstaff);
           $picName = mysqli_fetch_assoc($picname);

           $quotaCurrentYear = getCurrentYearQuota($conn,$currentYear, $idstaff);
           $quotaCurrent = mysqli_fetch_assoc($quotaCurrentYear);
            
           $totalAnnual = '';
           if(mysqli_num_rows($quotaCurrentYear) < 1){
             $totalAnnual = "-";
           }else{
             $totalAnnual = $quotaCurrent['total_annual_leave'];
           }

           $totalMedical = '';
           if(mysqli_num_rows($quotaCurrentYear) < 1){
             $totalMedical = "-";
           }else{
             $totalMedical = $quotaCurrent['total_medical_leave'];
           }

           $totalHospitalization = '';
           if(mysqli_num_rows($quotaCurrentYear) < 1){
            $totalHospitalization = "-";
           }else{
            $totalHospitalization = $quotaCurrent['total_hospitalization_leave'];
           }

           $currentYearAnnualBalance = getCurrentYearAnnualBalance($conn, $idstaff, $currentYear);

           $annualBalance = '';
           if(mysqli_num_rows($currentYearAnnualBalance) < 1){
            $annualBalance = "-";
           }else{
            $row = mysqli_fetch_assoc($currentYearAnnualBalance);
            $annualBalance = $row['balance_annual_leave'];
           }

           $currentYearMedicalBalance = getCurrentYearMedicalBalance($conn, $idstaff, $currentYear);
           $medicalBalance = '';
            if(mysqli_num_rows($currentYearMedicalBalance) < 1){
             $medicalBalance = "-";
            }else{
              $row = mysqli_fetch_assoc($currentYearMedicalBalance);
              $medicalBalance = $row['balance_medical_leave'];
            }

            $hospitalizationBalance = '';
            $currentYearHospitalizationBalance = getCurrentYearHospitalizationBalance($conn, $idstaff, $currentYear);
            if(mysqli_num_rows($currentYearHospitalizationBalance) < 1){
              $hospitalizationBalance = "-";
            }else{
              $row = mysqli_fetch_assoc($currentYearHospitalizationBalance);
              $hospitalizationBalance = $row['balance_hospitalisation_leave'];
            }

           echo "
           <table class='table' style='margin-top: 2em;'>
            <tbody>
              <tr>
                <td colspan='2'><img src='profilepic/".$picName['profilepic']."' alt='' width='150px'></td>
              </tr>
              <tr>
                <th colspan='2'>".$picName['fullname']."</th>
              </tr>
              <tr>
                <th scope='row'>Total annual leave: ".$currentYear.":</th>
                <td>".$totalAnnual."</td>
              </tr>
              <tr>
                <th scope='row'>Total medical leave: ".$currentYear.":</th>
                <td>".$totalMedical."</td>
              </tr>
              <tr>
                <th scope='row'>Total hospitalization leave: ".$currentYear.":</th>
                <td>".$totalHospitalization."</td>
              </tr>
              <tr>
                <th scope='row'>Balance annual leave: ".$currentYear.":</th>
                <td>".$annualBalance."</td>
              </tr> 
              <tr>
                <th scope='row'>Balance medical leave: ".$currentYear.":</th>
                <td>".$medicalBalance."</td>
              </tr> 
              <tr>
                <th scope='row'>Balance hospitalization leave: ".$currentYear.":</th>
                <td>".$hospitalizationBalance."</td>
              </tr>
            </tbody>
           </table>

           ";


        }
        
        ?>
    </div>
    


    <script src="bootstrap/js/bootstrap.min.js"></script>
    <script src="js/script.js"></script>
</body>
</html>