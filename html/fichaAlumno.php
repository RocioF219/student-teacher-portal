<?php
include("../func/fichaAlumnoBack.php")
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
                    <!-- FullCalendar CSS -->
        <link href="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.10/main.min.css" rel="stylesheet" />
                   <!-- FullCalendar JS -->
         <script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.10/main.min.js"></script>
        <link
            href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css"
            rel="stylesheet"
            integrity="sha384-SgOJa3DmI69IUzQ2PVdRZhwQ+dy64/BUtbMJw1MZ8t5HZApcHrRKUc4W0kG879m7"
            crossorigin="anonymous"
        />
        <script
            src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-k6d4wzSIapyDyv1kpU366/PK5hCdSbCRGRCMv+eplOQJWyd1fbcAu9OCUj5zNLiq"
            crossorigin="anonymous"
        ></script>
        <link rel="stylesheet" href="../css/fichaAlumno.css" />
        <title>Escuela de Danza Alicia Iranzo</title>
    </head>
    <body>
        <header>
            <div class="containerPadre">
                <img class="logo" src="../img/logo/logo_alicia.jpg" />
                <a href="../index.html">
                    <div class="containerHijo">
                        <img
                            class="button"
                            src="../img/logo/log-out.svg"
                            alt="Log out"
                            style="width: 30px; height: 30px"
                        />
                    </div>
                </a>
            </div>
        </header>
        <div class="contenedorTarjeta">
            <div class="row">
                <div class="col d-flex justify-content-center">
                    <div class="card" style="width: 18rem">
                        <img src="../img/logo/logo_alicia.jpg" class="card-img-top" alt="Imagen del alumno" />
                        <div class="card-body">
                        <h5 class="card-title"><?php echo $alumno['nombre'] . " " . $alumno['apellido']; ?></h5>
                            <ul class="list-group list-group-flush">
                                <li class="list-group-item"><?php echo $alumno['nombre']; ?></li>
                                <li class="list-group-item"><?php echo $alumno['apellido']; ?></li>
                                <li class="list-group-item"><?php echo $alumno['email']; ?></li>
                                <li class="list-group-item"><?php echo $alumno['telefono']; ?></li>
                                <li class="list-group-item"><?php echo $alumno['nombre_padres']; ?></li>
                            </ul>
                        <div class="card-body">
                            <a href="#" class="card-link">Editar</a>
                            <a href="#" class="card-link">Borrar</a>
                        </div>
                    </div>
                </div>
                <div class="col">
                    <div class="contenedorCalendario">
                        <div class="calendario">
                            <table id="calendar" style="background-color: aliceblue;">
                                <caption></caption>
                                <thead>
                                    <tr>
                                        <th>Lun</th>
                                        <th>Mar</th>
                                        <th>Mié</th>
                                        <th>Jue</th>
                                        <th>Vie</th>
                                        <th>Sáb</th>
                                        <th>Dom</th>
                                    </tr>
                                </thead>
                                <tbody></tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="col text-white">
                   Seccion de mensajes
                </div>
                <div class="col">
  <div class="card">
    <div class="card-header bg-primary text-white">
      Registrar Pago
    </div>
    <div class="card-body">
      <form id="formPago">
        <div class="mb-3">
          <label for="concepto" class="form-label">Concepto</label>
          <input type="text" class="form-control" id="concepto" placeholder="Mensualidad abril, matrícula...">
        </div>
        <div class="mb-3">
          <label for="importe" class="form-label">Importe (€)</label>
          <input type="number" class="form-control" id="importe" placeholder="Ej: 50">
        </div>
        <div class="mb-3">
          <label for="fecha" class="form-label">Fecha</label>
          <input type="date" class="form-control" id="fecha">
        </div>
        <div class="mb-3">
          <label for="metodo" class="form-label">Método de pago</label>
          <select class="form-select" id="metodo">
            <option>Selecciona</option>
            <option>Efectivo</option>
            <option>Transferencia</option>
            <option>Bizum</option>
          </select>
        </div>
        <button type="submit" class="btn btn-success">Enviar</button>
      </form>
    </div>
  </div>
</div>
            </div>
        </div>
        <script>
    window.clasesAlumno = <?php echo json_encode($clases); ?>;
    </script>
    <script src="js/fichaAlumno.js">
    </script>
    </body>
</html>
