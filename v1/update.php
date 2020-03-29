<?php

//Headers and rules to allow access to api
header("Access-Control-Allow-Origin: *"); //allow all origins localhost and cross-origins
header("Content-type: application/json; charset=UTF-8"); // specify the data types and charset encoading
header("Access-Control-Allow-Method: POST"); // api request method only POST

//include db configuration

include_once '../config/database.php';
include_once '../class/student.php';

$db = new Database();
//connect with the db through Database class connect method

$connection = $db->connect();

//initializing student class _construct function with connection parameter

$student = new Student($connection);

if ($_SERVER['REQUEST_METHOD'] === "POST") {

    $data = json_decode(file_get_contents("php://input"));
    //print_r($data);
    
    if (!empty($data->name) && !empty($data->email) && !empty($data->mobile) && !empty($data->id)) {
        //assign json object to variables
        $student->name = $data->name;
        $student->email = $data->email;
        $student->mobile = $data->mobile;
        $student->id = $data->id;


        //submit data by student class create_data() func()
        if ($student->update_student_data()) {
            http_response_code(200); //ok response
            echo json_encode(array(
                "status" => 1,
                "message" => "Student Record Updated"
            ));
        } else {
            http_response_code(500); //Internal Server Error
            echo json_encode(array(
                "status" => 0,
                "message" => "Failed to Update record"
            ));
        }

    }else{
        http_response_code(404); //not found
            echo json_encode(array(
                "status" => 0,
                "message" => "All Values Needed"
            ));
    }
    
} else {
    //access denied
    http_response_code(503); //Service unavailable
            echo json_encode(array(
                "status" => 0,
                "message" => "Access Denied"
            ));
}

?>