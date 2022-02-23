<?php
session_start();

if(!isset($_GET['apply'])){
    header("Location: ../login.php");
}
$hashId = '';
$applyId = '';
if(isset($_GET['apply'])){
    $hashId = $_GET['apply'];
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="../css/admin.css"/>
    <link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css"/>
    <title>Confirmation for Approve</title>
    <style>
        .confirm-container{
            width: 300px;
            margin: 5em auto;
        }
    </style>
</head>
<body>

<div class="confirm-container">
    <div class="card text-dark mb-3" style="max-width: 18rem;">
      <div class="card-header" style="background-color: #910b0b;color:#ffffff;"> Confirmation</div>
      <div class="card-body">
        <p class="card-text" style="color: #777777;">click the "Yes" button, if you agree with your choice</p>
            <a href="notAcceptedConfirm.inc.php?apply=<?php echo $hashId;?>" class="btn btn-sm btn-primary" name="submit">Yes</a>
            <span style="visibility: hidden;">''</span>
            <span><input
    class="btn btn-secondary btn-sm"
    action="action"
    onclick="window.history.go(-1); return false;"
    type="submit"
    value="No"
    /></span>

    </div>
    </div>

</div>


<script src="../js/script.js"></script>
<script src="../bootstrap/js/bootstrap.min.js"></script>   
</body>
</html>