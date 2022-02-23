<?php

if(isset($_POST['edit'])){

    include 'dbh.php';
    require_once 'function.inc.php';

    $filename = $_FILES["uploadImg"]["name"];
    $tempname = $_FILES["uploadImg"]["tmp_name"];
    $fileError = $_FILES["uploadImg"]["error"];
    $fileSize = $_FILES["uploadImg"]["size"];

        
    $fileExt = explode('.', $filename);
    $fileActualExt = strtolower(end($fileExt));

    $allowed = array('jpg', 'jpeg', 'png');

    $userid = $_POST['userid'];
    $ic = $_POST['nric'];
    $idstaff = $_POST['idstaff'];
    $fullname = strtoupper($_POST['fullname']);
    $username = $_POST['username'];
    $email = $_POST['email'];
    $address = strtoupper($_POST['address']);
    $department = strtoupper($_POST['department']);
    $start_year = $_POST['startyear'];
    $telephone_num = $_POST['telephone_num'];

    /**for deleted old picture from root folder */
    $result= getOldPictures($conn, $userid);
    $oldPic = mysqli_fetch_assoc($result);

    $oldPicName = $oldPic['profilepic'];

    echo $oldPicName;

    var_dump($_FILES["uploadImg"]);

    if($filename == ""){
        $sql = "UPDATE user
        SET ic = '$ic', idstaff = '$idstaff', username = '$username', fullname = '$fullname', email = '$email', address = '$address', telephone_num = '$telephone_num', 
        department = '$department', start_year = '$start_year'
        WHERE userid = '$userid';";

        if(mysqli_query($conn, $sql)){
            header("Location: ../editUser.php?msg=successedit");
        }
        else{
            header("Location: ../editUser.php?msg=failedit");
        }
    }else if($filename != ""){
        if (in_array($fileActualExt, $allowed)){
            if($fileError === 0){
                if($fileSize < 3000000){
                    $fileNameNew = uniqid('', true).".".$fileActualExt;
    
                    $folder = "../profilepic/".$fileNameNew;
    
                    if (move_uploaded_file($tempname, $folder)){
                        $path = "../profilepic/".$oldPicName."";
                        unlink($path);

                        $sql = "UPDATE user
                        SET ic = '$ic', idstaff = '$idstaff', username = '$username', profilepic = '$fileNameNew',profilepic = '$fileNameNew', fullname = '$fullname', email = '$email', address = '$address', telephone_num = '$telephone_num', 
                        department = '$department', start_year = '$start_year'
                        WHERE userid = '$userid';";
    
                        $result2 = mysqli_query($conn, $sql);
                        if($result2){
                            header("Location: ../editUser.php?msg=successeditwithpic");
                        }else{
                            header("Location: ../editUser.php?msg=faileditwithpic");
                        }
                        header("Location: ../editUser.php?msg=successeditwithpic");
                    }
                }else{
                    header("Location: ../editUser.php?msg=fileistoobig");
                }
            }else{
                header("Location: ../editUser.php?msg=error");
            }
        }else{
            header("Location: ../editUser.php?msg=filenotsupport");
        }

    }

}else{
    header("Location: ../login.php");
}
