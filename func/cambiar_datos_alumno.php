<?php

// Directorio raíz.
$directorio = $_SERVER["DOCUMENT_ROOT"];
include("$directorio/includes/database.php");

session_start();

header("Content-Type: application/json");

// Comprueba que la petición fue hecha mediante el método POST.
if($_SERVER["REQUEST_METHOD"] === "POST"){
    global $link;
// Recupera los datos enviados desde el formulario.
    $email = $_POST["email"];
    $tlf = $_POST["tlf"];
    $id = $_SESSION["alumno_id"];

    // Consulta para obtener el email y el telefono actual del usuario.
    $query = "SELECT email, telefono FROM usuario WHERE id_alumno = ?";
    $stmt = $link->prepare($query); // Prepara la consulta.
    $stmt->bind_param("i", $id); // Enlaza el ID como parametro.
    $stmt->execute(); // Ejecuta la consulta.
    $result = $stmt->get_result(); // Obtiene los resultados.
    $datos = $result->fetch_assoc(); // Los convierte en un array assoc.

    // Comprueba si los datos nuevos son iguales a los que ya están
    if($datos["email"] == $email && $datos["telefono"] == $tlf){
        // Si no hay cambios, devuelve un mensaje indicando que los datos son iguales.
        echo json_encode(["message" => "Datos iguales", "id" => "500"]);
        exit;
    }

    // Si los datos han cambiado, realiza una actualización en la base de datos.
    $query = "UPDATE usuario SET email = ?, telefono = ? WHERE id_alumno = ?";
    $stmt = $link->prepare($query); // Prepara una nueva consulta.
    $stmt->bind_param("sii", $email, $tlf, $id); // Enlaza los nuevos valores.
    $stmt->execute(); // Ejecuta la actualización.
    
    // Verifica si alguna fila ha sido modificada.
    if($stmt->affected_rows > 0){
        echo json_encode(["message" => "Cambios realizados correctamente", "id" => "200"]);
        exit;
    } else{
        // Muestra un error si lo anterior no se actualizó.
        echo json_encode(["message" => "Ocurrió un error al intentar realizar los cambios", "id" => "500"]);
        exit;
    }

}