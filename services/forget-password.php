<?php
error_reporting(E_ALL);
session_start();
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    require_once '../admin/config/db.php';
    require_once '../admin/config/database.class.php';
    require_once '../admin/config/functions.php';
    $d = new database($db_config);
    $email = $_POST['email'];
    $e = base64_encode($email);
     $select = 'SELECT * FROM login_details WHERE email="' . $email . '"';
        if ($d->numRow($select) > 0) {
            $res = $d->selectQuerySingleRow($select);
            $email = $d->singleDataSet->email;
            $update = 'UPDATE login_details SET forgetStatus=1 WHERE email="' . $email . '"';
            if ($d->updateQuery($update)) {

                $url = "http://ihuntbest.starlingsoftwares.in/change-password.php?change=" . $e;
                $address = $email;
                $to = $address;
                $subject = "Email Authentication";
                $message = "Please click the below link" . "\r" . "and follow the instruction given after open the link" . "\r\r" . $url . "\r\r" . "Best Regards," . "\r" . "Ihuntbest";
                $header = "From: dwivedi.nidhi@starlingrosy.com";
                $mail = mail($to, $subject, $message, $header);
                if ($mail) {
                    echo '{"status":"success","msg":"Mail hasbeen sent on your email id!"}';

                } else {
                    echo '{"status":"error", "msg":"Error in server,Please try again"}';
                }

            }
        } else {
            echo '{"status":"error","msg":"Email id not found!"}';
        }



}
?>