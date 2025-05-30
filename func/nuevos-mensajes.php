<?php
$directorio = $_SERVER["DOCUMENT_ROOT"];
session_start();

include("$directorio/func/verErrores.php");
include("$directorio/includes/database.php");
include_once("$directorio/func/logged.php");

if($_SERVER["REQUEST_METHOD"] === "POST"){
    global $link;

    $tipo = $_POST["tipo"];

    $id = $_SESSION["alumno_id"];

    if($tipo == 1){
        $query = "SELECT *, (SELECT nombre FROM usuario u WHERE u.id_alumno = m.emisor_id) AS nombre, (SELECT apellidos FROM usuario u WHERE u.id_alumno = m.emisor_id) AS apellidos FROM
            (SELECT *, ROW_NUMBER() OVER (PARTITION BY hilo ORDER BY fecha_envio DESC) AS rn FROM mensajes WHERE receptor_id = $id AND leido = 0 AND (receptor_id = $id AND deleted = 0)) m
            JOIN usuario u ON u.id_alumno = m.emisor_id
            WHERE m.rn = 1";
    } else{
        $query = "SELECT *, (SELECT nombre FROM usuario u WHERE u.id_alumno = m.emisor_id) AS nombre, (SELECT apellidos FROM usuario u WHERE u.id_alumno = m.emisor_id) AS apellidos FROM
            (SELECT *, ROW_NUMBER() OVER (PARTITION BY hilo ORDER BY fecha_envio DESC) AS rn FROM mensajes WHERE receptor_id = $id AND leido = 1 AND (receptor_id = $id AND deleted = 0)) m
            JOIN usuario u ON u.id_alumno = m.emisor_id
            WHERE m.rn = 1";
    }
    $stmt = $link->prepare($query);
    $stmt->execute();
    $result = $stmt->get_result();
    $mensajes = [];

    while($mensaje = $result->fetch_assoc()){
        $formato_fecha = new DateTime($mensaje["fecha_envio"]);
        $mensaje["fecha_envio"] = $formato_fecha->format("d/m/Y H:i");
        $mensajes[] = $mensaje;
    }

    echo json_encode(["message" => $mensajes, "id" => "200"]);
    exit;
}