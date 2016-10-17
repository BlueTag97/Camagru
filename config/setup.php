<?php

require_once ("database.php");
require_once ("database_connect.class.php");

function Setup($DB_DSN, $DB_USER, $DB_PASSWORD, $DB_NAME)
{
    $pdo = database_connect::GetInstance()->GetPDO($DB_DSN, $DB_USER, $DB_PASSWORD);

    $pdo->query("CREATE DATABASE IF NOT EXISTS $DB_NAME;");
    $pdo->query("USE $DB_NAME;");

    $pdo->query("
        CREATE TABLE IF NOT EXISTS image_tbl(
          image_id INT AUTO_INCREMENT NOT NULL,
          image_name VARCHAR (50) NOT NULL,
          image_path VARCHAR (60) NOT NULL,
          image_public BOOLEAN NOT NULL DEFAULT TRUE, 
          image_likes INT NOT NULL DEFAULT 0,
          PRIMARY KEY (image_id)
        );
    ");

    $pdo->query("
        CREATE TABLE IF NOT EXISTS gallery_tbl(
          image_id INT NOT NULL,
          user_id INT NOT NULL,
          FOREIGN KEY (image_id) REFERENCES image_tbl(image_id)
        );
    ");
}

Setup($DB_DSN, $DB_USER, $DB_PASSWORD, $DB_NAME);

?>