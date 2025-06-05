<?php

$directorio = $_SERVER["DOCUMENT_ROOT"];
include("$directorio/includes/database.php");

global $link;

// Consulta para obtener todos los grupos ordenados por su ID ascendente.
$query = "SELECT * FROM grupo ORDER BY id_grupo ASC";
// Prepara la consulta SQL.
$stmt = $link->prepare($query);
// Ejecuta la consulta.
$stmt->execute();
// Obtiene el resultado.
$result = $stmt->get_result();
// Almacena los grupos en un array.
$grupos = [];

// Recorre cada fila del resultado y la añade al array del grupos.
while($datos = $result->fetch_assoc()){
    $grupos[] = $datos;
}

return $grupos;
