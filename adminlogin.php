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
    <title>Admin Login Page</title>
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
          echo "<p style='color: red;'>*password not match!*</p>";
        }elseif($_GET["error"]=="usernamewrong"){
          echo "<p style='color: red;'>*password not match!*</p>";
        }
      }
    ?>
        <form name="loginForm" onsubmit="return validateForm()" action="include/adminlogin.inc.php" method="POST">
          <div class="inputUsername">
            <label for="inputUsername" class="labelUsername">Username</label><br>
            <input type="text"  id="inputUsername" size="25" name="UserId" autocomplete="off">
            <p id="warningUsername">hello</p>
          </div>
          <div class="inputPassword">
            <label for="inputPassword" class="labelPassword">Password</label><br>
            <input type="password"  id="inputPassword" size="25" name="UserPassword" autocomplete="off"><br/>
            <input type="checkbox" onclick="functionHideShowPassword()"> <span class="showPassword">show password</span>
            <p id="warningPassword">hello</p>
          </div>

          <button type="submit" class="btn btn-primary" name="submit">Sign in</button>
          <p class="textInformation">Sign in as <a href="login.php">Staff</a></p>    
        </form>
       
    </div>
  
    
    <script src="js/script.js"></script>
    <script src="bootstrap/js/bootstrap.min.js"></script>
</body>
</html>