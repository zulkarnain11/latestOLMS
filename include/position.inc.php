<?php

if(isset($_POST['submit'])){

    include 'dbh.php';
    include 'function.inc.php';

    $userid = $_POST['userid'];
    $position = $_POST['positionUpdate'];
    $positionDate = $_POST['position_start_date'];

    //echo $userid;
    //echo $position;
    //echo $positionDate;

    $sql = "SELECT * FROM position_history WHERE userid = '$userid';";
    $result = mysqli_query($conn, $sql);

    if($row = mysqli_num_rows($result) <1){
        $sql2 = "INSERT INTO position_history (position,position_date, userid)
        VALUES ('$position', '$positionDate', '$userid');";

        if(mysqli_query($conn, $sql2)){
            $sql3 = "INSERT INTO position (position_name, userid)
            VALUES ('$position', '$userid');";

            if(mysqli_query($conn, $sql3)){
                header("Location: ../position.php?msg=success");
            }else{
                header("Location: ../position.php?msg=failed");
            }
        }else{
            header("Location: ../position.php?msg=failed");
        }
    }else{
        $sql4 = "UPDATE position
        SET position_name = '$position'
        WHERE userid = '$userid';";

        if(mysqli_query($conn, $sql4)){
            $sql5 = "INSERT INTO position_history (position,position_date, userid)
            VALUES ('$position', '$positionDate', '$userid');";

            if(mysqli_query($conn, $sql5)){
                header("Location: ../position.php?msg=success");
            }else{
                header("Location: ../position.php?msg=failed");
            }
        }else{
            header("Location: ../position.php?msg=failed");
        }
    }
   
}else{
    header("Location: ../login.php");
}
