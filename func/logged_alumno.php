<?php

// Verifica si el rol del usuario en la sesión no es igual a 1.
if($_SESSION["rol"] != 1){
    // Si el rol no es 1, redirige al usuario al cms.
    header("Location: /cms");
}