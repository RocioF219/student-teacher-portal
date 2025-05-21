<?php

$directorio = $_SERVER["DOCUMENT_ROOT"];
include("$directorio/func/verErrores.php");
include("$directorio/includes/database.php");

session_start();

if($_SERVER["REQUEST_METHOD"] === "POST"){
    $email = $_POST["email"];
    $contrasena = $_POST["contrasena"];

    header('Content-Type: application/json');

    if(!isset($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)){
        echo json_encode(["message" => "Por favor introduzca un email válido", "id" => "500"]);
        exit;
    }

    if(strlen($contrasena) < 1){
        echo json_encode(["message" => "Por favor introduzca una contraseña", "id" => "500"]);
        exit;
    }

    $query = "SELECT id_alumno, email, contrasena, id_rol, id_grupo FROM usuario WHERE email = ? AND contrasena = ?";
    $stmt = $link -> prepare($query);
    $stmt -> bind_param("ss", $email, $contrasena);
    $stmt -> execute();
    $resultado = $stmt -> get_result();

    if(mysqli_num_rows($resultado) > 0){
        $datos = $resultado->fetch_assoc();
        $_SESSION["alumno_id"] = $datos["id_alumno"];
        $_SESSION["id_grupo"] = $datos["id_grupo"];
        $_SESSION["rol"] = $datos["id_rol"];
        if($_SESSION["rol"] === 1){
            echo json_encode([
                "id" => "200",
                "url" => "/ficha"
            ]);
            exit;
        } elseif($_SESSION["rol"] === 2){
            echo json_encode([
                "id" => "200",
                "url" => "/cms"
            ]);
            exit;
        }
    } else{
        echo json_encode(["message" => "Email o contraseña incorrectos", "id" => "500"]);
        exit;
    }

    $stmt->close();
}