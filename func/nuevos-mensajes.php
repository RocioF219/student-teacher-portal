<?php
$directorio = $_SERVER["DOCUMENT_ROOT"];
session_start();

include("$directorio/func/verErrores.php");
include("$directorio/includes/database.php");
include_once("$directorio/func/logged.php");

if($_SERVER["REQUEST_METHOD"] === "POST"){
    global $link;
// Recoge si se quieren ver mensajes leídfo, o no leidos.
    $tipo = $_POST["tipo"];
// ID del usuario actual, que es el receptor de los mensajes.
    $id = $_SESSION["alumno_id"];
//COnsulta para mensajes no leidos.
    if($tipo == 1){
        // Consulta SQL que selecciona mensajes no leidos del usuario.
        // Agrupa por hilos, toma el ultimo mensaje por hilo.
        //Obtiene nombre y apeliidos del emisor.
        $query = "SELECT *, (SELECT nombre FROM usuario u WHERE u.id_alumno = m.emisor_id) AS nombre, (SELECT apellidos FROM usuario u WHERE u.id_alumno = m.emisor_id) AS apellidos FROM
            (SELECT *, ROW_NUMBER() OVER (PARTITION BY hilo ORDER BY fecha_envio DESC) AS rn FROM mensajes WHERE receptor_id = $id AND leido = 0 AND (receptor_id = $id AND deleted = 0)) m
            JOIN usuario u ON u.id_alumno = m.emisor_id
            WHERE m.rn = 1";
    } else{
        // Consulta para los mensajes leidos.
        $query = "SELECT *, (SELECT nombre FROM usuario u WHERE u.id_alumno = m.emisor_id) AS nombre, (SELECT apellidos FROM usuario u WHERE u.id_alumno = m.emisor_id) AS apellidos FROM
            (SELECT *, ROW_NUMBER() OVER (PARTITION BY hilo ORDER BY fecha_envio DESC) AS rn FROM mensajes WHERE receptor_id = $id AND leido = 1 AND (receptor_id = $id AND deleted = 0)) m
            JOIN usuario u ON u.id_alumno = m.emisor_id
            WHERE m.rn = 1";
    }
    // Prepara y ejecuta la consulta.
    $stmt = $link->prepare($query);
    $stmt->execute();
    $result = $stmt->get_result();
    $mensajes = [];
// Recorre cada resultado y formatea la fecha.
    while($mensaje = $result->fetch_assoc()){
        $formato_fecha = new DateTime($mensaje["fecha_envio"]);
        $mensaje["fecha_envio"] = $formato_fecha->format("d/m/Y H:i");
        $mensajes[] = $mensaje; // Añade mensaje al array final.
    }

    echo json_encode(["message" => $mensajes, "id" => "200"]);
    exit;
}