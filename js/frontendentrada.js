const randomX = Math.floor(Math.random() * window.innerWidth);
const randomY = Math.floor(Math.random() * window.innerHeight);

$("#submitForm").click(function(){
    if(!revisarEmail($("#emailInput").val())){
        Swal.fire({
            icon: "error",
            title: "Por favor introduzca un email válido",
        });
        return;
    }

    if($("#passwordInput").val().length < 1){
        Swal.fire({
            icon: "error",
            title: "Por favor introduzca una contraseña",
        });
        return;
    }

    $.ajax({
        url: "../func/login.php",
        method: "POST",
        data: $("#loginForm").serialize(),
        success: function(res){
            if(res.id === "500"){
                Swal.fire({
                    icon: "error",
                    title: res.message,
                });
            } else{
                window.location.href = res.url;
            }
        },
        error: function(){
            Swal.fire({
                icon: "error",
                title: "Ocurrió un error, inténtelo de nuevo.",
            });
        }
    });
});

function revisarEmail(email) {
    const formato = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    return formato.test(email);
}