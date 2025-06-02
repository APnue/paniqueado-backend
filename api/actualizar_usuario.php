<?php
// Permitir que cualquier origen haga peticiones a esta API
header('Access-Control-Allow-Origin: *');
// Permitir varios métodos HTTP
header('Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE');
// Permitir ciertos encabezados
header('Access-Control-Allow-Headers: Content-Type, Authorization');

// Si es una petición OPTIONS (preflight), responder OK y salir
if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
    http_response_code(200);
    exit();
}

// Definir que la respuesta será JSON
header('Content-Type: application/json');

// Conectar a la base de datos
include 'db_connection.php';

// Leer los datos enviados en formato JSON
$data = json_decode(file_get_contents("php://input"), true);

// Verificar que se reciban los datos necesarios
if (!isset($data['id'], $data['nombre'], $data['correo'], $data['telefono'])) {
    echo json_encode(['error' => 'Faltan datos obligatorios']);
    exit;
}

// Limpiar y preparar datos para evitar inyección SQL
$id = intval($data['id']);
$nombre = $conexion->real_escape_string($data['nombre']);
$correo = $conexion->real_escape_string($data['correo']);
$telefono = $conexion->real_escape_string($data['telefono']);
// Recibir notificaciones será 1 o 0 dependiendo si se envía o no
$recibir = (isset($data['recibir_notificaciones']) && $data['recibir_notificaciones']) ? 1 : 0;

// Preparar la consulta SQL para actualizar el usuario con esos datos
$sql = "UPDATE usuarios SET 
          nombre = '$nombre',
          correo = '$correo',
          telefono = '$telefono',
          recibir_notificaciones = $recibir
        WHERE id = $id";

// Ejecutar la consulta y devolver éxito o error
if ($conexion->query($sql) === TRUE) {
    echo json_encode(['success' => true]);
} else {
    echo json_encode(['error' => $conexion->error]);
}

// Cerrar la conexión a la base de datos
$conexion->close();
?>
