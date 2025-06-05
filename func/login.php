<?php

// Directorio raíz del servidor
$directorio = $_SERVER["DOCUMENT_ROOT"];
include("$directorio/func/verErrores.php");
include("$directorio/includes/database.php");

session_start();

if($_SERVER["REQUEST_METHOD"] === "POST"){
    // Obtiene los datos enviados desde el formulario.
    $email = $_POST["email"];
    $contrasena = $_POST["contrasena"];

    header('Content-Type: application/json');

    // Valida que el email esté presente y tenga un formato correcto.
    if(!isset($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)){
        echo json_encode(["message" => "Por favor introduzca un email válido", "id" => "500"]);
        exit;
    }
    // Valida que la contraseá no esté vacía.
    if(strlen($contrasena) < 1){
        echo json_encode(["message" => "Por favor introduzca una contraseña", "id" => "500"]);
        exit;
    }
    // Consulta SQL para buscar al usuario con ese email.
    $query = "SELECT id_alumno, email, contrasena, id_rol, id_grupo FROM usuario WHERE email = ?";
    $stmt = $link -> prepare($query);
    $stmt -> bind_param("s", $email);
    $stmt -> execute();
    // Obtiene el resultado de la consulta.
    $resultado = $stmt -> get_result();
    $datos = $resultado->fetch_assoc();

    // Verifica si se encontró al usuario.
    if(mysqli_num_rows($resultado) > 0){
        // Compara la contraseña enviada con la almacenada.
        if(password_verify($contrasena, $datos["contrasena"])){

            // Asigna datos importantes a la sesión.
            $_SESSION["alumno_id"] = $datos["id_alumno"];
            $_SESSION["id_grupo"] = $datos["id_grupo"];
            $_SESSION["rol"] = $datos["id_rol"];

            // Redirige según el rol del usuario.
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
        }
    } else{
        // Si el usuario no se encuentra o las credenciales no coinciden.
        echo json_encode(["message" => "Email o contraseña incorrectos", "id" => "500"]);
        exit;
    }

    $stmt->close();
}