<?php

$directorio = $_SERVER["DOCUMENT_ROOT"];
include("$directorio/includes/database.php");

session_start();

header("Content-Type: application/json");

if($_SERVER["REQUEST_METHOD"] === "POST"){
    global $link;

    $email = $_POST["email"];
    $tlf = $_POST["tlf"];
    $id = $_SESSION["alumno_id"];

    $query = "SELECT email, telefono FROM alumno WHERE id_alumno = ?";
    $stmt = $link->prepare($query);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $datos = $result->fetch_assoc();

    if($datos["email"] == $email && $datos["telefono"] == $tlf){
        echo json_encode(["message" => "Datos iguales", "id" => "500"]);
        exit;
    }

    $query = "UPDATE alumno SET email = ?, telefono = ? WHERE id_alumno = ?";
    $stmt = $link->prepare($query);
    $stmt->bind_param("sii", $email, $tlf, $id);
    $stmt->execute();
    
    if($stmt->affected_rows > 0){
        echo json_encode(["message" => "Cambios realizados correctamente", "id" => "200"]);
        exit;
    } else{
        echo json_encode(["message" => "Ocurrió un error al intentar realizar los cambios", "id" => "500"]);
        exit;
    }

}