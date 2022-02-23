<?php
session_start();

if(!isset($_SESSION["userid"])){
    header("Location: login.php");
}
$username = $_SESSION['username'];
$fullname = $_SESSION['fullname'];
$userid = $_SESSION['userid'];

include 'include/dbh.php';
include 'include/function.inc.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View the application Page</title>
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

        /* The Modal (background) */
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
    width: 80%;
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
        <a class="navbar-brand">List application</a>
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
    <div style="width: 90%; margin: 0 auto;">
        <?php
        if(isset($_GET['msg'])){
            if($_GET['msg'] == "cancelsuccess"){
                echo "<div style='text-align:center;' class='alert alert-success' role='alert'>
                Cancellation successful .
                </div>";
            }else if($_GET['msg'] == "cancelfailed"){
                echo "<div style='text-align:center;' class='alert alert-danger' role='alert'>
                Cancellation unsuccessful, Error happen
                </div>";
            }else if($_GET['msg'] == "hidesuccess"){
                echo "<div style='text-align:center;' class='alert alert-success' role='alert'>
                Successfully hidden
                </div>";
            }else if($_GET['msg'] == "hidefailed"){
                echo "<div style='text-align:center;' class='alert alert-danger' role='alert'>
                Not successfully hidden, Error happen
                </div>";
            }
        }
        
        ?>    
    </div>
        
    <div style="width: 90%; margin: 1em auto;">
        <div class="table-responsive-sm">
            <table class="table-responsive-sm table-hover">
                <tr style="background-color: #ff0058;color: #ffffff;">
                    <th>Leave type</th>
                    <th>Apply date</th>
                    <th>Start date</th>
                    <th>End date</th>
                    <th>Total day</th>
                    <th>Venue</th>
                    <th>Organizer</th>
                    <th>Manager name</th>
                    <th style="color: #ff0058;">................</th>
                    <th>Reason</th>
                    <th>Document</th>
                    <th>Approval</th>
                    <th>Action</th>
                </tr>
                <tr>
                <?php
                $result = checkApply($conn, $userid);
                if(mysqli_num_rows($result) < 1){
                    echo "

                    <tr>
                    <td colspan='9' style='text-align:center;'>no application</td>
                    </tr>

                    ";
                }
                    while($row = mysqli_fetch_assoc($result)){

                        $approvestyle = $row['leave_approval'];
                        if($approvestyle == "in review"){
                            $style = "style='color:grey;'";
                        }else if($approvestyle == "approved"){
                            $style = "style='color:green;'";
                        }else if($approvestyle == "not accepted"){
                            $style = "style='color:red;'";
                        }
                        
                        $applyid = $row['id'];
                        $hashApplyId = base64_encode($applyid);

                        $organizer = $row['organizer'];
                        $venue = $row['venue'];
                        $manager = $row['manager_name'];

                        $managerName = '-';
                        if($manager == null || $manager == ""){
                            $managerName = "-";
                        }else{
                            $managerName = $manager;
                        }

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
                        

                        $btnhide = "";
                        if($approvestyle != "in review"){
                            $btnhide = "<a href='include/hide.inc.php?apply=".$hashApplyId."' class='btn btn-warning btn-sm'>Hide</a>";
                        }else{
                            $btnhide = "<a href='include/cancel.inc.php?apply=".$hashApplyId."' class='btn btn-danger btn-sm'>Cancel</a>";
                        }

                        $reason = $row['reason'];
                        if($reason == null || $reason == ""){
                            $reasontext = "not specified";
                        }else{
                            $reasontext = "<a href='reason.php?apply=".$hashApplyId."' class='btn btn-secondary btn-sm'>....</a>";
                        }

                        $document = $row['document'];
                        if($document != null || $document != ""){
                            $href = "<a class='btn btn-primary btn-sm' href='document/".$document."' download rel='noopener noreferrer' target='_blank'>Download</a>";
                        }else{
                            $href = "No document";
                        }
                        echo"
                        <tr>
                        <td>".$row['leave_type']."</td>
                        <td>".$row['applydate']."</td>
                        <td>".$row['startdate']."</td>
                        <td>".$row['enddate']."</td>
                        <td>".$row['total_leave_taken']."</td>
                        <td>".$venueText."</td>
                        <td>".$organizerName."</td>
                        <td colspan='2'>".$managerName."</td>
                        <td>".$reasontext."</td>                    
                        <td>".$href."</td>
                        <td ".$style.">".$row['leave_approval']."</td>
                        <td>".$btnhide."</td>
                        </tr>
                        <!-- The Modal -->
                        <div id='myModal' class='modal'>

                        <!-- Modal content -->
                        <div class='modal-content'>
                            <span class='close'>&times;</span>
                            <p>".$reason."</p>
                        </div>

                        </div>
                        
                        ";
                    }
                ?>
            </table>
        </div>

    </div>

    <script>
// Get the modal
var modal = document.getElementById("myModal");

// Get the button that opens the modal
var btn = document.getElementById("myBtn");

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