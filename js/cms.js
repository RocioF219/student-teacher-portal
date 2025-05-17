const alumnos = [
    {
      nombre: "Rocio",
      apellido: "Fuentes",
      email: "rocio@gmail.com",
      telefono: "12345678",
      grupo: "Mayores",
      img: "../img/person.svg"
    },
    {
      nombre: "Lucia",
      apellido: "Gutierrez Gómez",
      email: "lucia@gmail.com",
      telefono: "12345678",
      grupo: "Mayores",
      img: "../img/person.svg"
    },
  ];
  
  const contenedor = document.getElementById("container-cards");
  
  alumnos.forEach((alumno, index) => {
    const card = document.createElement("div");
    card.classList.add("card", "m-3", "p-2");
    card.style.width = "18rem";
  
    card.innerHTML = `
      <img src="${alumno.img}" class="card-img-top" alt="alumno">
      <div class="card-body">
        <input class="form-control mb-1 nombre" value="${alumno.nombre}" disabled>
        <input class="form-control mb-1 apellido" value="${alumno.apellido}" disabled>
        <input class="form-control mb-1 email" value="${alumno.email}" disabled>
        <input class="form-control mb-1 telefono" value="${alumno.telefono}" disabled>
        <input class="form-control mb-1 grupo" value="${alumno.grupo}" disabled>
      </div>
      <div class="card-body">
        <button class="btn btn-dark btn-sm me-2 editar">Editar</button>
        <button class="btn btn-success btn-sm me-2 guardar d-none">Guardar</button>
        <button class="btn btn-danger btn-sm me-2 borrar">Borrar</button>
        <button class="btn btn-info btn-sm asistencia">Asistencia</button>
      </div>
    `;
  
    contenedor.appendChild(card);
  
    const inputNombre = card.querySelector(".nombre");
    const inputApellido = card.querySelector(".apellido");
    const inputEmail = card.querySelector(".email");
    const inputTelefono = card.querySelector(".telefono");
    const inputGrupo = card.querySelector(".grupo");
  
    const btnEditar = card.querySelector(".editar");
    const btnGuardar = card.querySelector(".guardar");
    const btnBorrar = card.querySelector(".borrar");
    const btnAsistencia = card.querySelector(".asistencia");
  
    // Editar
    btnEditar.addEventListener("click", () => {
      inputNombre.disabled = false;
      inputApellido.disabled = false;
      inputEmail.disabled = false;
      inputTelefono.disabled = false;
      inputGrupo.disabled = false;
  
      btnEditar.classList.add("d-none");
      btnGuardar.classList.remove("d-none");
    });
  
    // Guardar
    btnGuardar.addEventListener("click", () => {
      alumno.nombre = inputNombre.value;
      alumno.apellido = inputApellido.value;
      alumno.email = inputEmail.value;
      alumno.telefono = inputTelefono.value;
      alumno.grupo = inputGrupo.value;
  
      inputNombre.disabled = true;
      inputApellido.disabled = true;
      inputEmail.disabled = true;
      inputTelefono.disabled = true;
      inputGrupo.disabled = true;
  
      btnEditar.classList.remove("d-none");
      btnGuardar.classList.add("d-none");
  
      alert("✅ Alumno actualizado");
    });
  
    // Borrar
    btnBorrar.addEventListener("click", () => {
      if (confirm(`¿Seguro que quieres borrar a ${alumno.nombre}?`)) {
        card.remove();
      }
    });
  
    // Asistencia
    btnAsistencia.addEventListener("click", () => {
      alert(`📋 Asistencia de ${alumno.nombre} (aún sin implementar)`);
    });
  });
  