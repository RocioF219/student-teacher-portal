<?php

$directorio = $_SERVER["DOCUMENT_ROOT"];
include("$directorio/includes/database.php");

session_start();

header("Content-Type: application/json");

if($_SERVER["REQUEST_METHOD"] === "POST"){
    global $link;

    $id = $_POST["id"];
    $contrasena = $_POST["input-cc-contrasena"];
    $cont_mod = password_hash($contrasena, PASSWORD_DEFAULT);

    $query = "UPDATE usuario SET contrasena = ? WHERE id_alumno = ?";
    $stmt = $link->prepare($query);
    $stmt->bind_param("si", $cont_mod, $id);
    $stmt->execute();
    $result = $stmt->get_result();

    if($stmt->affected_rows > 0){
        echo json_encode(["message" => "Cambios realizados correctamente", "id" => "200"]);
        exit;
    } else{
        echo json_encode(["message" => "Ocurrió un error al intentar realizar los cambios", "id" => "500"]);
        exit;
    }

}