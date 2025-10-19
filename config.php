<?php
class Config {
    const DB_HOST = 'localhost';
    const DB_NAME = 'timesheet_db';
    const DB_USER = 'root';
    const DB_PASS = '';
    
    public static function getConnection() {
        try {
            $pdo = new PDO(
                "mysql:host=" . self::DB_HOST . ";dbname=" . self::DB_NAME . ";charset=utf8",
                self::DB_USER,
                self::DB_PASS
            );
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
            return $pdo;
        } catch(PDOException $e) {
            die("Connection failed: " . $e->getMessage());
        }
    }
}
?>