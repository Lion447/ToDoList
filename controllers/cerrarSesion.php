<?php
session_start();

// destruir todas las variables de sesion
session_unset();

// destruir la sesion
session_destroy();

// redirigir a la pagina de inicio de sesion
header("Location: ../index.php");
exit();
?>