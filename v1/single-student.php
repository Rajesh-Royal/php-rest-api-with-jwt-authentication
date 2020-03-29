<?php

//Headers and rules to allow access to api
header("Access-Control-Allow-Origin: *"); //allow all origins localhost and cross-origins
header("Content-type: application/json; charset=UTF-8"); // specify the data types and charset encoading
header("Access-Control-Allow-Method: GET"); // api request method only POST

//include db configuration

include_once '../config/database.php';
include_once '../class/student.php';

$db = new Database();
//connect with the db through Database class connect method

$connection = $db->connect();

//initializing student class _construct function with connection parameter

$student = new Student($connection);

if($_SERVER['REQUEST_METHOD'] === "GET"){

    $param = json_decode(file_get_contents("php://input"));

    if(!empty($param->id)){
        $student->id = $param->id;
        $student_data = $student->get_Student_data();
        //print_r($student_data);

        if(!empty($student_data)){

            http_response_code(200);

            echo json_encode(array(
                "status" => 1,
                "data" => $student_data
            ));
        }else {
            
            http_response_code(404);

            echo json_encode(array(
                "status" => 0,
                "message" => "data not found"
            ));
        }
    }

}else {
    http_response_code(501);
    echo json_encode(array(
        
        "status" => 0,
        "message" => "access denied"
    ));
}

?>