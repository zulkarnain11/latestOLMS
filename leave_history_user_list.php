<?php
session_start();

if(isset($_POST['submit'])){
    $userid = $_POST['staff'];
    $year = $_POST['year']; 
}
if(!isset($_POST['submit'])){
    header("Location: login.php");
}

include 'include/dbh.php';
include 'include/function.inc.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel Page - Leave History</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300&display=swap" rel="stylesheet">
    
</head>
<body>
    
<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container-fluid">
        <a class="navbar-brand">Leave history</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNavDropdown">
        <ul class="navbar-nav">
            <li>
                <a href="admin-account.php" class="nav-link"><img src="icon/admin.png" style="width: 20px;" alt=""> account</a>
            </li>
            <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                Action
            </a>
            <ul class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
            <li><a class="dropdown-item" href="adminPanel.php">Add user</a></li>
                <li><a class="dropdown-item" href="editUser.php">Edit user</a></li>
                <li><a class="dropdown-item" href="deleteUser.php">Delete user</a></li>
                <li><a class="dropdown-item" href="managersetting.php">Manager setting</a></li>
                <li><a class="dropdown-item" href="position.php">Staff position</a></li>
                <li><a class="dropdown-item" href="leavequota.php">Leave quota</a></li>
                <li><a class="dropdown-item" href="listStaff.php">Staff list</a></li>
                <li><a class="dropdown-item" href="leave_history_user.php">Leave history</a></li>
                <li><a class="dropdown-item" href="meritHistory.php">Merit history</a></li>
                <li><a class="dropdown-item" href="logout.php" style="color:#ff0000;">Log out</a></li>
            </ul>

            </li>
            <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" role="button" data-bs-toggle="dropdown" aria-expanded="false">
               Leave type
            </a>
            <ul class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
            <li>
                <li><a class="dropdown-item" href="unplannedLeave.php">Unplanned leave</a></li>
                <li><a class="dropdown-item" href="compassionateLeave.php">Compassionate leave</a></li>
                <li><a class="dropdown-item" href="maternityLeave.php">Maternity leave</a></li>
                <li><a class="dropdown-item" href="unpaidLeave.php">Unpaid leave</a></li>
                <li><a class="dropdown-item" href="studiesLeave.php">Studies leave</a></li>
                               
            </ul>
            
            </li>
            <li>
              <a href="#" class="nav-link" onclick="printDiv('tb-print')"><img src="icon/printer.png" width="20px"> Print</a>
            </li>
            
        </ul>
        </div>
    </div>
</nav>


<div class="tb-container" id="tb-print">
    <p class="tb-title">Annual Leave : <?php echo $year;?></p>
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
            $annual_history = annualHistory($conn,$userid,$year);
            if(mysqli_num_rows($annual_history) < 1){
                echo '
                <tr>
                  <td style="text-align:center;" colspan="3">-</td>
                </tr>
                ';
            }else{
                while($annual = mysqli_fetch_assoc($annual_history)){
                echo '
                <tr>
                  <td>'.$annual['total_leave_taken'].'</td>
                  <td>'.$annual['startdate'].'</td>
                  <td>'.$annual['enddate'].'</td>
                </tr>
                ';
                }
            }

            ?>
            
        </tbody>
      </table>
    </div>
    <br>
    <p class="tb-title">Medical Leave : <?php echo $year;?></p>
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
            $medical_history = medicalHistory($conn,$userid,$year);
            if(mysqli_num_rows($medical_history) < 1){
                echo '
                <tr>
                  <td style="text-align:center;" colspan="3">-</td>
                </tr>
                ';
            }else{
                while($medical = mysqli_fetch_assoc($medical_history)){
                echo '
                <tr>
                  <td>'.$medical['total_leave_taken'].'</td>
                  <td>'.$medical['startdate'].'</td>
                  <td>'.$medical['enddate'].'</td>
                </tr>
                ';
                }
            }

            ?>
        </tbody>
      </table>
    </div>

    <br>

    <p class="tb-title">Hospitalization Leave : <?php echo $year;?></p>
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
            $hospitalization_history = hospitalizationHistory($conn,$userid,$year);
            if(mysqli_num_rows($hospitalization_history) < 1){
                echo '
                <tr>
                  <td style="text-align:center;" colspan="3">-</td>
                </tr>
                ';
            }else{
                while($hospital = mysqli_fetch_assoc($hospitalization_history)){
                echo '
                <tr>
                  <td>'.$hospital['total_leave_taken'].'</td>
                  <td>'.$hospital['startdate'].'</td>
                  <td>'.$hospital['enddate'].'</td>
                </tr>
                ';
                }
            }

            ?>
            
        </tbody>
      </table>
    </div>

    <br>

    <p class="tb-title">Outstation Leave : <?php echo $year;?></p>
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
            $outstation_history = outstationHistory($conn,$userid,$year);
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
    <p class="tb-title">Compassionate Leave : <?php echo $year;?></p>
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
            $compassionate_history = compassionateHistory($conn,$userid,$year);
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

    <p class="tb-title">Maternity Leave : <?php echo $year;?></p>
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
            $maternity_history = maternityHistory($conn,$userid,$year);
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
    <p class="tb-title">Studies Leave : <?php echo $year;?></p>
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
            $studies_history = studiesHistory($conn,$userid,$year);
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

    <p class="tb-title">Unpaid Leave : <?php echo $year;?></p>
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
            $unpaid_history = unpaidHistory($conn,$userid,$year);
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
    <p class="tb-title">Unplanned Leave : <?php echo $year;?></p>
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
            $unplanned_history = unplannedHistory($conn,$userid,$year);
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

<script>
  function printDiv(divName) {
     var printContents = document.getElementById(divName).innerHTML;
     var originalContents = document.body.innerHTML;

     document.body.innerHTML = printContents;

     window.print();

     document.body.innerHTML = originalContents;
}
</script>


    <script src="bootstrap/js/bootstrap.min.js"></script>
    <script src="js/script.js"></script>
</body>
</html>