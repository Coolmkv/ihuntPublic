<?php
error_reporting(E_ALL);
session_start();
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    require_once '../admin/config/db.php';
    require_once '../admin/config/database.class.php';
    require_once '../admin/config/functions.php';

    $d = new database($db_config);
    $email = $_POST['email'];
    $password1 = $_POST['new_password'];
    $new_password = md5($_POST['new_password']);
    $confirm_password = md5($_POST['confirm_password']);

        if ($new_password == $confirm_password) {
            $s_q = "SELECT * FROM login_details WHERE email='$email'";
            $num = $d->numRow($s_q);
            if ($num > 0) {
                $res1 = $d->selectQuerySingleRow($s_q);
                $forgetStatus = $d->singleDataSet->forgetStatus;
                $db_email = $d->singleDataSet->email;
                if($forgetStatus!=0){
                    if ($email == $db_email) {
                        $update = 'UPDATE login_details SET password="' . $password1 . '",password1="' . $new_password . '",forgetStatus=0 WHERE email="' . $email . '"';
                        $res = $d->updateQuery($update);
                        if ($res) {
                            echo '{"status":"success","msg":"password change successfully!"}';
                        } else {
                            echo '{"status":"error","msg":"Error in server, please contact Admin!"}';
                        }
                    } else {
                        echo'{"status":"error","msg":"Something went wrong in url"}';
                    }
                }else{
                    echo'{"status":"error","msg":"Your link is expired!"}';
                }
            } else {
                echo'{"status":"error","msg":"Unauthorised Access.!"}';
            }
        } else {
            echo '{"status":"error","msg":"New password and confirmed password did not match!"}';
        }






}


?>