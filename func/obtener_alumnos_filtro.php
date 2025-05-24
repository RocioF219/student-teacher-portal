<?php

$directorio = $_SERVER["DOCUMENT_ROOT"];
include("$directorio/includes/database.php");

global $link;

header("Content-Type: application/json");

$valor = "%".$_POST["valor"]."%";

$query = "SELECT id_alumno, nombre, apellidos, email, telefono, id_rol, id_grupo, (SELECT nombre_grupo FROM grupo g WHERE u.id_grupo = g.id_grupo) as grupo FROM usuario u WHERE id_rol = 1 AND CONCAT(nombre, ' ', apellidos) LIKE ?";
$stmt = $link->prepare($query);
$stmt->bind_param("s", $valor);
$stmt->execute();
$result = $stmt->get_result();
$alumnos = [];

while($datos = $result->fetch_assoc()){
    $alumnos[] = $datos;
}

echo json_encode($alumnos);
