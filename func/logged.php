<?php
// Verifica si la variable de sesion alumni_ id no esta definida
if(!isset($_SESSION["alumno_id"])){
    // Si no está definida, redirige al usuario a la página principal.
    header("Location: /");
}