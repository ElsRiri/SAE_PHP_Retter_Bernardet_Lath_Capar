<?php

namespace NetVOD\db;

class ConnectionFactory
{
    public static array $tab;
    public static ?\PDO $db = null;

    public static function setConfig( string $file ){
        return self::$tab = parse_ini_file($file);
    }

    public static function makeConnection(){
        $test = self::$tab['driver'].":host=".self::$tab['host']."; dbname=".self::$tab['database']."; charset=utf8";
        if(is_null(self::$db)) {
            try {
                self::$db = new \PDO($test, self::$tab['username'], self::$tab['password']);
            } catch (\Exception $e) {
                die('erreur ' . $e->getMessage());
            }
        }
        return self::$db;

    }
}