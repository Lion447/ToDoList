<?php
include ('../config/config.php');

// verificar si se recibio el id del empleado y la tarea
if (isset($_POST['id_empleado']) && isset($_POST['tarea'])) {
    $id_empleado = $_POST['id_empleado'];
    $tarea = trim($_POST['tarea']);

    // validar que no esta vacio
    if (!empty($tarea)) {
        // poner la tarea para el empleado en la tabla tareas
        $insertarTarea = "INSERT INTO tareas (id_empleadoTarea, tarea) VALUES ('$id_empleado', '$tarea')";
        $resultado = mysqli_query($conexion, $insertarTarea);

        if ($resultado) {
            // redireccionar con mensaje correcto
            header("location:../panel.php?insert_msg=Tarea agregada exitosamente");
            exit();
        } else {
            // redireccionar con mensaje de error
            header("location:../panel.php?insert_msg=Error al agregar la tarea");
            exit();
        }
    } else {
        // redireccionar si la tarea esta vacia
        header("location:../panel.php?insert_msg=Error la tarea no puede estar vacia");
        exit();
    }
} else {
    // redireccionar si no se envio los datos
    header("location:../panel.php?insert_msg=Datos no validos");
    exit();
}
?>