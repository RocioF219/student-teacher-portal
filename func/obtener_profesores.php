<?php

// Directoria raíz del servidor.
$directorio = $_SERVER["DOCUMENT_ROOT"];
// Incluimos la conexión a la base de datos.
include("$directorio/includes/database.php");


global $link;
//Consulta para obtener los usuarios con el rol 2.
$query = "SELECT id_alumno, nombre, apellidos, id_rol FROM usuario WHERE id_rol = 2";
// Prepara la consulta para evitar inyecciones SQL.
$stmt = $link->prepare($query);
// Ejecuta la consulta.
$stmt->execute();
// Se obtiene el resultado de la consulta.
$result = $stmt->get_result();
$profesores = [];

// Recorre cada fila del resultado y lo añade al array de profesores.
while($datos = $result->fetch_assoc()){
    $profesores[] = $datos;
}

// Devuelve el arreglo con los profesores.
return $profesores;
