<?php

//Obtenemos la ruta raíz del servidor para usar rutas absolutas
$directorio = $_SERVER["DOCUMENT_ROOT"];

//Incluimos los archivos de conexión a la base de datos, carga automatica de clases, función personalizada de manejo de errores.
include("$directorio/includes/database.php");
require "$directorio/vendor/autoload.php";
include("$directorio/func/verErrores.php");

// Uso de la clase UUID de la librería Ramsey 
use Ramsey\Uuid\Uuid;

session_start();

if($_SERVER["REQUEST_METHOD"] === "POST"){

    header("Content-Type: application/json");

    global $link;

    // Respuesta por defecto si falla algo
    $mensajes = [
        "code" => "500",
        "message" => "Error al enviar el mensaje."
    ];

    //Id del usuario emisor e ID del usuario receptor, mennsaje y direccion.
    $id = $_SESSION["alumno_id"];
    $id_usuario = $_POST["inp-usuario"];
    $mensaje = $_POST["inp-mensaje"];
    $direccion = $_POST["d"] ?? 20;

    // Si la direccion es 1, se envia a un alumno.
    if($direccion == 1){

        // Se hace la consulta de todos los IDs de usuarios con rol 1, que son alumnos.
        $query = "SELECT id_alumno FROM usuario WHERE id_rol = 1";
        $stmt = $link->prepare($query);
        $stmt->execute();
        $result = $stmt->get_result();
        $alumnos = [];
    
        // Almacena todos los IDs de alumnos.
        while($alumno = $result->fetch_assoc()){
            $alumnos[] = $alumno["id_alumno"];
        }
    
        // Funcion interna para generar un ID unico de hilo.
        function generar_id(){
            return "hilo_" . time() . "_" . bin2hex(random_bytes(8));
        }
    
        // Verifica que el ID destino pertenezca a un alumno.
        if(in_array($id_usuario, $alumnos)){
            // Genera un UUID uni, un identificador de hilo unico.
            $uuid = Uuid::uuid4();
            $hilo = generar_id();
            // Inserta el mensaje en la base de datos.
            $query = "INSERT INTO mensajes(uuid, hilo, emisor_id, receptor_id, mensaje) VALUES (?, ?, ?, ?, ?)";
            $stmt = $link->prepare($query);
            $stmt->bind_param("ssiis", $uuid, $hilo, $id, $id_usuario, $mensaje);
            $stmt->execute();
        // Si la insercion fue exitosa, cambia el mensaje de respuesta.
            if($stmt->affected_rows > 0){
                $mensajes = [
                    "code" => "200",
                    "message" => "Mensaje enviado correctamente"
                ];
            }
        }
    } else{
        // Si no es la direccion 1, se asume que el destino es un profesor que es el rol 2.
        $query = "SELECT id_alumno FROM usuario WHERE id_rol = 2";
        $stmt = $link->prepare($query);
        $stmt->execute();
        $result = $stmt->get_result();
        $profesores = [];
    // Almacena los IDs de los profesores.
        while($profesor = $result->fetch_assoc()){
            $profesores[] = $profesor["id_alumno"];
        }
    // Genera un ID unico de hilo.
        function generar_id(){
            return "hilo_" . time() . "_" . bin2hex(random_bytes(8));
        }
    
        // Verifica que el ID receptor sea un profesor.
        if(in_array($id_usuario, $profesores)){
            $uuid = Uuid::uuid4();
            $hilo = generar_id();
            $query = "INSERT INTO mensajes(uuid, hilo, emisor_id, receptor_id, mensaje) VALUES (?, ?, ?, ?, ?)";
            $stmt = $link->prepare($query);
            $stmt->bind_param("ssiis", $uuid, $hilo, $id, $id_usuario, $mensaje);
            $stmt->execute();
        
            if($stmt->affected_rows > 0){
                $mensajes = [
                    "code" => "200",
                    "message" => "Mensaje enviado correctamente"
                ];
            }
        }
    }

    
    echo json_encode($mensajes);
}

