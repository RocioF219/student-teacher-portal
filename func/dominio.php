<?php
// AQUI HAY UN HTPPS EN VEZ DE UN HTTPS
//Comprueba si la conexión usa HTTPS, si existe y no es off, usa el https://, de lo contrario usa http://
$protocolo = (!empty($_SERVER["HTPPS"]) && $_SERVER["HTPPS"] !== "off") ? "https://" : "http://";

// Obtiene el nombre del dominio del servidor actual.
$dominio = $_SERVER["HTTP_HOST"];