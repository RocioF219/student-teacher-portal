<?php
//Incluimos el archivo de conexion a la base de datos.
include("../includes/database.php");

session_start();

// Verifica si el alumno ha iniciado sesion.
if (!isset($_SESSION['alumno_id'])) {

    // Si no se ha iniciado sesion , se  le redirige a la pagina principal.
    header("Location: /");
    exit();
}

// Se obtiene el ID del alumno y del grupo desde la sesion.
$id = $_SESSION['alumno_id'];
$id_grupo = $_SESSION['id_grupo'];

global $link;

// Se hace la consulta de los datos del alumnos y el nombre del grupo.
$query = "SELECT nombre, apellidos, email, telefono, g.nombre_grupo AS grupo FROM usuario a INNER JOIN grupo g ON g.id_grupo = a.id_grupo WHERE a.id_alumno = ?";
//Se prepara la consulta.
$stmt = $link->prepare($query);
// Asociacion del parametro id del alumno.
$stmt->bind_param("i", $id);
// Se ejecuta la consulta.
$stmt->execute();
//Ibtiene el resultado de la consulta.
$resultado = $stmt->get_result();
//Obtiene la fila con los datos del alumno.
$alumno = $resultado->fetch_assoc();
