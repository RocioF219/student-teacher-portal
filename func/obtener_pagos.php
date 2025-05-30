<?php

$directorio = $_SERVER["DOCUMENT_ROOT"];
include("$directorio/includes/database.php");

global $link;

$id_grupo = $_SESSION["id_grupo"];

$query = "SELECT (SELECT nombre FROM usuario u WHERE u.id_alumno = p.id_alumno) AS nombre, (SELECT apellidos FROM usuario u WHERE u.id_alumno = p.id_alumno) AS apellidos, concepto, metodo, fecha, precio FROM pago p ORDER BY id_pago DESC";
$stmt = $link->prepare($query);
$stmt->execute();
$result = $stmt->get_result();
$pagos = [];

while($datos = $result->fetch_assoc()){
    $pagos[] = $datos;
}

return $pagos;
