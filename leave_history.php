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
    <title>Leave History Page</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300&display=swap" rel="stylesheet">
    <style>
         table{
    display: block;
    overflow-x: auto;
}
th{
    padding: 0 1em;
    font-weight: 600;
    width: 300px;
}
td{
    padding: 0.5em 1em;
    vertical-align: top;
    font-size: small;
}
     </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container-fluid">
        <a class="navbar-brand">Leave application history</a>
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

    <?php
    date_default_timezone_set('Asia/Kuala_Lumpur');
    $currentYear = date('Y');
    ?>
<div class="tb-container">
    <p class="tb-title">Annual Leave : <?php echo $currentYear;?></p>
    <div class="table-responsive-sm">
      <table class="table table-sm">
        <thead>
            <tr>
                <th>Total day</th>
                <th>Start date</th>
                <th>End date</th>
                <th>Manager</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $annual_history = annualHistory($conn,$userid,$currentYear);
            if(mysqli_num_rows($annual_history) < 1){
                echo '
                <tr>
                  <td style="text-align:center;" colspan="4">-</td>
                </tr>
                ';
            }else{
                while($annual = mysqli_fetch_assoc($annual_history)){
                echo '
                <tr>
                  <td>'.$annual['total_leave_taken'].'</td>
                  <td>'.$annual['startdate'].'</td>
                  <td>'.$annual['enddate'].'</td>
                  <td>'.$annual['manager_name'].'</td>
                </tr>
                ';
                }
            }

            ?>
            
        </tbody>
      </table>
    </div>
    <br>
    <p class="tb-title">Medical Leave : <?php echo $currentYear;?></p>
    <div class="table-responsive-sm">
      <table class="table table-sm">
        <thead>
            <tr>
                <th>Total day</th>
                <th>Start date</th>
                <th>End date</th>
                <th>Manager</th>
            </tr>
        </thead>
        <tbody>
        <?php
            $medical_history = medicalHistory($conn,$userid,$currentYear);
            if(mysqli_num_rows($medical_history) < 1){
                echo '
                <tr>
                  <td style="text-align:center;" colspan="4">-</td>
                </tr>
                ';
            }else{
                while($medical = mysqli_fetch_assoc($medical_history)){
                echo '
                <tr>
                  <td>'.$medical['total_leave_taken'].'</td>
                  <td>'.$medical['startdate'].'</td>
                  <td>'.$medical['enddate'].'</td>
                  <td>'.$medical['manager_name'].'</td>
                </tr>
                ';
                }
            }

            ?>
        </tbody>
      </table>
    </div>

    <br>

    <p class="tb-title">Hospitalization Leave : <?php echo $currentYear;?></p>
    <div class="table-responsive-sm">
      <table class="table table-sm">
        <thead>
            <tr>
                <th>Total day</th>
                <th>Start date</th>
                <th>End date</th>
                <th>Manager</th>
            </tr>
        </thead>
        <tbody>
        <?php
            $hospitalization_history = hospitalizationHistory($conn,$userid,$currentYear);
            if(mysqli_num_rows($hospitalization_history) < 1){
                echo '
                <tr>
                  <td style="text-align:center;" colspan="4">-</td>
                </tr>
                ';
            }else{
                while($hospital = mysqli_fetch_assoc($hospitalization_history)){
                echo '
                <tr>
                  <td>'.$hospital['total_leave_taken'].'</td>
                  <td>'.$hospital['startdate'].'</td>
                  <td>'.$hospital['enddate'].'</td>
                  <td>'.$hospital['manager_name'].'</td>
                </tr>
                ';
                }
            }

            ?>
            
        </tbody>
      </table>
    </div>

    <br>

    <p class="tb-title">Outstation Leave : <?php echo $currentYear;?></p>
    <div class="table-responsive-sm">
      <table class="table table-sm">
        <thead>
            <tr>
                <th>Total day</th>
                <th>Start date</th>
                <th>End date</th>
            </tr>
        </thead>
        <tbody>
        <?php
            $outstation_history = outstationHistory($conn,$userid,$currentYear);
            if(mysqli_num_rows($outstation_history) < 1){
                echo '
                <tr>
                  <td style="text-align:center;" colspan="3">-</td>
                </tr>
                ';
            }else{
                while($outstation = mysqli_fetch_assoc($outstation_history)){
                echo '
                <tr>
                  <td>'.$outstation['total_leave_taken'].'</td>
                  <td>'.$outstation['startdate'].'</td>
                  <td>'.$outstation['enddate'].'</td>
                </tr>
                ';
                }
            }

            ?>
            
        </tbody>
      </table>
    </div>

    <br>
    <p class="tb-title">Compassionate Leave : <?php echo $currentYear;?></p>
    <div class="table-responsive-sm">
      <table class="table table-sm">
        <thead>
            <tr>
                <th>Total day</th>
                <th>Start date</th>
                <th>End date</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $compassionate_history = compassionateHistory($conn,$userid,$currentYear);
            if(mysqli_num_rows($compassionate_history) < 1){
                echo '
                <tr>
                  <td style="text-align:center;" colspan="3">-</td>
                </tr>
                ';
            }else{
                while($compassionate = mysqli_fetch_assoc($compassionate_history)){
                echo '
                <tr>
                  <td>'.$compassionate['total_compassionate_leave'].'</td>
                  <td>'.$compassionate['compassionate_start_date'].'</td>
                  <td>'.$compassionate['compassionate_end_date'].'</td>
                </tr>
                ';
                }
            }
            ?>
            
        </tbody>
      </table>
    </div>

    <br>

    <p class="tb-title">Maternity Leave : <?php echo $currentYear;?></p>
    <div class="table-responsive-sm">
      <table class="table table-sm">
        <thead>
            <tr>
                <th>Total day</th>
                <th>Start date</th>
                <th>End date</th>
            </tr>
        </thead>
        <tbody>
        <?php
            $maternity_history = maternityHistory($conn,$userid,$currentYear);
            if(mysqli_num_rows($maternity_history) < 1){
                echo '
                <tr>
                  <td style="text-align:center;" colspan="3">-</td>
                </tr>
                ';
            }else{
                while($maternity = mysqli_fetch_assoc($maternity_history)){
                echo '
                <tr>
                  <td>'.$maternity['total_maternity_leave'].'</td>
                  <td>'.$maternity['maternity_start_date'].'</td>
                  <td>'.$maternity['maternity_end_date'].'</td>
                </tr>
                ';
                }
            }
            ?>
            
        </tbody>
      </table>
    </div>

    <br>
    <p class="tb-title">Studies Leave : <?php echo $currentYear;?></p>
    <div class="table-responsive-sm">
      <table class="table table-sm">
        <thead>
            <tr>
                <th>Total day</th>
                <th>Start date</th>
                <th>End date</th>
            </tr>
        </thead>
        <tbody>
        <?php
            $studies_history = studiesHistory($conn,$userid,$currentYear);
            if(mysqli_num_rows($studies_history) < 1){
                echo '
                <tr>
                  <td style="text-align:center;" colspan="3">-</td>
                </tr>
                ';
            }else{
                while($studies = mysqli_fetch_assoc($studies_history)){
                echo '
                <tr>
                  <td>'.$studies['total_studies_leave'].'</td>
                  <td>'.$studies['studies_start_date'].'</td>
                  <td>'.$studies['studies_end_date'].'</td>
                </tr>
                ';
                }
            }
            ?>
        </tbody>
      </table>
    </div>

    <br>

    <p class="tb-title">Unpaid Leave : <?php echo $currentYear;?></p>
    <div class="table-responsive-sm">
      <table class="table table-sm">
        <thead>
            <tr>
                <th>Total day</th>
                <th>Start date</th>
                <th>End date</th>
            </tr>
        </thead>
        <tbody>
        <?php
            $unpaid_history = unpaidHistory($conn,$userid,$currentYear);
            if(mysqli_num_rows($unpaid_history) < 1){
                echo '
                <tr>
                  <td style="text-align:center;" colspan="3">-</td>
                </tr>
                ';
            }else{
                while($unpaid = mysqli_fetch_assoc($unpaid_history)){
                echo '
                <tr>
                  <td>'.$unpaid['total_unpaid_leave'].'</td>
                  <td>'.$unpaid['unpaid_start_date'].'</td>
                  <td>'.$unpaid['unpaid_end_date'].'</td>
                </tr>
                ';
                }
            }
            ?>
            
        </tbody>
      </table>
    </div>

    <br>
    <p class="tb-title">Unplanned Leave : <?php echo $currentYear;?></p>
    <div class="table-responsive-sm">
      <table class="table table-sm">
        <thead>
            <tr>
                <th>Total day</th>
                <th>Start date</th>
                <th>End date</th>
            </tr>
        </thead>
        <tbody>
        <?php
            $unplanned_history = unplannedHistory($conn,$userid,$currentYear);
            if(mysqli_num_rows($unplanned_history) < 1){
                echo '
                <tr>
                  <td style="text-align:center;" colspan="3">-</td>
                </tr>
                ';
            }else{
                while($unplanned = mysqli_fetch_assoc($unplanned_history)){
                echo '
                <tr>
                  <td>'.$unplanned['total_unplanned_leave'].'</td>
                  <td>'.$unplanned['unplanned_start_date'].'</td>
                  <td>'.$unplanned['unplanned_end_date'].'</td>
                </tr>
                ';
                }
            }
            ?>
           
        </tbody>
      </table>
    </div>

</div>    



    <script src="bootstrap/js/bootstrap.min.js"></script>
    <script src="js/script.js"></script>
</body>
</html>