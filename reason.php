<?php
session_start();

if(!isset($_SESSION["userid"])){
    header("Location: login.php");
}
if(!isset($_GET['apply'])){
    header("Location: login.php");
}

$hashId = $_GET['apply'];
$applyId = base64_decode($hashId);
$username = $_SESSION['username'];
$fullname = $_SESSION['fullname'];

$status = "in review";

include 'include/dbh.php';
include 'include/function.inc.php';

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reason Page</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@500&display=swap"
     rel="stylesheet">
     <style>
         .reason-container{
             width: 300px;
             margin: 3em auto;
         }
     </style>
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container-fluid">
        <a class="navbar-brand text-secondary" href="account.php"><img src="icon/user.svg" width="20"> <?php echo $username;?></a>
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
$result  = getReason($conn,$applyId);
$row = mysqli_fetch_assoc($result);
$reason = $row['reason'];

?>

<div class="reason-container">
<div class="card mb-3" style="max-width: 18rem;">
  <div class="card-header" style="background-color: #2c739d;color:#ffffff;">Reason</div>
  <div class="card-body">
    <p class="card-text" style="color: #616d6f;"><?php echo $reason;?></p>
    <input
    class="btn btn-secondary btn-sm"
    action="action"
    onclick="window.history.go(-1); return false;"
    type="submit"
    value="Back"
/>
  </div>
</div>
</div>


    <script src="bootstrap/js/bootstrap.min.js"></script>
    <script src="js/script.js"></script>
</body>
</html>