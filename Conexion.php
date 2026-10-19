<?php
$host ="sql213.infinityfree.com";
$usuario ="if0_42365384";
$contrasena ="c9Hf7F9T2lwAR";
$base_de_datos = "if0_42365384__inac_activos"; 
$conn = mysqli_connect($host, $usuario, $contrasena, $base_de_datos);
if (!$conn) {
    die("Conexión fallida: " . mysqli_connect_error());
}
mysqli_set_charset($conn, "utf8mb4");
?>