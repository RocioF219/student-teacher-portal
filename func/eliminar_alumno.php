<?php

$directorio = $_SERVER["DOCUMENT_ROOT"];
include("$directorio/includes/database.php");
include("$directorio/func/verErrores.php");

session_start();

header("Content-Type: application/json");

if($_SERVER["REQUEST_METHOD"] === "POST"){
    global $link;

    // Obtiene el ID del usuario alumno que se desea eliminar, enviado por el POST.
    $id = $_POST["id-user"];

    // Prepara la consulta SQL para eliminar al usuario con el ID específicado.
    $query = "DELETE FROM usuario WHERE id_alumno = ?";
    $stmt = $link->prepare($query);

    // Vincula el parámetro ID como entero para evitar inyección SQL.
    $stmt->bind_param("i", $id);

    // Ejecuta la consulta.
    $stmt->execute();
    
    // Verifica si se eliminó algún usuario.
    if($stmt->affected_rows > 0){
        echo json_encode(["message" => "Alumno eliminado exitosamente", "id" => "200"]);
        exit;
    } else{
        echo json_encode(["message" => "Ocurrió un error al intentar eliminar al alumno", "id" => "500"]);
        exit;
    }

}