<?php

require_once '../../admin/config/db.php';
require_once '../../admin/config/database.class.php';
require_once '../../admin/config/functions.php';

$d = new database($db_config);

extract($_POST);
$Q_i = "INSERT INTO student_landing_details(name,mobile,education,courseTypeId,courseId,streamId,marks,scoreIelts,scorePte,scoreGate,scoreTofel,test,band,admissionForgein,admissionIndia,countryId,stateId,cityId,address)VALUES('$name','$mobile','$education','$courseTypeId','$courseId','$streamId','$marks','$scoreIelts','$scorePte','$scoreGate','$scoreTofel','$test','$band','$admissionForgein','$admissionIndia','$countryId','$stateId','$cityId','$address')";
$res = $d->insertQuery($Q_i);
$studentlandId=$d->last_insert_id;
if ($res) {
    if (isset($_FILES['document']['name'])) {
        for($i=0; $i<count($_FILES['document']['name']); $i++)  {
            $city_logo = $_FILES['document']['name'][$i];
            $file_pic = preg_replace('/\s+/', '_', $city_logo);
            $temp = explode(".", $file_pic);
            $extension = end($temp);
            $file_path = "../../uploads/document/";

            if (!file_exists("$file_path")) {
                mkdir("$file_path", 0777, true);
            }
            $file_pic = $temp[0] . mt_rand(100000000, 999999999) . "." . $extension;
            $upload_url = 'uploads/document/' . $file_pic;
            $file_path = $file_path . basename($file_pic);
            if (file_exists($file_path)) {
                unlink($file_path);
            }
            if (move_uploaded_file($_FILES["document"]["tmp_name"][$i], $file_path)) {
                $upload_url = $upload_url;
            }
            chmod("$file_path", 0777);
            $query = "INSERT INTO student_landing_document(`studentlandId`,`documentsImg`)VALUES('$studentlandId','$upload_url')";
            $res = $d->insertQuery($query);
        }
    }
    $query2 = "SELECT * FROM  student_landing_details as sd WHERE sd.studentlandId='$studentlandId'";
    $res = $d->selectQuerySingleRow($query2);
    $name=$d->singleDataSet->name;
    $mobile=$d->singleDataSet->mobile;
    $address1=$d->singleDataSet->address;
    $education=$d->singleDataSet->education;

    $to = "a.din.pangotra@gmail.com";
    $subject = "Student Details";
    $message = "Dear Admin," . "\n\n";
    $message = $message . "\r\r" . "Student Registered Successfully."."\r\r"."For More Details.<a href='http://ihuntbest.starlingsoftwares.in/admin/'>Click Here</a> " . "\n";
    $message = $message . "<html><body><table border='1'  align='center' style='border-collapse: collapse; width:30%'><tr><th colspan='2' style='text-align:center'>".$name."</th></tr><tr><th>Student Name</th><td>".$name."</td></tr><tr><th>Mobile</th><td>".$mobile."</td></tr><tr><th>Education</th><td>".$education."</td></tr><tr><th>Address</th><td>".$address1."</td></tr></table></body></html>";
    $message = $message . "\r\r" . "Thanks";
    $header = "MIME-Version: 1.0\r\n";
    $header .= "Content-type: text/html; charset: utf8\r\n";
    $header .= "From: support@ihuntbest.com";
    $mail = mail($to, $subject, $message, $header);

    $to = "nedcdelhi@gmail.com";
    $subject = "Student Details";
    $message = "Dear Admin," . "\n\n";
    $message = $message . "\r\r" . "Student Registered Successfully."."\r\r"."For More Details.<a href='http://ihuntbest.starlingsoftwares.in/admin/'>Click Here</a> " . "\n";
    $message = $message . "<html><body><table border='1'  align='center' style='border-collapse: collapse; width:30%'><tr><th colspan='2' style='text-align:center'>".$name."</th></tr><tr><th>Student Name</th><td>".$name."</td></tr><tr><th>Mobile</th><td>".$mobile."</td></tr><tr><th>Education</th><td>".$education."</td></tr><tr><th>Address</th><td>".$address1."</td></tr></table></body></html>";
    $message = $message . "\r\r" . "Thanks";
    $header = "MIME-Version: 1.0\r\n";
    $header .= "Content-type: text/html; charset: utf8\r\n";
    $header .= "From: support@ihuntbest.com";
    $mail = mail($to, $subject, $message, $header);

    echo '{"status":"success", "msg":"Saved Successfully"}';
} else {
    echo '{"status":"error", "msg":"Error in server, please contact admin!"}';
}

?>