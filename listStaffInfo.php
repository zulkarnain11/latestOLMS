<?php
session_start();
if(!isset($_SESSION['user'])){
    header("Location: login.php");
}
if(isset($_GET['idstaff'])){
    $hashID = $_GET['idstaff'];
    $idstaff = base64_decode($hashID);

}else{
    header("Location: ../login.php");
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
    <title>Admin Panel Page - Staff Information</title>
</head>
<body>
 
<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container-fluid">
        <a class="navbar-brand">Staff information</a>
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

   
<div class="staff-info">
    <?php
        $result = getStaffInfo($conn, $idstaff);
        $row = mysqli_fetch_assoc($result);
    ?>
    <div class="mb-3">
        <img src="profilepic/<?php echo $row['profilepic'];?>" class="rounded mx-auto d-block" alt="...">
    </div>
    <div class="mb-3">
        <label class="form-label fw-bold">NRIC:</label>
        <p><?php echo $row['ic'];?></p>
        
    </div>
    <div class="mb-3">
        <label class="form-label fw-bold">ID staff:</label>
        <p><?php echo $row['idstaff'];?></p>
    </div>
    <div class="mb-3">
        <label class="form-label fw-bold">Name:</label>
        <p><?php echo $row['fullname'];?></p>
    </div>
    <div class="mb-3">
        <label class="form-label fw-bold">Username:</label>
        <p><?php echo $row['username'];?></p>
    </div>
    <div class="mb-3">
        <label class="form-label fw-bold">E-mail address:</label>
        <p><?php echo $row['email'];?></p>      
    </div>
    <div class="mb-3">
        <label class="form-label fw-bold">Home address:</label>
        <p><?php echo $row['address'];?></p>
    </div>
    <div class="mb-3">
        <label class="form-label fw-bold">Phone number:</label>
        <p><?php echo $row['telephone_num'];?></p>
    </div>
    <div class="mb-3">
        <label class="form-label fw-bold">Department:</label>
        <p><?php echo $row['department'];?></p>
    </div>
    <?php
      date_default_timezone_set('Asia/Kuala_Lumpur');
      $year = date('Y');
      $getQuota = getQuota($conn, $idstaff, $year);
      $quota = mysqli_fetch_assoc($getQuota);
    ?>
    <div class="mb-3">
        <label class="form-label fw-bold">Total annual leave:</label>
        <p><?php
         if(mysqli_num_rows($getQuota) < 1)
         {
             echo "No Information";
         }else{
            echo $quota['total_annual_leave'];
         }
         ?>
         </p>
    </div>
    <div class="mb-3">
        <label class="form-label fw-bold">Total hospitalisation leave:</label>
        <p><?php
         if(mysqli_num_rows($getQuota) < 1)
         {
             echo "No information";
         }else{
            echo $quota['total_hospitalization_leave'];
         }
         ?>
         </p>        
    </div>
    <div class="mb-3">
        <label class="form-label fw-bold">Total medical leave:</label>
        <p><?php
         if(mysqli_num_rows($getQuota) < 1)
         {
             echo "No Information";
         }else{
            echo $quota['total_medical_leave'];
         }
         ?>
         </p>
    </div>
    <div class="mb-3">
        <label  class="form-label fw-bold">Start year of service:</label>
        <p><?php echo $row['start_year'];?></p>        
    </div>
    <div class="mb-3">
        <label  class="form-label fw-bold">Manager name:</label>
        <p>
            <?php
            if($row['manager_name'] == null || $row['manager_name'] == "" || $row['manager_name'] == "none"){
                echo "No Information";
            }else{
                echo $row['manager_name'];
            }
            
             ?>
        </p>        
    </div>
    <?php 
    getMerit($conn,$idstaff);
    $merittotal = mysqli_fetch_assoc(getMerit($conn,$idstaff));
    $merit = $merittotal['merit'];
    $color;
    if($merit <= 70){
        $color = "style='color:red;'";
    }else if($merit > 81){
        $color = "style='color:green;'";
    }else if($merit <= 80){
        $color = "style='color:orange;'";
    }
    ?>
    <div class="mb-3">
        <label class="form-label fw-bold">Merit:</label>
        <p id="meritcolor"<?php echo $color;?>><?php echo $merittotal['merit'];?></p>        
    </div>
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
      //validate position select
        function selectValidate(){
        var select = document.getElementById('updatePosition');
        if(select.value){
            return true;
        }
        select.style.borderColor = "red";
        return false;
        }

        
</script>
<script src="js/script.js"></script>
<script src="bootstrap/js/bootstrap.min.js"></script>
</body>
</html>