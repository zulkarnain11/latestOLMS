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
    <title>Staff Login Page</title>
    <style>
      a{
        text-decoration: none;
      }
      a:hover{
        text-decoration: underline;
      }
    </style>
</head>
<body>

    <div class="containerLogo">
      <img src="image/logoktd1.png" alt="logo">
    </div>

    <div class="containerLogin">
    <?php
      if(isset($_GET["error"])){
        if($_GET["error"]=="passwordnotmatch"){
          echo "<p class='alert alert-primary' style='width:230px;'>*password not match!*</p>";
        }
      }

      if(isset($_GET["msg"])){
        if($_GET["msg"]=="passwordUpdate"){
          echo "<p class='alert alert-success' style='width:230px;'>Password has been reset !</p>";
        }
      }
    ?>
        <form name="loginForm" onsubmit="return validateFormLogin()" action="include/login.inc.php" method="POST">
          <div class="inputUsername">
            <label for="nric" class="labelIC">Identity card number</label><br>
            <input type="text"  id="nric" size="25" name="ic" autocomplete="off" onkeypress="return restrictAlphabets(event)">
            <p id="warningIC">hello</p>
          </div>
          <div class="inputPassword">
            
            <label for="inputPassword" class="labelPassword">Password</label><br>
            <input type="password"  id="inputPassword" size="25" name="UserPassword" autocomplete="off"><br>
            <input type="checkbox" onclick="functionHideShowPassword()"> <span class="showPassword">show password</span>
            <p id="warningPassword">hello</p>

          </div>

          <button type="submit" class="btn btn-primary" name="submit">Sign in</button>

          <p class="textInformation"><a href="forgetpassword.php">Forgot password?</a></p>
          <p class="textInformation">Sign in as <a href="adminlogin.php">Admin</a></p> 
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
    </script>
    <script type="text/javascript" src="js/script.js"></script>
</body>
</html>