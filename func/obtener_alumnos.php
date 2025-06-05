<?php

$directorio = $_SERVER["DOCUMENT_ROOT"];
include("$directorio/includes/database.php");

global $link;

//Consulta SQL para obtener todos los alumnos.
// Se obtiene el nombre del grupo asociado a cada alumno mediante una subconsulta.
$query = "SELECT id_alumno, nombre, apellidos, email, telefono, id_rol, id_grupo, (SELECT nombre_grupo FROM grupo g WHERE u.id_grupo = g.id_grupo) as grupo FROM usuario u WHERE u.id_rol = 1";
// Se prepara la consulta.
$stmt = $link->prepare($query);
// Ejecuta la consulta.
$stmt->execute();
// Se obtiene el resultado de la consulta.
$result = $stmt->get_result();
// Array para almacenar todos los alumnos.
$alumnos = [];

// Recorre todos los resultados y los añade al array.
while($datos = $result->fetch_assoc()){
    $alumnos[] = $datos;
}
// Devuelve el array con todos los alumnos.
return $alumnos;
