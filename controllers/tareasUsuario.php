<?php
include('../config/config.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // obtener id_tarea y estado de tarea 
    $id_tarea = $_POST['id_tarea'];
    $nuevo_estado = (int)$_POST['estado'];

    if ($conexion) {
        // preparar consulta para estado de tarea
        $updateQuery = "UPDATE tareas SET estado = $nuevo_estado WHERE id_tarea = $id_tarea";
        
        // ejecutar consulta
        if (mysqli_query($conexion, $updateQuery)) {
            // mostrar estado
            header("Location: ../tareas.php?msg=Estado actualizado");
        } else {
            // mostrar error si funciona mal
            echo "Error al actualizar el estado: " . mysqli_error($conexion);
        }
    } else {
        echo "Error: No se pudo establecer la conexión con la base de datos.";
    }
}
?>
