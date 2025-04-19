<?php

namespace App\Controllers; 

use App\models\AuthenticationModel;

class UserController {

    public static function register($data = []) {
        header('Content-Type: application/json');

        try{
            $result = AuthenticationModel::register($data);

            http_response_code(201);

            echo json_encode([
                "success" => true,
                "message" => "User has been registered",
                "data" => $result
            ]);
        } catch(\InvalidArgumentException $e){
            http_response_code(400);
            echo json_encode([
                "success"=>false,
                "message"=>$e->getMessage()
            ]);
        } catch(\RuntimeException $e){
            http_response_code(500);
            echo json_encode([
                "success"=>false,
                "message"=> $e->getMessage()
            ]);
        }
    }

    public static function login($data = []) {
        header('Content-Type: application/json');

        try {
            $email = $data['email'];
            $password = $data['password'];
            $result = AuthenticationModel::login($email, $password);

            echo json_encode([
                "success" => true,
                "message" => "User logged successfully",
                "data" => $result
            ]);
        } catch (\PDOException $e) {
            http_response_code(500);
            echo json_encode([
                "status"=>false,
                "message"=> $e->getMessage()
            ]);
        }
    }
}