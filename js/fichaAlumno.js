
// Evento de escucha que espera que el DOM esté cargado antes de ejecutar el script.
document.addEventListener('DOMContentLoaded', function () {
    //Obtiene el elemento HTML donde se mostrará el calendario.
    const calendarEl = document.getElementById('calendar');
  
    //Obtiene el array de clases del alumno, si no hay, usa un array vacío.
    const clases = window.clasesAlumno || [];

  // Mapeo de cada clase a un objeto, que sea compatible con el calendario.
    const eventos = clases.map(clase => {
        return {
            title: clase.nombre_clase,
            start: clase.fecha + 'T' + clase.hora,
            allDay: false
        };
    });
  
    // Crea una nueva instancia del calendario usando FullCalendar.
    const calendar = new FullCalendar.Calendar(calendarEl, {
        initialView: 'dayGridMonth',
        locale: 'es',
        headerToolbar: {
            left: 'prev,next today',
            center: 'title',
            right: 'dayGridMonth,timeGridWeek,timeGridDay'
        },
        events: eventos
    });
  // Crea el calendario en la página.
    calendar.render();
  });
  