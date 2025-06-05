<?php

$directorio = $_SERVER["DOCUMENT_ROOT"];
include("$directorio/includes/database.php");

global $link;

$id_grupo = $_SESSION["id_grupo"];

// Consulta para obtener pagos con datos del alumno que hizo el pago, ordenados por el ultimo pago realizado.
$query = "SELECT (SELECT nombre FROM usuario u WHERE u.id_alumno = p.id_alumno) AS nombre, (SELECT apellidos FROM usuario u WHERE u.id_alumno = p.id_alumno) AS apellidos, concepto, metodo, fecha, precio FROM pago p ORDER BY id_pago DESC";
$stmt = $link->prepare($query);
$stmt->execute();
$result = $stmt->get_result();
$pagos = [];

// Recorre el resultado y lo almacena en un array.
while($datos = $result->fetch_assoc()){
    $pagos[] = $datos;
}
// Devuelve el array con los pagos.
return $pagos;
