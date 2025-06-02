<?php
// Permitir que cualquier origen pueda hacer peticiones a esta API
header('Access-Control-Allow-Origin: *');
// Permitir varios métodos HTTP
header('Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE');
// Permitir ciertos encabezados en la petición
header('Access-Control-Allow-Headers: Content-Type, Authorization');

// Responder rápido si es una petición OPTIONS (preflight)
if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
    http_response_code(200);
    exit();
}

// Definir que la respuesta será JSON
header('Content-Type: application/json');

// Incluir archivo para conectar a la base de datos
include 'db_connection.php';

// Verificar que se envió el parámetro 'id' vía GET
if (!isset($_GET['id'])) {
    echo json_encode(['error' => 'No se recibió id']);
    exit;
}

// Convertir el id recibido a número entero para mayor seguridad
$id = intval($_GET['id']);

// Crear la consulta para obtener datos del usuario con ese id
$sql = "SELECT id, nombre, correo, telefono, fecha_registro, recibir_notificaciones FROM usuarios WHERE id = $id";

// Ejecutar la consulta
$result = $conexion->query($sql);

// Verificar que haya resultados y devolver el usuario o error
if ($result && $result->num_rows > 0) {
    $usuario = $result->fetch_assoc(); // Obtener datos en array asociativo
    echo json_encode(['usuario' => $usuario]); // Enviar datos al cliente en formato JSON
} else {
    echo json_encode(['error' => 'Usuario no encontrado']);
}

// Cerrar la conexión a la base de datos
$conexion->close();
?>
