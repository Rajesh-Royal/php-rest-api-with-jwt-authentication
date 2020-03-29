<?php


    class Student{
        public $name;
        public $email;
        public $mobile;
        public $id;

        private $conn;
        private $table_name;

        
        //initialize with class object creation
        public function __construct($db){
            
            $this->conn = $db;
            $this->table_name = "user_data";
        }


        //function to insert record inside user_table
        public function create_data(){

            $query = "INSERT INTO ".$this->table_name." SET name = ?, email = ?, mobile = ?";
            //print_r($query);
            
            //prepare statement 
            $obj = $this->conn->prepare($query);
            

            //senetize extra symbol and tags to prevent sql injection

            $this->name = htmlspecialchars(strip_tags($this->name));
            $this->email = htmlspecialchars(strip_tags($this->email));
            $this->mobile = htmlspecialchars(strip_tags($this->mobile));

            $obj->bind_param("sss", $this->name, $this->email, $this->mobile);

            if($obj->execute()){
                return true;
            } 
        }

        public function get_all_data(){
            $sql_qery = "SELECT * from ".$this->table_name;
            $std_obj = $this->conn->prepare($sql_qery);
            //execute query
            $std_obj->execute();
            return $std_obj->get_result();
        }

        public function get_Student_data(){

            $sql_qery = "SELECT * from ".$this->table_name. " where id = ?"; //prepare the query
            $obj = $this->conn->prepare($sql_qery);

            $obj->bind_param("i", $this->id); // bind parameter with prepare query

            $obj->execute();

            $data = $obj->get_result();

            return $data->fetch_assoc();
        }

        public function update_student_data(){

            $update_query = "UPDATE $this->table_name SET name = ?, email = ?, mobile = ? where id = ?";

            //prepare query

            $query_object = $this->conn->prepare($update_query);

            //senetize parameters
            $this->id = htmlspecialchars(strip_tags($this->id));
            $this->name = htmlspecialchars(strip_tags($this->name));
            $this->email = htmlspecialchars(strip_tags($this->email));
            $this->mobile = htmlspecialchars(strip_tags($this->mobile));

            // echo $this->id,$this->mobile;
            
            $query_object->bind_param("sssi", $this->name, $this->email, $this->mobile, $this->id);

            if($query_object->execute()){
                return true;
            }else {
                return false;
            }

        }

        public function delete_student_data(){
            $delete_query = "DELETE from $this->table_name where id = ?";

            $query_object = $this->conn->prepare($delete_query);

             //senetize parameters
             $this->id = htmlspecialchars(strip_tags($this->id));

            $query_object->bind_param("i", $this->id);

            //we should check that the given parameter id is available in database or not after delete

            if($query_object->execute()){
                return true;
            }else {
                return false;
            }
        }
    }

?>