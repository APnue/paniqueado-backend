<?php
// Permitir peticiones desde cualquier origen (CORS)
header('Access-Control-Allow-Origin: *');
// Permitir métodos HTTP específicos
header('Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE');
// Permitir encabezados específicos
header('Access-Control-Allow-Headers: Content-Type, Authorization');

// Si es una petición OPTIONS (preflight), responder OK y salir
if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
    http_response_code(200);
    exit();
}

// Decir que la respuesta será JSON
header('Content-Type: application/json');

// Conectar a la base de datos (archivo que contiene la conexión)
include 'db_connection.php';

// Leer datos JSON enviados en el cuerpo de la petición
$data = json_decode(file_get_contents("php://input"), true);

// Obtener valores, si no existen usar cadena vacía o 0 para booleans
$nombre = $data['nombre'] ?? '';
$correo = $data['correo'] ?? '';
$telefono = $data['telefono'] ?? '';
$recibir_notificaciones = 0;

// Procesar la casilla "recibir_notificaciones" con distintas formas posibles
if (isset($data['recibir_notificaciones'])) {
    if (is_bool($data['recibir_notificaciones'])) {
        // Si es booleano, convertir a 1 o 0
        $recibir_notificaciones = $data['recibir_notificaciones'] ? 1 : 0;
    } elseif (is_numeric($data['recibir_notificaciones'])) {
        // Si es número, usar su valor entero
        $recibir_notificaciones = intval($data['recibir_notificaciones']);
    } elseif (is_string($data['recibir_notificaciones'])) {
        // Si es cadena, interpretar 'true' o '1' como 1, cualquier otra cosa 0
        $recibir_notificaciones = ($data['recibir_notificaciones'] === 'true' || $data['recibir_notificaciones'] === '1') ? 1 : 0;
    }
}

// Validar que nombre y correo no estén vacíos, si falta uno, mandar error y salir
if (empty($nombre) || empty($correo)) {
    echo json_encode(['error' => 'Nombre y correo son obligatorios']);
    exit;
}

// Preparar la consulta SQL para insertar un nuevo usuario
$sql = "INSERT INTO usuarios (nombre, correo, telefono, recibir_notificaciones) 
        VALUES ('$nombre', '$correo', '$telefono', $recibir_notificaciones)";

// Ejecutar la consulta
if ($conexion->query($sql) === TRUE) {
    // Si funcionó, devolver éxito y el ID generado
    echo json_encode(['success' => true, 'id' => $conexion->insert_id]);
} else {
    // Si falló, devolver el error de la base de datos
    echo json_encode(['error' => $conexion->error]);
}

// Cerrar conexión a la base de datos
$conexion->close();
?>
