<?php
    class Database{
        
        private $hostname;
        private $dbname;
        private $username;
        private $password;
        private $conn;

        public function connect(){

            $this->hostname = "localhost";
            $this->dbname = "php_api";
            $this->username = "root";
            $this->password = "";

            $this->conn = new mysqli($this->hostname, $this->username, $this->password, $this->dbname);

            //checking connections with database

            if($this->conn->connect_error){
                print_r($this->conn->connect_error);
                exit;
            }else{
                return $this->conn;
                //echo "connection successfull";
                //print_r($this->conn);
            }

        }

    }

    
?>