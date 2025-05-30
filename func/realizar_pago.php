<?php

$directorio = $_SERVER["DOCUMENT_ROOT"];
include("$directorio/includes/database.php");

session_start();

if($_SERVER["REQUEST_METHOD"] === "POST"){

    header("Content-Type: application/json");

    global $link;

    $mensajes = [
        "id" => "500",
        "message" => "Error al realizar el pago"
    ];

    $id = $_SESSION["alumno_id"];
    $concepto = $_POST["inp-concepto"];
    $importe = $_POST["inp-importe"];
    $fecha = $_POST["inp-fecha"];
    $metodo = $_POST["inp-metodo"];

    $query = "INSERT INTO pago(id_alumno, concepto, metodo, fecha, precio) VALUES (?, ?, ?, ?, ?)";
    $stmt = $link->prepare($query);
    $stmt->bind_param("issss", $id, $concepto, $metodo, $fecha, $importe);
    $stmt->execute();

    if($stmt->affected_rows > 0){
        $mensajes = [
            "id" => "200",
            "message" => "Pago realizado correctamente"
        ];
    }
    
    echo json_encode($mensajes);
}

