<?php

require_once("config/database.php");
require_once("config/database_connect.class.php");

$pdo = database_connect::GetInstance()->GetPDO($DB_DSN, $DB_USER, $DB_PASSWORD);

$pdo->query("DROP DATABASE IF EXISTS $DB_NAME;");
require_once ("config/setup.php");
$pdo->query("USE $DB_NAME;");

for ($count = 1; $count <= 12; $count++)
{
    $pdo->query("
        INSERT INTO image_tbl(image_name, image_path)
        VALUES ('img_$count', 'images/imgs/$count.jpg');
    ");
}

?>