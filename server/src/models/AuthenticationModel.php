<?php

namespace App\models;

use App\config\Connection;
use App\migrations\CreateUsersTable;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class AuthenticationModel {

    protected static $pdo;
    protected static $table = "";
    private static $secret_key;
    private static $encryptAlgorithm;

    public static function init(): void{
        if(self::$pdo === null){
            $envs = require __DIR__."/../config/envs.php";

            self::$secret_key = $envs['SECRET_KEY'];
            self::$encryptAlgorithm = $envs['ENCRYPTALGORITHM'];

            self::$pdo = Connection::exportConnection();

            $migration = new CreateUsersTable();
            $migration->up();
        }
    }

    public static function register(array $data): array{
        self::init();

        $required = ["username", "email", "password", "role"];

        foreach($required as $field){
            if(empty($data[$field])){
                throw new \InvalidArgumentException("Field $field is required");
            }
        }

        $data["password"] = password_hash($data["password"], PASSWORD_DEFAULT);

        # extraemos del array las keys o columas 0
        $columns = implode(", ", array_keys($data));
        
        # aplicamos marcadores de posicion
        $placeholders = ":" . implode(", :", array_keys($data));

        $sql = "INSERT INTO users($columns)VALUES($placeholders)";

        try{
            $stmt = self::$pdo->prepare($sql);

            $stmt->execute($data);

            return[
                "success" => true,
                "id" => self::$pdo->lastInsertId(),
                "data"=>$data
            ];
        }catch(\PDOException $e){
            throw new \RuntimeException("error to registred: " . $e->getMessage());
        }
    }

    # implemenatar login

    public static function login(string $email, string $password): array{
        if(empty($email) || empty($password)){
            throw new \InvalidArgumentException("Fields required");
        }

        # verificar si el email existe en base de datos, si existe traemos los datos para verificar el password

        try{
            # Obtener el usuario por email
            $stmt = self::$pdo->prepare("SELECT * FROM users WHERE email= :email");
            $stmt -> execute(["email"=>$email]);
            $userFound = $stmt->fetch(\PDO::FETCH_ASSOC);

            # si no existe el user
            if(!$userFound){
                throw new \RuntimeException("User not found");
            }

            # verificar password
            if(!password_verify($password, $userFound['password'])){
                throw new \RuntimeException("Invalid Credentials");
            }

            # generar token

            $token = self::generateJWT([
                "id" =>$userFound['id'],
                "email" => $userFound['email'],
                "role" => $userFound['role']
            ]);

            return[
                "success"=> true,
                "user" => [
                    "id"=>$userFound['id'],
                    "username" => $userFound['email'],
                    "role"=> $userFound['role'],
                    "isActive" => $userFound['isActive']
                ],
                "token"=>$token
            ];

        }catch(\PDOException $e){
            throw new \RuntimeException("Database error: " .$e->getMessage());
        }
    }

    public static function generateJWT(array $userData): string{
        $issuedAt = time();
        $expirationTime= $issuedAt + 36000;

        $payload = [
            "iat" => $issuedAt,
            "exp" => $expirationTime,
            "data" => $userData
        ];

        return JWT::encode($payload, self::$secret_key, self::$encryptAlgorithm);
    }

    public static function validateToken(string $token): array {
        try {
            $decoded = JWT::decode($token, new Key(self::$secret_key, self::$encryptAlgorithm));
            return (array) $decoded->data;
        } catch(\Exception $e) {
            throw new \RuntimeException("Invalid token: " . $e->getMessage());
        }
    }
}