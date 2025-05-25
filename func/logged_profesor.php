<?php

if($_SESSION["rol"] != 2){
    header("Location: /ficha");
}