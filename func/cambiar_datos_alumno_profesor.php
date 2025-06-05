<?php

$directorio = $_SERVER["DOCUMENT_ROOT"];
include("$directorio/includes/database.php");
include("$directorio/func/verErrores.php");

session_start();

header("Content-Type: application/json");

// Verifica si la solicitud fue realizada mediante el metodo POST.
if($_SERVER["REQUEST_METHOD"] === "POST"){
    global $link;
// Recupera los datos que son enviados por el formulario.
    $nombre = $_POST["inp-nombre"];
    $apellidos = $_POST["inp-apellidos"];
    $email = $_POST["inp-email"];
    $telefono = $_POST["inp-telefono"];
    $grupo = $_POST["inp-grupo"];
    $id = $_POST["id-user"];

    // Prepara la consulta SQL para actualizar los datos del usuario.
    $query = "UPDATE usuario SET nombre = ?, apellidos = ?, email = ?, telefono = ?, id_grupo = ? WHERE id_alumno = ?";
    $stmt = $link->prepare($query);
    $stmt->bind_param("ssssii", $nombre, $apellidos, $email, $telefono, $grupo, $id);
    $stmt->execute();

    // if($datos["nombre"] == $nombre && $datos["apellidos"] == $apellidos && $datos["email"] == $email && $datos["telefono"] == $tlf && $datos["id_grupo"] == $grupo){
    //     echo json_encode(["message" => "Datos iguales", "id" => "500"]);
    //     exit;
    // }
    
    // Verifica si la actualización de la filas de hizo correctamente.
    if($stmt->affected_rows > 0){
        echo json_encode(["message" => "Cambios realizados correctamente", "id" => "200"]);
        exit;
    } else{
        echo json_encode(["message" => "Ocurrió un error al intentar realizar los cambios", "id" => "500"]);
        exit;
    }

}