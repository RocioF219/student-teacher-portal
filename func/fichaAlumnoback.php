<?php
include("../includes/database.php");

session_start();

if (!isset($_SESSION['alumno_id'])) {
    header("Location: /");
    exit();
}

$id = $_SESSION['alumno_id'];
$id_grupo = $_SESSION['id_grupo'];

global $link;

$query = "SELECT nombre, apellidos, email, telefono, g.nombre_grupo AS grupo FROM usuario a INNER JOIN grupo g ON g.id_grupo = a.id_grupo WHERE a.id_alumno = ?";
$stmt = $link->prepare($query);
$stmt->bind_param("i", $id);
$stmt->execute();
$resultado = $stmt->get_result();
$alumno = $resultado->fetch_assoc();
