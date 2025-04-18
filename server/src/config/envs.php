<?php

require __DIR__ . '/../../vendor/autoload.php';

echo "Cargando dotenv...\n";

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../../');
$dotenv->load();

$envs = [];

$envs['DATABASE_USER'] = $_ENV['DATABASE_USER'];
$envs['DATABASE_PASSWORD'] = $_ENV['DATABASE_PASSWORD'];
$envs['DATABASE_HOST'] = $_ENV['DATABASE_HOST'];
$envs['DATABASE_PORT'] = $_ENV['DATABASE_PORT'];
$envs['DATABASE_NAME'] = $_ENV['DATABASE_NAME'];

$envs['SECRET_KEY'] = $_ENV['SECRET_KEY'];
$envs['ENCRYPTALGORITHM'] = $_ENV['ENCRYPTALGORITHM'];

return $envs;