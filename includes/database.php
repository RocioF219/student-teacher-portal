<?php

// Directorio raíz del servidor
$directorio = $_SERVER["DOCUMENT_ROOT"];
// Incluimos el archivo que habilita la visualización de errores.
include("$directorio/func/verErrores.php");

// Datos para la conexión a la base de datos.
$server = "127.0.0.1"; // Dirección del servidor de la base de datos.
$user = "root"; // Nombre de usuario para la base de datos.
$contrasena = "password"; // Contraseña del usuario de la base de datos.
$db = "escueladanza";// Nombre de la base de datos que se va a utilizar.

//Crea una nueva conexión a la base de datos usando MySQLi.
$link = new mysqli($server, $user, $contrasena, $db);

// Verifica si ocurrió un error durante la conexión.
if($link -> connect_error){
    // Si hay un error, se detiene la ejecución y se muestra un mensaje.
    die("Hubo un problema con la conexión");
}