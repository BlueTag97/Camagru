<?php

require_once("config/database.php");
require_once("config/database_connect.class.php");
require_once("images/gallery.php");

$pdo = database_connect::GetInstance()->GetPDO($DB_DSN, $DB_USER, $DB_PASSWORD);
$pdo->query("USE $DB_NAME;");

?>

<!doctype html>
<html>
    <head>
        <title>Gallery</title>
        <link rel="stylesheet" type="text/css" href="images/gallery.css">
        <script src="images/gallery.js"></script>
    </head>
    <body>
        <?php CreateGallery(-1, $pdo); ?>
    </body>
</html>