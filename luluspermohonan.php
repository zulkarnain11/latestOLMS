<?php
session_start();

if(!isset($_SESSION["userid"])){
    header("Location: login.php");
}
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
    <title>Approval Page</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@500&display=swap"
     rel="stylesheet">
     <style>
         table{
    display: block;
    overflow-x: auto;
}
th{
    padding: 0 1em;
    font-weight: 600;
}
td{
    padding: 0.5em 1em;
    vertical-align: top;
    width: 200px;
    font-size: small;
}
     </style>
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container-fluid">
        <a class="navbar-brand">Approval list</a>
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


    <div style="width: 90%; margin: 1em auto;">
    <?php
        if(isset($_GET['msg'])){
            if($_GET['msg'] == "approvedwithoutmerit"){
                echo "<div style='text-align:center;' class='alert alert-success' role='alert'>
                Approval updated
            </div>";
            }else if($_GET['msg'] == "approvedwithmerit"){
                echo "<div style='text-align:center;' class='alert alert-success' role='alert'>
                Approval updated
            </div>";
            }else if($_GET['msg'] == "error"){
                echo "<div style='text-align:center;' class='alert alert-danger' role='alert'>
                An error occurred, sorry for the inconvenience.
            </div>";
            }else if($_GET['msg'] == "notaccepted"){
                echo "<div style='text-align:center;' class='alert alert-success' role='alert'>
                Approval updated
            </div>";
            }
        }
        ?>
        <div class="table-responsive-sm">
            <table class="table-responsive-sm table-hover">
                <tr style="background-color: #009fff;color:#ffffff;">
                    <th>Name</th>
                    <th style="color: #009fff;">...................</th>
                    <!--<th>Department</th>-->
                    <th>Leave type</th>
                    <th>Apply date</th>
                    <th>Start date</th>
                    <th>End date</th>
                    <th>Total day</th>
                    <th>Venue</th>
                    <th>Organizer</th>
                    <th>Reason</th>
                    <th>Document</th>
                    <th>Action</th>
                    <th style="color: #009fff;">.............................</th>
                </tr>
                <?php
                $applyForManager = getApplyForManager($conn,$fullname,$status);
                if(mysqli_num_rows($applyForManager) < 1){
                    echo "
                    <tr>
                    <td colspan='9' style='text-align:center;'>no application</td>
                    </tr>
                    ";
                }

                while($row = mysqli_fetch_assoc($applyForManager)){
                    $staffUserid = $row['userid'];
                    $applyId = $row['id'];
                    $hashApplyId = base64_encode($applyId);

                   $result2 = getStaffName($conn,$staffUserid);
                   $staffFullname = mysqli_fetch_assoc($result2);
                   $staffName = $staffFullname['fullname'];
                   $staffDepartment = $staffFullname['department'];
                   $document = $row['document'];
                   $reason = $row['reason'];
                   $organizer = $row['organizer'];
                   $venue = $row['venue'];

                   $venueText = '';
                   if($venue == null || $venue == ""){
                       $venueText = "-";
                   }else{
                       $venueText = $venue;
                   }
                   
                   $organizerName = '';
                   if($organizer == null || $organizer == ""){
                       $organizerName = "-";
                   }else{
                       $organizerName = $organizer;
                   }

                   $reasontext = '';
                   if($reason == null || $reason == "" || $reason == "none"){
                       $reasontext = "-";
                   }else{
                       $reasontext = "<a href='reason.php?apply=".$hashApplyId."' class='btn btn-secondary btn-sm'>....</a>";
                   }

                   $buttonDownload = '';
                   if($document == null || $document == "" || $document == "none"){
                       $buttonDownload = 'No document';
                   }else{
                       $buttonDownload = "<a class='btn btn-primary btn-sm' href='document/".$document."' download rel='noopener noreferrer' target='_blank'>Download</a>";
                   }

                   echo "
                   <tr>
                     <td colspan='2'>".$staffName."</td>
                     
                     <!--<td>".$staffDepartment."</td>-->
                     <td>".$row['leave_type']."</td>
                     <td>".$row['applydate']."</td>
                     <td>".$row['startdate']."</td>
                     <td>".$row['enddate']."</td>
                     <td>".$row['total_leave_taken']."</td>
                     <td>".$venueText."</td>
                     <td>".$organizerName."</td>
                     <td>".$reasontext."</td>
                     <td>".$buttonDownload."</td>
                     <td colspan='2'>
                     <a href='include/approveConfirm.php?apply=".$hashApplyId."' class='btn btn-success btn-sm mx-2'>Approve</a>
                     <a href='include/notAcceptedConfirm.php?apply=".$hashApplyId."' class='btn btn-danger btn-sm'>Not accepted</a>
                     </td> 
                     
                   </tr>
                   ";
                }
                ?>
                
            </table>
        </div>
    </div>
    <script src="bootstrap/js/bootstrap.min.js"></script>
    <script src="js/script.js"></script>
</body>
</html>