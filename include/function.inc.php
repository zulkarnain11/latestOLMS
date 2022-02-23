<?php

require_once 'dbh.php';

/* validate password untuk adminlogin */
function notMatch($conn, $username, $password){
    $result = "";
    $sql = "SELECT adminUsername,adminPassword FROM admin WHERE adminUsername = '$username' and adminPassword = '$password';";
    $result = mysqli_query($conn,$sql);
    while($row = mysqli_fetch_assoc($result)){
        if($username !== $row['adminUsername'] && $password !== $row['adminPassword']){
            return true;
        }else{
            return false;
        }
    }
    return true;
}
/* validate passsword untuk user login */
function notMatchLogin($conn, $username, $password){
    $result = "";
    $sql = "SELECT username,userpassword FROM user WHERE username = '$username' and userpassword = '$password';";
    $result = mysqli_query($conn,$sql);
    while($row = mysqli_fetch_assoc($result)){
        if($username !== $row['username'] && $password !== $row['userpassword']){
            return true;
        }else{
            return false;
        }
    }
    return true;
}

//forget password
function getPassword($conn,$to){
    $sql = "SELECT userpassword FROM user WHERE email = '$to';";
    $result  = mysqli_query($conn,$sql);
    return $result;

}

//untuk dapatkan semua nama yang ada pada table user
function getManagerName($conn){
    $sql = "SELECT fullname FROM user;";
    $result = mysqli_query($conn, $sql);
    return $result;
}

//get profilepic name
function getProfilepicname($conn, $idstaff){
    $sql = "SELECT profilepic,fullname FROM user
    WHERE userid = '$idstaff';";

    $result = mysqli_query($conn, $sql);

    return $result;
}

//untuk ambil nama gambar profil
function getOldPictures($conn, $userid){
    $sql = "SELECT profilepic FROM user WHERE userid = '$userid';";
    $result = mysqli_query($conn,$sql);
    return $result;
}

//untuk ambil current position
function currentPosition($conn, $userid){
    $sql = "SELECT position_name FROM position WHERE userid = '$userid'";
    $result = mysqli_query($conn, $sql);
    return $result;
}
//untuk ambil semua maklumat staff
function getAllStaff($conn){
    $sql = "SELECT * FROM user;";
    $result = mysqli_query($conn, $sql);
    return $result;
}

//untuk ambil maklumat seorang staff
function getStaffInfo($conn, $idstaff){
    $sql = "SELECT * FROM user WHERE userid = '$idstaff';";
    $result = mysqli_query($conn, $sql);
    return $result;
}

//check manager name untuk navigation
function checkManagerName($conn,$fullname){
    $sql = "SELECT manager_name FROM user WHERE manager_name = '$fullname';";
    $result = mysqli_query($conn,$sql);
    return $result;
}

//ambil annual balance 
function getAnnualBalance($conn, $userid, $year){
    $year = (int)$year - 1;
    $sql = "SELECT balance_annual_leave FROM leave_available
    WHERE userid = '$userid' AND year = '$year';";
    $result = mysqli_query($conn,$sql);
    return $result;
}

function annualBalance($conn, $userid, $year){
    $sql = "SELECT balance_annual_leave FROM leave_available
    WHERE userid = '$userid' AND year = '$year';";
    $result = mysqli_query($conn,$sql);
    return $result;
}

//ambil medical balance
function getMedicalBalance($conn, $userid, $year){
    $year = (int)$year - 1;
    $sql = "SELECT balance_medical_leave FROM medical_leave_available
    WHERE userid = '$userid' AND year = '$year';";
    $result = mysqli_query($conn,$sql);
    return $result;
}

function medicalBalance($conn, $userid, $year){
    $sql = "SELECT balance_medical_leave FROM medical_leave_available
    WHERE userid = '$userid' AND year = '$year';";
    $result = mysqli_query($conn,$sql);
    return $result;
}

//ambil hospitalization balance
function getHospitalizationBalance($conn, $userid, $year){
    $year = (int)$year - 1;
    $sql = "SELECT balance_hospitalisation_leave FROM hospitalisation_leave
    WHERE userid = '$userid' AND year = '$year';";
    $result = mysqli_query($conn,$sql);
    return $result;
}

function hospitalizationBalance($conn, $userid, $year){
    $sql = "SELECT balance_hospitalisation_leave FROM hospitalisation_leave
    WHERE userid = '$userid' AND year = '$year';";
    $result = mysqli_query($conn,$sql);
    return $result;
}

//nk check ada tak tahun tu 
function getYear($conn,$userid,$year){
    $sql = "SELECT year FROM leave_quota WHERE year = '$year' AND userid = '$userid';";
    $result = mysqli_query($conn,$sql);
    return $result;
}

//nk check ada tak tahun tu dalam leave_available
function getYearLeaveAvailable($conn, $userid, $year){
    $sql = "SELECT year FROM leave_available WHERE year = '$year' AND userid = '$userid'";
    $result = mysqli_query($conn,$sql);
    return $result;
}

//nk check ada tak tahun tu dalam medical leave available
function  getYearMedicalAvailable($conn, $userid, $year){
    $sql = "SELECT year FROM medical_leave_available WHERE year = '$year' AND userid = '$userid';";

    $result = mysqli_query($conn,$sql);
    return $result;
}

//nk check ada tak tahun tu dalam hospitalization leave
function getYearHospitalizationAvailable($conn, $userid, $year){
    $sql = "SELECT year FROM hospitalisation_leave WHERE year = '$year' AND userid = '$userid';";

    $result = mysqli_query($conn,$sql);
    return $result;
}

//ambil nilai quota pada tahun tu
function getQuota($conn, $idstaff,$year){
    $sql = "SELECT * FROM leave_quota WHERE userid = '$idstaff' AND year = '$year';";
    $result = mysqli_query($conn,$sql);
    return $result;
}

//ambil merit
function getMerit($conn,$idstaff){
    $sql = "SELECT merit FROM merit WHERE userid = '$idstaff';";
    $result = mysqli_query($conn,$sql);
    return $result;
}

//nk ambil data permohonan
function checkApply($conn, $userid){
    $sql = "SELECT * FROM leave_application
    WHERE userid = '$userid' AND available = 1
    ORDER BY id DESC;";
    $result = mysqli_query($conn,$sql);
    return $result;
}

//nk ambil nama document
function getDocumentName($conn,$applyId){
    $sql = "SELECT * FROM leave_application WHERE id = '$applyId';";
    $result = mysqli_query($conn,$sql);
    return $result;
}

//last year annual balance
function getLastYearAnnualBalance($conn, $userid, $lastyear){
    $sql = "SELECT balance_annual_leave FROM leave_available
    WHERE year = '$lastyear' AND userid = '$userid';";

    $result = mysqli_query($conn, $sql);
    return $result;
}

//quota current year
function getCurrentYearQuota($conn,$currentyear, $userid){
    $sql = "SELECT * FROM leave_quota WHERE year = '$currentyear' AND userid = '$userid';";
    $result = mysqli_query($conn,$sql);
    return $result;
}

//current year annual balance
function getCurrentYearAnnualBalance($conn, $userid, $currentyear){
    $sql = "SELECT balance_annual_leave FROM leave_available
    WHERE year = '$currentyear' AND userid = '$userid';";

    $result = mysqli_query($conn, $sql);
    return $result;
}

//current year medical balance
function getCurrentYearMedicalBalance($conn, $userid, $currentyear){
    $sql = "SELECT balance_medical_leave FROM medical_leave_available
    WHERE year = '$currentyear' AND userid = '$userid';";

    $result = mysqli_query($conn, $sql);
    return $result;
}

//current year hospitalization balance
function getCurrentYearHospitalizationBalance($conn, $userid, $currentyear){
    $sql = "SELECT balance_hospitalisation_leave FROM hospitalisation_leave
    WHERE year = '$currentyear' AND userid = '$userid';";

    $result = mysqli_query($conn, $sql);
    return $result;
}

//staff for manager 
function staffForManager($conn,$fullname){
    $sql = "SELECT * FROM user WHERE manager_name = '$fullname';";
    $result = mysqli_query($conn,$sql);
    return $result;
}

//dapatkan maklumat permohonan 
function getApplyForManager($conn,$fullname,$status){
    $sql = "SELECT * FROM leave_application
    WHERE manager_name = '$fullname' AND leave_approval = '$status' AND available = 1
    ORDER BY id DESC;";

    $result = mysqli_query($conn,$sql);
    return $result;
}

//dapatkan nama staff
function getStaffName($conn,$staffUserid){
    $sql = "SELECT fullname,department FROM user WHERE userid = '$staffUserid';";
    $result = mysqli_query($conn,$sql);
    return $result;
}

//dapatkan reason
function getReason($conn,$applyId){
    $sql = "SELECT * FROM leave_application WHERE id = '$applyId';";
    $result = mysqli_query($conn, $sql);
    return $result;
}

//get email 
function getEmail($conn, $userid){
    $sql = "SELECT email FROM user WHERE userid = '$userid';";
    $result = mysqli_query($conn, $sql);
    return $result;
}

//get manager email 
function getManagerEmail($conn, $managerName){
    $sql = "SELECT email FROM user WHERE fullname = '$managerName';";
    $result = mysqli_query($conn, $sql);
    return $result;
}

//TODO get annual history from leave_application_approved
function annualHistory($conn,$userid,$currentYear){
    $sql = "SELECT * FROM leave_application_approved
    WHERE userid = '$userid' AND year = '$currentYear' AND leave_type = 'Annual Leave'
    ORDER BY id DESC;";

    $result = mysqli_query($conn,$sql);
    return $result;
}

//TODO get medical history from leave_application_approved
function medicalHistory($conn,$userid,$currentYear){
    $sql = "SELECT * FROM leave_application_approved
    WHERE userid = '$userid' AND year = '$currentYear' AND leave_type = 'Medical Leave'
    ORDER BY id DESC;";

    $result = mysqli_query($conn,$sql);
    return $result;
}

//TODO get hospitalization history from leave_application_approved
function hospitalizationHistory($conn,$userid,$currentYear){
    $sql = "SELECT * FROM leave_application_approved
    WHERE userid = '$userid' AND year = '$currentYear' AND leave_type = 'Hospitalization Leave'
    ORDER BY id DESC;";

    $result = mysqli_query($conn,$sql);
    return $result;
}

//TODO get outstation history from leave_application_approved
function outstationHistory($conn,$userid,$currentYear){
    $sql = "SELECT * FROM leave_application_approved
    WHERE userid = '$userid' AND year = '$currentYear' AND leave_type = 'Outstation'
    ORDER BY id DESC;";

    $result = mysqli_query($conn,$sql);
    return $result;
}

//TODO get compassionate history from compassionate-leave
function compassionateHistory($conn,$userid,$currentYear){
    $sql = "SELECT * FROM compassionate_leave
    WHERE userid = '$userid' AND year = '$currentYear';";

    $result = mysqli_query($conn,$sql);
    return $result;
}

//TODO get maternity history from maternity-leave
function maternityHistory($conn,$userid,$currentYear){
    $sql = "SELECT * FROM maternity_leave
    WHERE userid = '$userid' AND year = '$currentYear';";

    $result = mysqli_query($conn,$sql);
    return $result;
}

//TODO get studies history from studies-leave
function studiesHistory($conn,$userid,$currentYear){
    $sql = "SELECT * FROM studies_leave
    WHERE userid = '$userid' AND year = '$currentYear';";

    $result = mysqli_query($conn,$sql);
    return $result;
}

//TODO get unpaid history from unpaid-leave
function unpaidHistory($conn,$userid,$currentYear){
    $sql = "SELECT * FROM unpaid_leave
    WHERE userid = '$userid' AND year = '$currentYear';";

    $result = mysqli_query($conn,$sql);
    return $result;
}

//TODO get unplanned history from unplanned-leave
function unplannedHistory($conn,$userid,$currentYear){
    $sql = "SELECT * FROM unplanned_leave
    WHERE userid = '$userid' AND year = '$currentYear';";

    $result = mysqli_query($conn,$sql);
    return $result;
}
