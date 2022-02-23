<?php
session_start();

if(!isset($_SESSION["userid"])){
    header("Location: login.php");
}
$username = $_SESSION['username'];
$fullname = $_SESSION['fullname'];

include 'include/dbh.php';
include 'include/function.inc.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home Page</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300&display=swap" rel="stylesheet">
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

    <div class="sysabout">
        <div class="containerLogo">
            <div class="logo">
                <img src="image/logoktd1.png" />
            </div>
            <h1>Online Leave Management System</h1>
        </div>

        <h5>Online Leave Management System is a system that facilitates lecturers and staff to apply for leave online by referring to basic staff information. This system is an alternative needed by lecturers and staff to replace the manual leave application system. The system can also provide quick access to information to management for relevant reporting.</h5>

       
    </div>


    <script src="bootstrap/js/bootstrap.min.js"></script>
    <script src="js/script.js"></script>
</body>
</html>