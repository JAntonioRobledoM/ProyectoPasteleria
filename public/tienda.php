<?php
session_start();

// Verificar si el usuario está logueado
if (!isset($_SESSION['usuario'])) {
    header("Location: index.php");
    exit();
}

$usuario = $_SESSION['usuario'];

require_once '../db/db.php';
require_once '../src/Dulce.php';
require_once '../src/Chocolate.php';
require_once '../src/Bollo.php';
require_once '../src/Tarta.php';

// Conectar a la base de datos
$pdo = DB::getConnection();

// ID del cliente que realiza la compra
$numeroCliente = '12345';

// Procesar la creación de un dulce
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['crear_dulce'])) {
    if (isset($_POST['nombre'], $_POST['precio'], $_POST['categoria'])) {
        $nombre = $_POST['nombre'];
        $precio = $_POST['precio'];
        $categoria = $_POST['categoria'];
        $relleno = isset($_POST['relleno']) ? $_POST['relleno'] : null;
        $porcentaje_cacao = isset($_POST['porcentaje_cacao']) ? $_POST['porcentaje_cacao'] : null;
        $peso = isset($_POST['peso']) ? $_POST['peso'] : null;
        $min_comensales = isset($_POST['min_comensales']) ? $_POST['min_comensales'] : 2;
        $max_comensales = isset($_POST['max_comensales']) ? $_POST['max_comensales'] : 2;

        // Insertar el dulce en la base de datos
        $sql = "INSERT INTO dulces (nombre, precio, categoria, relleno, porcentaje_cacao, peso, min_comensales, max_comensales) 
                VALUES (:nombre, :precio, :categoria, :relleno, :porcentaje_cacao, :peso, :min_comensales, :max_comensales)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            ':nombre' => $nombre,
            ':precio' => $precio,
            ':categoria' => $categoria,
            ':relleno' => $relleno,
            ':porcentaje_cacao' => $porcentaje_cacao,
            ':peso' => $peso,
            ':min_comensales' => $min_comensales,
            ':max_comensales' => $max_comensales,
        ]);

        $_SESSION['mensaje'] = "Dulce '$nombre' creado exitosamente!";
        header('Location: ' . $_SERVER['PHP_SELF']);
        exit();
    } else {
        $_SESSION['mensaje'] = "Por favor, completa todos los campos obligatorios.";
        header('Location: ' . $_SERVER['PHP_SELF']);
        exit();
    }
}

// Procesar la compra de un dulce
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['dulce_id'])) {
    $dulceId = $_POST['dulce_id'];

    // Obtener el ID del cliente desde su número
    $sql = "SELECT id FROM clientes WHERE numero = :numero";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([':numero' => $numeroCliente]);
    $cliente = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($cliente) {
        $clienteId = $cliente['id'];

        // Registrar la compra en la tabla de compras
        $sql = "INSERT INTO compras (cliente_id, dulce_id) VALUES (:cliente_id, :dulce_id)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([':cliente_id' => $clienteId, ':dulce_id' => $dulceId]);

        // Incrementar el contador de pedidos del cliente
        $sql = "UPDATE clientes SET num_pedidos = num_pedidos + 1 WHERE id = :cliente_id";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([':cliente_id' => $clienteId]);

        $_SESSION['mensaje'] = "Compra realizada exitosamente.";
        header('Location: ' . $_SERVER['PHP_SELF']);
        exit();
    } else {
        $_SESSION['mensaje'] = "Cliente no encontrado.";
        header('Location: ' . $_SERVER['PHP_SELF']);
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pastelería OC | TIENDA</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/styles.css">
    <script defer src="js/carrito.js"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
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

    <!-- Listar productos -->
    <div class="container mt-5">
        <!-- Mostrar mensajes de sesión -->
        <?php
        if (isset($_SESSION['mensaje'])) {
            echo "<div class='alert alert-info'>{$_SESSION['mensaje']}</div>";
            unset($_SESSION['mensaje']); // Eliminar mensaje después de mostrarlo
        }
        ?>

        <h3>Lista de dulces:</h3>
        <div class="list-group">
            <?php
            $sql = "SELECT * FROM dulces";
            $stmt = $pdo->prepare($sql);
            $stmt->execute();
            $dulces = $stmt->fetchAll(PDO::FETCH_ASSOC);

            foreach ($dulces as $dulce) {
                echo "<div class='list-group-item list-group-item-action'>";
                echo "<strong>{$dulce['nombre']}</strong><br>";
                echo "Precio: {$dulce['precio']}€, Categoría: {$dulce['categoria']}<br>";

                // Información adicional
                if (!empty($dulce['relleno'])) {
                    echo "Relleno: {$dulce['relleno']}<br>";
                }
                if (isset($dulce['porcentaje_cacao'])) {
                    echo "Porcentaje de cacao: {$dulce['porcentaje_cacao']}%<br>";
                }
                if (isset($dulce['peso'])) {
                    echo "Peso: {$dulce['peso']} g<br>";
                }
                if (isset($dulce['min_comensales'])) {
                    echo "Min. comensales: {$dulce['min_comensales']}<br>";
                }
                if (isset($dulce['max_comensales'])) {
                    echo "Max. comensales: {$dulce['max_comensales']}<br>";
                }

                // Botón para comprar el dulce
                echo "<form method='POST' action='' class='mt-3'>
                        <input type='hidden' name='dulce_id' value='{$dulce['id']}'>
                        <button type='submit' class='btn btn-success'>Comprar</button>
                      </form>";

                // Botón para añadir al carrito
                echo "<button class='btn btn-primary btn-añadir-carrito mt-2' 
                        data-id='{$dulce['id']}' 
                        data-nombre='{$dulce['nombre']}' 
                        data-precio='{$dulce['precio']}'>Añadir al carrito</button>";
                echo "</div><br>";
            }
            ?>

            <div class="container mt-5">
                <h3>Carrito de compras:</h3>
                <ul id="carrito-lista" class="list-group">
                    <li class="list-group-item">El carrito está vacío.</li>
                </ul>

                <!-- Botón para realizar el pedido -->
                <button id="btn-realizar-pedido" class="btn btn-warning mt-3">Realizar Pedido</button>
            </div>
        </div>

        <!-- Mostrar cliente -->
        <h3 class="mt-5">Tu usuario:</h3>
        <div class="list-group">
            <?php
            require_once '../src/Cliente.php';

            // Número del cliente actual (puedes obtenerlo desde $_SESSION si corresponde)
            $numeroCliente = '12345';

            // Obtener el cliente utilizando el método obtenerClientePorNumero
            $cliente = Cliente::obtenerClientePorNumero($pdo, $numeroCliente);

            if ($cliente) {
                echo "<div class='list-group-item'>";
                echo "Nombre: {$cliente->getNombre()}, Número: {$cliente->getNumero()}, Compras realizadas: {$cliente->getNumPedidosEfectuados()}<br>";
                echo "</div>";
            } else {
                echo "<div class='list-group-item'>No se encontró información para este cliente.</div>";
            }
            ?>
        </div>

        <!-- Mostrar la lista de compras del cliente -->
        <h3 class="mt-5">Lista de compras del cliente 'usuario':</h3>
        <div class="list-group">
            <?php
            $sql = "SELECT dulces.nombre AS dulce_nombre, dulces.precio, dulces.categoria, compras.fecha_compra 
                    FROM compras 
                    JOIN dulces ON compras.dulce_id = dulces.id 
                    JOIN clientes ON compras.cliente_id = clientes.id 
                    WHERE clientes.numero = :numero
                    ORDER BY compras.fecha_compra DESC";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([':numero' => $numeroCliente]);
            $compras = $stmt->fetchAll(PDO::FETCH_ASSOC);

            if ($compras) {
                foreach ($compras as $compra) {
                    echo "<div class='list-group-item'>";
                    echo "Dulce: {$compra['dulce_nombre']}, Precio: {$compra['precio']}€, Categoría: {$compra['categoria']}, Fecha de compra: {$compra['fecha_compra']}<br>";
                    echo "</div>";
                }
            } else {
                echo "<div class='list-group-item'>El cliente 'usuario' no ha realizado ninguna compra aún.</div>";
            }
            ?>
        </div>
    </div>

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
                        <li><a href="sobre-nosotros.php" class="text-dark">Sobre Nosotros</a></li>
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

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>