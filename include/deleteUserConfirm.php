<?php
include 'dbh.php';
include 'function.inc.php';

if(isset($_GET['idstaff'])){
    //echo $_GET['idstaff'];

    $idstaff = base64_decode($_GET['idstaff']);

   // echo $idstaff;
   
}else{
    header("Location: ../login.php");
}
$result = getProfilepicname($conn, $idstaff);
$profilepicname = mysqli_fetch_assoc($result);
$profilepic = $profilepicname['profilepic'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/admin.css"/>
    <link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css"/>
    <title>Confirmation for delete</title>
    <style>
        .confirm-container{
            display: block;
            width: 500px;
            margin: 4em auto;
            padding: 3em 0;
            border-radius: 1em;
            background-color: rgb(231, 230, 230);
        }
        .confirm-container h5{
            text-align: center;
        }
        .confirm-container h6{
            text-align: center;
        }
        .btn-container{
            width: max-content;
            margin: 1em auto;
        }
        #btn-cancel{
            width: 70px;
            margin: 0 auto;
            
        }
        #btn-cancel a{
            text-decoration: none;
            color: white;
        }
        
        @media screen and (max-width: 414px){
            .confirm-container{
                width: 90%;
            }
            
        
        }
    </style>
</head>
<body>

<div class="confirm-container">    
    <h5>
         Are you sure?
    </h5>
    <h6>
       All information about this user will be deleted !!
    </h6>
    <div class="btn-container">
        <form action="deleteUserConfirm.php" method="POST">
            
             <input style="display: none;" name="idstaff" value="<?php echo $idstaff;?>"/>
            <input style="display: none;" name="profilepic" value="<?php echo $profilepic;?>"/>       
            <button class="btn btn-danger" type="submit" name="submit">Delete</button>
            
        </form>        
    </div>
    <div id="btn-cancel">
        <button class="btn btn-secondary"><a href="../deleteUser.php">Cancel</a></button>       
    </div>
    
           
</div>

<?php
if (isset($_POST['submit'])){
    $idstaff = $_POST['idstaff'];
    $profilepic = $_POST['profilepic'];

    $tables = array("unplanned_leave","unpaid_leave","studies_leave","position","position_history","merit_history","merit","leave_quota","medical_leave_available","maternity_leave","leave_available","leave_application_approved","leave_application","hospitalisation_leave","compassionate_leave");
    foreach($tables as $table) {
    $sql = "DELETE FROM $table WHERE userid ='$idstaff'";
    if(mysqli_query($conn,$sql)){
        $sql2 = "DELETE FROM user WHERE userid = '$idstaff';";
        if(mysqli_query($conn,$sql2)){
            $path = "../profilepic/".$profilepic."";
            unlink($path);
            header("Location: ../deleteUser.php?msg=deletesuccess"); 
        }else{
            header("Location: ../deleteUser.php?msg=deletefailed"); 
        }
    }else{
        header("Location: ../deleteUser.php?msg=deletefailed"); 
    }
    }


    //dear programmer:
    //when i wrote this code, only Allah and I knew how it worked.
    //Now, only Allah knows it!
    //Call this: MDEwMjU3Njk5Mg==

}
?>
<script src="../js/script.js"></script>
<script src="../bootstrap/js/bootstrap.min.js"></script>
</body>
</html>