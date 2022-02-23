<?php
session_start();
if(!isset($_SESSION['user'])){
  header("Location: login.php");
}
include 'include/dbh.php';
include 'include/function.inc.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/admin.css">
    <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
    <title>Admin Panel Page - Leave quota</title>
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container-fluid">
        <a class="navbar-brand">Leave quota</a>
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
            
        </ul>
        </div>
    </div>
</nav>


<div class="searchUser">
    <div class="container-fluid">
        <form class="d-flex" action="leavequota.php" method="POST">
        <input class="form-control me-2" type="search" placeholder="ID staff / IC number" aria-label="Search" name="staffid">
        <button class="btn btn-outline-success" type="submit" name="search">Search</button>
        </form>
        <?php
        if(isset($_GET['msg'])){
            if($_GET['msg'] == 'Inserthospitalsucces'){
                echo "<div style='margin-top: 1em;' class='alert alert-success' role='alert'>
                Successfully update leave quota
            </div>";
            }
            elseif($_GET['msg'] == 'inserthospitalfailed'){
                echo "<div  style='margin-top: 1em;' class='alert alert-warning' role='alert'>
                Failed ! error happening
            </div>";
            }
            elseif($_GET['msg'] == 'updatesuccess'){
              echo "<div  style='margin-top: 1em;' class='alert alert-success' role='alert'>
              Successfully update leave quota
          </div>";
          }

        }
        ?>
    </div>
</div>

<div class="leavequota-form">

    <form action="include/updatequote.inc.php" method="POST" enctype="multipart/form-data">
    <?php
    if (isset($_POST['search'])){
        $idstaff = mysqli_real_escape_string($conn, $_POST['staffid']);
        $sql = "SELECT * FROM user WHERE idstaff = ? OR ic = ?;";

        $stmt = mysqli_prepare($conn,$sql);
        mysqli_stmt_bind_param($stmt, 'ss', $idstaff, $idstaff);
        mysqli_stmt_execute($stmt);

        $result = mysqli_stmt_get_result($stmt);

        if (mysqli_num_rows($result) > 0){
        while($row = mysqli_fetch_assoc($result)){
            $userid = $row['userid'];

            date_default_timezone_set('Asia/Kuala_Lumpur');
            $year = date('Y');
            $annual_balance = getAnnualBalance($conn, $userid, $year);
            $medical_balance = getMedicalBalance($conn, $userid, $year);
            $hospitalization_balance =  getHospitalizationBalance($conn, $userid, $year);

            $annual_balance_record = "";
            if(mysqli_num_rows($annual_balance) < 1){
              $annual_balance_record =  "-";
            }else{
               $annual = mysqli_fetch_assoc($annual_balance);
               $annual_balance_record = $annual['balance_annual_leave'];
            }

            $medical_balance_record = "";
            if(mysqli_num_rows($medical_balance) < 1){
              $medical_balance_record =  "-";
            }else{
             $medical = mysqli_fetch_assoc($medical_balance);
             $medical_balance_record = $medical['balance_medical_leave']; 
            }

            $hospitalization_balance_record = "";
            if(mysqli_num_rows($hospitalization_balance) < 1){
              $hospitalization_balance_record =  "-";
            }else{
              $hospitalization = mysqli_fetch_assoc($hospitalization_balance);
              $hospitalization_balance_record = $hospitalization['balance_hospitalisation_leave'];
            }

            $lastYear = $year - 1;
        echo
        '
        <img src="profilepic/'.$row['profilepic'].'" class="rounded mx-auto d-block" alt="..."><br>
    

        <div class="mb-3" style="display:none;">
            <label for="userid" class="form-label">User ID</label>
            <input type="text" class="form-control" id="userid" value="'.$row['userid'].'" name="userid">
        </div>
        <div class="mb-3">
            <label for="nric" class="form-label fw-bold">NRIC:</label><br>
            <label>'.$row['ic'].'</label>         
        </div>
        <div class="mb-3">
            <label for="staffId" class="form-label fw-bold">ID staff: </label><br>
            <label>'.$row['idstaff'].'</label> 
        </div>
        <div class="mb-3">
            <label for="InputFullName" class="form-label fw-bold">Full name:</label><br>
            <label>'.$row['fullname'].'</label>
        </div>
        <div class="mb-3">
            <label class="form-label fw-bold">Leave balance: '.$lastYear.':</label><br> 
        </div>
        <div class="table-responsive-sm">
        <table class="table">
          <thead class="table-dark">
            <tr>
              <th>Leave type</th>
              <th>Balance</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td>Annual leave</td>
              <td>'.$annual_balance_record.'</td>
            </tr>
            <tr>
              <td>Medical leave</td>
              <td>'.$medical_balance_record.'</td>
            </tr>
            <tr>
              <td>Hospitalization leave</td>
              <td>'.$hospitalization_balance_record.'</td>
            </tr>
          </tbody>
        </table>
        </div><br>

        <div class="mb-3">
          <label style="background-color: #008f8c;" class="p-1 text-light">Update quota staff </label>       
        </div>
        <div class="mb-3">
            <label for="startyear" class="form-label fw-bold">Year<span> *</span></label>
            <input type="number" placeholder="YYYY" min="1995" max="2100" class="form-control" id="startyear" name="year" required>
        </div>
        <div class="mb-3">
            <label for="annualleave" class="form-label fw-bold">Total annual leave<span> *</span></label>
            <input type="text" class="form-control" id="annualleave" name="annual_leave" required onkeypress="return restrictAlphabets(event)">
        </div>
        <div class="mb-3">
            <label for="hospitalisationleave" class="form-label fw-bold">Total hospitalisation leave<span> *</span></label>
            <input type="text" class="form-control" id="hospitalisationleave" name="hospitalisationleave" required onkeypress="return restrictAlphabets(event)">
        </div>
        <div class="mb-3">
            <label for="medicalleave" class="form-label fw-bold">Total medical leave<span> *</span></label>
            <input type="text" class="form-control" id="medicalleave" name="medical_leave" required onkeypress="return restrictAlphabets(event)">
        </div>
        
        <button type="submit" class="btn btn-primary btn-sm" name="update">Update</button>
        <button type="reset" class="btn btn-outline-secondary btn-sm">Cancel</button>
        ';
        }
        }else{
            echo "<div class='alert alert-warning' role='alert'>
            User not found!
          </div>";
        }

    }
    if(isset($_GET['msg'])){
        if($_GET['msg'] == 'successedit'){
            echo "<div class='alert alert-success' role='alert'>
            Successfully edited the user
          </div>";
        }elseif ($_GET['msg'] == 'failedit'){
            echo "<div class='alert alert-danger' role='alert'>
            Error happening! Edit failed
          </div>";
        }
        elseif ($_GET['msg'] == 'successeditwithpic'){
            echo "<div class='alert alert-success' role='alert'>
            Successfully edited the user
          </div>";
        }
        elseif ($_GET['msg'] == 'fileistoobig'){
            echo "<div class='alert alert-danger' role='alert'>
            Edit failed!! images must not exceed 3MB
          </div>";
        }
        elseif ($_GET['msg'] == 'error'){
            echo "<div class='alert alert-danger' role='alert'>
            Image error!!
          </div>";
        }
        elseif ($_GET['msg'] == 'filenotsupport'){
            echo "<div class='alert alert-danger' role='alert'>
            Only supports 'jpg', 'jpeg', 'png' images !
          </div>";
        }
    }
    ?>
    </form>
</div>

<script type="text/javascript">
      /*code: 48-57 Numbers*/
      function restrictAlphabets(e){
          var x = e.which || e.keycode;
        if((x>=48 && x<=57))
          return true;
        else
          return false;
      }
</script>
<script src="js/script.js"></script>
<script src="bootstrap/js/bootstrap.min.js"></script>
</body>
</html>