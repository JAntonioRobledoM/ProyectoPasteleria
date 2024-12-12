Estas son unas instrucciones básicas del funcionamiento del proyecto.

El proyecto consiste en una pasteleria realizada en archivos php incluyendo código HTML, CSS, JS y SQL.

En la carpeta db podemos encontrar los archivos de la base de datos, uno el sql y otro la conexión

En la carpeta public encontramos los archivos php de la web y las carpetas de estilos css, imagenes usadas y archivos js.

-contacto.php: Web decorativa de contacto de la web
-index.php: Landing page del proyecto, aqui seria la página de inicio de sesión
-login.php: Sistema de log de los usuarios, en este caso admin y usuario
-logout: Sistema de cierre de sesión del usuario
-main.php: Página principal de la web, con elementos decorativos
-mainAdmin.php: Página de gestión de la web a la que accedemos iniciando sesión como admin, en ella puedes gestionar los dulces y ver los clientes y sus datos
-sobre-nosotros.php: Web decorativa explicando una breve historia de la Pastelería y su personal
-tienda.php: Web donde se realizan las compras de los dulces y se ve la información del usuario y sus compras listadas

El uso de la web sería el siguiente: Entras en index.php y tienes la opción de logearte como usuario (usuario) o admin (admin). Dependiendo del usuario puedes acceder a sus diferentes funciones en los archivos disponibles

En la carpeta src encontramos la creacion de los dulces en backend

Tenemos la clase Dulce.php, de la que heredan los diferentes dulces (Tarta, Bollo y Chocolate)
Cada archivo por separado tiene sus constructores y las funciones CRUD utilizadas en los diferentes archivos del proyecto para el uso enlazado de la base de datos

Tutorial de uso de la web en vídeo: https://youtu.be/Y0_PJa8BBFs
