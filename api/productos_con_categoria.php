<?php
// Permitir peticiones desde cualquier origen
header("Access-Control-Allow-Origin: *");
// Solo permitir método GET
header("Access-Control-Allow-Methods: GET");
// Permitir cualquier encabezado
header("Access-Control-Allow-Headers: *");
// Indicar que la respuesta será JSON con codificación UTF-8
header("Content-Type: application/json; charset=UTF-8");

// Datos para conectarse a la base de datos
$servername = "fdb1028.awardspace.net";
$username = "4639680_panaderia";
$password = "y9SW;CKwQ_rhX33";
$dbname = "4639680_panaderia";

// Crear la conexión con la base de datos
$conexion = new mysqli($servername, $username, $password, $dbname);

// Verificar si la conexión falló
if ($conexion->connect_error) { 
    die("Connection failed: " . $conexion->connect_error); 
}

// Consulta para obtener productos con su categoría
$sql = "SELECT 
          productos.id AS producto_id,
          productos.nombre AS producto_nombre,
          productos.precio,
          categorias.nombre AS categoria_nombre
        FROM productos
        INNER JOIN categorias ON productos.id_categoria = categorias.id";

// Ejecutar la consulta
$resultado = $conexion->query($sql);

// Arreglo donde guardaremos todos los productos encontrados
$datos = [];

// Si hay resultados, los vamos agregando al arreglo $datos
if ($resultado->num_rows > 0) {
  while ($fila = $resultado->fetch_assoc()) {
    $datos[] = $fila;
  }
}

// Convertir el arreglo $datos a JSON y mostrarlo como respuesta
echo json_encode($datos);

// Cerrar la conexión a la base de datos
$conexion->close();
?>
