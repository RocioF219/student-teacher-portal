<?php
$directorio = $_SERVER["DOCUMENT_ROOT"];
session_start();

include("$directorio/func/verErrores.php");
include("$directorio/includes/database.php");
include_once("$directorio/func/logged.php");
include_once("$directorio/func/logged_profesor.php");

if($_SERVER["REQUEST_METHOD"] === "POST"){
    global $link;

    $tipo = $_POST["tipo"];

    $id = $_SESSION["alumno_id"];

    if($tipo == 1){
        $query = "SELECT *, (SELECT nombre FROM usuario u WHERE u.id_alumno = m.emisor_id) as nombre, (SELECT apellidos FROM usuario u WHERE u.id_alumno = m.emisor_id) as apellidos FROM mensajes m WHERE receptor_id = $id AND leido = 0";
    } else{
        $query = "SELECT *, (SELECT nombre FROM usuario u WHERE u.id_alumno = m.emisor_id) as nombre, (SELECT apellidos FROM usuario u WHERE u.id_alumno = m.emisor_id) as apellidos FROM mensajes m WHERE receptor_id = $id AND leido = 1";

    }
    $stmt = $link->prepare($query);
    $stmt->execute();
    $result = $stmt->get_result();
    $mensajes = [];

    while($mensaje = $result->fetch_assoc()){
        $mensajes[] = $mensaje;
    }

    echo json_encode(["message" => $mensajes, "id" => "200"]);
    exit;
}