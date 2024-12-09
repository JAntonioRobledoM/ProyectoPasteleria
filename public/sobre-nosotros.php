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
    <title>Pastelería OC | Conócenos</title>
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

    <!-- Sección de Introducción -->
    <section class="container my-5">
        <div class="row">
            <div class="col-lg-6">
                <h2 class="display-4">¡Bienvenidos a Pastelería OC!</h2>
                <p class="lead">En Pastelería OC nos dedicamos a ofrecer los mejores dulces y tartas, elaborados con los ingredientes más frescos y de alta calidad. Nuestra pasión por la pastelería se refleja en cada producto que creamos, brindando a nuestros clientes una experiencia única en cada bocado.</p>
            </div>
            <div class="col-lg-6">
                <img src="img/pasteleria.jpg" alt="Pastelería OC" class="img-fluid rounded">
            </div>
        </div>
    </section>

    <!-- Historia de la empresa -->
    <section class="bg-light py-5">
        <div class="container">
            <h3 class="text-center mb-4">Nuestra Historia</h3>
            <div class="row">
                <div class="col-md-6">
                    <p>Pastelería OC fue fundada en 2010 con la misión de crear tartas, bollos y otros dulces que no solo fueran deliciosos, sino que también trajeran sonrisas a todos aquellos que los probaban. Desde nuestros humildes comienzos en un pequeño taller, nos hemos expandido para ofrecer nuestros productos a toda la comunidad, manteniendo siempre el compromiso de calidad y sabor.</p>
                </div>
                <div class="col-md-6">
                    <p>Con una pasión por la repostería artesanal, cada uno de nuestros productos es hecho a mano, utilizando solo los mejores ingredientes. ¡Ven a visitarnos y descubre por qué somos la pastelería favorita de muchos!</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Misión, Visión y Valores -->
    <section class="container my-5">
        <h3 class="text-center mb-4">Misión, Visión y Valores</h3>
        <div class="row">
            <div class="col-md-4">
                <h5>Misión</h5>
                <p>Proporcionar productos de pastelería deliciosos y de alta calidad, elaborados con ingredientes frescos y naturales, para deleitar a nuestros clientes en cada ocasión.</p>
            </div>
            <div class="col-md-4">
                <h5>Visión</h5>
                <p>Ser la pastelería de referencia en el pueblo, reconocida por la calidad de nuestros productos y la satisfacción de nuestros clientes.</p>
            </div>
            <div class="col-md-4">
                <h5>Valores</h5>
                <ul>
                    <li>Compromiso con la calidad</li>
                    <li>Pasión por la tradición</li>
                    <li>Innovación en nuestros productos</li>
                    <li>Atención al cliente excepcional</li>
                </ul>
            </div>
        </div>
    </section>

    <!-- Nuestro equipo -->
    <section class="bg-light py-5">
        <div class="container">
            <h3 class="text-center mb-4">Nuestro Equipo</h3>
            <div class="row">
                <div class="col-md-4 text-center">
                    <img src="img/persona1.jpg" alt="Miembro del equipo" class="rounded-circle mb-3">
                    <h5>Matito</h5>
                    <p>Chef Pastelero</p>
                    <p>Matito es el corazón de nuestra pastelería, con más de 20 años de experiencia en la creación de postres únicos.</p>
                </div>
                <div class="col-md-4 text-center">
                    <img src="img/persona2.jpg" alt="Miembro del equipo" class="rounded-circle mb-3">
                    <h5>OCK</h5>
                    <p>Encargado de la tienda</p>
                    <p>OCK asegura que cada cliente reciba un servicio amable y profesional en nuestra tienda.</p>
                </div>
                <div class="col-md-4 text-center">
                    <img src="img/persona3.jpg" alt="Miembro del equipo" class="rounded-circle mb-3">
                    <h5>Jose</h5>
                    <p>Responsable de ventas</p>
                    <p>Jose es quien te ayudará a elegir los productos perfectos para cualquier ocasión.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-light text-center text-lg-start py-4 mt-5">
        <div class="container">
            <div class="row">
                <div class="col-lg-3 col-md-6 mb-4">
                    <h5 class="text-uppercase">Pastelería OC</h5>
                    <p>Deliciosas tartas y dulces preparados con amor. ¡Elige tu favorito y disfruta!</p>
                </div>

                <div class="col-lg-3 col-md-6 mb-4">
                    <h5 class="text-uppercase">Enlaces rápidos</h5>
                    <ul class="list-unstyled">
                        <li><a href="index.php" class="text-dark">Página Principal</a></li>
                        <li><a href="tienda.php" class="text-dark">Tienda</a></li>
                        <li><a href="contacto.php" class="text-dark">Contacto</a></li>
                        <li><a href="sobre-nosotros.php" class="text-dark">Conócenos</a></li>
                    </ul>
                </div>

                <div class="col-lg-3 col-md-6 mb-4">
                    <h5 class="text-uppercase">Síguenos</h5>
                    <ul class="list-unstyled">
                        <li><a href="https://www.facebook.com" target="_blank" class="text-dark">Facebook</a></li>
                        <li><a href="https://www.instagram.com" target="_blank" class="text-dark">Instagram</a></li>
                        <li><a href="https://www.twitter.com" target="_blank" class="text-dark">Twitter</a></li>
                        <li><a href="https://www.linkedin.com" target="_blank" class="text-dark">LinkedIn</a></li>
                    </ul>
                </div>

                <div class="col-lg-3 col-md-6 mb-4">
                    <h5 class="text-uppercase">Contáctanos</h5>
                    <ul class="list-unstyled">
                        <li><a href="mailto:info@pasteleriaoc.com" class="text-dark">info@pasteleriaoc.com</a></li>
                        <li><a href="tel:+1234567890" class="text-dark">+123 456 7890</a></li>
                    </ul>
                </div>
            </div>
            <div class="text-center pt-4">
                <p class="mb-0">© 2024 Pastelería OC. Todos los derechos reservados.</p>
            </div>
        </div>
    </footer>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
