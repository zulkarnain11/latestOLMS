<?php
session_start();
if(!isset($_SESSION['user'])){
    header("Location: login.php");
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/admin.css">
    <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
    <title>Admin Panel Page - Add user</title>
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container-fluid">
        <a class="navbar-brand">Add user</a>
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



<div class="addUser-form">

    <?php
    if(isset($_GET['msg'])){
        if($_GET['msg'] == 'uploadsuccess'){
            echo"
            <div id='alert1' class='alert alert-success' role='alert'>
            Successfully added users!
            </div>
            ";
        }elseif($_GET['msg'] == 'fileistoobig'){
            echo"
            <div id='alert1' class='alert alert-danger' role='alert'>
            failed to add user, image size must not exceed 3MB !
            </div>
            ";
        }elseif($_GET['msg'] == 'error'){
            echo"
            <div id='alert1' class='alert alert-danger' role='alert'>
            error happening ! i am really sorry
            </div>
            ";
        }elseif($_GET['msg'] == 'uploadfailed'){
            echo"
            <div id='alert1' class='alert alert-danger' role='alert'>
            error happening ! i am really sorry
            </div>
            ";
        }
        elseif($_GET['msg'] == 'filenotsupport'){
            echo"
            <div id='alert1' class='alert alert-danger' role='alert'>
            Only supports 'jpg', 'jpeg', 'png' images !
            </div>
            ";
        }elseif($_GET['msg'] == 'idstaffhastaken'){
            echo"
            <div id='alert1' class='alert alert-danger' role='alert'>
            Id staff has taken !
            </div>
            ";
        }
    }
    ?>
    <form name="addUserForm" action="include/adduser.inc.php" method="POST" enctype="multipart/form-data"
    onsubmit="return validateAddUserForm()">
    
    <div class="mb-3">
        <label for="profilePic" class="form-label">Profile picture<span> *</span></label>
        <input type="file" class="form-control" id="profilePic" name="uploadImg" required>
    </div>
    <div class="mb-3">
        <label for="nric" class="form-label">NRIC<span> *</span></label>
        <input type="text" onkeypress="return restrictAlphabets(event)" class="form-control" id="nric" name="ic" required>
        <div id="icHelp" class="form-text">Without (-) , example : 991101336262</div>
    </div>
    <div class="mb-3">
        <label for="staffId" class="form-label">ID staff<span> *</span></label>
        <input type="text" onkeypress="return restrictAlphabets(event)" class="form-control" id="staffid" name="idstaff" required>
    </div>
    <div class="mb-3">
        <label for="InputFullName" class="form-label">Full name<span> *</span></label>
        <input type="text" class="form-control" id="InputFullName" name="fullname" required>
    </div>
    <div class="mb-3">
        <label for="InputUsername" class="form-label">Username<span> *</span></label>
        <input type="text" class="form-control" id="InputUsername" name="username" required>
    </div>
    <div class="mb-3">
        <label for="InputPassword1" class="form-label">Password<span> *</span></label>
        <input type="password" class="form-control" id="InputPassword1" name="password" required>
        <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault" onclick="functionHideShow()">
        <label class="form-check-label" for="flexCheckDefault">
            show password
        </label>
    </div>
    <div class="mb-3">
        <label for="InputPassword2" class="form-label">Re-enter Password<span> *</span></label>
        <input type="password" class="form-control" id="InputPassword2" name="repassword" required>
        <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault" onclick="functionHideShowRePassword()">
        <label class="form-check-label" for="flexCheckDefault">
            show password
        </label>
        <p id="warningPassword" style="color: rgb(255, 0, 0);
    visibility: hidden;">hello</p>
    </div>
    <div class="mb-3">
        <label for="InputEmail1" class="form-label">E-mail address<span> *</span></label>
        <input type="email" class="form-control" id="InputEmail1" name="email" required>
    </div>
    <div class="mb-3">
        <label for="telephone_num" class="form-label">Phone number<span> *</span></label>
        <input type="text" onkeypress="return restrictAlphabets(event)" class="form-control" id="telephone_num" name="telephone_num" required>
        <div id="icHelp" class="form-text">Without (-) , example : 0123456789</div>
    </div>
    <div class="mb-3">
        <label for="InputAddress" class="form-label">Home address<span> *</span></label>
        <input type="text" class="form-control" id="InputAddress" name="address" required>
    </div>
    <div class="mb-3">
        <label for="department1" class="form-label">Department<span> *</span></label>
        <select class="form-select" aria-label="Default select example" name="department" id="department1">
            <option selected  disabled>--Select a department--</option>
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
        <input type="number" placeholder="YYYY" min="1995" max="2100" class="form-control" id="startyear" name="startyear" required>
    </div>
    <button type="submit" class="btn btn-primary" name="submit">Add</button>
    <button type="reset" class="btn btn-outline-secondary">Cancel</button>
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