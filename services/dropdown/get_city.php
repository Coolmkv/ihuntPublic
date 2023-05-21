<?php

require_once '../../admin/config/db.php';
require_once '../../admin/config/database.class.php';
require_once '../../admin/config/functions.php';
$d = new database($db_config);
$stateId = $_POST['stateId'];
$qr1 = 'SELECT * FROM cities WHERE stateId="' . $stateId . '" ORDER BY name';
$res1 = $d->selectQueryInArray($qr1);
echo json_encode($res1);

?>



