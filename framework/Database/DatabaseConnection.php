<?php
/**
 * Created by PhpStorm.
 * User: AmauryD
 * Date: 18-03-18
 * Time: 21:05
 */

namespace Framework\Database;

use Framework\Config\ConfigReader;
use PDO;

class DatabaseConnection
{
    /* @var PDO $database */
    private static $database;

    /**
     * @param $sql
     * @param null $params
     * @return \PDOStatement
     */
    public static function query($sql, $params = null)
    {
        if ($params == null) {
            $resultat = self::getDatabase()->query($sql);
        }
        else {
            $resultat = self::getDatabase()->prepare($sql);
            $resultat->execute($params);
        }
        return $resultat;
    }

    /**
     * Tries to connect to the database with the config file options
     * @return PDO
     */
    public static function getDatabase()
    {
        if (isset(self::$database))
            return self::$database;

        $databaseConfig = ConfigReader::read('database');
        $ip = $databaseConfig['ip'];
        $dbname = $databaseConfig['name'];
        $port = $databaseConfig['port'];

        $databaseConnection = new PDO(
            "mysql:host=$ip;dbname=$dbname;charset=utf8;port=$port",
            $databaseConfig['username'],
            $databaseConfig['password'],
            (DEBUG) ?
                [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION] :
                [PDO::ATTR_ERRMODE => PDO::ERRMODE_SILENT]
        );

        self::$database = $databaseConnection;
        return self::$database;
    }
}