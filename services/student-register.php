<?php

require_once '../admin/config/db.php';
require_once '../admin/config/database.class.php';
require_once '../admin/config/functions.php';

$d = new database($db_config);
if (isset($_POST['g-recaptcha-response'])) {
    $response = $_POST['g-recaptcha-response'];
    $res = recaptcha($response);
    $res = json_decode($res, TRUE);

    if ($res['success'] != 1) {
        echo '{"status":"error","msg":"Recaptcha Not Verified.!!"}';
        exit();
    }
}
$name = $_POST['studentName'];
if (empty($name)) {
    echo '{"status:error","msg":"Name Can not be blank"}';
    exit();
}
if (!preg_match("/^[a-zA-Z ]*$/", $name)) {
    echo '{"status:error","msg":"Only letters and white space allowed"}';
    exit();
}
$mobile = $_POST['studentMobile'];
if (empty($mobile)) {
    echo '{"status:error","msg":"Mobile Can not be blank"}';
    exit();
}
$email = $_POST['email'];
if (empty($email)) {
    echo '{"status:error","msg":"Email Can not be blank"}';
    exit();
}
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    echo '{"status:error","msg":"Invalid Email Format"}';
    exit();
}
$password = $_POST['password'];
if (empty($password)) {
    echo '{"status:error","msg":"Password Can not be blank"}';
    exit();
}
$gender = $_POST['gender'];
$address = $_POST['address'];
$dob = $_POST['dob'];
$countryId = $_POST['countryId1'];
$stateId = $_POST['stateId1'];
$cityId = $_POST['cityId1'];
$orgAddress = $_POST['address'];
$user_password = md5($password);
$ip = $_SERVER['REMOTE_ADDR'];
$ipAddress = ip2long($ip);

$selectQuery = 'SELECT * FROM student_login WHERE email = "' . $email . '"';
if ($d->numRow($selectQuery) > 0) {
    echo '{"status":"error","msg":"Student Already Exists!"}';
    exit();
} else {
    $Q_i = 'INSERT INTO student_login(email,password,password1,studentName,ipAddress)VALUES("' . $email . '","' . $password . '","' . $user_password . '","' . $name . '","' . $ipAddress . '")';
    $res = $d->insertQuery($Q_i);
    $studentId = $d->last_insert_id;
    if ($res) {
        $Q_i = 'INSERT INTO student_details(studentId,studentName,studentMobile,countryId,stateId,cityId,location,gender,dob)VALUES("' . $studentId . '","' . $name . '", "' . $mobile . '","' . $countryId . '","' . $stateId . '","' . $cityId . '","' . $address . '","' . $gender . '","' . $dob . '")';
        $res = $d->insertQuery($Q_i);
	    $e = base64_encode($email);
	    $url = "http://ihuntbest.starlingsoftwares.in/verify?change=" . $e;
	    $to  = $email;
	    $subject = "iHuntBest Account Verification";
	    $message = "Please click the below link" . "\r" . "and Verify Your Account." . "\r\r" . $url . "\r\r" . "Best Regards," . "\r" . "iHuntBest";
	    $header = "From: support@ihuntbest.com";
	    $mail = mail($to, $subject, $message, $header);
        echo '{"status":"success","msg":"User Registered Successfully And Verification link send to your Email Address."}';
    } else {
        echo '{"status":"error","msg":"Error in server, please contact admin!"}';
    }
}




