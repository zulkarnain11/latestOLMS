<?php
session_start();
if(!isset($_SESSION['user'])){
    header("Location: login.php");
}
$username = $_SESSION['user'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/admin.css">
    <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
    <title>Admin Panel Page - Admin account</title>
    <style>
        .admin-container{
            display: block;
            width: 350px;
            border: 2px solid #b0abad;
            margin: 6em auto;
        }
        .admin-img{
            width: 60px;
            margin: 1em auto;
            margin-bottom: 0.5em;
            display: flex;
            border-radius: 50%;
            background-color: #b0abad;
        }

        .admin-text{
            text-align: center;
            border-bottom: 1px solid #e6dfdf;
            width: fit-content;
            display: flex;
            margin: 0 auto;
            color: #515151;
        }
        .admin-user{
            display: flex;
            text-align: center;
            justify-content: center;
            color: #101313;
            margin-top: 2em;
        }
        .button-pass{
            display: flex;
            justify-content: center;
            width: fit-content;
            margin: auto;
            background-color: black;
            color: white;
            padding: 0.5em;
            border-radius: 0.3em;
            border-color: #fff0;
            margin-bottom: 3em;
            font-size: small;
        }
        .button-pass:hover{
            background-color: #3e4044;
        }

        
        .modal {
        display: none; /* Hidden by default */
        position: fixed; /* Stay in place */
        z-index: 1; /* Sit on top */
        padding-top: 100px; /* Location of the box */
        left: 0;
        top: 0;
        width: 100%; /* Full width */
        height: 100%; /* Full height */
        overflow: auto; /* Enable scroll if needed */
        background-color: rgb(0,0,0); /* Fallback color */
        background-color: rgba(0,0,0,0.4); /* Black w/ opacity */
        }

        /* Modal Content */
        .modal-content {
        background-color: #fefefe;
        margin: auto;
        padding: 20px;
        border: 1px solid #888;
        width: 300px;
        }

        /* The Close Button */
        .close {
        color: #aaaaaa;
        float: right;
        font-size: 28px;
        font-weight: bold;
        }

        .close:hover,
        .close:focus {
        color: #000;
        text-decoration: none;
        cursor: pointer;
        }
        @media screen and (max-width: 414px) {
            .admin-container{
                width: 90%;
            }
        }
    </style>
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container-fluid">
        <a class="navbar-brand">Account</a>
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

<div class="admin-container">
    <img class="admin-img" src="icon/admin.png" alt="admin-logo">
    <h6 class="admin-text">Admin</h6>
    <p class="admin-user">Username: <?php echo $username;?></p>
    <button id="modalbtn" class="button-pass">Change Password</button>
    <?php
if(isset($_GET['msg'])){
    if($_GET['msg'] == "inputEmpty"){
        echo "<p style='color:yellow; text-align:center;' >Check your password</p>";
    }elseif($_GET['msg'] == "error"){
        echo "<p style='color:red; text-align:center;' >Error occurred</p>";
    }elseif($_GET['msg'] == "succesupdate"){
        echo "<p style='color:green; text-align:center;' >password updated</p>";
    }
}
?>
</div>

 <!-- The Modal -->
 <div id="myModal" class="modal">

<!-- Modal content -->
<div class="modal-content">
 <span class="close">&times;</span>

 <form name="passform" onsubmit="return validatePass()" action="include/adminpass.inc.php" method="POST" >
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
  <p id="warningPass" style="color: rgb(255, 0, 0);visibility: hidden;">hello</p>
</div>
<button type="submit" class="btn btn-primary btn-sm" name="submit">Change</button>

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

      function validatePass(){
        var pass = document.forms['passform']['InputPassword1'];
        var repass = document.forms['passform']['InputPassword2'];
        var warning = document.getElementById('warningPassword');

        if(pass.value != repass.value){

          alert("Password not same!");
          return false;
        }
      }

      // Get the modal
        var modal = document.getElementById("myModal");

        // Get the button that opens the modal
        var btn = document.getElementById("modalbtn");

        // Get the <span> element that closes the modal
        var span = document.getElementsByClassName("close")[0];

        // When the user clicks the button, open the modal 
        btn.onclick = function() {
        modal.style.display = "block";
        }

        // When the user clicks on <span> (x), close the modal
        span.onclick = function() {
        modal.style.display = "none";
        }

        // When the user clicks anywhere outside of the modal, close it
        window.onclick = function(event) {
        if (event.target == modal) {
            modal.style.display = "none";
        }
        }
</script>
<script src="js/script.js"></script>
<script src="bootstrap/js/bootstrap.min.js"></script>
</body>
</html>