<?php
$directorio = $_SERVER["DOCUMENT_ROOT"];
session_start();

include("$directorio/func/verErrores.php");
include("$directorio/func/dominio.php");
include("$directorio/func/logged.php");
include("$directorio/func/logged_profesor.php");


?>
<!DOCTYPE html>
<html lang="es">

<head>
    <?php include_once("$directorio/includes/header.php"); ?>
    <link rel="stylesheet" href="../css/cms.css" />
</head>

<body>
    <header>
        <?php include_once("$directorio/includes/navbar.php"); ?>
    </header>
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
                    <img src="<?= $protocolo . $dominio ?>/img/campana.png" class="card-img-top" alt="...">
                </div>
                <div class="card-body d-flex flex-column text-center">
                    <div>
                        <h4 class="card-title">Alertas</h4>
                        <p class="card-text">Contactar con alumnos, padres y ver mensajes recibidos.</p>
                    </div>
                    <div class="mt-auto">
                        <a href="<?= $protocolo . $dominio ?>/mensajes" class="btn btn-primary">Entrar</a>
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
                        <a href="#" class="btn btn-primary">Entrar</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>