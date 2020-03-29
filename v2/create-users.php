<?php

//headers to allow submit method and cross origin
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST");
header("Content-type: application/json; charset=UTF-8");

//include db files

include_once "../config/database.php";
include_once "../class/users.php";

//objects of DB and passing the returned db connection var to users class for accessing db

$db = new Database();
$connection = $db->connect();
$user_obj = new Users($connection);

//logical conditioning

if ($_SERVER['REQUEST_METHOD'] === "POST") {

    $data = json_decode(file_get_contents("php://input"));
    if (!empty($data->name) && !empty($data->email) && !empty($data->password)) {

        $user_obj->name = $data->name;
        $user_obj->email = $data->email;
        $user_obj->password = password_hash($data->password, PASSWORD_DEFAULT);

        if (!empty($user_obj->check_email())) { //the email var is already set by $user_obj

            http_response_code(500);

            echo json_encode(array(
                "status" => 0,
                "message" => "Email Not Available",
            ));

        } else {

            //create user
            if ($user_obj->create_users()) {

                http_response_code(200);

                echo json_encode(array(
                    "status" => 1,
                    "message" => "User Created",
                ));
                
            } else {
                http_response_code(500);

                echo json_encode(array(
                    "status" => 0,
                    "message" => "Failed To create user",
                ));
            }

        }

    } else {

        http_response_code(500);

        echo json_encode(array(
            "status" => 0,
            "message" => "All Data Needed",
        ));
    }
} else {

    http_response_code(503);

    echo json_encode(array(
        "status" => 0,
        "message" => "Access Denied",
    ));
}
