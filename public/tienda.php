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
    <title>Pastelería OC | TIENDA</title>
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

    <!-- Sección de productos -->
    <div class="container my-5">
        <h2 class="text-center mb-4">Nuestras Tartas</h2>
        <div class="row">
            <div class="col-md-4 mb-4">
                <div class="card">
                    <img src="img/pastel1.jpg" class="card-img-top" alt="Tarta de Chocolate">
                    <div class="card-body">
                        <h5 class="card-title">Tarta de Chocolate</h5>
                        <p class="card-text">Una deliciosa tarta de chocolate con un toque suave de crema.</p>
                        <p class="card-text"><strong>Precio: €15</strong></p>
                        <button class="btn btn-primary" onclick="agregarAlCarrito('Tarta de Chocolate', 15)">Agregar al carrito</button>
                        <button class="btn btn-danger" onclick="quitarDelCarrito('Tarta de Chocolate')">Quitar del carrito</button>
                    </div>
                </div>
            </div>
            
            <div class="col-md-4 mb-4">
                <div class="card">
                    <img src="img/pastel2.webp" class="card-img-top" alt="Tarta de Chocolate con Leche">
                    <div class="card-body">
                        <h5 class="card-title">Tarta de Chocolate con Leche</h5>
                        <p class="card-text">Tarta suave y cremoso con chocolate con leche.</p>
                        <p class="card-text"><strong>Precio: €18</strong></p>
                        <button class="btn btn-primary" onclick="agregarAlCarrito('Tarta de Chocolate con Leche', 18)">Agregar al carrito</button>
                        <button class="btn btn-danger" onclick="quitarDelCarrito('Tarta de Chocolate con Leche')">Quitar del carrito</button>
                    </div>
                </div>
            </div>

            <div class="col-md-4 mb-4">
                <div class="card">
                    <img src="img/pastel3.jpeg" class="card-img-top" alt="Tarta Lotus">
                    <div class="card-body">
                        <h5 class="card-title">Tarta Lotus</h5>
                        <p class="card-text">Tarta especiada con un toque de galleta Lotus crujiente.</p>
                        <p class="card-text"><strong>Precio: €20</strong></p>
                        <button class="btn btn-primary" onclick="agregarAlCarrito('Tarta Lotus', 20)">Agregar al carrito</button>
                        <button class="btn btn-danger" onclick="quitarDelCarrito('Tarta Lotus')">Quitar del carrito</button>
                    </div>
                </div>
            </div>
        </div>
        
        <hr>
        
        <h3 class="text-center">Carrito de Compras</h3>
        <ul id="carrito" class="list-group">
        </ul>
        <p class="text-center mt-3">Total: €<span id="total">0</span></p>
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
<script src="js/carrito.js"></script>
</body>
</html>
