<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
if (!isset($_SESSION['id_usuario'])) {
    header("Location: /Login.php");
    exit;
}
$usuarioActual = $_SESSION['usuario'] ?? '';
$nombreActual = $_SESSION['nombre'] ?? $usuarioActual;
$rolActual = $_SESSION['rol'] ?? '';
$rolesPermitidos = ['Administrador', 'Editor', 'Operativo'];

if (!in_array($rolActual, $rolesPermitidos, true)) {
    $_SESSION = [];
    session_destroy();

    header("Location: Login.php");
    exit;
}
?>
