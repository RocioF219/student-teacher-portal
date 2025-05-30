<?php

$directorio = $_SERVER["DOCUMENT_ROOT"];
include("$directorio/includes/database.php");

session_start();

header("Content-Type: application/json");

if($_SERVER["REQUEST_METHOD"] === "POST"){
    global $link;

    $id = $_POST["id"];
    $id_alumno = $_SESSION["alumno_id"];

    $query = "UPDATE mensajes SET leido = 1 WHERE uuid = ?";
    $stmt = $link->prepare($query);
    $stmt->bind_param("s", $id);
    $stmt->execute();
    $stmt->close();

    $query = "SELECT count(*) as numero FROM `mensajes` WHERE receptor_id = $id_alumno AND leido = 0";
    $stmt = $link->prepare($query);
    $stmt->execute();
    $stmt->execute();
    $result = $stmt->get_result();
    $stmt->close();
    $num = $result->fetch_assoc();
    
    // $query = "SELECT mensaje, hilo, (SELECT nombre FROM usuario u WHERE id_alumno = m.emisor_id) as nombre, (SELECT apellidos FROM usuario u WHERE id_alumno = m.emisor_id) as apellidos, fecha_envio FROM mensajes m WHERE uuid = ?";
    // $stmt = $link->prepare($query);
    // $stmt->bind_param("s", $id);
    // $stmt->execute();
    // $result = $stmt->get_result();
    // $stmt->close();

    $query = "SELECT hilo FROM mensajes m WHERE uuid = ?";
    $stmt = $link->prepare($query);
    $stmt->bind_param("s", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $stmt->close();
    $datos = $result->fetch_assoc();
    $hilo = $datos["hilo"];

    $query = "SELECT emisor_id, mensaje, hilo, (SELECT nombre FROM usuario u WHERE id_alumno = m.emisor_id) as nombre_em, (SELECT apellidos FROM usuario u WHERE id_alumno = m.emisor_id) as apellidos_em, (SELECT nombre FROM usuario u WHERE id_alumno = m.receptor_id) as nombre_re, (SELECT apellidos FROM usuario u WHERE id_alumno = m.receptor_id) as apellidos_re, fecha_envio FROM mensajes m WHERE hilo = ?";
    $stmt = $link->prepare($query);
    $stmt->bind_param("s", $hilo);
    $stmt->execute();
    $result = $stmt->get_result();
    $stmt->close();
    $mensajes = [];

    while($mensaje = $result->fetch_assoc()){
        $formato_fecha = new DateTime($mensaje["fecha_envio"]);
        $mensaje["fecha_envio"] = $formato_fecha->format("d/m/Y H:i");
        $mensajes[] = $mensaje;
    }
    
    echo json_encode([$mensajes, $num]);
}