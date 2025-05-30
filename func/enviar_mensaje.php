<?php

$directorio = $_SERVER["DOCUMENT_ROOT"];
include("$directorio/includes/database.php");
require "$directorio/vendor/autoload.php";
include("$directorio/func/verErrores.php");


use Ramsey\Uuid\Uuid;

session_start();

if($_SERVER["REQUEST_METHOD"] === "POST"){

    header("Content-Type: application/json");

    global $link;

    $mensajes = [
        "code" => "500",
        "message" => "Error al enviar el mensaje."
    ];

    $id = $_SESSION["alumno_id"];
    $id_usuario = $_POST["inp-usuario"];
    $mensaje = $_POST["inp-mensaje"];
    $direccion = $_POST["d"] ?? 20;

    if($direccion == 1){
        $query = "SELECT id_alumno FROM usuario WHERE id_rol = 1";
        $stmt = $link->prepare($query);
        $stmt->execute();
        $result = $stmt->get_result();
        $alumnos = [];
    
        while($alumno = $result->fetch_assoc()){
            $alumnos[] = $alumno["id_alumno"];
        }
    
        function generar_id(){
            return "hilo_" . time() . "_" . bin2hex(random_bytes(8));
        }
    
        if(in_array($id_usuario, $alumnos)){
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
    } else{
        $query = "SELECT id_alumno FROM usuario WHERE id_rol = 2";
        $stmt = $link->prepare($query);
        $stmt->execute();
        $result = $stmt->get_result();
        $profesores = [];
    
        while($profesor = $result->fetch_assoc()){
            $profesores[] = $profesor["id_alumno"];
        }
    
        function generar_id(){
            return "hilo_" . time() . "_" . bin2hex(random_bytes(8));
        }
    
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

