<?php

$directorio = $_SERVER["DOCUMENT_ROOT"];
// include("$directorio/func/logOut.php");

session_start();
session_destroy();

?>

<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link
    href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css"
    rel="stylesheet"
    integrity="sha384-SgOJa3DmI69IUzQ2PVdRZhwQ+dy64/BUtbMJw1MZ8t5HZApcHrRKUc4W0kG879m7"
    crossorigin="anonymous" />
  <script
    src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-k6d4wzSIapyDyv1kpU366/PK5hCdSbCRGRCMv+eplOQJWyd1fbcAu9OCUj5zNLiq"
    crossorigin="anonymous"></script>
  <link rel="stylesheet" href="css/entrada.css" />
  <title>Escuela de Danza Alicia Iranzo</title>
</head>

<body>
  <div class="circle circle1 z-n1" id="circulo1"></div>
  <div class="circle circle2 z-n1" id="circulo2"></div>
  <div class="circle circle3 z-n1" id="circulo3"></div>
  <div class="circle circle4 z-n1" id="circulo4"></div>
  <div class="circle circle5 z-n1" id="circulo5"></div>
  <div class="circle circle6 z-n1" id="circulo6"></div>
  <div class="circle circle7 z-n1" id="circulo7"></div>
  <div class="circle circle8 z-n1" id="circulo8"></div>
  <div class="circle circle9 z-n1" id="circulo9"></div>
  <div class="container">
    <div class="d-flex flex-column p-2 login-box">
      <div class="col mt-4">
        <img src="img/logo/logo_alicia.jpg" class="logo" alt="Imagen logo" />
      </div>
      <div class="col">
        <h5 class="card-title">Inicio de sesión</h5>
        <p class="card-text">
          Si eres la profesora, alumnado o administrador puedes iniciar
          sesion.
        </p>
      </div>
      <div class="col mt-2">
        <form method="POST" id="loginForm">
          <div class="mb-3">
            <label for="emailInput" class="form-label">Email</label>
            <input
              type="email"
              class="form-control"
              id="emailInput"
              name="email"
              aria-describedby="emailHelp" />
          </div>
          <div class="mb-3">
            <label for="passwordInput" class="form-label">Contraseña</label>
            <input
              type="password"
              class="form-control"
              id="passwordInput"
              name="contrasena" />
          </div>
          <br>
          <button type="button" class="btn btn-dark" id="submitForm">Iniciar sesión</button>
        </form>
      </div>
    </div>
  </div>

  <?php include($directorio . "/includes/footer.php") ?>
</body>

</html>