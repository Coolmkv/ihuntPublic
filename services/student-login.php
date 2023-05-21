<?php

session_start();
if ( $_SERVER['REQUEST_METHOD'] === 'POST' ) {

	require_once '../admin/config/db.php';
	require_once '../admin/config/database.class.php';
	require_once '../admin/config/functions.php';

	$d = new database( $db_config );
	if ( isset( $_POST['g-recaptcha-response'] ) ) {
		$response = $_POST['g-recaptcha-response'];
		$res      = recaptcha( $response );
		$res      = json_decode( $res, true );

		if ( $res['success'] != 1 ) {
			echo '{"status":"error","msg":"Recaptcha Not Verified.!!"}';
			exit();
		}
	}
	$Email     = $_POST['email'];
	$Password  = $_POST['password'];
	$Password1 = md5( $Password );
	$s_q       = 'SELECT * FROM student_login WHERE email="' . $Email . '"';
	$row       = $d->selectQuerySingleRow( $s_q );
	if ( $d->rowcount > 0 ) {
		$d_password   = $d->singleDataSet->password1;
		$verifyStatus = $d->singleDataSet->verifyStatus;
		if ( $Password1 == $d_password ) {
			if ( $verifyStatus == 1 ) {
				$d1    = new database( $db_config );
				$query = 'SELECT sd.studentName,sl.email,sl.studentId FROM student_login as sl INNER JOIN  student_details as sd ON sl.studentId=sd.studentId WHERE sl.email="' . $Email . '"';
				$d1->selectQuerySingleRow( $query );
				$_SESSION['webId']       = $d->singleDataSet->studentId;
				$_SESSION['studentName'] = $d->singleDataSet->studentName;
				$_SESSION['email']       = $d->singleDataSet->email;
				echo '{"status":"success","msg":"Login Successfully"}';
			} else {
				echo ' {"status":"error", "msg":"Account Not Verified, please Verify Your Account.!"}';
			}
		} else {
			echo '{"status":"error","msg":"Incorrect Password"}';
		}
	} else {
		echo '{"status":"error","msg":"Incorrect Email Id"}';
	}

}
?>