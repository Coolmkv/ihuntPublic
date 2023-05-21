<?php

require_once '../../admin/config/db.php';
require_once '../../admin/config/database.class.php';
require_once '../../admin/config/functions.php';
$d = new database($db_config);

$countryId = $_POST['countryId'];
$qr1 = 'SELECT * FROM states WHERE countryId="' . $countryId . '" ORDER BY name';
$res1 = $d->selectQueryInArray($qr1);

echo json_encode($res1);

?>


