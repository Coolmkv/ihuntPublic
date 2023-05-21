<?php


require_once '../../admin/config/db.php';
require_once '../../admin/config/database.class.php';
require_once '../../admin/config/functions.php';
$d = new database($db_config);
$cId = $_POST['cId'];
$qr1 = 'SELECT * FROM stream_details WHERE cId="' . $cId . '"';
$res1 = $d->selectQueryInArray($qr1);
echo json_encode($res1);

?>



