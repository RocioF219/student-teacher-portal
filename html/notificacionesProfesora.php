<?php
$directorio = $_SERVER["DOCUMENT_ROOT"];
session_start();

include("$directorio/func/verErrores.php");
include("$directorio/func/dominio.php");
include("$directorio/includes/database.php");
include_once("$directorio/func/logged.php");
include_once("$directorio/func/logged_profesor.php");

global $link;

$id = $_SESSION["alumno_id"];

$query = "SELECT count(*) as numero FROM `mensajes` WHERE receptor_id = $id AND leido = 0";
$stmt = $link->prepare($query);
$stmt->execute();
$result = $stmt->get_result();
$mensaje = $result->fetch_assoc();

$num_mensajes = $mensaje["numero"];

?>

<!DOCTYPE html>
<html lang="es">

<head>
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
      <?php include_once("$directorio/includes/navbar.php"); ?>
    </header>
    <?php include_once("$directorio/includes/menu-atras.php"); ?>

    <div class="container d-flex align-items-center mt-5">
      <div class="d-flex flex-row container-mensajes">
        <div class="d-flex align-items-center flex-column menu-lateral w-25">
          <div class="d-flex align-items-center justify-content-center boton-menu w-100 p-2" id="nuevos-mensajes"><b>Mensajes (<?= $num_mensajes ?>)</b></div>
          <div class="d-flex align-items-center justify-content-center boton-menu w-100 p-2" id="historial"><b>Historial</b></div>
        </div>
        <div class="d-flex flex-column menu-mensajes w-75">

        </div>
      </div>
    </div>
  </div>

  <?php include_once("$directorio/includes/footer.php") ?>
  <script>
    $(document).ready(function() {
      $("#nuevos-mensajes").on("click", function() {
        $.ajax({
          url: url + "/func/nuevos-mensajes.php",
          method: "POST",
          dataType: 'JSON',
          data: { tipo: 1 },
          success: function(res) {
            if (res.id == "200") {
              $(".menu-mensajes").html("");
              let msg = res.message;
              msg.forEach(function(mensaje) {
                let nombre = mensaje.nombre + " " + mensaje.apellidos;
                $(".menu-mensajes").append(`<div class="d-flex align-items-center mensaje w-100 ps-4"> Mensaje de: ${nombre}</div>`);
              })
            }
          }
        })
      })

      $("#historial").on("click", function() {
        $.ajax({
          url: url + "/func/nuevos-mensajes.php",
          method: "POST",
          dataType: 'JSON',
          data: { tipo: 2 },
          success: function(res) {
            if (res.id == "200") {
              $(".menu-mensajes").html("");
              let msg = res.message;
              msg.forEach(function(mensaje) {
                let nombre = mensaje.nombre + " " + mensaje.apellidos;
                $(".menu-mensajes").append(`<div class="d-flex align-items-center mensaje w-100 ps-4"> Mensaje de: ${nombre}</div>`);
              })
            }
          }
        })
      })
    })
  </script>
</body>

</html>