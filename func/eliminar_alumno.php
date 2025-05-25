<?php

$directorio = $_SERVER["DOCUMENT_ROOT"];
include("$directorio/includes/database.php");
include("$directorio/func/verErrores.php");

session_start();

header("Content-Type: application/json");

if($_SERVER["REQUEST_METHOD"] === "POST"){
    global $link;

    $id = $_POST["id-user"];

    $query = "DELETE FROM usuario WHERE id_alumno = ?";
    $stmt = $link->prepare($query);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    
    if($stmt->affected_rows > 0){
        echo json_encode(["message" => "Alumno eliminado exitosamente", "id" => "200"]);
        exit;
    } else{
        echo json_encode(["message" => "Ocurrió un error al intentar eliminar al alumno", "id" => "500"]);
        exit;
    }

}