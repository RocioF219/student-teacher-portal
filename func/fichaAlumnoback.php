<?php
include("../includes/database.php");

session_start();

if (!isset($_SESSION['alumno_id'])) {
    header("Location: /");
    exit();
}

$id = $_SESSION['alumno_id'];

global $link;

$query = "SELECT nombre, apellidos, email, telefono, g.nombre_grupo AS grupo FROM alumno a INNER JOIN grupo g ON g.id_grupo = a.id_grupo WHERE id_alumno = ?";
$stmt = $link->prepare($query);
$stmt->bind_param("i", $id);
$stmt->execute();
$resultado = $stmt->get_result();
$alumno = $resultado->fetch_assoc();

$stmtClases = $link->prepare("SELECT nombre_clase, fecha, hora FROM clases WHERE alumno_id = ?");
$stmtClases->bind_param("i", $id);
$stmtClases->execute();
$resultClases = $stmtClases->get_result();

$clases = [];
while ($fila = $resultClases->fetch_assoc()) {
    $clases[] = $fila;
}
