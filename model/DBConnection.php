<?php
    namespace Blog\model;

use PDO;

require_once "./DBInfos.php";

    class DBConnection{
        static $conn = null;

        const NAME = DB_NAME;
        const HOST = DB_HOST;
        const USER = DB_USER;
        const PSW = DB_PSW;

        private static function doConnection(){
            try{
                self::$conn = new PDO(
                    "mysql:host=" . self::HOST .
                    ";dbname=" . self::NAME , self::USER, self::PSW, array(\PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8", \PDO::ATTR_PERSISTENT => false) 
                );
                self::$conn->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
            } catch(\Exception $e){
                echo '<pre>Erreur : ' . $e->getMessage() . '</pre>';
                die('Could not connect to MySQL');
            }
            return self::$conn;
        }

        public static function getConnection(){
            if(self::$conn == null){
                self::doConnection();
            }
            return self::$conn;
        }
    }
?>