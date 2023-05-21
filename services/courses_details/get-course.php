<?php

require_once '../../admin/config/db.php';
require_once '../../admin/config/database.class.php';
require_once '../../admin/config/functions.php';
$d = new database($db_config);

$ctId = $_POST['ctId'];
$qr1 = 'SELECT * FROM course_details WHERE ctId="' . $ctId . '"';
$res1 = $d->selectQueryInArray($qr1);

echo json_encode($res1);

?>


