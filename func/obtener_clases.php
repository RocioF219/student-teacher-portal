<?php

// Obtiene la raíz del servidor.
$directorio = $_SERVER["DOCUMENT_ROOT"];
include("$directorio/includes/database.php");

global $link;

//Obtenemos el id del grupo desde la sesión.
$id_grupo = $_SESSION["id_grupo"];

// Consulta SQL para obtener las clases del grupo
// Se formatea la hora de entrada y salida para mostrar solo horas y minutos.
$query = "SELECT nombre_clase, fecha, DATE_FORMAT(hora_entrada, '%H:%i') as hora_entrada, DATE_FORMAT(hora_salida, '%H:%i') as hora_salida FROM clases WHERE id_grupo = ?";
// Se prepara la consulta.
$stmt = $link->prepare($query);
// Vincula el parametro id grupo a la consulta.
$stmt->bind_param("i", $id_grupo);
// Ejecuta la consulta.
$stmt->execute();
// Obtiene el resultado.
$result = $stmt->get_result();
// Array para almacenar las clases obtenidas.
$clases = [];
// Recorre cada fila del resultado y lo añade al array.
while($datos = $result->fetch_assoc()){
    $clases[] = $datos;
}

// Devuelve el array con todas las clases del grupo.
return $clases;
