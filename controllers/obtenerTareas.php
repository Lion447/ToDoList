<?php
include('../config/config.php');

if (isset($_GET['id_empleado'])) {
    // obtener id del empleado
    $id_empleado = $_GET['id_empleado'];

    // consulta sql de las tareas del empleado
    $sql = "SELECT id_tarea, tarea FROM tareas WHERE id_empleadoTarea = $id_empleado";
    $result = mysqli_query($conexion, $sql);

    // array para guardar las tareas
    $tareas = [];
    // agregar tareas en array
    while ($row = mysqli_fetch_assoc($result)) {
        $tareas[] = $row;
    }

    // mostrar tareas en formato json
    echo json_encode($tareas);
}
