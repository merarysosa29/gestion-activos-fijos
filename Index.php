<?php
require_once 'Sesiones.php';
$rol = $rolActual;
$esAdmin = ($rol === 'Administrador');
$nombreSeguro = htmlspecialchars($nombreActual ?? $usuarioActual, ENT_QUOTES, 'UTF-8');
$usuarioSeguro = htmlspecialchars($usuarioActual ?? '', ENT_QUOTES, 'UTF-8');
$rolSeguro = htmlspecialchars($rol, ENT_QUOTES, 'UTF-8');
?>
<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>INAC Activos | Panel de gestión</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
<link rel="stylesheet" href="style.css">
<style>
.barra-superior {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 15px;
    flex-wrap: nowrap;
}
.barra-superior-izquierda,
.barra-superior-derecha {
    display: flex;
    align-items: center;
    min-width: 0;
}
.barra-superior-izquierda {
    flex: 1 1 auto;
    gap: 12px;
}
.barra-superior-derecha {
    flex: 0 1 auto;
    justify-content: flex-end;
    gap: 12px;
}
.titulo-pagina {
    min-width: 0;
}
.usuario-superior {
    display: flex !important;
    align-items: center;
    gap: 8px;
    min-width: 0;
    padding-left: 12px;
    border-left: 1px solid #E7ECF2;
}
.usuario-avatar {
    display: grid;
    flex: 0 0 38px;
    width: 38px;
    height: 38px;
    place-items: center;
    border-radius: 12px;
    background: #DCEBFC;
    color: #123B63;
    font-size: 20px;
}
.usuario-superior-datos {
    display: flex !important;
    flex-direction: column;
    min-width: 0;
    max-width: 180px;
}
.usuario-superior-datos strong {
    display: block;
    overflow: hidden;
    color: #123B63;
    font-size: 12px;
    text-overflow: ellipsis;
    white-space: nowrap;
}
.usuario-superior-datos small {
    display: block;
    overflow: hidden;
    color: #718096;
    font-size: 10px;
    text-overflow: ellipsis;
    white-space: nowrap;
}
.boton-salir {
    display: inline-flex;
    flex: 0 0 auto;
    align-items: center;
    justify-content: center;
    gap: 6px;
    padding: 9px 12px;
    border: 1px solid #F0D5D5;
    border-radius: 9px;
    background: #FFFFFF;
    color: #C63D3D;
    font-size: 12px;
    font-weight: 600;
    text-decoration: none;
    white-space: nowrap;
}
.boton-salir:hover {
    background: #C63D3D;
    color: #FFFFFF;
}
.barra-lateral {
    height: 100vh;
    position: sticky;
    top: 0;
    overflow: hidden;
}
.navegacion {
    flex: 1;
    min-height: 0;
    overflow-y: auto;
    overflow-x: hidden;
    padding-right: 5px;
    scrollbar-width: thin;
    scrollbar-color: #496b8b #123B63;
}
.navegacion::-webkit-scrollbar {
    width: 6px;
}
.navegacion::-webkit-scrollbar-thumb {
    background: #496b8b;
    border-radius: 10px;
}
@media (max-width: 768px) {
    .barra-lateral {
        height: auto;
        min-height: 0;
        position: fixed;
    }
    .navegacion {
        max-height: 40vh;
    }
    .barra-superior {
        flex-wrap: nowrap;
        gap: 8px;
    }
    .barra-superior-izquierda {
        flex: 1 1 auto;
        width: auto;
        gap: 8px;
    }
    .barra-superior-derecha {
        flex: 0 1 auto;
        width: auto;
        justify-content: flex-end;
        gap: 8px;
    }
    .estado-sesion {
        display: none !important;
    }
    .usuario-superior {
        flex: 0 1 auto;
    }
    .usuario-superior-datos {
        max-width: 130px;
    }
}
@media (max-width: 420px) {
    .barra-superior {
        gap: 6px;
        padding: 10px;
    }
    .barra-superior-izquierda {
        gap: 6px;
    }
    .barra-superior-derecha {
        gap: 6px;
    }
    .usuario-superior-datos {
        max-width: 88px;
    }
    .usuario-superior-datos strong {
        font-size: 10px;
    }
    .usuario-superior-datos small {
        font-size: 8px;
    }
    .usuario-avatar {
        flex-basis: 30px;
        width: 30px;
        height: 30px;
    }
    .boton-salir {
        gap: 4px;
        padding: 7px;
        font-size: 10px;
    }
    .boton-menu {
        flex-basis: 34px;
        width: 34px;
        height: 34px;
    }
    .titulo-pagina > span {
        font-size: 7px;
        letter-spacing: .5px;
    }
    .titulo-pagina h1 {
        font-size: 13px;
    }
}
</style>
<script src="JavaScript/script.js" defer></script>
</head>
<body class="pagina-sistema">
<div class="aplicacion" id="aplicacion">
    <aside class="barra-lateral" id="barraLateral">
        <a href="bienvenida.php" target="marco" class="marca-sistema" title="Inicio">
            <span class="marca-icono">
                <img src="Logo/LogoCamus.webp" alt="Logo institucional">
            </span>
            <span class="marca-texto">
                <strong>INAC Activos</strong>
                <small>Gestión institucional</small>
            </span>
        </a>
        <nav class="navegacion" aria-label="Navegación principal">
            <span class="nav-titulo">MENÚ PRINCIPAL</span>
            <a href="bienvenida.php" target="marco" class="enlace-navegacion activo" data-titulo="Inicio">
                <i class="bi bi-grid-1x2-fill"></i>
                <span>Inicio</span>
            </a>
            <a href="Activos/activos.php" target="marco" class="enlace-navegacion" data-titulo="Gestión de activos">
                <i class="bi bi-pc-display"></i>
                <span>Activos</span>
            </a>
            <?php if (is_file(__DIR__ . '/Mantenimiento/mantenimientos.php')): ?>
                <a href="Mantenimiento/mantenimientos.php" target="marco" class="enlace-navegacion" data-titulo="Mantenimiento">
                    <i class="bi bi-tools"></i>
                    <span>Mantenimiento</span>
                </a>
            <?php endif; ?>
            <a href="Ubicacion/ubicaciones.php" target="marco" class="enlace-navegacion" data-titulo="Ubicaciones">
                <i class="bi bi-geo-alt"></i>
                <span>Ubicaciones</span>
            </a>
            <?php if (is_file(__DIR__ . '/Responsables/responsables.php')): ?>
                <a href="Responsables/responsables.php" target="marco" class="enlace-navegacion" data-titulo="Responsables">
                    <i class="bi bi-people"></i>
                    <span>Responsables</span>
                </a>
            <?php endif; ?>
            <?php
            $rutaReportes = __DIR__ . '/Reportes_Y_Estadísticas/reportes.php';
            ?>
            <?php if (is_file($rutaReportes)): ?>
                <a href="Reportes_Y_Estad%C3%ADsticas/reportes.php" target="marco" class="enlace-navegacion" data-titulo="Reportes y estadísticas">
                    <i class="bi bi-bar-chart-line"></i>
                    <span>Reportes y estadísticas</span>
                </a>
            <?php endif; ?>
            <?php if ($esAdmin): ?>
                <a href="Usuarios/usuarios.php" target="marco" class="enlace-navegacion" data-titulo="Gestión de usuarios">
                    <i class="bi bi-person-gear"></i>
                    <span>Usuarios</span>
                </a>
            <?php endif; ?>
        </nav>
        <div class="lateral-pie">
            <div class="sistema-indicador">
                <span class="indicador-punto"></span>
                Sistema de gestión
            </div>
        </div>
    </aside>
    <main class="area-principal">
        <header class="barra-superior">
            <div class="barra-superior-izquierda">
                <button type="button" class="boton-menu" id="botonMenu" aria-label="Contraer o expandir el menú" title="Contraer o expandir el menú">
                    <i class="bi bi-layout-sidebar-inset"></i>
                </button>
                <div class="titulo-pagina">
                    <span>INAC ACTIVOS / SISTEMA</span>
                    <h1 id="tituloModulo">Inicio</h1>
                </div>
            </div>
            <div class="barra-superior-derecha">
                <span class="estado-sesion">
                    <span class="indicador-punto"></span>
                    Sesión activa
                </span>
                <div class="usuario-superior">
                    <div class="usuario-avatar">
                        <i class="bi bi-person-fill"></i>
                    </div>
                    <div class="usuario-superior-datos">
                        <strong><?= $nombreSeguro ?></strong>
                        <small><?= $rolSeguro ?> · <?= $usuarioSeguro ?></small>
                    </div>
                </div>
                <a href="logout.php" class="boton-salir" data-confirm="¿Estás seguro de que deseas cerrar sesión?" data-confirm-type="salir" title="Cerrar sesión">
                    <i class="bi bi-box-arrow-right"></i>
                    <span>Salir</span>
                </a>
            </div>
        </header>
        <section class="contenedor-marco">
            <iframe name="marco" id="marco" src="bienvenida.php" title="Contenido de INAC Activos"></iframe>
        </section>
        <footer class="pie-sistema">
            <span>INAC Activos</span>
            <span>Sistema de gestión de activos y mantenimiento</span>
        </footer>
    </main>
</div>
<script>
const aplicacion = document.getElementById('aplicacion');
const botonMenu = document.getElementById('botonMenu');
const tituloModulo = document.getElementById('tituloModulo');
const marco = document.getElementById('marco');
const enlaces = document.querySelectorAll('.enlace-navegacion');
botonMenu.addEventListener('click', function () {
    if (window.innerWidth > 768) {
        aplicacion.classList.toggle('menu-contraido');
    } else {
        aplicacion.classList.toggle('menu-movil-abierto');
    }
});
enlaces.forEach(function (enlace) {
    enlace.addEventListener('click', function () {
        enlaces.forEach(function (elemento) {
            elemento.classList.remove('activo');
        });
        enlace.classList.add('activo');
        tituloModulo.textContent = enlace.dataset.titulo || 'INAC Activos';
        if (window.innerWidth <= 768) {
            aplicacion.classList.remove('menu-movil-abierto');
        }
    });
});
marco.addEventListener('load', function () {
    try {
        const ruta = marco.contentWindow.location.pathname;
        if (ruta.endsWith('/bienvenida.php')) {
            enlaces.forEach(function (enlace) {
                enlace.classList.toggle(
                    'activo',
                    enlace.getAttribute('href') === 'bienvenida.php'
                );
            });
            tituloModulo.textContent = 'Inicio';
        }
    } catch (error) {
    }
});
</script>
</body>
</html>