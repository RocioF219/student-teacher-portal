<?php

$directorio = $_SERVER["DOCUMENT_ROOT"];
include("$directorio/includes/database.php");

session_start();

if($_SERVER["REQUEST_METHOD"] === "POST"){

    header("Content-Type: application/json");

    global $link;

    $mensajes = [
        "code" => "500",
        "message" => "Error"
    ];

    $id = $_SESSION["alumno_id"];
    $id_profesor = base64_decode($_POST["inp-profesor"]);
    $mensaje = $_POST["inp-mensaje"];

    $query = "INSERT INTO mensajes(emisor_id, receptor_id, mensaje) VALUES (?, ?, ?)";
    $stmt = $link->prepare($query);
    $stmt->bind_param("iis", $id, $id_profesor, $mensaje);
    $stmt->execute();

    if($stmt->affected_rows > 0){
        $mensajes = [
            "code" => "200",
            "message" => "Mensaje enviado correctamente"
        ];
    }
    
    echo json_encode($mensajes);
}

