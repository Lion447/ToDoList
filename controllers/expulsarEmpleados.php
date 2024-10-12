<?php
include('../config/config.php');

if(isset($_POST['expulsarEmpleados'])){
    // verificar si hay empleados seleccionados
    if(!empty($_POST['empleados'])){
        
        // obtener lista de empleados elegidos
        $empleados = $_POST['empleados'];
        foreach($empleados as $id_empleado){
            // primero elimina el usuario relacionado
            $eliminarUsuario = "DELETE FROM usuarios WHERE id_usuarios = '$id_empleado'";
            mysqli_query($conexion, $eliminarUsuario);
            // despues elimina al empleado
            $eliminarEmpleado = "DELETE FROM empleados WHERE id_empleado = '$id_empleado'";
            mysqli_query($conexion, $eliminarEmpleado);
        }
        // redirigir con mensaje correcto
        header("Location: ../panel.php?insert_msg=Empleados expulsados correctamente");
        exit();
    } else {
        // redirigir con mensaje de error 
        header("Location: ../panel.php?insert_msg=Error: No se seleccionó ningún empleado");
        exit();
    }
}
?>
