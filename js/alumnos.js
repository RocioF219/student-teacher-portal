// Creación del array de objetos con información de los alumnos.
const alumnos=[
    {
        nombre: "Rocio",
        apellido:"Fuentes",
        email:"rocio@gmail.com",
        telefono:"12345678",
        grupo: "Mayores",
        img: "../img/person.svg"
    
    },
    {
        nombre: "Lucia",
        apellido:"Gutierrez Gómez",
        email:"lucia@gmail.com",
        telefono:"12345678",
        grupo: "Mayores",
        img: "../img/person.svg"
    
    },
]
// Contenedor donde se inyectan las tarjetas.
const contenedor = document.getElementById("container-cards");

// Recorremos el array de alumnos.
alumnos.forEach(alumno =>{
  // Creación de un nuevo div para cada tarjeta.
    const card = document.createElement("div");
    card.classList.add("card", "m-3");
    card.style.width = "18rem";
    card.innerHTML=`
    <img src="${alumno.img}" class="card-img-top" alt="alumno">
  <div class="card-body">
  </div>
  <ul class="list-group list-group-flush">
    <li class="list-group-item">${alumno.nombre}</li>
    <li class="list-group-item">${alumno.apellido}</li>
    <li class="list-group-item">${alumno.email}</li>
    <li class="list-group-item">${alumno.telefono}</li>
    <li class="list-group-item">${alumno.grupo}</li>
  </ul>
  <div class="card-body">
    <button class="btn btn-dark btn-sm me-3">Editar</button>
    <button class="btn btn-danger btn-sm me-3">Borrar</button>
    <button class="btn btn-info btn-sm ">Asistencia</button>
  </div>
  `;
  // Añadimos la tarjeta al contenedor principal en el DOM.
  contenedor.appendChild(card);
});
  