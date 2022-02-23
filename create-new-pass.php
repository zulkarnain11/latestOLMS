<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">    
    <link rel="stylesheet" href="css/login.css">  
    <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300&display=swap" rel="stylesheet">
    <title>Reset password</title>
    <style>
        .containerLogin{
            position: relative;
            top: 3em;
        }
    </style>
</head>
<body>



    <?php 
    $selector = $_GET['selector'];
    $validate = $_GET['validate'];

    if(empty($selector) || empty($validate)){
        echo "Could not validate your request";
    }else{
        
        if(!empty($selector) !== false && !empty($validate) !== false){
            ?>
            
            <div class="containerLogin">
    <?php
      if(isset($_GET["error"])){
        if($_GET["error"]=="passwordnotmatch"){
          echo "<p class='alert alert-primary' style='width:230px;'>*password not match!*</p>";
        }
      }
    ?>
        <form name="formPass" onsubmit="return validatePass()"  action="include/reset-password.inc.php" method="POST">
          
          <div class="inputPassword">
              
            <h5 style="width: 250px;" class="text-light bg-dark p-2">Reset Password</h5><br>

            <input type="hidden" name="selector" value="<?php echo $selector;?>">
            <input type="hidden" name="validate" value="<?php echo $validate;?>">


            <input type="password"  id="inputPassword" size="25" name="pwd" autocomplete="off" placeholder="Enter a new password" requird><br>
            <input type="checkbox" onclick="functionHideShowPassword()"> <span class="showPassword">show password</span>
            <p id="warningPassword">hello</p>

            <input type="password" id="InputPassword2" size="25" name="repwd" autocomplete="off" placeholder="Repeat new password" required><br>
            <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault" onclick="functionHideShowRePassword()"> <span class="showPassword">show password</span>
            <p id="warningPassword">hello</p>

          </div>

          <button type="submit" class="btn btn-primary" name="reset-password">Reset password</button>
        </form>
           
    </div>
            <?php
        }
    }
    ?>
    
  
    <script type="text/javascript">

      function validatePass(){
        var pass = document.forms['formPass']['inputPassword'];
        var repass = document.forms['formPass']['InputPassword2'];
        var warning = document.getElementById('warningPassword');

        if(pass.value != repass.value){

          alert("Password not same!");
          return false;
        }
      }


      /*code: 48-57 Numbers*/
      function restrictAlphabets(e){
          var x = e.which || e.keycode;
        if((x>=48 && x<=57))
          return true;
        else
          return false;
      }
    </script>
    <script type="text/javascript" src="js/script.js"></script>
</body>
</html>