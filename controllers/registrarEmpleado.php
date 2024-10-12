<?php
include ('../config/config.php');

if (isset($_POST['agregarEmpleado'])) {
    // obtener apellid, nombre, email del formulario
    $apellido = $_POST['apellido'];
    $nombre = $_POST['nombre'];
    $email = $_POST['email'];

    // validar que el apellido no este vacio
    if ($apellido == "" || empty($apellido)) {
        header('location:../panel.php?insert_msg=Error: El apellido no puede estar vacio');
    } else {
        // convertir apellido y nombre a "Apellido Nombre"
        $apellido = ucwords(strtolower($apellido));
        $nombre = ucwords(strtolower($nombre));
        // poner el empleado en la tabla `empleados`
        $query = "INSERT INTO `empleados`(`apellido`, `nombre`, `email`) VALUES ('$apellido', '$nombre', '$email')";
        $result = mysqli_query($conexion, $query);

        if (!$result) {
            die("Error: " . mysqli_error($conexion));
        } else {
            // obtener el ID del empleado
            $id_empleado = mysqli_insert_id($conexion);

            // crear usuario y contraseña
            $usuario = $email; // usar el email como usuario

            // si hay apellido con espacios, sacar los espacios del apellido
            $apellidoSinEspacios = str_replace(' ', '', $apellido);

            // la contraseña es inicial del nombre + apellido sin espacios
            $password = strtolower(substr($nombre, 0, 1)) . strtolower($apellidoSinEspacios);

            // insertar el usuario en la tabla `usuarios`
            $queryUsuario = "INSERT INTO `usuarios`(`usuario`, `password`, `id_usuarios`, `rol`) VALUES ('$usuario', '$password', '$id_empleado', 'usuario')";
            $resultUsuario = mysqli_query($conexion, $queryUsuario);

            // mostrar mensaje de error si no fuciona
            if (!$resultUsuario) {
                die("Error al insertar usuario: " . mysqli_error($conexion));
            } else {
                // mostrar mensaje correcto
                header('location:../panel.php?insert_msg=Los datos se agregaron bien');
            }
        }
    }
}
?>
