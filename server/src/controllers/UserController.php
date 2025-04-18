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
}


/**
 * ejemplo de uso de conexion:
 * <?php
 *
 *   use App\config\Connection;

 *   $pdo = Connection::exportConnection();

  *  // ¡y listo! ya podés usar $pdo directamente
   * $stmt = $pdo->query("SELECT * FROM pacientes");
    *$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

 */