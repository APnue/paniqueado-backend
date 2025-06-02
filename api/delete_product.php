<?php
// Permitir solicitudes desde cualquier origen
header("Access-Control-Allow-Origin: *");
// Permitir solo métodos POST y OPTIONS
header("Access-Control-Allow-Methods: POST, OPTIONS");
// Permitir encabezado Content-Type para enviar JSON
header("Access-Control-Allow-Headers: Content-Type");

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
