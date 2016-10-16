<?php

class database_connect
{
    private static $_instance = null;
    private static $_pdo = null;

    private function __construct(){}
    private function __clone(){}

    public static function GetInstance()
    {
        if (self::$_instance == null)
            self::$_instance = new database_connect();
        return self::$_instance;
    }

    public function GetPDO($DB_DSN, $DB_USER, $DB_PASSWORD)
    {
        if (self::$_pdo == null)
        {
            $DB_OPTIONS = array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION);
            self::$_pdo = new PDO($DB_DSN, $DB_USER, $DB_PASSWORD, $DB_OPTIONS);
        }
        return self::$_pdo;
    }

    public static function Doc()
    {
        return file_get_contents("database_connect.class.txt");
    }
}

?>