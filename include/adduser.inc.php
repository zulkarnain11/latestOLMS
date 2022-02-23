<?php
/* file ini berfungsi untuk menambah user ke database
--untuk menambah gambar, pertama sekali mencipta unik 
id untuk setiap nama gambar.. kedua pindahkan gambar
dari temporary ke folder 'profilpic'.. langkah terakhir
muat naik maklumat gambar iaitu nama unik gambar dan
seluruh maklumat user ke database*/

if(isset($_POST['submit'])){

    require_once 'dbh.php';

    $filename = $_FILES["uploadImg"]["name"];
    $tempname = $_FILES["uploadImg"]["tmp_name"];
    $fileError = $_FILES["uploadImg"]["error"];
    $fileSize = $_FILES["uploadImg"]["size"];
        
    $fileExt = explode('.', $filename);
    $fileActualExt = strtolower(end($fileExt));

    $allowed = array('jpg', 'jpeg', 'png');

    $ic = $_POST['ic'];
    $idstaff = $_POST['idstaff'];
    $fullname = strtoupper($_POST['fullname']);
    $username = $_POST['username'];
    $password = $_POST['password'];
    $email = $_POST['email'];
    $address = strtoupper($_POST['address']);
    $telephone_num = $_POST['telephone_num'];
    $department = strtoupper($_POST['department']);
    $start_year = $_POST['startyear'];
    $merit = 100;
    $available = 1;

    $hashPassword = password_hash($password,PASSWORD_DEFAULT);

    $sql2 = "SELECT idstaff FROM user WHERE idstaff = '$idstaff';";
    $result = mysqli_query($conn,$sql2);

    $row = mysqli_fetch_assoc($result);

    if($row['idstaff'] != null || $row['idstaff'] != ""){
        header("Location: ../adminPanel.php?msg=idstaffhastaken");
        exit();
    }

    if (in_array($fileActualExt, $allowed)){
        if($fileError === 0){
            if($fileSize < 3000000){
                $fileNameNew = uniqid('', true).".".$fileActualExt;

                $folder = "../profilepic/".$fileNameNew;

                if (move_uploaded_file($tempname, $folder)){

                    $sql = "INSERT INTO user(ic,idstaff,username,userpassword,profilepic,fullname,email,address,department,telephone_num,start_year,available) 
                    VALUES('$ic','$idstaff','$username','$hashPassword','$fileNameNew',
                    '$fullname','$email','$address','$department','$telephone_num','$start_year','$available');";

                    $result = mysqli_query($conn, $sql);
                    if($result){
                        $sql2 = "SELECT userid FROM user WHERE idstaff = '$idstaff';";
                        $result2 = mysqli_query($conn, $sql2);

                        $useridFromUser = mysqli_fetch_assoc($result2);
                        $userid = $useridFromUser['userid'];

                        $sql3 = "INSERT INTO merit (merit, userid)
                        VALUES('$merit','$userid');";

                        mysqli_query($conn, $sql3);
                        header("Location: ../adminPanel.php?msg=uploadsuccess");
                    }else{
                        header("Location: ../adminPanel.php?msg=uploadfailed");
                    }
                    header("Location: ../adminPanel.php?msg=uploadsuccess");
                }
            }else{
                header("Location: ../adminPanel.php?msg=fileistoobig");
            }
        }else{
            header("Location: ../adminPanel.php?msg=error");
        }
    }else{
        header("Location: ../adminPanel.php?msg=filenotsupport");
    }

}else{
    header("Location: ../login.php");
}