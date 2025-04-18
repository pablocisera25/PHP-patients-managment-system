<?php

require __DIR__ . '/../vendor/autoload.php';

// Obtenemos la URI actual y dividimos
$URI = $_SERVER['REQUEST_URI'];
$uri = trim($URI, "/");
$segmentsUri = explode("/", $uri);

// Validamos que existan al menos dos segmentos
if (count($segmentsUri) < 3) {
    http_response_code(400);
    echo json_encode(["error" => "Faltan segmentos en la URL"]);
    exit;
}

$controllerSegment = ucfirst($segmentsUri[1]);
$methodSegment = $segmentsUri[2];

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    callController($controllerSegment, $methodSegment);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Leemos el cuerpo JSON
    $json = file_get_contents("php://input");
    $data = json_decode($json, true);

    if (json_last_error() !== JSON_ERROR_NONE) {
        http_response_code(400);
        echo json_encode(["error" => "JSON inválido"]);
        exit;
    }

    callController($controllerSegment, $methodSegment, $data);
}

function callController($segment, $methodSegment, $params = []) {
    $filepath = __DIR__ . "/../src/controllers/" . $segment . "Controller.php";

    if (file_exists($filepath)) {
        require_once $filepath;

        $className = "\\App\\Controllers\\" . $segment . "Controller";

        if (class_exists($className)) {
            if (method_exists($className, $methodSegment)) {
                // Llamamos al método estático con o sin parámetros
                call_user_func([$className, $methodSegment], $params);
            } else {
                http_response_code(404);
                echo json_encode(["error" => "Método '$methodSegment' no encontrado"]);
            }
        } else {
            http_response_code(404);
            echo json_encode(["error" => "Clase '$className' no encontrada"]);
        }
    } else {
        http_response_code(404);
        echo json_encode(["error" => "Archivo de controlador no encontrado"]);
    }
}