<?php
$directorio = $_SERVER["DOCUMENT_ROOT"];// Definicoón de la raíz del servidor para usar rutas absolutas.
session_start();// Inicia la sesión para acceder a las variables de sesión.

// Incluimos las funciones auxiliares y comprobaciones de sesión.
include("$directorio/func/verErrores.php"); //Muestra errores personalizados.
include("$directorio/func/dominio.php");    // Define las variables $protocolo y $dominio
include("$directorio/includes/database.php"); // Conexión a la base de datos
include("$directorio/func/logged.php"); // Verifica si el usuario esta logueado.
include("$directorio/func/logged_profesor.php"); // Verifica si el usuario tiene rol de profesor.

// Usamos la conexión global a la base de datos.
global $link;

// Recuperamos el ID del alumno desde la sesión.
$id = $_SESSION["alumno_id"];

// Consulta cuantos mensajes no leídos tiene ese alumno.
$query = "SELECT count(*) as numero FROM `mensajes` WHERE receptor_id = $id AND leido = 0";
$stmt = $link->prepare($query); // Se prepara la consulta.
$stmt->execute(); //Ejecuta la consulta.
$result = $stmt->get_result();// Se obtienen los resultados.
$mensaje = $result->fetch_assoc();// Alamacenan el resultado en un array asociativo.

$num_mensajes = $mensaje["numero"]; // Se extrae el número de mensajes no leidos.

?>
<!DOCTYPE html>
<html lang="es">

<head>
    <!-- Incluimos el archivo de cabercera común -->
    <?php include_once("$directorio/includes/header.php"); ?>
    <link rel="stylesheet" href="../css/cms.css" />
</head>

<body>
    <header>
        <!--Incluimos la barra de navegación-->
        <?php include_once("$directorio/includes/navbar.php"); ?>
    </header>
    <!-- Contenedor principal que contiene todas las tarjetas-->
    <div class="card-container">
        <div class="card" style="width: 18rem; height: 30rem;">
            <div class="d-flex flex-column justify-content-between h-100">
                <div class="d-flex flex-column justify-content-center">
                    <img src="<?= $protocolo . $dominio ?>/img/person.svg" class="card-img-top" alt="...">
                </div>
                <div class="card-body d-flex flex-column text-center">
                    <div>
                        <h4 class="card-title">Alumnos</h4>
                        <p class="card-text">Consultar, editar y borrar alumnos.</p>
                    </div>
                    <div class="mt-auto">
                        <a href="<?= $protocolo . $dominio ?>/alumnos" class="btn btn-primary">Entrar</a>
                    </div>
                </div>
            </div>
        </div>
        <div class="card" style="width: 18rem; height: 30rem;">
            <div class="d-flex flex-column justify-content-between h-100">
                <div class="d-flex flex-column justify-content-center">
                    <img src="<?= $protocolo . $dominio ?>/img/campana.png" class="card-img-top" alt="Alerta icono">
                </div>
                <div class="card-body d-flex flex-column text-center">
                    <div>
                        <h4 class="card-title">Alertas <?php if($num_mensajes > 0){ ?>(<?= ($num_mensajes < 100) ? $num_mensajes : "+99" ?>)<?php } ?></h4>
                        <p class="card-text">Contactar con alumnos, padres y ver mensajes recibidos.</p>
                    </div>
                    <div class="mt-auto">
                        <a href="<?= $protocolo . $dominio ?>/pmensajes" class="btn btn-primary">Entrar</a>
                    </div>
                </div>
            </div>
        </div>
        <div class="card" style="width: 18rem; height: 30rem;">
            <div class="d-flex flex-column justify-content-between h-100">
                <div class="d-flex flex-column justify-content-center">
                    <img src="<?= $protocolo . $dominio ?>/img/credit-card-fill.svg" class="card-img-top" alt="...">
                </div>
                <div class="card-body d-flex flex-column text-center">
                    <div>
                        <h4 class="card-title">Pagos</h4>
                        <p class="card-text">Consultar los pagos.</p>
                    </div>
                    <div class="mt-auto ">
                        <a href="<?= $protocolo . $dominio ?>/pagos" class="btn btn-primary">Entrar</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>