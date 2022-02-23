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
    <title>Admin Panel Page - Delete User</title>
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container-fluid">
        <a class="navbar-brand">Delete user</a>
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
        <form class="d-flex" action="deleteUser.php" method="POST">
        <input class="form-control me-2" type="search" placeholder="ID staff / IC number" aria-label="Search" name="idstaff" onkeypress="return restrictAlphabets(event)">
        <button class="btn btn-outline-success" type="submit" name="search">Search</button>
        </form>
    </div>
</div>

<div class="deleteUser">

    <?php
    if(isset($_POST['search'])){
        $idstaff = mysqli_real_escape_string($conn, $_POST['idstaff']);
        $sql = "SELECT * FROM user WHERE idstaff = ? OR ic = ?;";

        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, 'ss', $idstaff, $idstaff);
        mysqli_stmt_execute($stmt);

        $result = mysqli_stmt_get_result($stmt);

        if(mysqli_num_rows($result) > 0){
        while($row = mysqli_fetch_assoc($result)){

        $hashidstaff = base64_encode($row['idstaff']);
        $hashuserid = base64_encode($row['userid']);
        
        echo '
        <img src="profilepic/'.$row['profilepic'].'" class="rounded mx-auto d-block" alt="...">
        <div class="mb-3">
            <label for="nric" class="form-label fw-bold">NRIC:</label>
            <p>'.$row['ic'].'</p>
        </div>
        <div class="mb-3">
            <label for="staffId" class="form-label fw-bold">ID staff:</label>
            <p>'.$row['idstaff'].'</p>
        </div>
        <div class="mb-3">
            <label for="InputFullName" class="form-label fw-bold">Full name:</label>
            <p>'.$row['fullname'].'</p>
        </div>
        <div class="mb-3">
            <label for="InputUsername" class="form-label fw-bold">Username:</label>
            <p>'.$row['username'].'</p>
        </div>
        <div class="mb-3">
            <label for="InputEmail1" class="form-label fw-bold">E-mail address:</label>
            <p>'.$row['email'].'</p>
        </div>
        <div class="mb-3">
            <label for="InputAddress" class="form-label fw-bold">Home address:</label>
            <p>'.$row['address'].'</p>
        </div>
        <div class="mb-3">
            <label for="telephon_num" class="form-label fw-bold">Phone number:</label>
            <p>'.$row['telephone_num'].'</p>
        </div>
        <div class="mb-3">
            <label for="Department" class="form-label fw-bold">Department:</label>
            <p>'.$row['department'].'</p>
        </div>
        <a type="submit" class="btn btn-danger btn-sm" href="include/deleteUserConfirm.php?idstaff='.$hashuserid.'">Delete from database</a>
        <a type="submit" class="btn btn-warning btn-sm" href="include/deleteDisplayConfirm.php?idstaff='.$hashidstaff.'">Delete from display</a>
        
        ';
        }
        }else{
            echo "<div class='alert alert-warning' role='alert'>
            User not found!
          </div>";
        }
        
    }

    if(isset($_GET['msg'])){
        if($_GET['msg'] == 'deletesuccess'){
            echo "<div class='alert alert-success' role='alert'>
            Successfully deleted user
          </div>";
        }elseif ($_GET['msg'] == 'deletefailed'){
            echo "<div class='alert alert-danger' role='alert'>
            Error happening! Delete failed
          </div>";
        }
    }
    ?>

    
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