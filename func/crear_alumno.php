<?php

$directorio = $_SERVER["DOCUMENT_ROOT"];
include("$directorio/includes/database.php");
include("$directorio/func/verErrores.php");

session_start();

header("Content-Type: application/json");

if($_SERVER["REQUEST_METHOD"] === "POST"){
    global $link;

    $nombre = $_POST["input-na-nombre"];
    $apellidos = $_POST["input-na-apellidos"];
    $email = $_POST["input-na-email"];
    $telefono = $_POST["input-na-telefono"];
    $grupo = $_POST["input-na-grupo"];
    $contrasena = $_POST["input-na-contrasena"];

    $query = "INSERT INTO usuario(id_grupo, nombre, apellidos, email, contrasena, telefono, id_rol) VALUES (?, ?, ?, ?, ?, ?, 1)";
    $stmt = $link->prepare($query);
    $stmt->bind_param("isssss", $grupo, $nombre, $apellidos, $email, $contrasena, $telefono);
    $stmt->execute();
    
    if($stmt->affected_rows > 0){
        echo json_encode(["message" => "Alumno creado exitosamente", "id" => "200"]);
        exit;
    } else{
        echo json_encode(["message" => "Ocurrió un error al intentar crear al alumno", "id" => "500"]);
        exit;
    }

}