
// Genera una posición aleatoria dentro del ancho de la ventana del navegador.
const randomX = Math.floor(Math.random() * window.innerWidth);

//Genera una posición aleatoria dentro del alto de la ventana del navegador.
const randomY = Math.floor(Math.random() * window.innerHeight);

//Asocia un evento de clic al botón con id "submitform".
$("#submitForm").click(function(){

    //Valida que el campo del email contenga una direccion valida.
    if(!revisarEmail($("#emailInput").val())){
        // Si el email no es valido, muestra un mensaje de error.
        Swal.fire({
            icon: "error",
            title: "Por favor introduzca un email válido",
        });
        return;
    }

    // Verifica que se haya ingresado la contraseña.
    if($("#passwordInput").val().length < 1){
        Swal.fire({
            icon: "error",
            title: "Por favor introduzca una contraseña",
        });
        return;
    }
    // Si las validaciones pasan de forma correcta, se envía una petición AJAX al servidor.
    $.ajax({
        url: "../func/login.php", // Ruta del archivo PHP donde procesa el login
        method: "POST",
        data: $("#loginForm").serialize(), // Serialización de los campos del formulario.
        success: function(res){
            if(res.id === "500"){
                Swal.fire({
                    icon: "error",
                    title: res.message,
                });
            } else{
                // SI hay error, redirige al usuario a la URL que devuelve el servidor
                window.location.href = res.url;
            }
        },
        // Función que se ejecuta si hay un fallo en la conexión AJAX.
        error: function(){
            Swal.fire({
                icon: "error",
                title: "Ocurrió un error, inténtelo de nuevo.",
            });
        }
    });
});
// Función para verificar si el email tiene un formato válido.
function revisarEmail(email) {
    const formato = /^[^\s@]+@[^\s@]+\.[^\s@]+$/; // Expresión regular para validar emails.
    return formato.test(email); // Devuelve true si el formato es válido, false si no lo es.
}