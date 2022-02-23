<?php
session_start();

if(!isset($_SESSION["userid"])){
    header("Location: login.php");
}
$username = $_SESSION['username'];
$fullname = $_SESSION['fullname'];
$userid = $_SESSION['userid'];

include 'include/dbh.php';
include 'include/function.inc.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Leave records Page</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@500&display=swap"
     rel="stylesheet">
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container-fluid">
        <a class="navbar-brand text-secondary" href="account.php"><img src="icon/user.svg" width="20"> <?php echo $username;?></a>
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

    <div class="title-function">
        <h1>Leave records</h1>
    </div>

    <div style="width:350px; margin: 2em auto; background-color: #adb5bd;">

    <?php
    date_default_timezone_set('Asia/Kuala_Lumpur');
    $currentyear = date('Y');
    $lastyear = $currentyear - 1;
    
    ?>
        <table class="table" style="margin-top: 2em;">
            <tbody>
                <tr style="background-color: #56ce56;">
                    
                    <th scope="row">Balance annual leave: <?php echo $lastyear;?>: </th>
                    <td><?php
                    $lastYearAnnualBalance = getLastYearAnnualBalance($conn, $userid, $lastyear);
                    if(mysqli_num_rows($lastYearAnnualBalance) < 1){
                        echo "-";
                    }else{
                        $row = mysqli_fetch_assoc($lastYearAnnualBalance);
                        echo $row['balance_annual_leave'];
                    }
                    ?></td>
                </tr>
                <?php
                $quotaCurrentYear = getCurrentYearQuota($conn,$currentyear, $userid);
                $quotaCurrent = mysqli_fetch_assoc($quotaCurrentYear);
                ?>
                <tr style="background-color: #40b8e8;">
                    <th scope="row">Total annual leave: <?php echo $currentyear;?>:</th>
                    <td><?php
                    if(mysqli_num_rows($quotaCurrentYear) < 1){
                        echo "-";
                    }else{
                        echo $quotaCurrent['total_annual_leave'];
                    }
                    ?></td>
                </tr>
                <tr style="background-color: #40b8e8;">
                    <th scope="row">Total medical leave: <?php echo $currentyear;?>:</th>
                    <td colspan="2"><?php
                    if(mysqli_num_rows($quotaCurrentYear) < 1){
                        echo "-";
                    }else{
                        echo $quotaCurrent['total_medical_leave'];
                    }
                    ?></td>
                </tr>
                <tr style="background-color: #40b8e8;">
                    <th scope="row">Total hospitalization leave: <?php echo $currentyear;?>:</th>
                    <td colspan="2"><?php
                    if(mysqli_num_rows($quotaCurrentYear) < 1){
                        echo "-";
                    }else{
                        echo $quotaCurrent['total_hospitalization_leave'];
                    }
                    ?></td>
                </tr>
                <tr style="background-color: #ffa6a6;">
                    <th scope="row">Balance annual leave: <?php echo $currentyear;?>:</th>
                    <td colspan="2">
                    <?php
                    $currentYearAnnualBalance = getCurrentYearAnnualBalance($conn, $userid, $currentyear);
                    if(mysqli_num_rows($currentYearAnnualBalance) < 1){
                        echo "-";
                    }else{
                        $row = mysqli_fetch_assoc($currentYearAnnualBalance);
                        echo $row['balance_annual_leave'];
                    }
                    ?>
                    </td>
                </tr>
                <tr style="background-color: #ffa6a6;">
                    <th scope="row">Balance medical leave: <?php echo $currentyear;?>:</th>
                    <td colspan="2">
                    <?php
                    $currentYearMedicalBalance = getCurrentYearMedicalBalance($conn, $userid, $currentyear);
                    if(mysqli_num_rows($currentYearMedicalBalance) < 1){
                        echo "-";
                    }else{
                        $row = mysqli_fetch_assoc($currentYearMedicalBalance);
                        echo $row['balance_medical_leave'];
                    }
                    ?>
                    </td>
                </tr>
                <tr style="background-color: #ffa6a6;">
                    <th scope="row">Balance hospitalization leave: <?php echo $currentyear;?>:</th>
                    <td colspan="2">
                    <?php
                    $currentYearHospitalizationBalance = getCurrentYearHospitalizationBalance($conn, $userid, $currentyear);
                    if(mysqli_num_rows($currentYearHospitalizationBalance) < 1){
                        echo "-";
                    }else{
                        $row = mysqli_fetch_assoc($currentYearHospitalizationBalance);
                        echo $row['balance_hospitalisation_leave'];
                    }
                    ?>
                    </td>
                </tr>
                
            </tbody>
        </table>
    </div>
    


    <script src="bootstrap/js/bootstrap.min.js"></script>
    <script src="js/script.js"></script>
</body>
</html>