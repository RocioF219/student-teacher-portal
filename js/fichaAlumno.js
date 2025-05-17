document.addEventListener('DOMContentLoaded', function () {
    const calendarEl = document.getElementById('calendar');
  
    const clases = window.clasesAlumno || [];
  
    const eventos = clases.map(clase => {
        return {
            title: clase.nombre_clase,
            start: clase.fecha + 'T' + clase.hora,
            allDay: false
        };
    });
  
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
  
    calendar.render();
  });
  