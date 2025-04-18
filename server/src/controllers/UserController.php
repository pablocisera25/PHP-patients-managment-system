<?php

namespace App\Controllers; 

class UserController {
    public static function register($data = []) {
        header('Content-Type: application/json');

        if(
            empty($data["username"]) ||
            empty($data["email"]) ||
            empty($data["password"]) ||
            empty($data["role"])
        ){
            http_response_code(400);
            echo json_encode(["error"=>"Faltan datos en el cuerpo de la petición"]);
            return;
        }
        
        $hashedPassword = password_hash($data["password"], PASSWORD_DEFAULT);

        $data['password'] = $hashedPassword;

        echo json_encode(["status" => http_response_code(200), "data" => $data]);
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