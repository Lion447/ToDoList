<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar Sesión</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>
<body class="bg-body-secondary">

<!-- cargar archivos php para conectar a la base de datos y control de inicio de sesion -->
    <?php
        include("./config/config.php");
        include("./controllers/iniciarSesion.php");
    ?>
<!-- seccion para el formulario de iniciar sesion -->
    <section class="modal modal-sheet position-static d-block bg-body-secondary p-4 py-md-5">
        <form method="POST" class="container d-grid gap-2 justify-content-sm-center p-4 py-md-5 row-cols-sm-auto bg-body-tertiary modal-dialog modal-content rounded-4 shadow">
            <h3 class="text-center mb-4 mt-3">Iniciar Sesión</h3>
            <!-- campo para usuario -->
            <div class="mb-2">
                <label for="usuario" class="form-label">Usuario</label>
                <div class="input-group">
                  <span class="input-group-text"><img src="./images/person-fill.svg" alt="usuario"></span>
                  <input type="text" class="form-control" id="usuario" name="usuario" placeholder="Ingresa tu usuario" required="">
                </div>
            </div>

            <!-- campo para contraseña -->
            <div class="mb-2">
              <label for="password" class="form-label">Contraseña</label>
                <div class="input-group">
                    <span class="input-group-text"><img src="./images/lock-fill.svg" alt="password"></span>
                    <input type="password" class="form-control" id="password" name="password" placeholder="Ingresa la contraseña" required="">
                    <!-- boton para mostrar/ocultar contraseña -->
                    <button class="btn btn-outline-secondary" type="button" id="toggle-password" data-visible="false" onclick="togglePasswordVisibility()">
                        <img src="./images/eye-slash.svg" alt="Cambiar visibilidad de contraseña">
                    </button>

                </div>
            </div>

            <!-- boton para enviar formulario y iniciar sesion -->
            <button type="submit" class="btn btn-primary" name="ingresarBtn">Login</button>
        </form>
    </section>
    <script src="./js/scriptLogin.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>
