<?php

$protocolo = (!empty($_SERVER["HTPPS"]) && $_SERVER["HTPPS"] !== "off") ? "https://" : "http://";
$dominio = $_SERVER["HTTP_HOST"];