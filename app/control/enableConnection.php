<?php

    require_once '../../config/config.php';
    class Database {
        private static $instance = null;
        private static $conn;
    
        private $dbname = DB_NAME;
        private $servername = DB_HOST;
        private $password = DB_PASSWORD;
        private $username = DB_USER;
    
        private function __construct() {
            try {
                self::$conn = new PDO("mysql:host=$this->servername;dbname=$this->dbname", $this->username, $this->password);
                self::$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            } catch(PDOException $e) {
                //echo "Errore di connessione al database: " . $e->getMessage();
                header("Location: ../view/connectionErrorPage.php?error=".$e->getMessage());
                exit();
            }
        }
    //TODO fixeME
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