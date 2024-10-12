<?php
    $host = "localhost";
    $usuario = "root";
    $password = "";
    $baseDeDatos = "asignador_tareas";

    $conexion = new mysqli($host, $usuario, $password, $baseDeDatos);
    $conexion->set_charset("utf8");

    if ($conexion->connect_error) {
        die("Error :" . $conexion->connect_error);
    }
?>
