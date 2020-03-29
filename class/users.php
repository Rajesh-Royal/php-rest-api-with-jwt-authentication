<?php
    class Users{

        //define properties
        public $id;
        public $name;
        public $email;
        public $password;
        public $user_id;
        public $project_name;
        public $description;
        public $status;

        private $conn;
        private $users_table;
        private $project_table;

        public function __construct($db){

            $this->conn = $db;
            $this->users_table = "tbl_users";
            $this->project_table = "tbl_projects";
        }


        public function create_users(){

            $users_query = "INSERT INTO ".$this->users_table." SET name =?, email = ?, password = ?";

            $users_object = $this->conn->prepare($users_query);

            $users_object->bind_param("sss", $this->name, $this->email, $this->password);

            if($users_object->execute()){
                return true;
            }else {
                return false;
            }

        }

        public function check_email(){

            $email_query = "SELECT * FROM ".$this->users_table." where email = ? ";

            $user_obj = $this->conn->prepare($email_query);

            $user_obj->bind_param("s", $this->email);

            if($user_obj->execute()){

                $data = $user_obj->get_result();

                return $data->fetch_assoc();
            }

            return array();
        }
    }