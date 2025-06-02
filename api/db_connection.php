<?php
$host = 'crossover.proxy.rlwy.net';
$port = 56848;
$user = 'root';
$pass = 'XTjFdCZuyfSTrBHAbapYseFgMglSOLtG'; 
$dbname = 'railway'; 

$conexion = new mysqli($host, $user, $pass, $dbname, $port);

if ($conexion->connect_error) {
    die("Conexión fallida: " . $conexion->connect_error);
}
?>
