<?php

$server = "192.168.1.140";
$user = "root";
$contrasena = "password";
$db = "escueladanza";

$link = new mysqli($server, $user, $contrasena, $db);

if($link -> connect_error){
    die("Hubo un problema con la conexión");
}