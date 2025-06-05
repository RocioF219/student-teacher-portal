<!--Contenedor con padding a la izquierda y arriba usando la clase de boostrap--> 
<div class="ps-5 pt-4">
    <!--Contenedor flex con espacio entre elementos-->
    <div class="d-flex justify-content-between">
        <!--Enlace que redirige al panel CMS usando protocolo y dominio definidos dinamicamente-->
        <a href="<?= $protocolo . $dominio ?>/cms">
            <!--Imagen del icono con botón de regresa-->
            <img src="../img/atras_b.png" alt="Logout" style="width: 30px; height: 30px;">
        </a>
    </div>
</div>