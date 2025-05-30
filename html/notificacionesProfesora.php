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

$alumnos = require_once("$directorio/func/obtener_alumnos.php");
$html_alumnos = "";

foreach($alumnos as $alumno){
    $html_alumnos .= '<option value="' . $alumno['id_alumno'] . '">' . $alumno['nombre'] . " " . $alumno['apellidos'] . '</option>';
}

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
                    <div class="d-flex align-items-center justify-content-center boton-menu w-100 p-2" id="crear-mensaje">Crear mensaje</div>
                    <div class="d-flex align-items-center justify-content-center boton-menu w-100 p-2 <?php if($num_mensajes > 0){ ?>fw-bold<?php } ?>" id="nuevos-mensajes">Mensajes (<?= $num_mensajes ?>)</div>
                    <div class="d-flex align-items-center justify-content-center boton-menu w-100 p-2" id="historial">Historial</div>
                </div>
                <div class="d-flex overflow-y-auto flex-column menu-mensajes w-75">

                </div>
            </div>
        </div>
    </div>

    <?php include_once("$directorio/includes/footer.php") ?>
    <script>
        $(document).ready(function() {
            $("#crear-mensaje").on("click", function() {
                $(".menu-selected").removeClass("menu-selected")
                $(this).addClass("menu-selected")
                let $alumnos = '<?= $html_alumnos ?>';
                $(".menu-mensajes").html("");
                $(".msj-responder").addClass("invisible");
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

                $('.select-alumnos').select2();
            })

            $(document).on("click", ".btn-enviar-nuevo-mensaje", function() {
                $.ajax({
                    url: url + "/func/enviar_mensaje.php",
                    method: "POST",
                    dataType: 'JSON',
                    data: $("#nuevo-mensaje").serialize() + "&d=1",
                    success: function(res) {
                        if (res.code == "200") {
                            Swal.fire({
                                title: 'Mensaje enviado',
                                toast: true,
                                position: 'top-end',
                                timer: 3000,
                                timerProgressBar: true,
                                showConfirmButton: false,
                                icon: 'success'
                            });
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

            $("#nuevos-mensajes").on("click", function() {
                $(".menu-selected").removeClass("menu-selected")
                $(this).addClass("menu-selected")
                $(".menu-mensajes").html("");
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
                                msg.forEach(function(mensaje) {
                                    let nombre = mensaje.nombre + " " + mensaje.apellidos;
                                    $(".menu-mensajes").prepend(`<div class="d-flex justify-content-between align-items-center mensaje w-100 ps-4" id="${mensaje.uuid}"><div>Mensaje de: ${nombre}</div><div class="me-3">${mensaje.fecha_envio}</div></div>`);
                                })
                            } else{
                                $(".menu-mensajes").prepend(`<div class="d-flex alert alert-warning justify-content-between align-items-center ms-4 mt-4 me-4">No hay mensajes nuevos.</div>`);
                            }
                        }
                    }
                })
            })

            $("#historial").on("click", function() {
                $(".menu-selected").removeClass("menu-selected")
                $(this).addClass("menu-selected")
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
                                msg.forEach(function(mensaje) {
                                    let nombre = mensaje.nombre + " " + mensaje.apellidos;
                                    $(".menu-mensajes").prepend(`<div class="d-flex justify-content-between align-items-center mensaje w-100 ps-4" id="${mensaje.uuid}"><div>Mensaje de: ${nombre}</div><div class="me-3 nombre-usuario">${mensaje.fecha_envio} <button class="btn btn-danger btn-borrar d-none">B</button></div></div>`);
                                })
                            } else{
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

            $(document).on("click", ".mensaje", function() {
                let id = $(this).attr("id");
                $.ajax({
                    url: url + "/func/obtener_mensaje.php",
                    method: "POST",
                    data: { id },
                    success: function(res){
                        $(".menu-mensajes").html("");
                        $("#nuevos-mensajes").html(`Mensajes (${res[1].numero})`);
                        if(res[1].numero <= 0){
                            $("#nuevos-mensajes").removeClass("fw-bold")
                        }
                        let mensajes = res[0];

                        if(<?= $_SESSION["alumno_id"] ?> == res[0][0].emisor_id){
                            $nombre = res[0][0].nombre_re + " " + res[0][0].apellidos_re;
                        } else{
                            $nombre = res[0][0].nombre_em + " " + res[0][0].apellidos_em;
                        }

                        if(res[0][0].emisor_id == <?= $_SESSION["alumno_id"] ?>){
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
                        mensajes.slice(1).forEach(function(mensaje){
                            if(mensaje.emisor_id == <?= $_SESSION["alumno_id"] ?>){
                                $(".div-mensajes").append(`
                                    <div class="col-12 d-flex justify-content-end">
                                        <div class="d-flex flex-column m-2 p-2 rounded bg-success text-white main" style="max-width: 70%;">
                                            <div class="mb-1 small text-end">${mensaje.fecha_envio}</div>
                                            <div>${mensaje.mensaje}</div>
                                        </div>
                                    </div>
                                `);
                            } else{
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

            $(document).on("click", ".msj-responder", function() {
                $(".msj-responder").addClass("invisible");
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
                
                const desplazar = setInterval(function(){
                    const menuMensajes = document.querySelector('.menu-mensajes');

                    menuMensajes.scrollTo({
                        top: menuMensajes.scrollHeight,
                        behavior: "smooth"
                    })

                    clearInterval(desplazar)
                }, 100)

            })

            $(document).on("click", ".btn-cancelar", function() {
                $(".msj-responder").removeClass("invisible");
                $(".div-respuesta").remove();
                
                const desplazar = setInterval(function(){
                    const menuMensajes = document.querySelector('.menu-mensajes');

                    menuMensajes.scrollTo({
                        top: 0,
                        behavior: "smooth"
                    })

                    clearInterval(desplazar)
                }, 100)
            })

            $(document).on("click", ".btn-enviar", function() {
                const hilo = $(this).closest(".menu-mensajes").find(".main").data("hilo");
                const mensaje = $(this).closest(".menu-mensajes").find(".respuesta").val();

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

            $(document).on("mouseover", ".mensaje", function(){
                $(this).closest(".mensaje").find(".btn-borrar").removeClass("d-none")
            })

            $(document).on("mouseleave", ".mensaje", function(){
                $(this).closest(".mensaje").find(".btn-borrar").addClass("d-none")
            })

            $(document).on("click", ".btn-borrar", function(e){
                e.stopPropagation();
                let confirm = window.confirm("¿Seguro que quieres eliminar la conversación?")
                const hilo = $(this).closest(".mensaje").attr("id");
                const este = $(this);

                if(confirm){
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