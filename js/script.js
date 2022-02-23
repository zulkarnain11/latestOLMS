//toggle for hide show password
function functionHideShowPassword() {
    var x = document.getElementById("inputPassword");
    if (x.type === "password") {
      x.type = "text";
    } else {
      x.type = "password";
    }
    
  }
//toggle for hide show password for adminPanel.php
function functionHideShow() {
  var y = document.getElementById("InputPassword1");
  if (y.type === "password") {
    y.type = "text";
  } else {
    y.type = "password";
  }
}

//toggle for hide show re-enter password for adminPanel.php
function functionHideShowRePassword() {
  var y = document.getElementById("InputPassword2");
  if (y.type === "password") {
    y.type = "text";
  } else {
    y.type = "password";
  }
}

//function validate login form

function validateForm(){
    var username = document.forms["loginForm"]["UserId"];
    var password = document.forms["loginForm"]["UserPassword"];
    var passwordlength = password.value;

    var warningUsername = document.getElementById("warningUsername");
    var warningPassword = document.getElementById("warningPassword");
    

    if (username.value == "" && password.value == ""){
        warningUsername.innerHTML = "enter a username";
        warningUsername.style.visibility = "visible";
        warningPassword.innerHTML = "enter the password";
        warningPassword.style.visibility = "visible";
        return false;
    }
    if (username.value == ""){
        warningUsername.innerHTML = "enter a username";
        warningUsername.style.visibility = "visible";
        return false;
    }

    if (password.value == ""){
        warningPassword.innerHTML = "enter the password";
        warningPassword.style.visibility = "visible";
        return false;
    }
   
}

//function validate login form

function validateFormLogin(){
  var nric = document.forms["loginForm"]["nric"];
  var password = document.forms["loginForm"]["UserPassword"];
  var passwordlength = password.value;

  var warningIC = document.getElementById("warningIC");
  var warningPassword = document.getElementById("warningPassword");
  

  if (nric.value == "" && password.value == ""){
      warningIC.innerHTML = "enter identity card number";
      warningIC.style.visibility = "visible";
      warningPassword.innerHTML = "enter the password";
      warningPassword.style.visibility = "visible";
      return false;
  }
  if (nric.value == ""){
      warningIC.innerHTML = "enter identity card number";
      warningIC.style.visibility = "visible";
      return false;
  }

  if (password.value == ""){
      warningPassword.innerHTML = "enter the password";
      warningPassword.style.visibility = "visible";
      return false;
  }
 
}
//validate add user
function validateAddUserForm(){
  var password = document.forms["addUserForm"]["InputPassword1"];
  var repassword = document.forms["addUserForm"]["InputPassword2"];
  var warningPassword = document.getElementById("warningPassword");

  if(password.value != repassword.value){
    warningPassword.innerHTML = "Password and re-enter password not match";
    repassword.style.outlineColor = "red";
    warningPassword.style.visibility = "visible";
    return false;
  }
}

