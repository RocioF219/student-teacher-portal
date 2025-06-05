<?php

// Verifica si el usuario actual no tiene el rol igual a 2.
if($_SESSION["rol"] != 2){
    // Si el rol no es 2, redirige a la ruta fihca. 
    header("Location: /ficha");
}