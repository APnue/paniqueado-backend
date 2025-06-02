<?php
// Permitir que cualquier origen acceda a este recurso
header('Access-Control-Allow-Origin: *');
// Permitir estos métodos HTTP
header('Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE');
// Permitir encabezados específicos para enviar datos JSON y autorización
header('Access-Control-Allow-Headers: Content-Type, Authorization');

// Responder rápido a las peticiones OPTIONS (preflight)
if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
    http_response_code(200);
    exit();
}

// Decir que la respuesta será JSON
header('Content-Type: application/json');

// Incluir conexión a la base de datos (asegúrate que db_connection.php crea $conexion)
include 'db_connection.php';

// Verificar que se recibió el parámetro id por GET
if (!isset($_GET['id'])) {
    echo json_encode(['error' => 'No se recibió id']);
    exit;
}

// Convertir el id recibido a entero para seguridad
$id = intval($_GET['id']);

// Preparar la consulta SQL para borrar el usuario con ese id
$sql = "DELETE FROM usuarios WHERE id = $id";

// Ejecutar la consulta y verificar si tuvo éxito
if ($conexion->query($sql) === TRUE) {
    // Respuesta JSON indicando éxito
    echo json_encode(['success' => true]);
} else {
    // Respuesta JSON con error si falla la consulta
    echo json_encode(['error' => $conexion->error]);
}

// Cerrar la conexión a la base de datos
$conexion->close();
?>
