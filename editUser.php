<?php
session_start();
if(!isset($_SESSION['user'])){
    header("Location: login.php");
}
include 'include/dbh.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/admin.css">
    <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
    <title>Admin Panel Page - Edit User</title>
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container-fluid">
        <a class="navbar-brand">Edit user</a>
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
        <form class="d-flex" action="editUser.php" method="POST">
        <input class="form-control me-2" type="search" placeholder="ID staff / IC number" aria-label="Search" name="staffid">
        <button class="btn btn-outline-success" type="submit" name="search">Search</button>
        </form>
    </div>
</div>

<div class="editUser-form">

    <form action="include/editUser.inc.php" method="POST" enctype="multipart/form-data">
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
        echo
        '
        <img src="profilepic/'.$row['profilepic'].'" class="rounded mx-auto d-block" alt="...">
    
        <div class="mb-3">
            <label for="profilePic" class="form-label">Profile picture</label>
            <input type="file" class="form-control" id="profilePic" name="uploadImg">
        </div>
        <div class="mb-3" style="display:none;">
            <label for="userid" class="form-label">User ID</label>
            <input type="text" class="form-control" id="userid" value="'.$row['userid'].'" name="userid">
        </div>
        <div class="mb-3">
            <label for="nric" class="form-label">NRIC</label>
            <input type="text" onkeypress="return restrictAlphabets(event)" class="form-control" id="nric" value="'.$row['ic'].'" name="nric">
            <div id="icHelp" class="form-text">Without (-) , Example : 991101336262</div>
        </div>
        <div class="mb-3">
            <label for="staffId" class="form-label">ID staff</label>
            <input type="text" onkeypress="return restrictAlphabets(event)" class="form-control" id="staffid" value="'.$row['idstaff'].'" name="idstaff">
        </div>
        <div class="mb-3">
            <label for="InputFullName" class="form-label">Full name</label>
            <input type="text" class="form-control" id="InputFullName" value="'.$row['fullname'].'" name="fullname">
        </div>
        <div class="mb-3">
            <label for="InputUsername" class="form-label">Username</label>
            <input type="text" class="form-control" id="InputUsername" value="'.$row['username'].'" name="username">
        </div>
        <div class="mb-3">
            <label for="InputEmail1" class="form-label">E-mail address</label>
            <input type="email" class="form-control" id="InputEmail1" value="'.$row['email'].'" name="email">
        </div>
        <div class="mb-3">
            <label for="InputAddress" class="form-label">Home address</label>
            <input type="text" class="form-control" id="InputAddress" value="'.$row['address'].'" name="address">
        </div>
        <div class="mb-3">
            <label for="telephone_num" class="form-label">Phone number<span> *</span></label>
            <input type="text" onkeypress="return restrictAlphabets(event)" class="form-control" id="telephone_num" value="'.$row['telephone_num'].'" name="telephone_num" required>
            <div id="icHelp" class="form-text">Without (-) , example : 0123456789</div>
        </div>
        <div class="mb-3">
            <label for="department1" class="form-label">Department</label>
            <select class="form-select" aria-label="Default select example" name="department" id="department1">
                <option value="'.$row['department'].'" selected>'.$row['department'].'</option>
                <option value="JHEA - JABATAN HAL EHWAL AKADEMIK">JHEA - JABATAN HAL EHWAL AKADEMIK</option>
                <option value="JHEP - JABATAN HAL EHWAL PELAJAR">JHEP - JABATAN HAL EHWAL PELAJAR</option>
                <option value="JKEW - JABATAN KEWANGAN">JKEW - JABATAN KEWANGAN</option>
                <option value="JPPHL - JABATAN PENGAMBILAN PELAJAR DAN HUBUNGAN LUAR">JPPHL - JABATAN PENGAMBILAN PELAJAR DAN HUBUNGAN LUAR</option>
                <option value="JPENDAFTAR - JABATAN PENDAFTAR">JPENDAFTAR - JABATAN PENDAFTAR</option>
                <option value="JKUALITI - JABATAN KUALITI">JKUALITI - JABATAN KUALITI</option>
            </select>    
        </div>
        <div class="mb-3">
            <label for="startyear" class="form-label">Start year of service<span> *</span></label>
            <input type="number" placeholder="YYYY" min="1995" max="2100" class="form-control" id="startyear" name="startyear" required value="'.$row['start_year'].'">
        </div>
        <button type="submit" class="btn btn-primary" name="edit">Edit</button>
        <button type="reset" class="btn btn-outline-secondary">Cancel</button>
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