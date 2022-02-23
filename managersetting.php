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
    <title>Admin Panel Page - Manager Setting</title>
</head>
<body>
    
<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container-fluid">
        <a class="navbar-brand">Manager setting</a>
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
        <form class="d-flex" action="managersetting.php" method="POST">
        <input class="form-control me-2" type="search" placeholder="ID staff / IC number" aria-label="Search" name="staffid">
        <button class="btn btn-outline-success" type="submit" name="search">Search</button>
        </form>
        <?php
        if(isset($_GET['msg'])){
            if($_GET['msg'] == 'addmanagersuccess'){
                echo "<div class='alert alert-success' role='alert'>
                Successfully added a manager to the staff
            </div>";
            }
            elseif($_GET['msg'] == 'emptymanager'){
                echo "<div class='alert alert-warning' role='alert'>
                Empty manager name
            </div>";
            }
        }
        ?>
    </div>
</div>

<div class="addManager">

    <form action="include/addmanager.inc.php" method="POST" enctype="multipart/form-data">
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

        $manager = "";
        if($row['manager_name'] == null){
            $manager = "None";
        }elseif($manager == "None"){
            $manager = "None";
        }else{
            $manager = $row['manager_name'];
        }
        echo
        '
        <img src="profilepic/'.$row['profilepic'].'" class="rounded mx-auto d-block" alt="..."><br/>
        <div class="mb-3">
            <label for="staffId" class="form-label fw-bold">ID staff:</label>
            <p id="staffId">'.$row['idstaff'].'</p>
            <input style="display:none;" type="text" name="userid" value="'.$row['userid'].'"/>
        </div>
        <div class="mb-3">
            <label for="InputFullName" class="form-label fw-bold">Staff name:</label>
            <p id="InputFullName">'.$row['fullname'].'</p>
        </div>
        <div class="mb-3">
            <label for="currentmanager" class="form-label fw-bold">Current manager:</label>
            <p id="currentmanager">'.$manager.'</p>
        </div>
        <div class="mb-3">
            <label for="manager" style="background-color: #008f8c;" class="form-label p-1
             text-light">Update manager name:</label>
            <select name="managername" class="form-select form-select-sm" aria-label=".form-select-sm example">
                <option value="'.$row['manager_name'].'" selected>'.$row['manager_name'].'</option>
                <option value="None">None</option>';
        
        $managerName = getManagerName($conn);
        while($row = mysqli_fetch_assoc($managerName)){
        echo '
         <option value="'.$row['fullname'].'">'.$row['fullname'].'</option>
         
        ';
        }
        echo '
        </select>
        </div>
        <button type="submit" class="btn btn-primary" name="submit">Add</button>
        <a class="btn btn-outline-secondary" href="adminPanel.php">Back</a>
        ';
        }
        }else{
            echo "<div class='alert alert-warning' role='alert'>
            User not found!
          </div>";
        }

    }
    ?>
    </form>
</div>

<script src="js/script.js"></script>
<script src="bootstrap/js/bootstrap.min.js"></script>
</body>
</html>