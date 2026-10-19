<?php
session_start();
if (isset($_SESSION['id_usuario'])) {
    header("Location: Index.php");
    exit;
}
$error = $_SESSION['error_login'] ?? '';
unset($_SESSION['error_login']);
?>
<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>INAC Activos | Iniciar sesión</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&family=Roboto:wght@400;500&display=swap" rel="stylesheet">
<style>
:root {
    --azul: #123B63;
    --azul-claro: #2F80ED;
    --fondo: #F4F6F8;
}
* {
    box-sizing: border-box;
}
body {
    margin: 0;
    min-height: 100vh;
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 30px;
    background: var(--fondo);
    font-family: 'Roboto', sans-serif;
}
.login-card {
    display: grid;
    grid-template-columns: 0.95fr 1.05fr;
    width: 100%;
    max-width: 960px;
    min-height: 540px;
    background: #fff;
    border: 1px solid #E7ECF2;
    border-radius: 20px;
    overflow: hidden;
    box-shadow: 0 20px 60px rgba(18, 59, 99, .12);
}
.panel-marca {
    position: relative;
    display: flex;
    flex-direction: column;
    justify-content: space-between;
    padding: 42px;
    overflow: hidden;
    color: white;
    background: linear-gradient(145deg, #123B63, #0B2946);
}
.panel-marca::before,
.panel-marca::after {
    content: "";
    position: absolute;
    border: 1px solid rgba(255,255,255,.10);
    border-radius: 50%;
    pointer-events: none;
}
.panel-marca::before {
    width: 350px;
    height: 350px;
    right: -170px;
    top: 80px;
}
.panel-marca::after {
    width: 250px;
    height: 250px;
    right: -120px;
    top: 130px;
}
.marca-contenido,
.marca-pie {
    position: relative;
    z-index: 1;
}
.marca-icono {
    display: flex;
    align-items: center;
    justify-content: center;
    width: 62px;
    height: 62px;
    margin-bottom: 30px;
    border: 1px solid rgba(255,255,255,.25);
    border-radius: 16px;
    background: rgba(255,255,255,.08);
    font-size: 29px;
}
.marca-icono img {
    display: block;
    width: 100%;
    height: 100%;
    padding: 5px;
    object-fit: contain;
}
.marca-titulo {
    margin: 0;
    font-family: 'Poppins', sans-serif;
    font-size: 31px;
    font-weight: 700;
    letter-spacing: -.8px;
}
.marca-linea {
    width: 48px;
    height: 4px;
    margin: 18px 0;
    border-radius: 5px;
    background: var(--azul-claro);
}
.marca-descripcion {
    max-width: 290px;
    color: #D7E4F0;
    font-size: 15px;
    line-height: 1.8;
}
.marca-pie {
    color: #B9CDDF;
    font-size: 12px;
}
.panel-formulario {
    display: flex;
    flex-direction: column;
    justify-content: center;
    padding: 55px 50px;
}
.etiqueta-superior {
    color: var(--azul-claro);
    font-family: 'Poppins', sans-serif;
    font-size: 11px;
    font-weight: 700;
    letter-spacing: 1.5px;
    text-transform: uppercase;
}
.titulo-formulario {
    margin: 10px 0 8px;
    color: var(--azul);
    font-family: 'Poppins', sans-serif;
    font-size: 27px;
    font-weight: 700;
}
.texto-formulario {
    margin-bottom: 32px;
    color: #778394;
    font-size: 14px;
    line-height: 1.7;
}
.form-label {
    margin-bottom: 9px;
    color: #344256;
    font-size: 13px;
    font-weight: 600;
}
.campo {
    position: relative;
}
.campo .icono-campo {
    position: absolute;
    top: 50%;
    left: 15px;
    transform: translateY(-50%);
    color: #8794A5;
    z-index: 3;
}
.form-control {
    height: 49px;
    padding: 10px 44px;
    border: 1px solid #DFE5ED;
    border-radius: 10px;
    color: #24364B;
    font-size: 14px;
    background: #FCFDFE;
}
.form-control::placeholder {
    color: #A1AAB7;
}
.form-control:focus {
    border-color: var(--azul-claro);
    background: #fff;
    box-shadow: 0 0 0 4px rgba(47,128,237,.10);
}
.boton-ver {
    position: absolute;
    top: 50%;
    right: 13px;
    transform: translateY(-50%);
    padding: 5px;
    border: 0;
    background: transparent;
    color: #718096;
    z-index: 4;
}
.boton-ingresar {
    height: 49px;
    margin-top: 10px;
    border: 0;
    border-radius: 10px;
    background: var(--azul);
    color: white;
    font-family: 'Poppins', sans-serif;
    font-size: 14px;
    font-weight: 600;
    transition: background .2s, transform .2s;
}
.boton-ingresar:hover {
    background: var(--azul-claro);
    color: white;
    transform: translateY(-1px);
}
.pie-formulario {
    margin-top: 30px;
    padding-top: 18px;
    border-top: 1px solid #EDF0F4;
    color: #98A2B0;
    font-size: 11px;
    text-align: center;
}
@media (max-width: 760px) {
    body {
        padding: 18px;
    }
    .login-card {
        max-width: 440px;
        grid-template-columns: 1fr;
    }
    .panel-marca {
        padding: 28px;
    }
    .marca-icono {
        width: 50px;
        height: 50px;
        margin-bottom: 18px;
        font-size: 23px;
    }
    .marca-titulo {
        font-size: 25px;
    }
    .marca-pie {
        margin-top: 25px;
    }
    .panel-formulario {
        padding: 32px 28px;
    }
    .titulo-formulario {
        font-size: 24px;
    }
}
</style>
</head>
<body>
<div class="login-card">
    <section class="panel-marca">
        <div class="marca-contenido">
            <div class="marca-icono">
                <img src="Logo/LogoCamus.webp" alt="Logo institucional">
            </div>
            <h1 class="marca-titulo">INAC Activos</h1>
            <div class="marca-linea"></div>
            <p class="marca-descripcion">
                Sistema de Gestión de Activos y Mantenimiento.
            </p>
        </div>
        <div class="marca-pie">
            <i class="bi bi-shield-check me-2"></i>
            Plataforma de gestión institucional
        </div>
    </section>
    <section class="panel-formulario">
        <span class="etiqueta-superior">Acceso al sistema</span>
        <h2 class="titulo-formulario">Bienvenido</h2>
        <p class="texto-formulario">
            Ingresa tus credenciales para acceder a la plataforma.
        </p>
        <?php if ($error !== ''): ?>
            <div class="alert alert-danger py-2 small" role="alert">
                <i class="bi bi-exclamation-circle me-2"></i>
                <?= htmlspecialchars($error) ?>
            </div>
        <?php endif; ?>
        <form action="validarLogin.php" method="POST">
            <div class="mb-4">
                <label for="usuario" class="form-label">Usuario</label>
                <div class="campo">
                    <i class="bi bi-person icono-campo"></i>
                    <input
                        type="text"
                        class="form-control"
                        id="usuario"
                        name="usuario"
                        placeholder="Escribe tu usuario"
                        maxlength="50"
                        autocomplete="username"
                        required
                        autofocus
                    >
                </div>
            </div>
            <div class="mb-4">
                <label for="clave" class="form-label">Contraseña</label>
                <div class="campo">
                    <i class="bi bi-lock icono-campo"></i>
                    <input
                        type="password"
                        class="form-control"
                        id="clave"
                        name="clave"
                        placeholder="Escribe tu contraseña"
                        autocomplete="current-password"
                        required
                    >
                    <button
                        type="button"
                        class="boton-ver"
                        id="mostrarClave"
                        aria-label="Mostrar contraseña"
                    >
                        <i class="bi bi-eye" id="iconoClave"></i>
                    </button>
                </div>
            </div>
            <button type="submit" class="btn boton-ingresar w-100">
                Iniciar sesión
                <i class="bi bi-arrow-right ms-2"></i>
            </button>
        </form>
        <div class="pie-formulario">
            INAC Activos · Sistema institucional
        </div>
    </section>
</div>
<script>
const campoClave = document.getElementById('clave');
const botonMostrar = document.getElementById('mostrarClave');
const iconoClave = document.getElementById('iconoClave');
botonMostrar.addEventListener('click', function () {
    const mostrar = campoClave.type === 'password';
    campoClave.type = mostrar ? 'text' : 'password';
    iconoClave.className = mostrar ? 'bi bi-eye-slash' : 'bi bi-eye';
    botonMostrar.setAttribute(
        'aria-label',
        mostrar ? 'Ocultar contraseña' : 'Mostrar contraseña'
    );
});
</script>
</body>
</html>