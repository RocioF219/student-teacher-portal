<?php
// Se obtiene la ruta raíz del servidor.
$directorio = $_SERVER["DOCUMENT_ROOT"];

// Incluimos las funciones necesarias para mostrar errores.
include("$directorio/func/verErrores.php");
include_once("$directorio/func/fichaAlumnoback.php");
include("$directorio/func/dominio.php");
include_once("$directorio/func/logged.php");
include_once("$directorio/func/logged_alumno.php");

// Se obtiene las clases y profesores disponibles
$clases = include_once("$directorio/func/obtener_clases.php");
$profesores = include_once("$directorio/func/obtener_profesores.php");

// Variable global para acceder a la base de datos.
global $link;

// Se obtiene el ID del alumnno desde la sesión
$id = $_SESSION["alumno_id"];


// Consulta para contar mensajes no leídos del alumno.
$query = "SELECT count(*) as numero FROM `mensajes` WHERE receptor_id = $id AND leido = 0";
$stmt = $link->prepare($query);
$stmt->execute();
$result = $stmt->get_result();
$mensaje = $result->fetch_assoc();

// Numero de mensajes no leídos.
$num_mensajes = $mensaje["numero"];

?>

<!DOCTYPE html>
<html lang="es">

<head>
    <!-- Incluimos el encabezado común-->
    <?php include_once("$directorio/includes/header.php"); ?>
    <link rel="stylesheet" href="../css/fichaAlumno.css" />
</head>

<body>
    <header>
        <div class="container-padre">
            <img class="logo" src="../img/logo/logo_alicia.jpg" />
            <a href="/">
                <div class="container-hijo">
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
        <div class="d-flex justify-content-center">
            <div class="d-flex flex-wrap justify-content-center">
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
                        <!--Botones para editar , borrar y cancelar-->
                        <div class="card-body">
                            <button class="btn btn-primary" id="editar-btn">Editar</button>
                            <button class="btn btn-success d-none" id="guardar-btn">Guardar</button>
                            <button class="btn btn-danger d-none" id="cancelar-btn">Cancelar</button>
                        </div>
                    </div>
                </div>
                <div>
                    <!-- Tabla base de horario de clases-->
                    <div class="w-100 p-2">
                        <div class="div-clases text-white">
                            <h2>Horario de clases</h2>
                            <table class="table table-striped table-bordered">
                                <thead>
                                    <tr class="table-danger">
                                        <th>Clase</th>
                                        <th>Fecha</th>
                                        <th>Hora</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($clases as $clase) {
                                        $fecha = (new DateTime($clase["fecha"]))->format("d/m/Y"); // formateo de la fecha
                                    ?>
                                        <tr>
                                            <td><?= $clase["nombre_clase"] ?></td>
                                            <td><?= $fecha ?></td>
                                            <td><?= $clase["hora_entrada"] . " - " . $clase["hora_salida"] ?></td>
                                        </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <!-- <div class="text-black m-3 div-mensajes">
                    <div class="d-flex flex-column">
                        <div class="d-flex flex-row menu-mensajes">
                            <button class="btn" id="btn-mensajes">
                                <div class="d-flex justify-content-center align-items-center text-white ms-3 me-3 menu-opcion">
                                    Mensajes
                                </div>
                            </button>
                            <button class="btn" id="btn-historial">
                                <div class="d-flex justify-content-center align-items-center text-white menu-opcion">
                                    Historial
                                </div>
                            </button>
                            <button class="btn" id="btn-crear">
                                <div class="d-flex justify-content-center align-items-center text-white menu-opcion">
                                    Nuevo mensaje
                                </div>
                            </button>
                        </div>
                        <div class="vista-mensajes">
                            <section id="seccion1" class="bg-secondary text-white text-center">
                                <h1>Mensajes</h1>
                            </section>
                            <section id="seccion2" class="d-none">
                                <h1 class="bg-warning text-dark text-center">Historial de mensajes</h1>
                            </section>
                            <section id="seccion3" class="d-none">
                                <h1 class="bg-danger text-dark text-center">Crear nuevo mensaje</h1>
                                <div class="w-100 p-3">
                                    <form id="form-mensaje">
                                        <label class="form-label" for="profesor">Profesor:</label>
                                        <select class="form-control" name="inp-usuario" id="profesor">
                                            <option value="">Elije un profesor</option>
                                            <?php foreach($profesores as $profesor){ ?>
                                                <option value="<?= $profesor["id_alumno"] ?>"><?= $profesor["nombre"] . " " . $profesor["apellidos"] ?></option>
                                            <?php } ?>
                                        </select>
                                        <br>
                                        <label for="mensaje">Mensaje:</label>
                                        <textarea class="form-control" name="inp-mensaje" id="mensaje" rows="5" maxlength="1000"></textarea>
                                        <br>
                                        <input class="btn btn-success" type="button" id="enviar" value="Enviar">
                                    </form>
                                </div>
                            </section>
                        </div>
                    </div>
                </div> -->
                <div class="card" style="width: 18rem; height: 30rem;">
                    <div class="d-flex flex-column justify-content-between h-100 mt-5">
                        <div class="d-flex flex-column justify-content-center align-items-center">
                            <img src="<?= $protocolo . $dominio ?>/img/mensaje.png" class="card-img-top w-50" alt="Alerta icono">
                        </div>
                        <div class="card-body d-flex flex-column text-center mt-5">
                            <div>
                                <h4 class="card-title">Alertas <?php if($num_mensajes > 0){ ?>(<?= ($num_mensajes < 100) ? $num_mensajes : "+99" ?>)<?php } ?></h4>
                                <p class="card-text">Contactar con profesores y ver mensajes recibidos.</p>
                            </div>
                            <div class="mt-auto">
                                <a href="<?= $protocolo . $dominio ?>/amensajes" class="btn btn-primary">Entrar</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div>
                    <div class="card" style="width: 18rem; height: 30rem;">
                        <div class="card-header bg-primary text-white">
                            Registrar Pago
                        </div>
                        <div class="card-body">
                            <form id="formPago" method="POST">
                                <div class="mb-3">
                                    <label for="concepto" class="form-label">Concepto</label>
                                    <input type="text" class="form-control" id="concepto" name="inp-concepto" placeholder="Mensualidad abril, matrícula...">
                                </div>
                                <div class="mb-3">
                                    <label for="importe" class="form-label">Importe (€)</label>
                                    <input type="number" class="form-control" id="importe" name="inp-importe" placeholder="Ej: 50">
                                </div>
                                <div class="mb-3">
                                    <label for="fecha" class="form-label">Fecha</label>
                                    <input type="date" class="form-control" id="fecha" name="inp-fecha">
                                </div>
                                <div class="mb-3">
                                    <label for="metodo" class="form-label">Método de pago</label>
                                    <select class="form-select" id="metodo"  name="inp-metodo">
                                        <option value="">Selecciona</option>
                                        <option value="Efectivo">Efectivo</option>
                                        <option value="Transferencia">Transferencia</option>
                                        <option value="Bizum">Bizum</option>
                                    </select>
                                </div>
                                <button type="button" class="btn btn-success" id="btn-pagar">Enviar</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Incluimos el footes -->
        <?php include($directorio . "/includes/footer.php") ?>
          <!-- Script específico para manejar los eventos de la ficha del alumno -->                                      
        <script src="/js/fichaAlumno.js"></script>
        <!-- Script con Jquery para control de interacciones-->
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
                //Guardamos cambios de email y telefono.
                $("#guardar-btn").on("click", function() {
                    let $email = $("#campo-email").val();
                    let $tlf = $("#campo-telefono").val();

                    if ($email.length == 0) {
                        Swal.fire({
                            icon: "error",
                            title: "Debes rellenar el campo email",
                        });
                        return;
                    }

                    if ($tlf.length == 0) {
                        Swal.fire({
                            icon: "error",
                            title: "Debes rellenar el campo teléfono",
                        });
                        return;
                    }

                    if ($tlf.length > 9) {
                        Swal.fire({
                            icon: "error",
                            title: "El campo telefono no puede superar los 9 dígitos",
                        });
                        return;
                    }
                    // Se evian los datos actualizados por AJAX.
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
                // Se cancela la edicion 
                $("#cancelar-btn").on("click", function() {
                    $("#campo-email").prop("disabled", true);
                    $("#campo-telefono").prop("disabled", true);

                    $("#editar-btn").removeClass("d-none");
                    $("#guardar-btn").addClass("d-none");
                    $("#cancelar-btn").addClass("d-none");
                });
                // Se cambia entre secciones de mensajes.
                $("#btn-mensajes").on("click", function(){
                    $("#seccion1").removeClass("d-none");
                    $("#seccion2").addClass("d-none");
                    $("#seccion3").addClass("d-none");
                })

                $("#btn-historial").on("click", function(){
                    $("#seccion2").removeClass("d-none");
                    $("#seccion1").addClass("d-none");
                    $("#seccion3").addClass("d-none");
                })

                $("#btn-crear").on("click", function(){
                    $("#seccion3").removeClass("d-none");
                    $("#seccion1").addClass("d-none");
                    $("#seccion2").addClass("d-none");
                })
                // Se envia el mensaje.
                $("#enviar").on("click", function(){
                    let $profe = $("#profesor").val();
                    let $mensaje = $("#mensaje").val();

                    if($profe <= 0){
                        Swal.fire({
                            icon: "error",
                            title: "Debes rellenar el campo profesor.",
                        });
                        return;
                    }

                    if($mensaje.length <= 0){
                        Swal.fire({
                            icon: "error",
                            title: "Debes rellenar el campo mensaje.",
                        });
                        return;
                    }
                    // Se envia el mensaje al profesor
                    $.ajax({
                        url: url + "/func/enviar_mensaje.php", // Direccion del script que procesa el mensaje.
                        method: "POST",
                        data: $("#form-mensaje").serialize(), // Serialización de los datos del formulario con id form-mensaje.
                        success: function(res){ // Callback en caso de que la petición sea exitosa.
                            if(res.code == "200"){ // Si la respuesta del servidor indica éxito salta el codigo 200.
                                Swal.fire({
                                    icon: "success", // Alerta de éxito.
                                    title: res.message, // Se muestra el mensaje recibido por el servidor
                                });
                                $("#form-mensaje")[0].reset(); // Resetea el formulario despues del envio
                            } else{
                                Swal.fire({
                                    icon: "error", // Muestra una alerta de error
                                    title: res.message, // Muestra el mensaje de error recibido
                                });
                            }
                        }
                    })
                })
                // Registro de pago por parte del alumno
                $("#btn-pagar").on("click", function() {

                    // Obtención de los valores de los campos del formulario
                    let $concepto = $("#concepto").val();
                    let $importe = $("#importe").val();
                    let $fecha = $("#fecha").val();
                    let $metodo = $("#metodo").val();

                    // Validaciones para asegurarme de que los campos no estén vacíos y sean válidos.
                    if ($concepto.length == 0) {
                        Swal.fire({
                            icon: "error",
                            title: "Debes rellenar el campo concepto",
                        });
                        return;
                    }

                    if ($importe < 0) {
                        Swal.fire({
                            icon: "error",
                            title: "Debes rellenar el campo importe",
                        });
                        return;
                    }

                    if ($importe == 0) {
                        Swal.fire({
                            icon: "error",
                            title: "El importe debe de ser mayor a 0€",
                        });
                        return;
                    }

                    if ($fecha.length == 0) {
                        Swal.fire({
                            icon: "error",
                            title: "Debes rellenar el campo fecha",
                        });
                        return;
                    }

                    if ($metodo.length == 0) {
                        Swal.fire({
                            icon: "error",
                            title: "Debes rellenar el campo método",
                        });
                        return;
                    }
                    // Si todas la validaciones son correctas, se realiza el envío del formulario.
                    $.ajax({
                        url: url + "/func/realizar_pago.php", // Dirección del script que registra el pago.
                        method: "POST",
                        data: $("#formPago").serialize(), // Serialización de los datos del formulario.
                        success: function(respuesta) {
                            if (respuesta.id == "200") {
                                Swal.fire({
                                    icon: "success",
                                    title: respuesta.message, // Mensaje de confirmación.
                                });
                                $("#formPago")[0].reset(); // Limpia el formulario tras el registro.
                            } else {
                                Swal.fire({
                                    icon: "error",
                                    title: respuesta.message, // Mensaje de error desde el servidor.
                                });
                            }
                        }
                    })

                });
            })
        </script>
</body>

</html>