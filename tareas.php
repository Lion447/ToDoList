<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Tareas</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>
<body>
  <?php
  // crear sesion
      session_start();
      include ('./config/config.php');

      // verificar usuario logueado
      if (!isset($_SESSION['usuario'])) {
          header("Location: index.php");
          exit();
      }

      $usuario = $_SESSION['usuario'];

      // obtener el id del usuario logueado
      $queryUser = "SELECT id_usuarios FROM usuarios WHERE usuario = '$usuario'";
      $resultUser = mysqli_query($conexion, $queryUser);
      $user = mysqli_fetch_assoc($resultUser);
      $id_usuarios = $user['id_usuarios'];

      // obtener el nombre y apellido del empleado relacion al usuario
      $queryEmpleado = "SELECT nombre, apellido FROM empleados WHERE id_empleado = $id_usuarios";
      $resultEmpleado = mysqli_query($conexion, $queryEmpleado);
      $empleado = mysqli_fetch_assoc($resultEmpleado);
      $nombreCompleto = $empleado['apellido'] . ' ' . $empleado['nombre'];
  ?>
  <!-- barra de navegacion -->
  <nav class="navbar navbar-expand-sm navbar-dark bg-dark">
    <div class="container">
      <a class="navbar-brand text-uppercase" href="#"><i class="bi bi-person-circle m-2"></i>AppTareas</a>

      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent">
        <span class="navbar-toggler-icon"></span>
      </button>

      <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
          <!-- mostrar nombre y apellido de usuario -->
          <li class="nav-item">
            <a class="nav-link active text-uppercase" href="#"><?php echo $nombreCompleto; ?></a>
          </li>
          <!-- boton para cerrrar sesion -->
          <li class="nav-item">
            <a class="nav-link" href="./controllers/cerrarSesion.php">Salir</a>
          </li>
        </ul>
      </div>
    </div>
  </nav>

  <!-- tabla para mostrar tareas -->
  <section id="contacto" class="col-12 p-5">
      <h2 class="mb-4">Tareas Asignadas a <?php echo $nombreCompleto; ?></h2>
      <table class="table table-striped table-bordered">
        <thead class="table-dark">
          <tr>
            <th scope="col">Tarea</th>
            <th scope="col">Estado</th>
          </tr>
        </thead>
        <tbody class="table-group-divider">

          <?php 
            // consulta para obtener tareas de usuario
            $consultar = "
              SELECT id_tarea, tarea, estado 
              FROM tareas 
              WHERE id_empleadoTarea = $id_usuarios";
            // ejecutar consulta de tareas
            $resultado = mysqli_query($conexion, $consultar);

            if(!$resultado){
              die("Error: ".mysqli_error($conexion));
            }
            else{
              while($row = mysqli_fetch_assoc($resultado)){
                ?>
                  <tr>
                    <!-- mostrar tarea -->
                    <td><?php echo $row['tarea']; ?></td>
                    <td>
                      <form action="./controllers/tareasUsuario.php" method="POST">
                        <input type="hidden" name="id_tarea" value="<?php echo $row['id_tarea']; ?>">
                        <!-- elegir estado tarea -->
                        <select name="estado" class="form-select" onchange="this.form.submit()">
                            <option value="0" <?php echo $row['estado'] == 0 ? 'selected' : ''; ?>>Pendiente</option>
                            <option value="1" <?php echo $row['estado'] == 1 ? 'selected' : ''; ?>>Completado</option>
                        </select>
                    </form>
                    </td>
                  </tr>
                <?php
              }
            }
          ?>
        </tbody>
      </table>
  </section>
  <!-- cargar script js -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>