<?php

$directorio = $_SERVER["DOCUMENT_ROOT"];
include("$directorio/includes/database.php");

session_start();

header("Content-Type: application/json");

if($_SERVER["REQUEST_METHOD"] === "POST"){
    global $link;

    $mensajes = [
        "code" => "500",
        "message" => "Error al eliminar el mensaje."
    ];

    $uuid = $_POST["hilo"];
    $id_alumno = $_SESSION["alumno_id"];

    $query = "SELECT hilo FROM mensajes WHERE uuid = ?";
    $stmt = $link->prepare($query);
    
    if($stmt){
        $stmt->bind_param("s", $uuid);
        $stmt->execute();
        $result = $stmt->get_result();
        $datos = $result->fetch_assoc();
        $hilo = $datos["hilo"];
        $stmt->close();
    }

    $query = "UPDATE mensajes SET deleted = 1 WHERE hilo = ? AND receptor_id = ?";
    $stmt = $link->prepare($query);
    
    if($stmt){
        $stmt->bind_param("si", $hilo, $id_alumno);
        $stmt->execute();
    
        if($stmt->affected_rows > 0){
            $mensajes = [
                "code" => "200",
                "message" => "Mensaje eliminado con éxito."
            ];
        }
    
        $stmt->close();
    }
    
    echo json_encode($mensajes);
}