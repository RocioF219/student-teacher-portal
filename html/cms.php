<?php
$directorio = $_SERVER["DOCUMENT_ROOT"];
session_start();

include("$directorio/func/verErrores.php");
include("$directorio/func/dominio.php");
include_once("$directorio/func/logged.php");


?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-SgOJa3DmI69IUzQ2PVdRZhwQ+dy64/BUtbMJw1MZ8t5HZApcHrRKUc4W0kG879m7" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-k6d4wzSIapyDyv1kpU366/PK5hCdSbCRGRCMv+eplOQJWyd1fbcAu9OCUj5zNLiq" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="../css/cms.css" />
    <title>Escuela de Danza Alicia Iranzo</title>
</head>

<body>
    <header>
        <div class="containerPadre">
            <img class="logo" src="../img/logo/logo_alicia.jpg" />
            <a href="../index.html">
                <div class="container2">
                    <img class="button" src="../img/logo/log-out.svg" alt="Log out" style="width: 30px; height: 30px;">
            </a>
        </div>
        </div>
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
                <div  class="d-flex flex-column justify-content-center">
                    <img  src="<?= $protocolo . $dominio ?>/img/campana.png" class="card-img-top" alt="...">
                </div>
                <div class="card-body d-flex flex-column text-center">
                    <div>
                        <h4 class="card-title">Alertas</h4>
                        <p class="card-text">Contactar con alumnos, padres y ver mensajes recibidos.</p>
                    </div>
                    <div class="mt-auto">
                        <a href="#" class="btn btn-primary">Entrar</a>
                    </div>
                </div>
            </div>
        </div>
        <div class="card" style="width: 18rem; height: 30rem;">
            <div class="d-flex flex-column justify-content-between h-100">
                <div  class="d-flex flex-column justify-content-center">
                    <img  src="<?= $protocolo . $dominio ?>/img/credit-card-fill.svg" class="card-img-top" alt="...">
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
    <script src="../js/cms.js"></script>
</body>

</html>