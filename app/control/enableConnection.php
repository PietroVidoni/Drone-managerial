<?php

    require_once '../../config/config.php';
    class Database {
        private static $instance = null;
        private static $conn;
    
        private $servername = DB_HOST;
        private $username = DB_NAME;
        private $password = DB_USER;
        private $dbname = DB_PASSWORD;
    
        private function __construct() {
            try {
                self::$conn = new PDO("mysql:host=$this->servername;dbname=$this->dbname", $this->username, $this->password);
                self::$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            } catch(PDOException $e) {
                echo "Errore di connessione al database: " . $e->getMessage();
                exit;
            }
        }
    
        
        public static function getInstance() {
            if (!self::$instance) {
                self::$instance = new Database();
            }
            
            return self::$instance;
        }
    
        public function getConnection() {
            return self::$conn;
        }
        
        public function closeConnection(){
           self::$conn = null;
        }
    }    
    
?>