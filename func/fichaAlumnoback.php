<?php
include("../includes/database.php");

session_start();

if(!isset($_SESSION['alumno:id'])){ // guarda la variable de sesion verifica si no existe y devulve al login
    header("Location: fichaAlumno.php"); //redirecciona
    exit();
}

$id = $_SESSION['alumno_id'];

$stmt = $conn->prepare("SELECT * FROM alumnos WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$resultado = $stmt->get_result();
$alumno = $resultado->fetch_assoc();

$stmtClases = $conn->prepare("SELECT nombre_clase, fecha, hora FROM clases WHERE alumno_id = ?");
$stmtClases->bind_param("i", $id);
$stmtClases->execute();
$resultClases = $stmtClases->get_result();

$clases = [];
while ($fila = $resultClases->fetch_assoc()) {
    $clases[] = $fila;
}
