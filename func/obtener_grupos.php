<?php

$directorio = $_SERVER["DOCUMENT_ROOT"];
include("$directorio/includes/database.php");

global $link;

$query = "SELECT * FROM grupo ORDER BY id_grupo ASC";
$stmt = $link->prepare($query);
$stmt->execute();
$result = $stmt->get_result();
$grupos = [];

while($datos = $result->fetch_assoc()){
    $grupos[] = $datos;
}

return $grupos;
