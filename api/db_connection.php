<?php
$host = 'ballast.proxy.rlwy.net';
$port = 16875;
$user = 'root';
$pass = 'MWroSKktNmZigNeuIAyORjggCKArEdhy'; 
$dbname = 'railway'; 

$conexion = new mysqli($host, $user, $pass, $dbname, $port);

if ($conexion->connect_error) {
    die("Conexión fallida: " . $conexion->connect_error);
}
?>
