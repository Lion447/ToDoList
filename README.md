# Proyecto To Do List: AppTareas


https://github.com/user-attachments/assets/30aaaae9-1f98-4873-962c-5852018d5787



## Descripción
Desarrollo de una aplicación web llamada AppTareas para usar en empresas o emprendimientos, permite a los empleados gestionar sus tareas. Los empleados pueden ver sus tareas asignadas y cambiar su estado entre "Pendiente" y "Completado". El administrador tiene acceso a un panel para gestionar empleados y asignar tareas, así como para editar y eliminar tareas existentes.

## Tecnologías
- **Frontend**: HTML, Bootstrap, y JavaScript
- **Backend**: PHP
- **Base de Datos**: MySQL

## Instalación
### Requisitos
- Tener instalado [XAMPP](https://www.apachefriends.org/es/index.html) o cualquier otro servidor que incluya MySQL.
- Tener MySQL configurado y funcionando.

### Pasos para ejecutar la aplicación
1. Clonar el repositorio
```git clone https://github.com/Lion447/ToDoList.git```

2. Configuración de la base de datos:

    Configurar el archivo config.php dentro de la carpeta config para establecer la conexión a la base de datos.
    En la carpeta **sql** se provee el script .sql para generar la base de datos y sus tablas.

3. Configuración del entorno usando XAMPP:

    Copia el contenido del repositorio clonado a la carpeta htdocs de la instalación de XAMPP.
    Asegurarse de que el servidor Apache y MySQL estén corriendo en el panel de control de XAMPP.

4. Acceso a la aplicación:

    En el navegador accede a http://localhost/todolist para iniciar sesión.
    El administrador accede con el usuario admin y contraseña admin.
    Los empleados acceden con el mail y contraseña, **la contraseña es la primer letra de su nombre seguido del apellido** (por ejemplo si tu nombre es Juan Perez, la contraseña seria jperez).

   
### Estructura del proyecto
```
/ToDoList/
│
├── config/
│   └── config.php                # Archivo de configuración para la conexión a la base de datos.
│
├── controllers/                   # Controladores para gestionar las operaciones del sistema.
│   ├── cerrarSesion.php           # Controlador para cerrar sesión de los usuarios.
│   ├── darTareasEmpleado.php      # Controlador para asignar tareas a los empleados.
│   ├── editarTareas.php           # Controlador para editar las tareas asignadas.
│   ├── eliminarTareas.php         # Controlador para eliminar tareas.
│   ├── expulsarEmpleados.php      # Controlador para eliminar empleados.
│   ├── iniciarSesion.php          # Controlador para manejar el inicio de sesión de los usuarios.
│   ├── obtenerTareas.php          # Controlador para obtener las tareas asignadas a los empleados.
│   ├── registrarEmpleado.php      # Controlador para registrar nuevos empleados.
│   └── tareasUsuario.php          # Controlador para gestionar las tareas específicas de cada usuario.
│
├── images/                        # Carpeta que contiene los iconos en formato SVG.
│   └── (iconos SVG)
│
├── js/                            # Carpeta que contiene los archivos JavaScript.
│   ├── script.js                  # Script para las funciones generales del panel.
│   └── scriptLogin.js             # Script para ver y ocultar la contraseña del inicio de sesion.
│
├── sql/                           # Carpeta que contiene el archivo para generar la base de datos.
│   └── asignador_tareas.sql       # Archivo SQL para generar la base de datos con las tablas.
│
├── index.php                      # Página principal de inicio de sesión.
├── panel.php                      # Panel de administración donde el administrador puede gestionar empleados y tareas.
└── tareas.php                     # Panel del empleado donde puede ver y actualizar sus tareas.

```


### Funcionalidades

- Para empleados:
    Ver sus tareas asignadas.
    Cambiar el estado de las tareas (Pendiente o Completado).

 - Para administradores:
    Agregar y eliminar empleados.
    Asignar tareas a empleados.
    Editar y eliminar tareas existentes.
