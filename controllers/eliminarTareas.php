<?php
include ('../config/config.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // obtener id de empleado
    $id_empleado = $_POST['id_empleado'];

    // obtener las tareas pendientes y completadas ya elegida
    $tareas_pendientes_a_eliminar = $_POST['tareas_pendientes'] ?? []; // si no hay tarea pendiente, el array esta vacio
    $tareas_completadas_a_eliminar = $_POST['tareas_completadas'] ?? []; // si no hay tareas compeltadas, el array esta vacio

    // juntar las listas de tareas para eliminar
    $tareas_a_eliminar = array_merge($tareas_pendientes_a_eliminar, $tareas_completadas_a_eliminar);

    // verificar si hay tareas para eliminar
    if (!empty($tareas_a_eliminar)) {
        // prepara consulta para eliminar las tareas seleccionadas
        foreach ($tareas_a_eliminar as $tarea) {
            $tarea = mysqli_real_escape_string($conexion, $tarea);
            $query = "DELETE FROM tareas WHERE tarea = '$tarea' AND id_empleadoTarea = '$id_empleado'";
            $resultado = mysqli_query($conexion, $query);
            
            // ver si hay error
            if (!$resultado) {
                die("Error al eliminar la tarea: " . mysqli_error($conexion));
            }
        }

        // redirigir con mensaje correcto
        header("Location: ../panel.php?insert_msg=Tareas eliminadas exitosamente");
        exit();
    } else {
        // redirigir con mensaje de error si no se seleccionaron tareas
        header("Location: ../panel.php?insert_msg=Error: No se seleccionaron tareas");
        exit();
    }
} else {
    //redirigir si no es POST
    header("Location: ../panel.php");
    exit();
}
?>
