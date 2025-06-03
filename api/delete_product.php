<?php
// Mostrar errores en desarrollo (quítalos en producción)
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

include 'db_connection.php';

set_exception_handler(function($e) {
    http_response_code(500);
    echo json_encode(["success" => false, "error" => "Error interno del servidor: " . $e->getMessage()]);
    exit();
});

try {
    // Leer y decodificar JSON
    $inputJSON = file_get_contents('php://input');
    $input = json_decode($inputJSON, true);

    if (!isset($input['id'])) {
        echo json_encode(["success" => false, "error" => "No se recibió el id"]);
        exit();
    }

    $id = intval($input['id']);

    // Preparar consulta
    $stmt = $conexion->prepare("DELETE FROM productos WHERE id = ?");
    if (!$stmt) {
        throw new Exception("Error en la preparación de la consulta: " . $conexion->error);
    }

    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
    echo json_encode(["success" => true]);
} else {
    if ($conexion->errno === 1451) { // Código de error para violación de FK en MySQL
        echo json_encode([
            "success" => false,
            "error" => "No puedes eliminar este producto porque ya fue usado en pedidos."
        ]);
    } else {
        throw new Exception("Error al ejecutar la consulta: " . $stmt->error);
    }
}

    $stmt->close();
    $conexion->close();

} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(["success" => false, "error" => "Excepción capturada: " . $e->getMessage()]);
    exit();
}
?>
