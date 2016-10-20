<?php

require_once("config/database.php");
require_once("config/database_connect.class.php");

$pdo = database_connect::GetInstance()->GetPDO($DB_DSN, $DB_USER, $DB_PASSWORD);

$pdo->query("DROP DATABASE IF EXISTS $DB_NAME;");
require_once ("config/setup.php");
$pdo->query("USE $DB_NAME;");


$pdo->query("
    INSERT INTO image_tbl(image_name, image_path)
    VALUES ('Borowitz-Donald-Trump-1200', 'images/imgs/Borowitz-Donald-Trump-1200.jpg');
");

$pdo->query("
    INSERT INTO image_tbl(image_name, image_path)
    VALUES ('download', 'images/imgs/download.jpeg');
");

$pdo->query("
    INSERT INTO image_tbl(image_name, image_path)
    VALUES ('images (1)', 'images/imgs/images (1).jpeg');
");

$pdo->query("
    INSERT INTO image_tbl(image_name, image_path)
    VALUES ('images (1)', 'images/imgs/images (1).png');
");

$pdo->query("
    INSERT INTO image_tbl(image_name, image_path)
    VALUES ('images (2)', 'images/imgs/images (2).jpeg');
");

$pdo->query("
    INSERT INTO image_tbl(image_name, image_path)
    VALUES ('images', 'images/imgs/images.jpeg');
");

$pdo->query("
    INSERT INTO image_tbl(image_name, image_path)
    VALUES ('images', 'images/imgs/images.png');
");

$pdo->query("
    INSERT INTO image_tbl(image_name, image_path)
    VALUES ('promo_5', 'images/imgs/promo_5.png');
");

$pdo->query("
    INSERT INTO image_tbl(image_name, image_path)
    VALUES ('random_detail', 'images/imgs/random_detail.jpg');
");

?>