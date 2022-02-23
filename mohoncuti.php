<?php
session_start();

if(!isset($_SESSION["userid"])){
    header("Location: login.php");
}
$userid = $_SESSION['userid'];
$username = $_SESSION['username'];
$fullname = $_SESSION['fullname'];
$managerName = $_SESSION['manager_name'];

include 'include/dbh.php';
include 'include/function.inc.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Apply leave Page</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@500&display=swap"
     rel="stylesheet">
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

    <div class="title-function">
        <h1>Apply leave</h1>
    </div>
    
    <div class="mohoncuti-form">
        
    <?php
        if(isset($_GET['msg'])){
            if($_GET['msg'] == "applicationsubmittedwithdoc"){
                echo "<div class='alert alert-success' role='alert'>
                Application submitted .
            </div>";
            }else if($_GET['msg'] == "failwithoutdoc"){
                echo "<div class='alert alert-danger' role='alert'>
                An error occurred, sorry for the inconvenience.
            </div>";
            }else if($_GET['msg'] == "applicationsubmitted"){
                echo "<div class='alert alert-success' role='alert'>
                Application submitted .
            </div>";
            }else if($_GET['msg'] == "failwithdoc"){
                echo "<div class='alert alert-danger' role='alert'>
                An error occurred, sorry for the inconvenience.
            </div>";
            }else if($_GET['msg'] == "errorhappen"){
                echo "<div class='alert alert-danger' role='alert'>
                An error occurred, sorry for the inconvenience.
            </div>";
            }else if($_GET['msg'] == "cannotsubmitfiletoobig"){
                echo "<div class='alert alert-danger' role='alert'>
                Files are too large, 6MB and below are only allowed
            </div>";
            }else if($_GET['msg'] == "filenotallowed"){
                echo "<div class='alert alert-danger' role='alert'>
                Only 'jpg', 'jpeg', 'png', 'pdf' files are allowed
            </div>";
            }
        }
        ?>
        <form action="include/applyleave.inc.php" method="POST" enctype="multipart/form-data">
        <div class="mb-3">
            <label for="startdate" class="form-label">Leave start date<span class="text-danger"> *</span></label>
            <input type="date" class="form-control" id="startdate" name="leave_start_date" required>
        </div>
        <div class="mb-3">
            <label for="enddate" class="form-label">Leave end date<span class="text-danger"> *</span></label>
            <input type="date" class="form-control" id="enddate" name="leave_end_date" required>
        </div>
        <div class="mb-3">
            <label for="leavetaken" class="form-label">Total day<span class="text-secondary"> (excluding public holidays)</span><span class="text-danger"> *</span></label>
            <input type="number" class="form-control" id="leavetaken" name="total_leave_taken" onkeypress="return restrictAlphabets(event)" required>
        </div>
        <div class="mb-3">
        <label for="leavetype" class="form-label">Type of leave<span class="text-danger"> *</span></label>
            <select class="form-select" id="leavetype" aria-label="Default select example" name="leave_type" onchange="outstationfield(this)">
                <option selected disabled>--Select the type of leave--</option>
                <option value="Annual Leave">Annual Leave</option>
                <option value="Medical Leave">Medical Leave</option>
                <option value="Hospitalization Leave">Hospitalization Leave</option>
                <option value="Outstation">Outstation</option>
            </select>
        </div>
        <div class="mb-3" id="venueid">
            <label for="venue" class="form-label">Venue<span class="text-secondary"> (Optional)</span></label>
            <input type="text" class="form-control" id="venue" name="venue">
            <input type="text" style="display: none;" class="form-control" name="userid" value="<?php echo $userid;?>">
            <input type="text" style="display: none;" class="form-control" name="managername" value="<?php echo $managerName;?>">
            
        </div>
        <div class="mb-3" id="organizerid">
            <label for="organizer" class="form-label">Organizer<span class="text-secondary"> (Optional)</span></label>
            <input type="text" class="form-control" id="organizer" name="organizer">
        </div>
        <div class="mb-3">
            <label for="reason" class="form-label">Reason<span class="text-secondary"> (Optional)</span></label>
            <input type="text" class="form-control" id="reason" name="reason">
        </div>        
        <div class="mb-3">
            <label for="document" class="form-label">Document<span class="text-secondary"> (Optional -'jpg', 'jpeg', 'png', 'pdf')</span></label>
            <input type="file" class="form-control" id="document" name="document">
        </div>
        <button type="submit" class="btn btn-primary btn-sm" name="submit">Submit</button>
        <button type="reset" class="btn btn-outline-secondary btn-sm">Cancel</button>
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

      function hide(){
        var venueid = document.getElementById('venueid');
        venueid.style.display = 'none';
        var organizerid = document.getElementById('organizerid');
        organizerid.style.display = 'none';
      }

      function show(){
        var venueid = document.getElementById('venueid');
        venueid.style.display = 'block';
        var organizerid = document.getElementById('organizerid');
        organizerid.style.display = 'block';
      }

      function outstationfield(select){
      if(select.value == 'Outstation'){
        show();
      }else if(select.value == 0){
        hide();
      } else{
        hide();
      }}
    </script>
    <script src="bootstrap/js/bootstrap.min.js"></script>
    <script src="js/script.js"></script>
</body>
</html>