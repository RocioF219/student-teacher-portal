<?php
$directorio = $_SERVER["DOCUMENT_ROOT"];
include("$directorio/func/verErrores.php");
include_once("$directorio/func/fichaAlumnoback.php");
include_once("$directorio/func/logged.php");
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <!-- FullCalendar CSS -->
    <link href="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.10/main.min.css" rel="stylesheet" />
    <!-- FullCalendar JS -->
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.10/main.min.js"></script>
    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css"
        rel="stylesheet"
        integrity="sha384-SgOJa3DmI69IUzQ2PVdRZhwQ+dy64/BUtbMJw1MZ8t5HZApcHrRKUc4W0kG879m7"
        crossorigin="anonymous" />
    <script
        src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-k6d4wzSIapyDyv1kpU366/PK5hCdSbCRGRCMv+eplOQJWyd1fbcAu9OCUj5zNLiq"
        crossorigin="anonymous"></script>
    <link rel="stylesheet" href="../css/fichaAlumno.css" />
    <title>Escuela de Danza Alicia Iranzo</title>
</head>

<body>
    <header>
        <div class="containerPadre">
            <img class="logo" src="../img/logo/logo_alicia.jpg" />
            <a href="/">
                <div class="containerHijo">
                    <img
                        class="button"
                        src="../img/logo/log-out.svg"
                        alt="Log out"
                        style="width: 30px; height: 30px" />
                </div>
            </a>
        </div>
    </header>
    <div class="contenedorTarjeta">
        <div class="row">
            <div class="col d-flex justify-content-center">
                <div class="card" style="width: 18rem">
                    <img src="../img/logo/logo_alicia.jpg" class="card-img-top" alt="Imagen del alumno" />
                    <div class="card-body">
                        <h5 class="card-title"><?php echo $alumno['nombre'] . " " . $alumno['apellidos']; ?></h5>
                        <ul class="list-group list-group-flush">
                            <form id="datos-alumno">
                                <li class="list-group-item">
                                    <label for="campo-email">Email</label>
                                    <input id="campo-email" name="email" class="form-control" value="<?php echo $alumno['email']; ?>" disabled></input>
                                </li>
                                <li class="list-group-item">
                                    <label for="campo-telefono">Teléfono</label>
                                    <input id="campo-telefono" name="tlf" class="form-control" value="<?php echo $alumno['telefono']; ?>" disabled></input>
                                </li>
                            </form>
                            <li class="list-group-item">
                                <label for="campo-grupo">Grupo</label>
                                <input id="campo-grupo" class="form-control" value="<?php echo $alumno['grupo']; ?>" disabled></input>
                            </li>
                        </ul>
                        <div class="card-body">
                            <button class="btn btn-primary" id="editar-btn">Editar</button>
                            <button class="btn btn-success d-none" id="guardar-btn">Guardar</button>
                            <button class="btn btn-danger d-none" id="cancelar-btn">Cancelar</button>
                        </div>
                    </div>
                </div>
                <div class="col">
                    <div class="contenedorCalendario">
                        <div class="calendario">
                            <table id="calendar" style="background-color: aliceblue;">
                                <caption></caption>
                                <thead>
                                    <tr>
                                        <th>Lun</th>
                                        <th>Mar</th>
                                        <th>Mié</th>
                                        <th>Jue</th>
                                        <th>Vie</th>
                                        <th>Sáb</th>
                                        <th>Dom</th>
                                    </tr>
                                </thead>
                                <tbody></tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="col text-white">
                    Seccion de mensajes
                </div>
                <div class="col">
                    <div class="card">
                        <div class="card-header bg-primary text-white">
                            Registrar Pago
                        </div>
                        <div class="card-body">
                            <form id="formPago">
                                <div class="mb-3">
                                    <label for="concepto" class="form-label">Concepto</label>
                                    <input type="text" class="form-control" id="concepto" placeholder="Mensualidad abril, matrícula...">
                                </div>
                                <div class="mb-3">
                                    <label for="importe" class="form-label">Importe (€)</label>
                                    <input type="number" class="form-control" id="importe" placeholder="Ej: 50">
                                </div>
                                <div class="mb-3">
                                    <label for="fecha" class="form-label">Fecha</label>
                                    <input type="date" class="form-control" id="fecha">
                                </div>
                                <div class="mb-3">
                                    <label for="metodo" class="form-label">Método de pago</label>
                                    <select class="form-select" id="metodo">
                                        <option>Selecciona</option>
                                        <option>Efectivo</option>
                                        <option>Transferencia</option>
                                        <option>Bizum</option>
                                    </select>
                                </div>
                                <button type="submit" class="btn btn-success">Enviar</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php include($directorio . "/includes/footer.php") ?>

        <script src="/js/fichaAlumno.js"></script>
        <script>
            $(document).ready(function() {
                $("#editar-btn").on("click", function() {
                    let $email = $("#campo-email").data("email");
                    let $tlf = $("#campo-telefono").data("tlf");
                    $("#campo-email").prop("disabled", false);
                    $("#campo-telefono").prop("disabled", false);

                    $("#editar-btn").addClass("d-none");
                    $("#guardar-btn").removeClass("d-none");
                    $("#cancelar-btn").removeClass("d-none");
                })
                $("#guardar-btn").on("click", function() {
                    let $email = $("#campo-email").val();
                    let $tlf = $("#campo-telefono").val();
                    console.log($tlf.length)


                    if ($email.length == 0) {
                        Swal.fire({
                            icon: "error",
                            title: "Debes rellenar el campo email",
                        });
                    }

                    if ($tlf.length == 0) {
                        Swal.fire({
                            icon: "error",
                            title: "Debes rellenar el campo teléfono",
                        });
                    }

                    if ($tlf.length > 9) {
                        Swal.fire({
                            icon: "error",
                            title: "El campo telefono no puede superar los 9 dígitos",
                        });
                    }

                    $.ajax({
                        url: url + "/func/cambiar_datos_alumno.php",
                        method: "POST",
                        data: $("#datos-alumno").serialize(),
                        success: function(respuesta) {
                            if (respuesta.id == "200") {
                                Swal.fire({
                                    icon: "success",
                                    title: respuesta.message,
                                });

                                $("#campo-email").prop("disabled", true);
                                $("#campo-telefono").prop("disabled", true);

                                $("#editar-btn").removeClass("d-none");
                                $("#guardar-btn").addClass("d-none");
                                $("#cancelar-btn").addClass("d-none");
                            } else {
                                Swal.fire({
                                    icon: "error",
                                    title: respuesta.message,
                                });
                            }
                        }
                    })



                });

                $("#cancelar-btn").on("click", function() {
                    $("#campo-email").prop("disabled", true);
                    $("#campo-telefono").prop("disabled", true);

                    $("#editar-btn").removeClass("d-none");
                    $("#guardar-btn").addClass("d-none");
                    $("#cancelar-btn").addClass("d-none");
                });
            })
        </script>
</body>

</html>