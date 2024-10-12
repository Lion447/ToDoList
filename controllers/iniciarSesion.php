<?php
session_start(); // iniciar la sesion

if (isset($_POST['ingresarBtn'])) {
    include_once './config/config.php';

    // obtener usuario y contraseña del formulario
    $usuario = $_POST['usuario'];
    $password = $_POST['password'];

    // preparar consulta SQL para buscar el usuario
    $query = $conexion->prepare("SELECT * FROM usuarios WHERE usuario = ?");
    $query->bind_param("s", $usuario); // s = String 
    $query->execute();
    $result = $query->get_result();
    $user = $result->fetch_assoc();

    // si el usuario existe
    if ($user) {
        // verificar la contraseña
        if ($password == $user['password']) {
            // guardar la informacion de sesion
            $_SESSION['usuario'] = $user['usuario'];  // guardar usuario
            $_SESSION['rol'] = $user['rol']; // guardar el rol
            
            // redirigir por rol
            if ($user['rol'] == 'admin') {
                header("Location: panel.php"); // pagina de admin para dar tareas
                exit();
            } else {
                header("Location: tareas.php"); // pagina de usuario para ver sus tareas
                exit();
            }
        } else {
            echo "Contraseña incorrecta";
        }
    } else {
        echo "El usuario no existe";
    }
}
?>
