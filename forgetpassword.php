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
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@200&display=swap" rel="stylesheet">
    <title>Forget Password Page</title>
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
        <form name="loginForm" action="include/forgetpassword.inc.php" method="POST">
        <?php
        if(isset($_GET["msg"])){
            if($_GET["msg"]=="send"){
              echo "
              <div class='alert alert-success' role='alert'>
              Please check your email, if you no longer receive email from us, please try again after 2 minutes
              </div>";
            }else if($_GET["msg"]=="emailerror"){
              echo "
              <div class='alert alert-warning' role='alert'>
              E-mail does not exist in the system!
              </div>";
            }else if($_GET["msg"] == "error"){
              echo "
              <div class='alert alert-warning' role='alert'>
              Error happening ! iam sorry
              </div>";
            }else if($_GET["msg"] == "succes"){
              echo "
              <div class='alert alert-succes' role='alert'>
              Check your e-mail!
              </div>";
            }
        }

        ?>
          <div class="inputUsername">
            <label for="email1" class="labelUsername">E-mail address</label><br>
            <input type="email"  id="email1" size="30" name="email" autocomplete="off" required>
            <p id="warningUsername">hello</p>
          </div>

          <button type="submit" class="btn btn-primary" name="submit">Submit</button>

        </form>
        <p class="textInformation">Go to the <a href="login.php">login page</a></p>    
    </div>
  
    
    <script src="js/script.js"></script>
</body>
</html>