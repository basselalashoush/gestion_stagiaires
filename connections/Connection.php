<?php

/**
 * Description of Connection
 *
 * @author uInfo
 */
class Connection {

    public static $server = 'localhost';
    public static $db_name = 'stagiaires';
    public static $user = 'root';
    public static $pwd = '';
    public static $pdo;
    public static $is_connected = NULL;

    public function __construct() {
        try {
            $connect = 'mysql:dbname='.self::$db_name.';'.self::$server;
            self::$pdo = new PDO($connect, self::$user, self::$pwd,array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8'));
            self::$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
         
        } catch (PDOException $ex) {
             echo('Erreur : ' . $ex->getMessage());
        }

    }

    public function _destruct() {
        self::$is_connected = null;
    }

    public static function getPDO() {
        if (self::$is_connected === NULL) {
            new Connection();
            
        }
        return self::$pdo;
    }
   
}
