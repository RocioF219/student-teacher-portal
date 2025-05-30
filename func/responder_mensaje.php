<?php

$directorio = $_SERVER["DOCUMENT_ROOT"];
include("$directorio/includes/database.php");
require "$directorio/vendor/autoload.php";

use Ramsey\Uuid\Uuid;

session_start();

if($_SERVER["REQUEST_METHOD"] === "POST"){

    header("Content-Type: application/json");

    global $link;

    $hilo = $_POST["hilo"];
    $id = $_SESSION["alumno_id"];
    $mensaje = $_POST["mensaje"];
    $uuid = Uuid::uuid4();

    $mensajes = [
        "code" => "500",
        "message" => "Error al enviar el mensaje."
    ];

    $query = "SELECT emisor_id, receptor_id FROM mensajes WHERE hilo = ?";
    $stmt = $link->prepare($query);
    $stmt->bind_param("s", $hilo);
    $stmt->execute();
    $result = $stmt->get_result();
    $stmt->close();
    $emisor = $result->fetch_assoc();
    $dest_id = ($emisor["emisor_id"] != $id) ? $emisor["emisor_id"] : $emisor["receptor_id"];
    $dest_col = ($emisor["emisor_id"] != $id) ? "emisor_id" : "receptor_id";

        $query = "INSERT INTO mensajes(uuid, hilo, emisor_id, receptor_id, mensaje) VALUES (?, ?, ?, $dest_id , ?)";
        $stmt = $link->prepare($query);
        $stmt->bind_param("ssis", $uuid, $hilo, $id, $mensaje);
        $stmt->execute();
   

    if($stmt->affected_rows > 0){
        $mensajes = [
            "code" => "200",
            "message" => "Mensaje enviado correctamente"
        ];
    }

    
    echo json_encode($mensajes);
}

