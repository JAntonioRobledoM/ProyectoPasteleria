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
    <title>Pastelería OC | Contacto</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/styles.css">
</head>

<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">Pastelería OC</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
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

    <!-- Contacto -->
    <div class="container my-5">
        <h2 class="text-center mb-4">Contáctanos</h2>

        <div class="row">
            <!-- Información de Contacto -->
            <div class="col-md-6">
                <h4>Información de la Tienda</h4>
                <p><strong>Dirección:</strong> Calle Real, 28, La Rinconada (Sevilla), España</p>
                <p><strong>Teléfono:</strong> <a href="tel:+1234567890">+123 456 7890</a></p>
                <p><strong>Email:</strong> <a href="mailto:info@pasteleriaoc.com">info@pasteleriaoc.com</a></p>

                <h4 class="mt-4">Redes Sociales</h4>
                <ul class="list-unstyled">
                    <li><a href="https://www.facebook.com" target="_blank">Facebook</a></li>
                    <li><a href="https://www.instagram.com" target="_blank">Instagram</a></li>
                    <li><a href="https://www.twitter.com" target="_blank">Twitter</a></li>
                    <li><a href="https://www.linkedin.com" target="_blank">LinkedIn</a></li>
                </ul>
            </div>

            <!-- Formulario de Contacto -->
            <div class="col-md-6">
                <h4>Envíanos tu mensaje</h4>
                <form action="contacto_procesar.php" method="POST">
                    <div class="mb-3">
                        <label for="nombre" class="form-label">Nombre</label>
                        <input type="text" class="form-control" id="nombre" name="nombre" required>
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Correo Electrónico</label>
                        <input type="email" class="form-control" id="email" name="email" required>
                    </div>
                    <div class="mb-3">
                        <label for="mensaje" class="form-label">Mensaje</label>
                        <textarea class="form-control" id="mensaje" name="mensaje" rows="4" required></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary">Enviar mensaje</button>
                </form>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="embed-responsive embed-responsive-16by9">
                    <iframe class="embed-responsive-item"
                        src="https://www.google.com/maps/embed?pb=...&q=Calle+Ficticia,+123,+Madrid" allowfullscreen=""
                        loading="lazy"></iframe>
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

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>