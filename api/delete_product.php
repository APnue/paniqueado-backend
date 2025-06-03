<?php
// Mostrar errores en desarrollo
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Headers CORS y JSON
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");
header("Content-Type: application/json; charset=UTF-8");

// Responder a preflight
if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
    http_response_code(200);
    exit();
}

// Conexión a la base de datos
include 'db_connection.php';

// Leer y decodificar el cuerpo de la solicitud
$inputJSON = file_get_contents('php://input');
$input = json_decode($inputJSON, true);

// Validar que se recibió el ID
if (!isset($input['id'])) {
    echo json_encode(["success" => false, "error" => "No se recibió el id"]);
    exit();
}

$id = intval($input['id']); // forzar a número entero

// Consulta segura con prepared statement
$stmt = $conexion->prepare("DELETE FROM productos WHERE id = ?");
$stmt->bind_param("i", $id);

if ($stmt->execute()) {
    echo json_encode(["success" => true]);
} else {
    echo json_encode(["success" => false, "error" => $stmt->error]);
}

$stmt->close();
$conexion->close();
?>
