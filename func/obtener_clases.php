<?php

$directorio = $_SERVER["DOCUMENT_ROOT"];
include("$directorio/includes/database.php");

global $link;

$id_grupo = $_SESSION["id_grupo"];

$query = "SELECT nombre_clase, fecha, DATE_FORMAT(hora_entrada, '%H:%i') as hora_entrada, DATE_FORMAT(hora_salida, '%H:%i') as hora_salida FROM clases WHERE id_grupo = ?";
$stmt = $link->prepare($query);
$stmt->bind_param("i", $id_grupo);
$stmt->execute();
$result = $stmt->get_result();
$clases = [];

while($datos = $result->fetch_assoc()){
    $clases[] = $datos;
}

return $clases;
