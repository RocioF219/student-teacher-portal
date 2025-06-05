<?php

// Obtiene la ruta raíz del servidor
$directorio = $_SERVER["DOCUMENT_ROOT"];

// Incluye el archivo de conexión a la base de datos.
include("$directorio/includes/database.php");

// Inicia la sesión del usuario.
session_start();

// Establece que la respuesta derá del tipo JSON.
header("Content-Type: application/json");

// Verifica que la petición sea de tipo POST.
if($_SERVER["REQUEST_METHOD"] === "POST"){
    // Accede a la variable global.
    global $link;

    // Obtiene el ID del alumno enviados por el POST.
    $id = $_POST["id"];

    // Obtiene la nueva contraseña desde el formulario.
    $contrasena = $_POST["input-cc-contrasena"];

    // Hash de la nueva contraseña.
    $cont_mod = password_hash($contrasena, PASSWORD_DEFAULT);

    // Prepara la consulta SQL para actualizar la contraseña del usaurio.
    $query = "UPDATE usuario SET contrasena = ? WHERE id_alumno = ?";
    $stmt = $link->prepare($query);
    // Indica que se espera resibir un string y un integer.
    $stmt->bind_param("si", $cont_mod, $id);
    // Ejecuta la consulta.
    $stmt->execute();
    // Obtiene el resultado.
    $result = $stmt->get_result();

    // Verifica si se hizo la actualización correctamente.
    if($stmt->affected_rows > 0){
        // Devuelve un mensaje de exito.
        echo json_encode(["message" => "Cambios realizados correctamente", "id" => "200"]);
        exit;
    } else{
        // Devuelve un mensaje de error.
        echo json_encode(["message" => "Ocurrió un error al intentar realizar los cambios", "id" => "500"]);
        exit;
    }

}