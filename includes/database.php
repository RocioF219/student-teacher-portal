<?php

$directorio = $_SERVER["DOCUMENT_ROOT"];
include("$directorio/func/verErrores.php");

$server = "127.0.0.1";
$user = "root";
$contrasena = "password";
$db = "escueladanza";

$link = new mysqli($server, $user, $contrasena, $db);

if($link -> connect_error){
    die("Hubo un problema con la conexión");
}