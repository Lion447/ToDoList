<?php
include('../config/config.php');

// verificar el formulario para guardar cambios
if (isset($_POST['guardarCambios'])) {
    $id_empleado = $_POST['id_empleado'];
    $tareas = $_POST['tarea'];

    // actualizar las tareas en la base de datos
    foreach ($tareas as $tarea_id => $tarea) {
        // actualizar la tarea
        $sql_update = "UPDATE tareas SET tarea = '$tarea' WHERE id_tarea = $tarea_id AND id_empleadoTarea = $id_empleado";
        mysqli_query($conexion, $sql_update);
    }
    // mostrar mensaje si se actualiza correcto
    header("Location: ../panel.php?insert_msg=Tareas actualizadas exitosamente");
    exit();
}
