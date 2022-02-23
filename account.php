<?php
session_start();

if(!isset($_SESSION["userid"])){
    header("Location: login.php");
}
$username = $_SESSION['username'];
$fullname = $_SESSION['fullname'];
$idstaff = $_SESSION["userid"];

include 'include/dbh.php';
include 'include/function.inc.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Account</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@500&display=swap"
     rel="stylesheet">

    <style>

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
    </style>
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container-fluid">
        <a class="navbar-brand" href="account.php">Personal account</a>
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

    
    $result = getStaffInfo($conn, $idstaff);
    $row = mysqli_fetch_assoc($result);

    if(isset($_GET['msg'])){
        if($_GET['msg'] == "passnotmatch"){
            echo "<script>setTimeout(function(){ alert('Password not match'); }, 1000);</script>";            
        }else if($_GET['msg'] == "changefailed"){
            echo "<script>setTimeout(function(){ alert('Error happen , sorry'); }, 1000);</script>";
        }else if($_GET['msg'] == "changesuccess"){
            echo "<script>setTimeout(function(){ alert('Successfully changed the password'); }, 1000);</script>";
        }
    }
    
    ?>

    <div style="width: 150px; margin: 2em auto;background-color: red;">
        <img src="profilepic/<?php echo $row['profilepic'];?>" alt="" width="150px">
    </div>
    
    <div class="account-info" style="width: 350px; margin: 1em auto;background-color:whitesmoke; padding: 2em;">
        <div class="mb-3">
            <label for="name" class="form-label fw-bold">Name:</label>
            <p id="name"><?php echo $row['fullname'];?></p>
        </div>
        <div class="mb-3">
            <label for="email" class="form-label fw-bold">E-mail:</label>
            <p id="email"><?php echo $row['email'];?></p>
        </div>
        <div class="mb-3">
            <label for="phone" class="form-label fw-bold">Phone number:</label>
            <p id="phone"><?php echo $row['telephone_num'];?></p>
        </div>
        <div class="mb-3">
            <label for="address" class="form-label fw-bold">Address:</label>
            <p id="address"><?php echo $row['address'];?></p>
        </div>
        <div class="mb-3">
            <label for="department" class="form-label fw-bold">Department:</label>
            <p id="department"><?php echo $row['department'];?></p>
        </div>
        <?php
          
          getMerit($conn,$idstaff);
          $merittotal = mysqli_fetch_assoc(getMerit($conn,$idstaff));

          $merit = $merittotal["merit"];
          
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
            <label for="merit" class="form-label fw-bold">Merit:</label>
            <p id="merit" <?php echo $color;?>><?php echo $merit;?></p>
        </div>
        <button id="modalbtn" class="btn btn-dark btn-sm">Change Password</button>
    </div>

    <!-- The Modal -->
    <div id="myModal" class="modal">

        <!-- Modal content -->
        <div class="modal-content">
         <span class="close">&times;</span>

         <form action="include/changepass.inc.php" method="POST" enctype="multipart/form-data">
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
    
    
<script>
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

    <script src="bootstrap/js/bootstrap.min.js"></script>
    <script src="js/script.js"></script>
</body>
</html>