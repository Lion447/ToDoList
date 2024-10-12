// modal dar tarea 
var darTareaModal = document.getElementById('darTareaEmpleado');
// usar listener cuando muestra el modal
darTareaModal.addEventListener('show.bs.modal', function (event) {
  // cual boton activo el modal
  var button = event.relatedTarget;
  
  // obtener información de los atributos data-*
  var idEmpleado = button.getAttribute('data-id');
  var apellido = button.getAttribute('data-apellido');
  var nombre = button.getAttribute('data-nombre');
  
  // obtener campos del formulario dentro del modal
  var inputId = darTareaModal.querySelector('input[name="id_empleado"]');
  var inputApellido = darTareaModal.querySelector('input[name="apellido"]');
  var inputNombre = darTareaModal.querySelector('input[name="nombre"]');
  
  // asignar valores a los inputs
  inputId.value = idEmpleado;
  inputApellido.value = apellido;
  inputNombre.value = nombre;
});

// modal para eliminar tareas
var eliminarTareasModal = document.getElementById('eliminarTareasModal');
// usar listener cuando muestra el modal eliminar tareas
eliminarTareasModal.addEventListener('show.bs.modal', function (event) {
  var button = event.relatedTarget;
  
  // obtener valor de empleado, tareas completadas o pendiente, nombre y apellido
  var idEmpleado = button.getAttribute('data-id');
  var tareasPendientes = button.getAttribute('data-pendientes');
  var tareasCompletadas = button.getAttribute('data-completadas');
  var apellido = button.getAttribute('data-apellido');
  var nombre = button.getAttribute('data-nombre');
  
  // poner valores en campo de texto
  eliminarTareasModal.querySelector('input[name="id_empleado"]').value = idEmpleado;
  eliminarTareasModal.querySelector('#apellido').value = apellido;
  eliminarTareasModal.querySelector('#nombre').value = nombre;

  // contenedor de tareas pendientes
  var tareasPendientesContainer = eliminarTareasModal.querySelector('#tareasPendientesContainer');
  tareasPendientesContainer.innerHTML = ''; // limpiar contenido

  // si hay tareas mostrar lista 
  if (tareasPendientes) {
    var tareasPendientesArray = tareasPendientes.split(' <br> ');
    tareasPendientesArray.forEach(function(tarea) {
      var div = document.createElement('div');
      div.classList.add('form-check');

      var checkbox = document.createElement('input');
      checkbox.type = 'checkbox';
      checkbox.name = 'tareas_pendientes[]';
      checkbox.value = tarea;
      checkbox.classList.add('form-check-input');

      var label = document.createElement('label');
      label.textContent = tarea;
      label.classList.add('form-check-label');

      div.appendChild(checkbox);
      div.appendChild(label);
      tareasPendientesContainer.appendChild(div);
    });
  } else {
    tareasPendientesContainer.innerHTML = '<p>No hay tareas pendientes.</p>';
  }

  // contenedor de tareas completadas
  var tareasCompletadasContainer = eliminarTareasModal.querySelector('#tareasCompletadasContainer');
  tareasCompletadasContainer.innerHTML = ''; // limpiar contenido

  // mostrar lista si hay tareas completadas
  if (tareasCompletadas) {
    var tareasCompletadasArray = tareasCompletadas.split(' <br> ');
    tareasCompletadasArray.forEach(function(tarea) {
      var div = document.createElement('div');
      div.classList.add('form-check');

      var checkbox = document.createElement('input');
      checkbox.type = 'checkbox';
      checkbox.name = 'tareas_completadas[]';
      checkbox.value = tarea;
      checkbox.classList.add('form-check-input');

      var label = document.createElement('label');
      label.textContent = tarea;
      label.classList.add('form-check-label');

      div.appendChild(checkbox);
      div.appendChild(label);
      tareasCompletadasContainer.appendChild(div);
    });
  } else {
    tareasCompletadasContainer.innerHTML = '<p>No hay tareas completadas.</p>';
  }
});


// modal de editar tareas
document.addEventListener('DOMContentLoaded', function () {  // documento cargado
    const editarTareaModal = document.getElementById('editarTareaEmpleado');
    // usar listener cuando muestra el modal editar tarea
    editarTareaModal.addEventListener('show.bs.modal', function (event) {
        const button = event.relatedTarget; 

        // obtener valores de id_empleado, apellido, nombre
        const idEmpleado = button.getAttribute('data-id');
        const apellido = button.getAttribute('data-apellido');
        const nombre = button.getAttribute('data-nombre');

        // poner valores en campos de texto de modal
        document.getElementById('id_empleado').value = idEmpleado;
        document.getElementById('apellido').value = apellido;
        document.getElementById('nombre').value = nombre;

        // obtener las tareas del empleado
        fetch(`./controllers/obtenerTareas.php?id_empleado=${idEmpleado}`)
            .then(response => response.json())
            .then(data => {
                let tareasContainer = document.getElementById('tareasContainer');
                tareasContainer.innerHTML = ''; // limpiar el contenedor

                data.forEach(tarea => {
                    // crear campo de texto para cada tarea
                    const tareaDiv = document.createElement('div');
                    tareaDiv.className = 'form-group mt-2';
                    tareaDiv.innerHTML = `
                        <input type="text" name="tarea[${tarea.id_tarea}]" class="form-control" value="${tarea.tarea}">
                    `;
                    tareasContainer.appendChild(tareaDiv);
                });
            });
    });
});
