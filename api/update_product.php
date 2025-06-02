<?php
// Permitir peticiones desde cualquier origen
header("Access-Control-Allow-Origin: *");
// Permitir solo métodos POST y OPTIONS
header("Access-Control-Allow-Methods: POST, OPTIONS");
// Permitir el encabezado Content-Type para recibir JSON
header("Access-Control-Allow-Headers: Content-Type");

// Datos para la conexión a la base de datos
$servername = "fdb1028.awardspace.net";
$username = "4639680_panaderia";
$password = "y9SW;CKwQ_rhX33";
$dbname = "4639680_panaderia";

// Crear la conexión
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar si la conexión falló
if ($conn->connect_error) { 
    die("Connection failed: " . $conn->connect_error); 
}

// Obtener datos enviados en JSON desde la petición
$data = json_decode(file_get_contents("php://input"), true);

// Guardar los valores recibidos en variables
$id = $data['id'];
$nombre = $data['nombre'];
$precio = $data['precio'];
$id_categoria = $data['id_categoria'];

// Consulta para actualizar el producto con los nuevos datos
$sql = "UPDATE productos SET 
            nombre = '$nombre', 
            precio = $precio, 
            id_categoria = $id_categoria 
        WHERE id = $id";

// Ejecutar la consulta y enviar respuesta en JSON según el resultado
if ($conn->query($sql) === TRUE) {
  echo json_encode(["success" => true]);
} else {
  echo json_encode(["success" => false, "error" => $conn->error]);
}

// Cerrar la conexión a la base de datos
$conn->close();
?>
