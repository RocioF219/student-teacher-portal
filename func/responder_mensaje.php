<?php
// DIrectorio raíz del servidor.
$directorio = $_SERVER["DOCUMENT_ROOT"];
// Incluimos la conexión a la base de datos y el autoload de Composer que es necesario para usar Ramsey y UUID.
include("$directorio/includes/database.php");
require "$directorio/vendor/autoload.php";

// Uso de clase de UUID de Ramsey para genera UUIDs.
use Ramsey\Uuid\Uuid;

// Inicia la sesion para acceder a las variables.
session_start();

// Verifica que la solicitud sea de tipo POST.
if($_SERVER["REQUEST_METHOD"] === "POST"){

    // Establece que la respuesta será en formato JSON.
    header("Content-Type: application/json");

    global $link;
// Obtiene los valores enviados por POST:
    $hilo = $_POST["hilo"];
    $id = $_SESSION["alumno_id"];
    $mensaje = $_POST["mensaje"];
    $uuid = Uuid::uuid4();

    $mensajes = [
        "code" => "500",
        "message" => "Error al enviar el mensaje."
    ];

    // Obtiene emisor y receptor del hilo actual
    $query = "SELECT emisor_id, receptor_id FROM mensajes WHERE hilo = ?";
    $stmt = $link->prepare($query);
    $stmt->bind_param("s", $hilo);
    $stmt->execute();
    $result = $stmt->get_result();
    $stmt->close();
    $emisor = $result->fetch_assoc();
    // Determina quien es el destinatario.
    $dest_id = ($emisor["emisor_id"] != $id) ? $emisor["emisor_id"] : $emisor["receptor_id"];
    $dest_col = ($emisor["emisor_id"] != $id) ? "emisor_id" : "receptor_id";

        // Inserta el nuevo mensaje en la base de datos.
        $query = "INSERT INTO mensajes(uuid, hilo, emisor_id, receptor_id, mensaje) VALUES (?, ?, ?, $dest_id , ?)";
        $stmt = $link->prepare($query);
        $stmt->bind_param("ssis", $uuid, $hilo, $id, $mensaje);
        $stmt->execute();
   
    // Verifica si se insertó correctamente.
    if($stmt->affected_rows > 0){
        $mensajes = [
            "code" => "200",
            "message" => "Mensaje enviado correctamente"
        ];
    }

    
    echo json_encode($mensajes);
}

