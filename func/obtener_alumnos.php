<?php

$directorio = $_SERVER["DOCUMENT_ROOT"];
include("$directorio/includes/database.php");

global $link;

$query = "SELECT id_alumno, nombre, apellidos, email, telefono, id_rol, id_grupo, (SELECT nombre_grupo FROM grupo g WHERE u.id_grupo = g.id_grupo) as grupo FROM usuario u WHERE u.id_rol = 1";
$stmt = $link->prepare($query);
$stmt->execute();
$result = $stmt->get_result();
$alumnos = [];

while($datos = $result->fetch_assoc()){
    $alumnos[] = $datos;
}

return $alumnos;
