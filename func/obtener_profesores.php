<?php

$directorio = $_SERVER["DOCUMENT_ROOT"];
include("$directorio/includes/database.php");

global $link;

$query = "SELECT id_alumno, nombre, apellidos, id_rol FROM usuario WHERE id_rol = 2";
$stmt = $link->prepare($query);
$stmt->execute();
$result = $stmt->get_result();
$profesores = [];

while($datos = $result->fetch_assoc()){
    $profesores[] = $datos;
}

return $profesores;
