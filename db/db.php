<?php

class DB {
    private static $host = 'localhost';  
    private static $db = 'pasteleria';  
    private static $user = 'root';       
    private static $pass = '';          

    private static $connection = null;

    public static function getConnection() {
        if (self::$connection === null) {
            try {
                $dsn = "mysql:host=" . self::$host . ";dbname=" . self::$db;
                self::$connection = new PDO($dsn, self::$user, self::$pass);
                self::$connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            } catch (PDOException $e) {
                echo "Error de conexión: " . $e->getMessage();
            }
        }
        return self::$connection;
    }
}

?>
