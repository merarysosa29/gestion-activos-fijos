<?php
require_once 'Sesiones.php';
require_once 'Conexion.php';
function contarRegistros($conn, $sql) {
    $resultado = mysqli_query($conn, $sql);
    if (!$resultado) {
        return 0;
    }
    $fila = mysqli_fetch_assoc($resultado);
    return (int) ($fila['total'] ?? 0);
}
$totalActivos = contarRegistros(
    $conn,
    "SELECT COUNT(*) AS total FROM activo"
);
$activosEnUso = contarRegistros(
    $conn,
    "SELECT COUNT(*) AS total FROM activo a INNER JOIN estado_activo e ON a.id_estado = e.id_estado WHERE LOWER(e.nombre_estado) <> 'baja'"
);
$totalMantenimientos = contarRegistros(
    $conn,
    "SELECT COUNT(*) AS total FROM mantenimiento"
);
$mantenimientosPendientes = contarRegistros(
    $conn,
    "SELECT COUNT(*) AS total FROM mantenimiento WHERE estado_mantenimiento = 'Pendiente'"
);
$totalPreventivos = contarRegistros(
    $conn,
    "SELECT COUNT(*) AS total
     FROM mantenimiento m
     INNER JOIN tipo_mantenimiento t
       ON m.id_tipo_mantenimiento = t.id_tipo_mantenimiento
     WHERE LOWER(t.nombre) = 'preventivo'"
);

$totalCorrectivos = contarRegistros(
    $conn,
    "SELECT COUNT(*) AS total FROM mantenimiento m INNER JOIN tipo_mantenimiento t ON m.id_tipo_mantenimiento = t.id_tipo_mantenimiento WHERE LOWER(t.nombre) = 'correctivo'"
);
$sqlRecientes = "SELECT a.codigo, a.nombre AS activo, t.nombre AS tipo, m.fecha, m.estado_mantenimiento FROM mantenimiento m INNER JOIN activo a 
ON m.id_activo = a.id_activo INNER JOIN tipo_mantenimiento t 
ON m.id_tipo_mantenimiento = t.id_tipo_mantenimiento ORDER BY m.id_mantenimiento DESC LIMIT 5";

$recientes = mysqli_query($conn, $sqlRecientes);
$nombreMostrar = htmlspecialchars( $nombreActual ?? $usuarioActual ?? 'Usuario', ENT_QUOTES, 'UTF-8'
);
$rolMostrar = htmlspecialchars( $rolActual ?? '', ENT_QUOTES, 'UTF-8'
);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard | INAC Activos</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
</head>
<body class="dashboard">
<main class="dashboard-contenido">
    <section class="bienvenida-dashboard">
        <div>
            <h2>Resumen general</h2>
            <p>
                Bienvenido/a, <?= $nombreMostrar ?>.
                Aquí puedes consultar el estado general de los activos y mantenimientos.
            </p>
        </div>
        <span class="etiqueta-rol">
            <i class="bi bi-shield-check"></i>
            <?= $rolMostrar ?>
        </span>
    </section>
    <section class="row g-3" aria-label="Estadísticas generales">
        <div class="col-12 col-sm-6 col-xl-4">
            <article class="tarjeta">
                <div class="tarjeta-superior">
                    <span class="tarjeta-titulo">Total de activos</span>
                    <span class="tarjeta-icono icono-azul">
                        <i class="bi bi-pc-display"></i>
                    </span>
                </div>
                <div class="tarjeta-numero"><?= $totalActivos ?></div>
                <p class="tarjeta-pie">Activos registrados en el sistema</p>
            </article>
        </div>
        <div class="col-12 col-sm-6 col-xl-4">
            <article class="tarjeta">
                <div class="tarjeta-superior">
                    <span class="tarjeta-titulo">Activos no dados de baja</span>
                    <span class="tarjeta-icono icono-verde">
                        <i class="bi bi-check-circle"></i>
                    </span>
                </div>
                <div class="tarjeta-numero"><?= $activosEnUso ?></div>
                <p class="tarjeta-pie">Activos que no están en estado Baja</p>
            </article>
        </div>
        <div class="col-12 col-sm-6 col-xl-4">
            <article class="tarjeta">
                <div class="tarjeta-superior">
                    <span class="tarjeta-titulo">Total de mantenimientos</span>
                    <span class="tarjeta-icono icono-azul">
                        <i class="bi bi-tools"></i>
                    </span>
                </div>
                <div class="tarjeta-numero"><?= $totalMantenimientos ?></div>
                <p class="tarjeta-pie">Registros de mantenimiento</p>
            </article>
        </div>
        <div class="col-12 col-sm-6 col-xl-4">
            <article class="tarjeta">
                <div class="tarjeta-superior">
                    <span class="tarjeta-titulo">Mantenimientos pendientes</span>
                    <span class="tarjeta-icono icono-amarillo">
                        <i class="bi bi-clock-history"></i>
                    </span>
                </div>
                <div class="tarjeta-numero"><?= $mantenimientosPendientes ?></div>
                <p class="tarjeta-pie">Pendientes de atención</p>
            </article>
        </div>
        <div class="col-12 col-sm-6 col-xl-4">
            <article class="tarjeta">
                <div class="tarjeta-superior">
                    <span class="tarjeta-titulo">Preventivos</span>
                    <span class="tarjeta-icono icono-verde">
                        <i class="bi bi-calendar-check"></i>
                    </span>
                </div>
                <div class="tarjeta-numero"><?= $totalPreventivos ?></div>
                <p class="tarjeta-pie">Mantenimientos preventivos registrados</p>
            </article>
        </div>
        <div class="col-12 col-sm-6 col-xl-4">
            <article class="tarjeta">
                <div class="tarjeta-superior">
                    <span class="tarjeta-titulo">Correctivos</span>
                    <span class="tarjeta-icono icono-rojo">
                        <i class="bi bi-wrench-adjustable"></i>
                    </span>
                </div>
                <div class="tarjeta-numero"><?= $totalCorrectivos ?></div>
                <p class="tarjeta-pie">Mantenimientos correctivos registrados</p>
            </article>
        </div>
    </section>
    <section class="seccion-dashboard">
        <h2>
            <i class="bi bi-clock-history"></i>
            Últimos mantenimientos
        </h2>
        <div class="table-responsive">
            <table class="table tabla-dashboard">
                <thead>
                    <tr>
                        <th>Código</th>
                        <th>Activo</th>
                        <th>Tipo</th>
                        <th>Fecha</th>
                        <th>Estado</th>
                    </tr>
                </thead>
                <tbody>
                <?php if ($recientes && mysqli_num_rows($recientes) > 0): ?>
                    <?php while ($fila = mysqli_fetch_assoc($recientes)): ?>
                        <tr>
                            <td><?= htmlspecialchars($fila['codigo'] ?? '', ENT_QUOTES, 'UTF-8') ?></td>
                            <td><?= htmlspecialchars($fila['activo'] ?? '', ENT_QUOTES, 'UTF-8') ?></td>
                            <td><?= htmlspecialchars($fila['tipo'] ?? '', ENT_QUOTES, 'UTF-8') ?></td>
                            <td>
                                <?php
                                $fecha = $fila['fecha'] ?? '';
                                echo $fecha && strtotime($fecha)
                                    ? htmlspecialchars(date('d/m/Y', strtotime($fecha)), ENT_QUOTES, 'UTF-8')
                                    : '—';
                                ?>
                            </td>
                            <td>
                                <span class="estado">
                                    <?= htmlspecialchars($fila['estado_mantenimiento'] ?? 'Sin estado', ENT_QUOTES, 'UTF-8') ?>
                                </span>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="5" class="mensaje-vacio">
                            <i class="bi bi-inbox"></i>
                            Todavía no hay mantenimientos registrados.
                        </td>
                    </tr>
                <?php endif; ?>
                </tbody>
            </table>
        </div>
    </section>
</main>
</body>
</html>