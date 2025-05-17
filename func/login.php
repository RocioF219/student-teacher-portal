<?php

include("../includes/database.php");

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

    $query = "SELECT id, email, contrasena, tipo FROM usuarios WHERE email = ? AND contrasena = ?";
    $stmt = $link -> prepare($query);
    $stmt -> bind_param("ss", $email, $contrasena);
    $stmt -> execute();
    $resultado = $stmt -> get_result();

    if(mysqli_num_rows($resultado) > 0){
        $datos = $resultado->fetch_assoc();
        $_SESSION["user_id"] = $datos["id"];
        $_SESSION["rol"] = $datos["tipo"];
        echo json_encode(["id" => "200"]);
        exit;
    } else{
        echo json_encode(["message" => "Email o contraseña incorrectos", "id" => "500"]);
        exit;
    }

    $stmt->close();
}