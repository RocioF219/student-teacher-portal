<?php
// Directorio raíz y archivo para la conexión de la base de datos.
$directorio = $_SERVER["DOCUMENT_ROOT"];
include("$directorio/includes/database.php");

session_start();

//Establece que la respuesta será en formato JSON para la comunicación AJAX.
header("Content-Type: application/json");

// Solo ejecuta el código si la solicitud es POST.
if($_SERVER["REQUEST_METHOD"] === "POST"){
    global $link;

    // Mensaje por defecto en caso de que haya un error al eliminar.
    $mensajes = [
        "code" => "500",
        "message" => "Error al eliminar el mensaje."
    ];

    // Obtiene el identificador unico que es UUID del hilo del mensaje que ha sido enviado por el POST.
    $uuid = $_POST["hilo"];

    // Obtiene el ID del alumno desde la sesión activa.
    $id_alumno = $_SESSION["alumno_id"];

    // Consulta para obtener el identificador del hilo asociado al UUID que ha sido recibido.
    $query = "SELECT hilo FROM mensajes WHERE uuid = ?";
    $stmt = $link->prepare($query);
    
    if($stmt){
        // Asigna el parametro UUID a la consulta preparada.
        $stmt->bind_param("s", $uuid);
        // Ejecuta la consulta.
        $stmt->execute();
        // Obtiene el resultado de la consulta.
        $result = $stmt->get_result();
        // Extrae el hilo del resultado.
        $datos = $result->fetch_assoc();
        $hilo = $datos["hilo"];
        // Cierra la sentencia para liberar recursos.
        $stmt->close();
    }

    // Consulta para marcar como eliminado todos los mensajes de ese hilo.
    $query = "UPDATE mensajes SET deleted = 1 WHERE hilo = ? AND receptor_id = ?";
    $stmt = $link->prepare($query);
    
    if($stmt){
        // Asignaa los parametros de hilo e id_ alumno para la consulta preparada.
        $stmt->bind_param("si", $hilo, $id_alumno);
        $stmt->execute();
    
        if($stmt->affected_rows > 0){
            // Mensaje de respuesta para indicar el éxito.
            $mensajes = [
                "code" => "200",
                "message" => "Mensaje eliminado con éxito."
            ];
        }
    
        $stmt->close();
    }
    // Devuelve el mensaje del exito o de error.
    echo json_encode($mensajes);
}