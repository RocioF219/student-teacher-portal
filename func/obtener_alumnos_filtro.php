<?php

// Directorio raíz del servidor.
$directorio = $_SERVER["DOCUMENT_ROOT"];
// Incluye a la base de datos.
include("$directorio/includes/database.php");

// Decalracion de la variable global del enlace a la base de datos.
global $link;

header("Content-Type: application/json");
// Prepara el valor recibido por post para busqueda parcial.
$valor = "%".$_POST["valor"]."%";

// Consulta SQL que busca usuarios con rol de alumno y nombres y apellidos coincidan parcialmente con lo ingresado.
// También se obtiene el nombre del grupo al que pertenecen.
$query = "SELECT id_alumno, nombre, apellidos, email, telefono, id_rol, id_grupo, (SELECT nombre_grupo FROM grupo g WHERE u.id_grupo = g.id_grupo) as grupo FROM usuario u WHERE id_rol = 1 AND CONCAT(nombre, ' ', apellidos) LIKE ?";
// Prepara y ejecuta la consulta con el valor buscado.
$stmt = $link->prepare($query);
$stmt->bind_param("s", $valor);
$stmt->execute();
$result = $stmt->get_result();
// Array para almacenar los resultados.
$alumnos = [];

while($datos = $result->fetch_assoc()){
    $alumnos[] = $datos;
}

echo json_encode($alumnos);
