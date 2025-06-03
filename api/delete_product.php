<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
// Permitir solicitudes desde cualquier origen
header("Access-Control-Allow-Origin: *");
// Permitir solo métodos POST y OPTIONS
header("Access-Control-Allow-Methods: POST, OPTIONS");
// Permitir encabezado Content-Type para enviar JSON
header("Access-Control-Allow-Headers: Content-Type");
header("Content-Type: application/json; charset=UTF-8");

if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
    http_response_code(200);
    exit();
}

include 'db_connection.php';

// Leer datos JSON que vienen en el cuerpo de la petición
$inputJSON = file_get_contents('php://input');
$input = json_decode($inputJSON, true);

// Obtener el id del producto a eliminar, o null si no viene
$id = $input['id'] ?? null;

// Validar que se haya recibido el id
if ($id === null) {
  echo json_encode(["success" => false, "error" => "No se recibió el id"]);
  exit();
}


$id = intval($id);
// Armar la consulta para borrar el producto con ese id
$sql = "DELETE FROM productos WHERE id = $id";

// Ejecutar la consulta y devolver resultado
if ($conexion->query($sql) === TRUE) {
  echo json_encode(["success" => true]);
} else {
  echo json_encode(["success" => false, "error" => $conexion->error]);
}

// Cerrar la conexión
$conexion->close();
?>
