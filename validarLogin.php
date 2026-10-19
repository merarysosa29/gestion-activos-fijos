<?php
session_start();
require_once 'Conexion.php';
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: Login.php");
    exit;
}
$usuario = trim($_POST['usuario'] ?? '');
$clave = $_POST['clave'] ?? '';
if ($usuario === '' || $clave === '') {
    $_SESSION['error_login'] = "Completa el usuario y la contraseña.";
    header("Location: Login.php");
    exit;
}
$sql = "SELECT u.id_usuario, u.nombre, u.usuario,
               u.contrasena, u.id_rol, u.estado,
               r.nombre_rol
        FROM usuario u
        INNER JOIN rol r ON u.id_rol = r.id_rol
        WHERE u.usuario = ?
        LIMIT 1";
$stmt = mysqli_prepare($conn, $sql);
if (!$stmt) {
    $_SESSION['error_login'] = "No se pudo procesar el inicio de sesión.";
    header("Location: Login.php");
    exit;
}
mysqli_stmt_bind_param($stmt, "s", $usuario);
mysqli_stmt_execute($stmt);
$resultado = mysqli_stmt_get_result($stmt);
$fila = mysqli_fetch_assoc($resultado);
mysqli_stmt_close($stmt);
if (
    !$fila ||
    !password_verify($clave, $fila['contrasena']) ||
    $fila['estado'] !== 'Activo'
) {
    $_SESSION['error_login'] =
        "Usuario o contraseña incorrectos, o cuenta inactiva.";
    header("Location: Login.php");
    exit;
}
session_regenerate_id(true);
$_SESSION['id_usuario'] = $fila['id_usuario'];
$_SESSION['nombre'] = $fila['nombre'];
$_SESSION['usuario'] = $fila['usuario'];
$_SESSION['id_rol'] = $fila['id_rol'];
$_SESSION['rol'] = $fila['nombre_rol'];
header("Location: Index.php");
exit;
?>