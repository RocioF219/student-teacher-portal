<?php

$directorio = $_SERVER["DOCUMENT_ROOT"];
include("$directorio/includes/database.php");
// Incluimos el archivo de errores personalizados.
include("$directorio/func/verErrores.php");

session_start();

// Define que el contenido será JSON.
header("Content-Type: application/json");


// Verifica que la petición sea por método POST.
if($_SERVER["REQUEST_METHOD"] === "POST"){
    global $link;

    // Recupera los valores enviados desde el formulario.
    $nombre = $_POST["input-na-nombre"];
    $apellidos = $_POST["input-na-apellidos"];
    $email = $_POST["input-na-email"];
    $telefono = $_POST["input-na-telefono"];
    $grupo = $_POST["input-na-grupo"];
    $contrasena = password_hash($_POST["input-na-contrasena"], PASSWORD_BCRYPT);

    // Prepara una consulta para insertar al nuevo alumno.
    $query = "INSERT INTO usuario(id_grupo, nombre, apellidos, email, contrasena, telefono, id_rol) VALUES (?, ?, ?, ?, ?, ?, 1)";
    $stmt = $link->prepare($query); // Prepara la consulta SQL.
    $stmt->bind_param("isssss", $grupo, $nombre, $apellidos, $email, $contrasena, $telefono);
    $stmt->execute();
    
    // Verifica si la consulta afectó alguna fila, es decir si se insertó correctamente.
    if($stmt->affected_rows > 0){
        // Si fue exitoso, envia un mensaje de éxito.
        echo json_encode(["message" => "Alumno creado exitosamente", "id" => "200"]);
        exit;
    } else{
        // Si hubo un error , manda un mensaje de error.
        echo json_encode(["message" => "Ocurrió un error al intentar crear al alumno", "id" => "500"]);
        exit;
    }

}