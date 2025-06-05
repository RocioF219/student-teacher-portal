<?php
// Obtenemos ruta raíz del servidor
$directorio = $_SERVER["DOCUMENT_ROOT"];

//Inicio de sesión para usar las variables de sesión.
session_start();

//Incluimos los archivos necesarios para el funcionamiento.
include("$directorio/func/verErrores.php");
include("$directorio/func/dominio.php");
include("$directorio/includes/database.php");
include_once("$directorio/func/logged.php");
include_once("$directorio/func/logged_profesor.php");

global $link;

// Obtenemos el ID del alumno desde la sesión.
$id = $_SESSION["alumno_id"];

// COnsulta SQL para contar mensajes no leídos del usuario actual.
$query = "SELECT count(*) as numero FROM `mensajes` WHERE receptor_id = $id AND leido = 0";
$stmt = $link->prepare($query);
$stmt->execute();
$result = $stmt->get_result();
$mensaje = $result->fetch_assoc();

// Guarda el número de mensajes no leídos.
$num_mensajes = $mensaje["numero"];

// Obtenemos la lista de todos los alumnos desde archivo externo.
$alumnos = require_once("$directorio/func/obtener_alumnos.php");
$html_alumnos = "";

foreach($alumnos as $alumno){
    $html_alumnos .= '<option value="' . $alumno['id_alumno'] . '">' . $alumno['nombre'] . " " . $alumno['apellidos'] . '</option>';
}

?>

<!DOCTYPE html>
<html lang="es">

<head>
    <!-- Integración de Boostrap y CSS personalizado -->
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
            <!-- Incluimos la barra de mavegación -->
            <?php include_once("$directorio/includes/navbar.php"); ?>
        </header>
        <!-- Incluimos el menú ir hacia atrás-->
        <?php include_once("$directorio/includes/menu-atras.php"); ?>

        <div class="container d-flex align-items-center mt-5">
            <div class="d-flex flex-row container-mensajes">
                <!-- Menú lateral con opciones de mensajería-->
                <div class="d-flex align-items-center flex-column menu-lateral w-25">
                    <!-- Boton para crear un nuevo mensaje--> 
                    <div class="d-flex align-items-center justify-content-center boton-menu w-100 p-2" id="crear-mensaje">Crear mensaje</div>
                    <!-- Boton para ver los mensajes nuevos-->
                    <div class="d-flex align-items-center justify-content-center boton-menu w-100 p-2 <?php if($num_mensajes > 0){ ?>fw-bold<?php } ?>" id="nuevos-mensajes">Mensajes (<?= $num_mensajes ?>)</div>
                   <!-- Boton para ver el historial de los mensajes-->
                    <div class="d-flex align-items-center justify-content-center boton-menu w-100 p-2" id="historial">Historial</div>
                </div>
                <!-- Sitio principal donde se muestran los mensajes-->
                <div class="d-flex overflow-y-auto flex-column menu-mensajes w-75">

                </div>
            </div>
        </div>
    </div>
    <!-- Incluimos el pie de la página-->
    <?php include_once("$directorio/includes/footer.php") ?>
    <script>
        //Ejecuta cuando el documento esté listo.
        $(document).ready(function() {
            // Evento click para crea un nuevo mensaje.
            $("#crear-mensaje").on("click", function() {
                // Remueve la clase selección de otros menús y aregarla al actual.
                $(".menu-selected").removeClass("menu-selected")
                $(this).addClass("menu-selected")

                // Obtiene lista alumnos generada en PHP.
                let $alumnos = '<?= $html_alumnos ?>';

                //Limpia el a´rea de los mensajes.
                $(".menu-mensajes").html("");
                $(".msj-responder").addClass("invisible");

                // Si hay alumnos disponibles, muestra el formulario completo.
                if($alumnos != ""){
                    $(".menu-mensajes").append(`
                        <div class="div-respuesta m-4">
                            <div class="d-flex flex-column m-1">
                                <form id="nuevo-mensaje" method="POST">
                                    <label class="form-label">Para:</label>
                                    <select class="form-select select-alumnos" name="inp-usuario">
                                        <option value="" disabled selected>Elija un alumno</option>
                                        ${$alumnos}
                                    </select>
                                    <br><br>
                                    <div class="w-100">
                                        <label class="form-label">Mensaje:</label>
                                        <textarea class="w-100 form-control respuesta" name="inp-mensaje"></textarea>
                                    </div>
                                    <div class="w-100 text-end mt-3">
                                        <input type="button" class="btn btn-success btn-enviar-nuevo-mensaje" value="Enviar">
                                    </div>
                                </form>
                            </div>
                        </div>
                    `);
                } else{
                    // Si no hay alumnos, muestra el formulario deshabilitado.
                    $(".menu-mensajes").append(`
                        <div class="div-respuesta m-4">
                            <div class="d-flex flex-column m-1">
                                <label class="form-label">Para:</label>
                                <select class="select-alumnos">
                                    <option value="" disabled selected>No se encontraron alumnos</option>
                                </select>
                                <br>
                                <div class="w-100">
                                    <label class="form-label">Mensaje:</label>
                                    <textarea class="w-100 form-control respuesta"></textarea>
                                </div>
                                <div class="w-100 text-end mt-3">
                                    <button class="btn btn-success btn-enviar-nuevo-mensaje">Enviar</button>
                                </div>
                            </div>
                        </div>
                    `);                }
                    // Inicializa el select2 para mejorar el selectro de alumnos.
                $('.select-alumnos').select2();
            })
            // Evento para enviar nuevo mensaje.
            $(document).on("click", ".btn-enviar-nuevo-mensaje", function() {
                // Petición AJAX para enviar el mensaje.
                $.ajax({
                    url: url + "/func/enviar_mensaje.php", // Archivo PHP que procesa el envío.
                    method: "POST",
                    dataType: 'JSON',
                    data: $("#nuevo-mensaje").serialize() + "&d=1",
                    success: function(res) {
                        if (res.code == "200") {
                            // Muestra la notificación de éxito.
                            Swal.fire({
                                title: 'Mensaje enviado',
                                toast: true,
                                position: 'top-end',
                                timer: 3000,
                                timerProgressBar: true,
                                showConfirmButton: false,
                                icon: 'success'
                            });

                            // Limpia el formulario.
                            $("#nuevo-mensaje")[0].reset();
                        } else{
                            Swal.fire({
                                icon: "error",
                                title: res.message,
                            });
                        }
                    }
                })
            });

            // Evento click para ver mensajes nuevos.
            $("#nuevos-mensajes").on("click", function() {
                // Cambia la selección del menú.
                $(".menu-selected").removeClass("menu-selected")
                $(this).addClass("menu-selected")
                $(".menu-mensajes").html("");
                // Peticiín AJAX para obtener mensajes nuevos.
                $.ajax({
                    url: url + "/func/nuevos-mensajes.php",
                    method: "POST",
                    dataType: 'JSON',
                    data: {
                        tipo: 1
                    },
                    success: function(res) {
                        if (res.id == "200") {
                            $(".menu-mensajes").html("");
                            let msg = res.message;
                            if(msg.length > 0){

                                // Muestra cada mensaje recibido.
                                msg.forEach(function(mensaje) {
                                    let nombre = mensaje.nombre + " " + mensaje.apellidos;
                                    $(".menu-mensajes").prepend(`<div class="d-flex justify-content-between align-items-center mensaje w-100 ps-4" id="${mensaje.uuid}"><div>Mensaje de: ${nombre}</div><div class="me-3">${mensaje.fecha_envio}</div></div>`);
                                })
                            } else{
                                // Muestra mensaje si no hay mensajes nuevos.
                                $(".menu-mensajes").prepend(`<div class="d-flex alert alert-warning justify-content-between align-items-center ms-4 mt-4 me-4">No hay mensajes nuevos.</div>`);
                            }
                        }
                    }
                })
            })

            // Evento click para poder ver el historial de mensajes.
            $("#historial").on("click", function() {
                $(".menu-selected").removeClass("menu-selected")
                $(this).addClass("menu-selected")

                // Petición AJAX para obtener historial.
                $.ajax({
                    url: url + "/func/nuevos-mensajes.php",
                    method: "POST",
                    dataType: 'JSON',
                    data: {
                        tipo: 2
                    },
                    success: function(res) {
                        if (res.id == "200") {
                            $(".menu-mensajes").html("");
                            let msg = res.message;
                            if(msg.length > 0){
                                // Muestra cada mensaje del historial con boton de borrar.
                                msg.forEach(function(mensaje) {
                                    let nombre = mensaje.nombre + " " + mensaje.apellidos;
                                    $(".menu-mensajes").prepend(`<div class="d-flex justify-content-between align-items-center mensaje w-100 ps-4" id="${mensaje.uuid}"><div>Mensaje de: ${nombre}</div><div class="me-3 nombre-usuario">${mensaje.fecha_envio} <button class="btn btn-danger btn-borrar d-none">B</button></div></div>`);
                                })
                            } else{
                                // Muestra mensaje si no hay historial.
                                $(".menu-mensajes").prepend(`<div class="d-flex alert alert-warning justify-content-between align-items-center ms-4 mt-4 me-4">No se encontraron mensajes en el historial.</div>`);
                            }
                        } else{
                            Swal.fire({
                                icon: "error",
                                title: res.message,
                            });
                        }
                    }
                })
            })

            // Evento delegado para hacer click en un mensaje especifico.
            $(document).on("click", ".mensaje", function() {
                // Obtenemos el ID único del mensaje clickeado
                let id = $(this).attr("id");
                // Petición AJAX para obtener el contenido completo del mensaje.
                $.ajax({
                    url: url + "/func/obtener_mensaje.php",
                    method: "POST",
                    data: { id },
                    success: function(res){

                        // Limpia el área de mensajes.
                        $(".menu-mensajes").html("");

                        // Actualiza contador de mensajes nuevos en el menú.
                        $("#nuevos-mensajes").html(`Mensajes (${res[1].numero})`);

                        // Si no hay mensajes nuevos, quitar el formato en negrita.
                        if(res[1].numero <= 0){
                            $("#nuevos-mensajes").removeClass("fw-bold")
                        }

                        // Obtener array de mensajes de la respuesta.
                        let mensajes = res[0];

                        // Determina el nombre de mensajes de la respuesta.
                        if(<?= $_SESSION["alumno_id"] ?> == res[0][0].emisor_id){
                            // Si el usuario actual es el emisor, mostrar nombre del receptor.
                            $nombre = res[0][0].nombre_re + " " + res[0][0].apellidos_re;
                        } else{
                            // Si el usuario actual es el receptor, mostrar nombre del emisor.
                            $nombre = res[0][0].nombre_em + " " + res[0][0].apellidos_em;
                        }

                        // Muestra el primer mensaje de la conversación.
                        if(res[0][0].emisor_id == <?= $_SESSION["alumno_id"] ?>){

                            //Si el usuario actual envio el mensaje, lo muestra alineado a la derecha con el fondo verde.
                            $(".menu-mensajes").append(`
                                <div class="d-flex flex-column m-2 main" data-hilo="${res[0][0].hilo}">
                                    <div class="d-flex justify-content-between">
                                        <div>
                                            <h4 class="emisor">${$nombre}</h4>
                                        </div>
                                        <div>
                                            <button class="btn btn-success msj-responder">Responder</button>
                                        </div>
                                    </div>
                                    <div class="">
                                        Fecha de creación: ${res[0][0].fecha_envio}
                                    </div>
                                    <div class="border-bottom mb-2 mt-2"></div>
                                    <div class="row div-mensajes">
                                        <div class="col-12 d-flex justify-content-end">
                                        <div class="d-flex flex-column m-2 p-2 rounded bg-success text-white main" style="max-width: 70%;">
                                            <div class="mb-1 small text-end">${res[0][0].fecha_envio}</div>
                                            <div>${res[0][0].mensaje}</div>
                                        </div>
                                    </div>
                                    </div>
                                </div>
                            `);
                        } else{

                            // Si otro usuario envió el mensaje, lo muestra alineado a la izquierda con fondo gris.
                            $(".menu-mensajes").append(`
                                <div class="d-flex flex-column m-2 main" data-hilo="${res[0][0].hilo}">
                                    <div class="d-flex justify-content-between">
                                        <div>
                                            <h4 class="emisor">${$nombre}</h4>
                                        </div>
                                        <div>
                                            <button class="btn btn-success msj-responder">Responder</button>
                                        </div>
                                    </div>
                                    <div class="">
                                        Fecha de creación: ${res[0][0].fecha_envio}
                                    </div>
                                    <div class="border-bottom mb-2 mt-2"></div>
                                    <div class="row div-mensajes">
                                        <div class="col-12 d-flex justify-content-start">
                                        <div class="d-flex flex-column m-2 p-2 rounded bg-light text-dark main" style="max-width: 70%;">
                                            <div class="mb-1 small text-muted">${res[0][0].fecha_envio}</div>
                                            <div>${res[0][0].mensaje}</div>
                                        </div>
                                    </div>
                                    </div>
                                </div>
                            `);
                        }

                        // Agrega el resto de mensajes de la conversación (desde el segundo mensaje en adelante).
                        mensajes.slice(1).forEach(function(mensaje){
                            if(mensaje.emisor_id == <?= $_SESSION["alumno_id"] ?>){
                                // Mensajes enviados por el usuario actual.
                                $(".div-mensajes").append(`
                                    <div class="col-12 d-flex justify-content-end">
                                        <div class="d-flex flex-column m-2 p-2 rounded bg-success text-white main" style="max-width: 70%;">
                                            <div class="mb-1 small text-end">${mensaje.fecha_envio}</div>
                                            <div>${mensaje.mensaje}</div>
                                        </div>
                                    </div>
                                `);
                            } else{
                                // Mensajes recibidos.
                                $(".div-mensajes").append(`
                                    <div class="col-12 d-flex justify-content-start">
                                        <div class="d-flex flex-column m-2 p-2 rounded bg-light text-dark main" style="max-width: 70%;">
                                            <div class="mb-1 small text-muted">${mensaje.fecha_envio}</div>
                                            <div>${mensaje.mensaje}</div>
                                        </div>
                                    </div>
                                `);
                            }
                        })
                    }
                })
            })
            // Evetno para mostrar el formulario de respuesta cuando se hace clock en "Responder".
            $(document).on("click", ".msj-responder", function() {
                $(".msj-responder").addClass("invisible");
                // Agrega el formulario de respuesta al final del área de mensajes.
                $(".menu-mensajes").append(`
                    <div class="div-respuesta">
                        <div class="border-bottom mb-1 mt-2"></div>
                        <div class="d-flex flex-column m-1">
                            <br>
                            <div class="w-100">
                                <label class="form-label">Respuesta:</label>
                                <textarea class="w-100 form-control respuesta"></textarea>
                            </div>
                            <div class="w-100 text-end mt-3">
                                <button class="btn btn-success btn-enviar">Enviar</button>
                                <button class="btn btn-danger btn-cancelar">Cancelar</button>
                            </div>
                        </div>
                    </div>
                `);
                // Desplaza hacia arriba al incio de la conversación
                const desplazar = setInterval(function(){
                    const menuMensajes = document.querySelector('.menu-mensajes');

                    menuMensajes.scrollTo({
                        top: menuMensajes.scrollHeight,
                        behavior: "smooth"
                    })

                    clearInterval(desplazar)// Limpia el intervalo 
                }, 100)

            })
            // Evento para cancelar una respuesta con el boton cancelar 
            $(document).on("click", ".btn-cancelar", function() {
                $(".msj-responder").removeClass("invisible"); // Muestra de nuevo el boton
                $(".div-respuesta").remove(); // Elimina el area de texto de respuesta

                //Desplaza automaticamente hacia la parte superior del contenedorde mensajes.
                const desplazar = setInterval(function(){
                    const menuMensajes = document.querySelector('.menu-mensajes');

                    menuMensajes.scrollTo({
                        top: 0,
                        behavior: "smooth"
                    })

                    clearInterval(desplazar) // Detiene el intervalo despues de hacer scroll.
                }, 100)
            })
            // Evento para enviar una respuesta con el boton enviar
            $(document).on("click", ".btn-enviar", function() {
                const hilo = $(this).closest(".menu-mensajes").find(".main").data("hilo");
                const mensaje = $(this).closest(".menu-mensajes").find(".respuesta").val();

                // Realiza peticion AJAX para enviar el mensaje.
                $.ajax({
                    url: url + "/func/responder_mensaje.php",
                    method: "POST",
                    data: { 
                        hilo,
                        mensaje
                     },
                    success: function(res){
                        if(res.code == "200"){
                            Swal.fire({
                                title: 'Mensaje enviado',
                                toast: true,
                                position: 'top-end',
                                timer: 3000,
                                timerProgressBar: true,
                                showConfirmButton: false,
                                icon: 'success'
                            });

                            $(".msj-responder").removeClass("invisible");
                            $(".div-respuesta").remove();

                            // Agrega el nuevo mensaje al hilo de conversación.
                            $(".div-mensajes").append(`
                                <div class="col-12 d-flex justify-content-end">
                                    <div class="d-flex flex-column m-2 p-2 rounded bg-success text-white main" style="max-width: 70%;">
                                        <div class="mb-1 small text-end">Ahora</div>
                                        <div>${mensaje}</div>
                                    </div>
                                </div>
                            `);
                        } else{
                            Swal.fire({
                                icon: "error",
                                title: res.message,
                            });
                        }
                    }
                })
            })
            // Evento al pasar el raton sobre un mensaje, mostrando el boton de borrar.
            $(document).on("mouseover", ".mensaje", function(){
                $(this).closest(".mensaje").find(".btn-borrar").removeClass("d-none")
            })

            // Evento al quitar el raton de un mensaje, oculta el boton de borrar.
            $(document).on("mouseleave", ".mensaje", function(){
                $(this).closest(".mensaje").find(".btn-borrar").addClass("d-none")
            })

            //Evento para eliminar una conversación completa.
            $(document).on("click", ".btn-borrar", function(e){
                e.stopPropagation(); // Previene que se active otro evento, como por ejemplo abrir el mensaje.
                let confirm = window.confirm("¿Seguro que quieres eliminar la conversación?")
                const hilo = $(this).closest(".mensaje").attr("id");
                const este = $(this);

                if(confirm){
                    // Si el usuario confirma,  se realiza la petición AJAX para eliminar.
                    $.ajax({
                        url: url + "/func/eliminar_mensaje.php",
                        method: "POST",
                        data: { hilo },
                        success: function(res){
                            if(res.code == "200"){
                                Swal.fire({
                                    title: res.message,
                                    toast: true,
                                    position: 'top-end',
                                    timer: 3000,
                                    timerProgressBar: true,
                                    showConfirmButton: false,
                                    icon: 'success'
                                });
                            
                                este.closest(".mensaje").remove();
                            } else{
                                Swal.fire({
                                    icon: "error",
                                    title: res.message,
                                });
                            }
                        }
                    })
                }
            })

        })

        
    </script>
</body>

</html>