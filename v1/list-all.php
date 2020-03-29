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

if($_SERVER['REQUEST_METHOD'] ==="GET"){

    $data = $student->get_all_data();
    ///print_r($data);

    if($data->num_rows > 0){
        $students["records"] = array();
        while($row = $data->fetch_assoc()){
            array_push($students['records'], array(
                "id" => $row['id'],
                "name" => $row['name'],
                "email" => $row['email'],
                "mobile" => $row['mobile'],
            ));
        }
        http_response_code(200); //ok code
        echo json_encode(array(
            "status" => 1,
            "data" => $students['records']
        ));
    }
}else {
    http_response_code(503);
    echo json_encode(array(

        "status" => 0,
        "message" => "Access Denied"
    ));
}

?>