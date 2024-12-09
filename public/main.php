<?php
session_start();

// Verificar si el usuario está logueado
if (!isset($_SESSION['usuario'])) {
    header("Location: index.php");
    exit();
}

$usuario = $_SESSION['usuario'];
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bienvenido - Pastelería</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/styles.css">
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">Pastelería OC</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse justify-content-center" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link active" href="main.php">Página Principal</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="tienda.php">Tienda</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="contacto.php">Contacto</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="sobre-nosotros.php">Sobre Nosotros</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <!-- Carrousel -->
    <div id="carouselExample" class="carousel slide" data-bs-ride="carousel">
    <div class="carousel-inner">
        <!-- Primera imagen -->
        <div class="carousel-item active">
            <img src="img/pasteles1.jpg" class="d-block w-100" alt="Tarta deliciosa">
            <div class="carousel-caption d-none d-md-block">
                <h5>Tarta de Chocolate</h5>
                <p>Un placer irresistible para los amantes del chocolate.</p>
            </div>
        </div>
        <!-- Segunda imagen -->
        <div class="carousel-item">
            <img src="img/pasteles2.jpg" class="d-block w-100" alt="Cupcakes variados">
            <div class="carousel-caption d-none d-md-block">
                <h5>Cupcakes Variados</h5>
                <p>Colores y sabores que alegran cualquier día.</p>
            </div>
        </div>
        <!-- Tercera imagen -->
        <div class="carousel-item">
            <img src="img/pasteles3.jpg" class="d-block w-100" alt="Galletas decoradas">
            <div class="carousel-caption d-none d-md-block">
                <h5>Galletas Decoradas</h5>
                <p>Un toque artístico para cada momento especial.</p>
            </div>
        </div>
    </div>
    <!-- Controles del carrusel -->
    <button class="carousel-control-prev" type="button" data-bs-target="#carouselExample" data-bs-slide="prev">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Anterior</span>
    </button>
    <button class="carousel-control-next" type="button" data-bs-target="#carouselExample" data-bs-slide="next">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Siguiente</span>
    </button>
</div>


    <!-- Contenido de Bienvenida -->
<div class="welcome-container">
    <h1 class="display-4">¡Bienvenido, <?php echo htmlspecialchars($usuario); ?>!</h1>
    <p class="lead">Nos alegra tenerte aquí. Disfruta de nuestros deliciosos dulces y tartas.</p>
    <a href="logout.php" class="btn btn-logout btn-lg mt-3">Cerrar sesión</a>
</div>


<div class="section">
    <div class="container">
            
        <div class="row photo-text">
            <div class="col-md-6 order-md-2">
                <img src="img/pastel1.jpg" alt="Imagen 1" class="img-fluid">
            </div>
            <div class="col-md-6 order-md-1">
                <div class="content">
                    <h3>Tarta de Chocolate Intensa</h3>
                    <p>Deléitate con nuestra tarta de chocolate, una experiencia rica y envolvente. Preparada con el mejor cacao, esta tarta ofrece una textura suave y un sabor profundo que encanta a los amantes del chocolate. Perfecta para cualquier ocasión, ¡no podrás resistirte a una segunda porción!</p>
                </div>
            </div>
        </div>
    
            
        <div class="row photo-text">
            <div class="col-md-6 order-md-1">
                <img src="img/pastel2.webp" alt="Imagen 2" class="img-fluid">
            </div>
            <div class="col-md-6 order-md-2">
                <div class="content">
                    <h3>Tarta de Chocolate con Leche Cremosa</h3>
                    <p>Si eres fan de los sabores más suaves, nuestra tarta de chocolate con leche es la elección ideal. Con una base esponjosa y una capa cremosa de chocolate con leche, esta tarta es un verdadero placer para el paladar. Su suavidad y dulzura la convierten en una opción irresistible para todos.</p>
                </div>
            </div>
        </div>
    
          
        <div class="row photo-text">
            <div class="col-md-6 order-md-2">
                <img src="img/pastel3.jpeg" alt="Imagen 3" class="img-fluid">
            </div>
            <div class="col-md-6 order-md-1">
                <div class="content">
                    <h3>Tarta de Lotus Caramelizada</h3>
                    <p>La tarta de Lotus es un homenaje a la deliciosa galleta especiada que todos conocemos. Con un toque sutil de caramelo y un sabor único que combina perfectamente con la crema suave de la tarta, esta creación es perfecta para quienes buscan algo diferente. ¡Un bocado de pura indulgencia!</p>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Footer -->
<footer class="bg-light text-center text-lg-start py-4 mt-5">
    <div class="container">
        <div class="row">
            <!-- Sección 1: Información de la tienda -->
            <div class="col-lg-3 col-md-6 mb-4">
                <h5 class="text-uppercase">Pastelería OC</h5>
                <p>Deliciosas tartas y dulces preparados con amor. ¡Elige tu favorito y disfruta!</p>
            </div>

            <!-- Sección 2: Enlaces rápidos -->
            <div class="col-lg-3 col-md-6 mb-4">
                <h5 class="text-uppercase">Enlaces rápidos</h5>
                <ul class="list-unstyled">
                    <li><a href="index.php" class="text-dark">Página Principal</a></li>
                    <li><a href="tienda.php" class="text-dark">Tienda</a></li>
                    <li><a href="contacto.php" class="text-dark">Contacto</a></li>
                    <li><a href="sobre-nosotros.php" class="text-dark">Sobre Nosotros</a></li>
                </ul>
            </div>

            <!-- Sección 3: Redes sociales -->
            <div class="col-lg-3 col-md-6 mb-4">
                <h5 class="text-uppercase">Síguenos</h5>
                <ul class="list-unstyled">
                    <li><a href="https://www.facebook.com" target="_blank" class="text-dark">Facebook</a></li>
                    <li><a href="https://www.instagram.com" target="_blank" class="text-dark">Instagram</a></li>
                    <li><a href="https://www.twitter.com" target="_blank" class="text-dark">Twitter</a></li>
                    <li><a href="https://www.linkedin.com" target="_blank" class="text-dark">LinkedIn</a></li>
                </ul>
            </div>

            <!-- Sección 4: Contacto -->
            <div class="col-lg-3 col-md-6 mb-4">
                <h5 class="text-uppercase">Contáctanos</h5>
                <ul class="list-unstyled">
                    <li><a href="mailto:info@pasteleriaoc.com" class="text-dark">info@pasteleriaoc.com</a></li>
                    <li><a href="tel:+1234567890" class="text-dark">+123 456 7890</a></li>
                </ul>
            </div>
        </div>

        <!-- Copyright -->
        <div class="text-center pt-4">
            <p class="mb-0">© 2024 Pastelería OC. Todos los derechos reservados.</p>
        </div>
    </div>
</footer>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
