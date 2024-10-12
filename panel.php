<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Asignar Tareas</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>
    
<body>
  <!-- cargar archivo php para conectar a base de datos -->
  <?php include ('./config/config.php'); ?>

  <!-- barra de navegacion -->
    <nav class="navbar navbar-expand-sm navbar-dark bg-dark">
      <div class="container">
        <a class="navbar-brand text-uppercase" href="#"><i class="bi bi-clipboard-check m-2"></i>AppTareas</a>
          <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
            <li class="nav-item">
              <!-- boton de cerrar sesion -->
              <a class="nav-link" href="./controllers/cerrarSesion.php">Salir</a>
            </li>
          </ul>
      </div>
    </nav>

  <!-- parte para mostrar mensajes (alertas) -->
    <section class="col-12 p-5">
      <?php
        if(isset($_GET['insert_msg'])){
          $mensaje = $_GET['insert_msg'];

          // elegir tipo de alerta de mensaje
          if (strpos($mensaje, 'error') !== false || strpos($mensaje, 'Error') !== false) {
            $alertType = 'alert-danger'; // alerta roja para errores
          } else if (strpos($mensaje, 'Tareas eliminadas exitosamente') !== false) {
            $alertType = 'alert-warning'; // alerta amarilla para tareas borradas
          } else if (strpos($mensaje, 'Empleados expulsados correctamente') !== false) {
            $alertType = 'alert-danger'; // alerta roja para expulsar empleado
          } else {
            $alertType = 'alert-success'; // alerta verde para mensaje correcto
          }
          
          // mostrar alerta
          echo "<div class='alert $alertType alert-dismissible fade show' role='alert'>";
          echo $mensaje;
          echo "<button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>";
          echo "</div>";
        }
      ?>
      
      <!-- mostrar tabla para empleados y tareas -->
      <table class="table table-striped table-bordered">
        <thead class="table-dark">
          <tr>
            <th scope="col">ID</th>
            <th scope="col">Apellido</th>
            <th scope="col">Nombre</th>
            <th scope="col">Correo Electronico</th>
            
            <th scope="col">Tarea a hacer</th>
            <th scope="col">Tareas completadas</th>
            <!-- botones para agregar y expulsar empleado -->
            <th scope="col">
              <a href="" class="btn btn-small btn-info" data-bs-toggle="modal" data-bs-target="#agregarEmpleado"><img height="25" src="./images/person-plus.svg" alt="Agregar Empleado"></a>
              <a href="" class="btn btn-small btn-danger" data-bs-toggle="modal" data-bs-target="#expulsarEmpleado"><img height="25" src="./images/person-x-fill.svg" alt="Expulsar Empleado"></a>
            </th>  
          </tr>
        </thead>

            <tbody class="table-group-divider">
              <!-- consulta de empleados y tareas -->
              <?php 
                $consultar = "
                SELECT empleados.id_empleado, empleados.apellido, empleados.nombre, empleados.email, 
                GROUP_CONCAT(CASE WHEN tareas.estado = 0 THEN tareas.tarea END SEPARATOR ' <br> ') AS tareas_pendientes,
                GROUP_CONCAT(CASE WHEN tareas.estado = 1 THEN tareas.tarea END SEPARATOR ' <br> ') AS tareas_completadas
                FROM empleados
                LEFT JOIN tareas ON empleados.id_empleado = tareas.id_empleadoTarea
                GROUP BY empleados.id_empleado";

                // consulta si la tarea esta completa o no
                $sql_pendientes = "SELECT * FROM tareas WHERE tareas.estado = 0";
                $resultado_pendientes = $conexion->query($sql_pendientes);
                
                $sql_completadas = "SELECT * FROM tareas WHERE tareas.estado = 1";
                $resultado_completadas = $conexion->query($sql_completadas);

                // ejecutar consulta de empleados
                $resultado = mysqli_query($conexion, $consultar);

                if(!$resultado){
                  die("Error: ".mysqli_error($conexion));
                }
                else{
                  while($row = mysqli_fetch_assoc($resultado)){
                    if ($row['id_empleado'] == 1) {
                      continue; // Saltamos esta iteración y no mostramos esta fila
                    }
              ?>
                      <!-- mostrar empleados en tabla -->
                      <tr>
                        <td><?php echo $row['id_empleado']; ?></td>
                        <td><?php echo $row['apellido']; ?></td>
                        <td><?php echo $row['nombre']; ?></td>
                        <td><?php echo $row['email']; ?></td>
                        <td><?php echo $row['tareas_pendientes'] ? $row['tareas_pendientes'] : 'No asignada'; ?></td>
                        <td><?php echo $row['tareas_completadas'] ? $row['tareas_completadas'] : ' '; ?></td>

                        <!-- botones para agregar, editar, o borrar tareas -->
                        <td>
                          <a href="#" class="btn btn-small btn-success" 
                            data-bs-toggle="modal" 
                            data-bs-target="#darTareaEmpleado"
                            data-id="<?php echo $row['id_empleado']; ?>"
                            data-apellido="<?php echo $row['apellido']; ?>"
                            data-nombre="<?php echo $row['nombre']; ?>">
                            <img src="./images/pencil-square.svg" alt="Agregar tareas">
                          </a>

                          <a href="#" class="btn btn-small btn-warning" 
                            data-bs-toggle="modal" 
                            data-bs-target="#editarTareaEmpleado"
                            data-id="<?php echo $row['id_empleado']; ?>"
                            data-apellido="<?php echo $row['apellido']; ?>"
                            data-nombre="<?php echo $row['nombre']; ?>">
                            <img src="./images/pencil.svg" alt="editar tareas">
                          </a>

                          <a href="#" class="btn btn-small btn-danger" 
                            data-bs-toggle="modal" 
                            data-bs-target="#eliminarTareasModal"
                            data-id="<?php echo $row['id_empleado']; ?>"
                            data-pendientes="<?php echo $row['tareas_pendientes']; ?>"
                            data-completadas="<?php echo $row['tareas_completadas']; ?>"
                            data-apellido="<?php echo $row['apellido']; ?>"
                            data-nombre="<?php echo $row['nombre']; ?>">
                            <img src="./images/trash3.svg" alt="eliminar tareas">
                          </a>

                        </td>
                      </tr>

                    <?php
                  }
                }
              ?>
            </tbody>
        </table>
    </section>

    
  <!-- modal para agregar empleado -->
  <form method="POST" action="./controllers/registrarEmpleado.php">
    <div class="modal fade" id="agregarEmpleado" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
          <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Agregar Empleado</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="apellido">Apellido</label>
                        <input type="text" name="apellido" class="form-control" required>
                    </div>
                    <div class="form-group mt-3">
                        <label for="nombre">Nombre</label>
                        <input type="text" name="nombre" class="form-control" required>
                    </div>
                    <div class="form-group mt-3">
                        <label for="email">Email</label>
                        <input type="email" name="email" class="form-control" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                    <input name="agregarEmpleado" type="submit" class="btn btn-success" value="Agregar">
                </div>
            </div>
          </div>
    </div>
  </form>


  <!-- modal para dar tareas a empleado -->
    <form method="POST" action="./controllers/darTareasEmpleado.php">

      <div class="modal fade" id="darTareaEmpleado" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">

          <div class="modal-content">

            <div class="modal-header">
              <h1 class="modal-title fs-5" id="exampleModalLabel">Asignar tarea a Empleado</h1>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body">
                <!-- ocultar id del empleado -->
              <input type="hidden" name="id_empleado" value="<?php echo $row['id_empleado']; ?>">

              <div class="form-group">
                <label for="apellido">Apellido</label>
                <input type="text" name="apellido" class="form-control" readonly>
              </div>

              <div class="form-group mt-3">
                <label for="nombre">Nombre</label>
                <input type="text" name="nombre" class="form-control" readonly>
              </div>

              <div class="form-group mt-3">
                <label for="tarea">Tarea a asignar</label>
                <input type="text" name="tarea" class="form-control" >
              </div>
            </div>

            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
              <input name="darTarea" type="submit" class="btn btn-success" value="Agregar">
            </div>
          </div>
        </div>
      </div>
    </form> 

  <!-- modal para editar tareas de empleado -->
  <form method="POST" action="./controllers/editarTareas.php">
    <div class="modal fade" id="editarTareaEmpleado" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
      <div class="modal-dialog modal-lg">
        <div class="modal-content">
          <div class="modal-header">
            <h1 class="modal-title fs-5" id="exampleModalLabel">Editar Tareas de Empleado</h1>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <!-- ocultar id empleado -->
            <input type="hidden" name="id_empleado" id="id_empleado" value="<?php echo $row['id_empleado']; ?>">

            <div class="form-group">
              <label for="apellido">Apellido</label>
              <input type="text" name="apellido" class="form-control" id="apellido" readonly>
            </div>

            <div class="form-group mt-3">
              <label for="nombre">Nombre</label>
              <input type="text" name="nombre" class="form-control" id="nombre" readonly>
            </div>

            <h5 class="mt-4">Tareas a modificar</h5>
            <div id="tareasContainer">
              <!-- cargar tareas por javascript -->
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
            <input name="guardarCambios" type="submit" class="btn btn-success" value="Guardar Cambios">
          </div>
        </div>
      </div>
    </div>
  </form>


  <!-- modal para eliminar tareas -->
  <form method="POST" action="./controllers/eliminarTareas.php">
    <div class="modal fade" id="eliminarTareasModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h1 class="modal-title fs-5" id="exampleModalLabel">Eliminar Tareas</h1>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <!-- ocultar id empleado -->
            <input type="hidden" name="id_empleado" id="id_empleado" value="<?php echo $row['id_empleado']; ?>">

            <div class="form-group">
              <label for="apellido">Apellido</label>
              <input type="text" name="apellido" class="form-control" id="apellido" readonly>
            </div>

            <div class="form-group mt-3">
              <label for="nombre">Nombre</label>
              <input type="text" name="nombre" class="form-control" id="nombre" readonly>
            </div>

          <!-- contenedor tareas pendientes -->
            <h5 class="mt-4">Tareas Pendientes</h5>
            <div id="tareasPendientesContainer">
              <!-- cargar las tareas pendientes -->
            </div>

            <!-- contenedor de tareas completadas -->
            <h5 class="mt-4">Tareas Completadas</h5>
            <div id="tareasCompletadasContainer">
              <!-- cargar las tareas completadas -->
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
            <input name="eliminarTareas" type="submit" class="btn btn-danger" value="Eliminar">
          </div>
        </div>
      </div>
    </div>
  </form>


  <!-- modal para expulsar empleados -->
  <form method="POST" action="./controllers/expulsarEmpleados.php">
    <div class="modal fade" id="expulsarEmpleado" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
      <div class="modal-dialog modal-lg">
        <div class="modal-content">
          <div class="modal-header">
            <h1 class="modal-title fs-5" id="exampleModalLabel">Expulsar Empleados</h1>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <div id="empleadosContainer">
              <!-- cargar los empleados -->
              <?php
                // consulta para obtener todos los empleados
                $consultarEmpleados = "SELECT id_empleado, apellido, nombre FROM empleados";
                $resultadoEmpleados = mysqli_query($conexion, $consultarEmpleados);

                if(!$resultadoEmpleados){
                  die("Error: ".mysqli_error($conexion));
                } else {
                  while($empleado = mysqli_fetch_assoc($resultadoEmpleados)){
                    if ($empleado['id_empleado'] == 1) {
                      continue; // saltear el id 1 (administrador)
                    }
                    // mostrar empleados con checkbox
                    echo '<div class="form-check">';
                    echo '<input type="checkbox" class="form-check-input" name="empleados[]" value="'.$empleado['id_empleado'].'">';
                    echo '<label class="form-check-label">'.$empleado['apellido'].' '.$empleado['nombre'].'</label>';
                    echo '</div>';
                  }
                }
              ?>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
            <input name="expulsarEmpleados" type="submit" class="btn btn-danger" value="Expulsar">
          </div>
        </div>
      </div>
    </div>
  </form>
  <!-- cargar scripts -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
  <script src="./js/script.js"></script>

</body>
</html>