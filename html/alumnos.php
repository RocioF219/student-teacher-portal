<?php
$directorio = $_SERVER["DOCUMENT_ROOT"];
session_start();

include("$directorio/func/verErrores.php");
include("$directorio/func/dominio.php");
include_once("$directorio/func/logged.php");
include_once("$directorio/func/logged_profesor.php");

$alumnos = include_once("$directorio/func/obtener_alumnos.php");
$grupos = include_once("$directorio/func/obtener_grupos.php");

?>
<!DOCTYPE html>
<html lang="es">

<head>
    <?php include_once("$directorio/includes/header.php"); ?>
    <link rel="stylesheet" href="../css/alumnos.css" />
</head>

<body>
    <header class="container-padre py-3">
        <div class="container">
            <div class="row align-items-center">

                <!-- Logo a la izquierda -->
                <div class="col-4 col-md-2 text-start">
                    <img src="../img/logo/logo_alicia.jpg" alt="Logo" style="height: 150px;">
                </div>

                <!-- Buscador centrado -->
                <div class="col-12 col-md-8 my-2 my-md-0 d-flex justify-content-center">
                    <input type="text" class="form-control w-50 w-md-50 me-3" id="nombre-alumno" name="inp-nombre-alumno" placeholder="Buscar por nombre...">
                    <button class="btn btn-outline-success my-2 my-sm-0 btn-buscar" type="submit">Buscar</button>
                </div>

                <!-- Logout a la derecha -->
                <div class="col-4 col-md-2 text-end">
                    <a href="/">
                        <img src="../img/logo/log-out.svg" alt="Logout" style="width: 30px; height: 30px;">
                    </a>
                </div>

            </div>
        </div>
    </header>
    <div class="ps-5 pt-4">
        <div class="d-flex justify-content-between">
            <a href="<?= $protocolo . $dominio ?>/cms">
                <img src="../img/atras_b.png" alt="Logout" style="width: 30px; height: 30px;">
            </a>
            <button class="btn btn-success me-5 btn-crear-alumno" data-bs-toggle="modal" data-bs-target="#modal-crear-alumno">Crear nuevo alumno</button>
        </div>
    </div>
    <div id="container-cards" class="container-cards ps-4 pt-4">
        <?php foreach ($alumnos as $alumno) { ?>
            <div class="card m-3 p-2" style="width: 18rem;">
                <img src="<?= $protocolo . $dominio ?>/img/person.svg" class="card-img-top" alt="alumno">
                <div class="card-body">
                    <form class="alumno-form">
                        <label for="nombre">Nombre:</label>
                        <input class="form-control mb-1 nombre" name="inp-nombre" value="<?= $alumno["nombre"] ?>" disabled>
                        <label for="apellidos">Apellidos:</label>
                        <input class="form-control mb-1 apellidos" name="inp-apellidos" value="<?= $alumno["apellidos"] ?>" disabled>
                        <label for="email">Email:</label>
                        <input class="form-control mb-1 email" name="inp-email" value="<?= $alumno["email"] ?>" disabled>
                        <label for="telefono">Telefono:</label>
                        <input class="form-control mb-1 telefono" name="inp-telefono" value="<?= $alumno["telefono"] ?>" disabled>
                        <label for="grupo">Grupo:</label>
                        <select class="form-control mb-1 grupo" name="inp-grupo" disabled>
                            <option value="<?= ($alumno["id_grupo"] != 0) ? $alumno["id_grupo"] : "" ?>"><?= ($alumno["grupo"] != 0) ? $alumno["grupo"] : "Elije un grupo" ?></option>
                            <?php foreach ($grupos as $grupo) { ?>
                                <option value="<?= $grupo["id_grupo"] ?>"><?= $grupo["nombre_grupo"] ?></option>
                            <?php } ?>
                        </select>
                        <input type="hidden" class="id-user" name="id-user" value="<?= $alumno["id_alumno"] ?>">
                    </form>
                </div>
                <div class="card-body d-flex justify-content-end">
                    <button class="btn btn-warning btn-sm me-2 btn-contra" data-bs-toggle="modal" data-bs-target="#modal-cambiar-contrasena">Cambiar contraseña</button>
                    <button class="btn btn-dark btn-sm me-2 btn-editar">Editar</button>
                    <button class="btn btn-success btn-sm me-2 btn-guardar d-none">Guardar</button>
                    <button class="btn btn-danger btn-sm me-2 btn-cancelar d-none">Cancelar</button>
                    <button class="btn btn-danger btn-sm me-2 btn-borrar">Borrar</button>
                </div>
            </div>
        <?php } ?>
        <!-- Modal cambiar contraseña -->
        <div class="modal fade" id="modal-cambiar-contrasena" tabindex="-1" aria-labelledby="modal-label-cambiar-contrasena" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modal-label-cambiar-contrasena">Cambiar la contraseña</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form id="form-cambiar-contrasena">
                            <label class="form-label" for="cc-contrasena">Contraseña:</label>
                            <input type="password" class="form-control" name="input-cc-contrasena" id="cc-contrasena">
                            <br>
                            <label class="form-label" for="cc-contrasena2">Confirmar contraseña:</label>
                            <input type="password" class="form-control" name="input-cc-contrasena2" id="cc-contrasena2">
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cerrar</button>
                        <button type="button" class="btn btn-success" id="btn-confirmar-contrasena">Aceptar</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- Modal crear alumno -->
        <div class="modal fade" id="modal-crear-alumno" tabindex="-1" aria-labelledby="modal-label-crear-alumno" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modal-label-crear-alumno">Crear nuevo alumno</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form id="form-nuevo-alumno">
                            <label class="form-label" for="na-nombre">Nombre:</label>
                            <input type="text" class="form-control" name="input-na-nombre" id="na-nombre">
                            <br>
                            <label class="form-label" for="na-apellidos">Apellidos:</label>
                            <input type="text" class="form-control" name="input-na-apellidos" id="na-apellidos">
                            <br>
                            <label class="form-label" for="na-email">Email:</label>
                            <input type="text" class="form-control" name="input-na-email" id="na-email">
                            <br>
                            <label class="form-label" for="na-telefono">Telefono:</label>
                            <input type="text" class="form-control" name="input-na-telefono" id="na-telefono">
                            <br>
                            <label class="form-label" for="na-grupo">Grupo:</label>
                            <select class="form-control mb-1 grupo" id="na-grupo" name="input-na-grupo">
                                <option value="">Elije un grupo</option>
                                <?php foreach ($grupos as $grupo) { ?>
                                    <option value="<?= $grupo["id_grupo"] ?>"><?= $grupo["nombre_grupo"] ?></option>
                                <?php } ?>
                            </select>
                            <br>
                            <label class="form-label" for="na-contrasena">Contraseña:</label>
                            <input type="password" class="form-control" name="input-na-contrasena" id="na-contrasena">
                            <br>
                            <label class="form-label" for="na-contrasena2">Confirmar contraseña:</label>
                            <input type="password" class="form-control" name="input-na-contrasena2" id="na-contrasena2">
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cerrar</button>
                        <button type="button" class="btn btn-success" id="btn-confirmar-alumno">Crear alumno</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?= include_once($directorio . "/includes/footer.php") ?>
</body>

<script>
    const regexEmail = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

    $(document).ready(function() {
        const datosCrear = localStorage.getItem("alumnoCreado");
        const datosEliminar = localStorage.getItem("alumnoEliminado");

        if(datosCrear){
            const respuesta = JSON.parse(datosCrear);

            if(respuesta.usuarioCreado){
                Swal.fire({
                    icon: "success",
                    title: respuesta.msg,
                });

                localStorage.removeItem("alumnoCreado");
            }
        }

        if(datosEliminar){
            const respuesta = JSON.parse(datosEliminar);

            if(respuesta.usuarioEliminado){
                Swal.fire({
                    icon: "success",
                    title: respuesta.msg,
                });

                localStorage.removeItem("alumnoEliminado");
            }
        }

        $(".btn-buscar").on("click", function() {
            $valor = $("#nombre-alumno").val();

            $.ajax({
                url: url + "/func/obtener_alumnos_filtro.php",
                method: "POST",
                data: {
                    valor: $valor
                },
                success: function(res) {
                    let html = "";
                    res.forEach((alumno, x) => {
                        html += `<div class="card m-3 p-2" style="width: 18rem;">
                                    <img src="<?= $protocolo . $dominio ?>/img/person.svg" class="card-img-top" alt="alumno">
                                    <div class="card-body">
                                        <form class="alumno-form">
                                            <label for="nombre">Nombre:</label>
                                            <input class="form-control mb-1 nombre" id="nombre" name="inp-nombre" value="${alumno.nombre}" disabled>
                                            <label for="apellidos">Apellidos:</label>
                                            <input class="form-control mb-1 apellidos" id="apellidos" name="inp-apellidos" value="${alumno.apellidos}" disabled>
                                            <label for="email">Email:</label>
                                            <input class="form-control mb-1 email" id="email" name="inp-email" value="${alumno.email}" disabled>
                                            <label for="telefono">Telefono:</label>
                                            <input class="form-control mb-1 telefono" id="telefono" name="inp-telefono" value="${alumno.telefono}" disabled>
                                            <label for="grupo">Grupo:</label>
                                            <select class="form-control mb-1 grupo" id="grupo" name="inp-grupo" disabled>
                                                <option value="${(alumno.id_grupo != 0) ? alumno.id_grupo : ""}">${(alumno.grupo != 0) ? alumno.grupo : "Elije un grupo"}</option>
                                                <?php foreach ($grupos as $grupo) { ?>
                                                    <option value="<?= $grupo["id_grupo"] ?>"><?= $grupo["nombre_grupo"] ?></option>
                                                <?php } ?>
                                            </select>
                                            <input type="hidden" name="id-user" value="${alumno.id_alumno}">
                                        </form>
                                    </div>
                                    <div class="card-body d-flex justify-content-end">
                                        <button class="btn btn-dark btn-sm me-2 btn-editar">Editar</button>
                                        <button class="btn btn-success btn-sm me-2 btn-guardar d-none">Guardar</button>
                                        <button class="btn btn-danger btn-sm me-2 btn-cancelar d-none">Cancelar</button>
                                        <button class="btn btn-danger btn-sm me-2 btn-borrar">Borrar</button>
                                    </div>
                                </div>`
                        $("#container-cards").html(html);
                    });
                }
            })
        })

        $(document).on("click", ".btn-editar", function() {
            $(this).closest(".card").find(".nombre, .apellidos, .email, .telefono, .grupo").attr("disabled", false)
            $(this).addClass("d-none");
            $(this).closest(".card").find(".btn-borrar").addClass("d-none");
            $(this).closest(".card").find(".btn-guardar").removeClass("d-none");
            $(this).closest(".card").find(".btn-cancelar").removeClass("d-none");
        })

        $(document).on("click", ".btn-cancelar", function() {
            $(this).closest(".card").find(".nombre, .apellidos, .email, .telefono, .grupo").attr("disabled", true)
            $(this).addClass("d-none");
            $(this).closest(".card").find(".btn-borrar").removeClass("d-none");
            $(this).closest(".card").find(".btn-editar").removeClass("d-none");
            $(this).closest(".card").find(".btn-guardar").addClass("d-none");
        })

        $(document).on("click", ".btn-borrar", function() {
            const respuesta = confirm("¿Seguro que quieres eliminar este alumno?");

            if(respuesta){
                $.ajax({
                    url: url + "/func/eliminar_alumno.php",
                    type: "POST",
                    data: $(this).closest(".card").find(".alumno-form").serialize(),
                    success: function(res) {
                        if (res.id == "200") {
                            const datos = {
                                eliminado: true,
                                msg: res.message
                            }
                            localStorage.setItem("eliminarAlumno", JSON.stringify(datos));
                            location.reload();
                        } else {
                            Swal.fire({
                                icon: "error",
                                title: res.message,
                            });
                        }
                    }
                })
            }
        })


        $(document).on("click", ".btn-guardar", function() {
            let $nombre = $(this).closest(".card").find(".nombre").val();
            let $apellidos = $(this).closest(".card").find(".apellidos").val();
            let $email = $(this).closest(".card").find(".email").val();
            let $telefono = $(this).closest(".card").find(".telefono").val();
            let $grupo = $(this).closest(".card").find(".grupo").val();

            let $btn_guardar = $(this);
            let $btn_borrar = $(this).closest(".card").find(".btn-borrar");
            let $btn_editar = $(this).closest(".card").find(".btn-editar");
            let $btn_cancelar = $(this).closest(".card").find(".btn-cancelar");
            let $inputs = $(this).closest(".card").find(".nombre, .apellidos, .email, .telefono, .grupo");

            if ($nombre.length <= 0 || $apellidos.length <= 0 || $email.length <= 0 || $telefono.length <= 0) {
                Swal.fire({
                    icon: "error",
                    title: "Debes rellenar todos lo campos",
                });
            }

            if (!regexEmail.test($email)) {
                Swal.fire({
                    icon: "error",
                    title: "Formato del email no valido",
                });
            }

            if ($telefono.length > 9 || $telefono.length < 9) {
                Swal.fire({
                    icon: "error",
                    title: "El teléfono debe tener 9 dígitos",
                });
            }

            $.ajax({
                url: url + "/func/cambiar_datos_alumno_profesor.php",
                type: "POST",
                data: $(this).closest(".card").find(".alumno-form").serialize(),
                success: function(res) {
                    if (res.id == "200") {
                        Swal.fire({
                            icon: "success",
                            title: res.message,
                        });
                        $btn_guardar.addClass("d-none");
                        $btn_cancelar.addClass("d-none");
                        $btn_borrar.removeClass("d-none");
                        $btn_editar.removeClass("d-none");
                        $inputs.attr("disabled", true);
                    } else {
                        Swal.fire({
                            icon: "error",
                            title: res.message,
                        });
                    }
                }
            })
        })

        $("#btn-confirmar-alumno").on("click", function(){
            let $nombre = $("#na-nombre").val();
            let $apellidos = $("#na-apellidos").val();
            let $email = $("#na-email").val();
            let $telefono = $("#na-telefono").val();
            let $grupo = $("#na-grupo").val();
            let $contrasena = $("#na-contrasena").val();
            let $contrasena2 = $("#na-contrasena2").val();
            
            if($nombre.length <= 0){
                Swal.fire({
                    icon: "error",
                    title: "Por favor, rellene el campo nombre",
                });
                return;
            }
            if($apellidos.length <= 0){
                Swal.fire({
                    icon: "error",
                    title: "Por favor, rellene el campo apellidos",
                });
                return;
            }
            if($email.length <= 0){
                Swal.fire({
                    icon: "error",
                    title: "Por favor, rellene el campo email",
                });
                return;
            }
            if(!regexEmail.test($email)){
                Swal.fire({
                    icon: "error",
                    title: "Email no válido",
                });
                return;
            }
            if($telefono.length <= 0){
                Swal.fire({
                    icon: "error",
                    title: "Por favor, rellene el campo teléfono",
                });
                return;
            }
            if($telefono.length < 9){
                Swal.fire({
                    icon: "error",
                    title: "Por favor, el teléfono debe tener al menos 9 dígitos",
                });
                return;
            }
            if($grupo.length <= 0){
                Swal.fire({
                    icon: "error",
                    title: "Por favor, rellene el campo grupo",
                });
                return;
            }
            if($contrasena.length <= 0){
                Swal.fire({
                    icon: "error",
                    title: "Por favor, rellene el campo contraseña",
                });
                return;
            }
            if($contrasena2.length <= 0){
                Swal.fire({
                    icon: "error",
                    title: "Por favor, rellene el campo confirmar contraseña",
                });
                return;
            }
            if($contrasena !== $contrasena2){
                Swal.fire({
                    icon: "error",
                    title: "Las contraseñas no coinciden",
                });
                return;
            }

            $.ajax({
                url: url + "/func/crear_alumno.php",
                method: "POST",
                data: $("#form-nuevo-alumno").serialize(),
                success: function(res){
                    if (res.id == "200") {
                        const datos = {
                            usuarioCreado: true,
                            msg: res.message
                        }
                        localStorage.setItem("alumnoCreado", JSON.stringify(datos));
                        location.reload();
                    } else{
                        Swal.fire({
                            icon: "error",
                            title: res.message,
                        });
                    }
                }
            })
        })

        $(document).on("click", ".btn-contra", function(){
            const idAlumno = $(this).closest(".card").find(".id-user").val();
            $("#btn-confirmar-contrasena").data("id-user", idAlumno);
        })

        $("#btn-confirmar-contrasena").on("click", function(){
            let $contrasena = $("#cc-contrasena").val();
            let $contrasena2 = $("#cc-contrasena2").val();
            let $id = $(this).data("id-user");

            if($contrasena.length <= 0){
                Swal.fire({
                    icon: "error",
                    title: "Por favor, rellene el campo contraseña",
                });
                return;
            }
            if($contrasena2.length <= 0){
                Swal.fire({
                    icon: "error",
                    title: "Por favor, rellene el campo confirmar contraseña",
                });
                return;
            }
            if($contrasena !== $contrasena2){
                Swal.fire({
                    icon: "error",
                    title: "Las contraseñas no coinciden",
                });
                return;
            }

            $.ajax({
                url: url + "/func/cambiar_contrasena_alumno.php",
                method: "POST",
                data: $("#form-cambiar-contrasena").serialize() + "&id=" + $id,
                success: function(res){
                    if (res.id == "200") {
                        Swal.fire({
                            icon: "success",
                            title: res.message,
                        });

                        $("#modal-cambiar-contrasena").modal("hide");
                        $("#form-cambiar-contrasena")[0].reset();
                    } else{
                        Swal.fire({
                            icon: "error",
                            title: res.message,
                        });
                    }
                }
            })
        })
    })
</script>

</html>