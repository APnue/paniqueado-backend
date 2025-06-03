<?php
// Mostrar errores como JSON (NO HTML)
set_exception_handler(function($e) {
    http_response_code(500);
    echo json_encode(["success" => false, "error" => "Excepción capturada: " . $e->getMessage()]);
    exit();
});

set_error_handler(function($errno, $errstr, $errfile, $errline) {
    http_response_code(500);
    echo json_encode(["success" => false, "error" => "Error: $errstr en $errfile línea $errline"]);
    exit();
});

// CORS y JSON
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");
header("Content-Type: application/json; charset=UTF-8");

if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
    http_response_code(200);
    exit();
}

// Conexión
include 'db_connection.php';

// Leer entrada
$inputJSON = file_get_contents('php://input');
$input = json_decode($inputJSON, true);

if (!isset($input['id'])) {
    echo json_encode(["success" => false, "error" => "No se recibió el id"]);
    exit();
}

$id = intval($input['id']);

$stmt = $conexion->prepare("DELETE FROM productos WHERE id = ?");
$stmt->bind_param("i", $id);

if ($stmt->execute()) {
    echo json_encode(["success" => true]);
} else {
    // Error de clave foránea
    if (strpos($stmt->error, 'foreign key constraint fails') !== false) {
        echo json_encode([
            "success" => false,
            "error" => "No puedes eliminar este producto porque ya fue usado en pedidos."
        ]);
    } else {
        throw new Exception($stmt->error);
    }
}

$stmt->close();
$conexion->close();
?>
