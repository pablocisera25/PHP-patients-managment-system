<?php

namespace App\migrations;

use App\config\Connection;

class CreateUsersTable {

    private $pdo;

    public function __construct()
    {
        $this->pdo = Connection::exportConnection();
    }

    public function up(): void{

        $sql = "
            CREATE TABLE IF NOT EXISTS users(
            id SERIAL PRIMARY KEY,
            username VARCHAR(50) NOT NULL UNIQUE,
            email VARCHAR(100) NOT NULL UNIQUE,
            password VARCHAR(255) NOT NULL,
            role VARCHAR(20) NOT NULL,
            isActive BOOLEAN DEFAULT FALSE,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP)
        ";

        try {
            $this->pdo->exec($sql);

            echo "Table 'users' has been successfully created\n";
        }catch(\PDOException $e){
            die("Error to create table: " . $e->getMessage());
        }
    }

    public function down(): void{
        $sql = "DROP TABLE IF EXISTS users";

        try {
            $this->pdo->exec($sql);
            echo "Table 'users' has been successfully eliminated";
        } catch (\PDOException $e) {
            die("Error to eliminate table: " . $e->getMessage());
        }
    }
}