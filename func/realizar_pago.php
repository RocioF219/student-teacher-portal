<?php

// Directorio raíz del servidor
$directorio = $_SERVER["DOCUMENT_ROOT"];
//Incluimos la conexión a la base de datos.
include("$directorio/includes/database.php");

session_start();

// Verifica que la solicitud sea de tipo POST.
if($_SERVER["REQUEST_METHOD"] === "POST"){

    // Establece el tipo de contenido como JSON para la respuesta.
    header("Content-Type: application/json");

    global $link;

// Mensaje de error por defecto.
    $mensajes = [
        "id" => "500",
        "message" => "Error al realizar el pago"
    ];
// Obtiene los datos enviados desde el formulario.
    $id = $_SESSION["alumno_id"];
    $concepto = $_POST["inp-concepto"];
    $importe = $_POST["inp-importe"];
    $fecha = $_POST["inp-fecha"];
    $metodo = $_POST["inp-metodo"];

    // Prepara la consulta SQL para insertar el pago en la base de datos.
    $query = "INSERT INTO pago(id_alumno, concepto, metodo, fecha, precio) VALUES (?, ?, ?, ?, ?)";
    $stmt = $link->prepare($query);
    $stmt->bind_param("issss", $id, $concepto, $metodo, $fecha, $importe);
    $stmt->execute();

    // Si la inserción ha sido exitosa, cambia el mensaje de respuesta.
    if($stmt->affected_rows > 0){
        $mensajes = [
            "id" => "200",
            "message" => "Pago realizado correctamente"
        ];
    }
    // Devuelve la respuesta como JSON.
    echo json_encode($mensajes);
}

