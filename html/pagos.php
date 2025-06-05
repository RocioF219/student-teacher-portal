<?php
// Directorio raíz del servidor.
$directorio = $_SERVER["DOCUMENT_ROOT"];
// Inicia la sesión.
session_start();

// Incluimos los archivos de erorres personalizados, funciones, conexión a la base de datos, si el usuario esta logueado o el profesor.
include("$directorio/func/verErrores.php");
include("$directorio/func/dominio.php");
include("$directorio/includes/database.php");
include_once("$directorio/func/logged.php");
include_once("$directorio/func/logged_profesor.php");

global $link;

$id = $_SESSION["alumno_id"];

// Incluye el script que devuelve los pagos realizados por el alumno.
$pagos = include("$directorio/func/obtener_pagos.php");

// Función para formatear fechas.
function form_fecha($fecha){
    $fecha_arr = explode("-", $fecha);
    $fecha_mod = $fecha_arr[2] . "/" . $fecha_arr[1] . "/" . $fecha_arr[0];

    return $fecha_mod; // Devuelve la fecha formateada.
}

?>

<!DOCTYPE html>
<html lang="es">

<head>
    <!-- Implementación de Boostrap, Boostraps JS, CSS personalizado-->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-SgOJa3DmI69IUzQ2PVdRZhwQ+dy64/BUtbMJw1MZ8t5HZApcHrRKUc4W0kG879m7" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-k6d4wzSIapyDyv1kpU366/PK5hCdSbCRGRCMv+eplOQJWyd1fbcAu9OCUj5zNLiq" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="../css/notificacionesProfesora.css" />
    <title>Escuela de Danza Alicia Iranzo</title>
</head>

<body>
    <div class="container-fluid no-gutter">
        <header>
            <!-- Incluye el navegador que es la cabecera de la pagina-->
            <?php include_once("$directorio/includes/navbar.php"); ?>
        </header>
        <!-- Incluye el menu atras-->
        <?php include_once("$directorio/includes/menu-atras.php"); ?>

        <div class="container d-flex align-items-center mt-5">
            <div class="d-flex flex-row container-pagos w-100">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Nombre</th>
                            <th>Concepto</th>
                            <th>Método</th>
                            <th>Fecha de pago</th>
                            <th>Cantidad</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Recorre los pagos y muestra cada uno en una fila-->
                        <?php foreach($pagos as $pago): ?>
                            <tr>
                                <!-- Muestra nombre completo alumno, concepto del pago, método del pago y fecha-->
                                <td><?= $pago["nombre"] . " " . $pago["apellidos"] ?></td>
                                <td><?= $pago["concepto"] ?></td>
                                <td><?= $pago["metodo"] ?></td>
                                <td><?= form_fecha($pago["fecha"]) ?></td>
                                <td><?= $pago["precio"] ?>€</td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
        <!-- Incluye el pie de la página-->
    <?php include_once("$directorio/includes/footer.php") ?>
    <script>
        // Script asegura HTML esté cargado y listo para ejecutar.
        $(document).ready(function() {

        })
    </script>
</body>

</html>