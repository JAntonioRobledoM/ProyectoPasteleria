<?php
require_once '../src/Tarta.php';
require_once '../src/Bollo.php';
require_once '../src/Chocolate.php';
require_once '../src/Cliente.php';
require_once '../src/Pasteleria.php';
require_once '../db/db.php';
session_start();

// Verificar si el usuario está logueado y es admin
if (!isset($_SESSION['usuario']) || !isset($_SESSION['admin'])) {
    header("Location: index.php");
    exit();
}

$usuario = htmlspecialchars($_SESSION['usuario']);

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

        // Convertir el campo relleno en un array
        $relleno = isset($_POST['relleno']) ? explode(',', $_POST['relleno']) : [];
        
        $porcentaje_cacao = $_POST['porcentaje_cacao'] ?? null;
        $peso = $_POST['peso'] ?? null;
        $min_comensales = $_POST['min_comensales'] ?? 2;
        $max_comensales = $_POST['max_comensales'] ?? 2;

        // Crear instancia de la subclase según la categoría
        $dulce = match ($categoria) {
            'Bollería' => new Bollo($nombre, $precio, $categoria, $relleno),
            'Chocolates' => new Chocolate($nombre, $precio, $categoria, $porcentaje_cacao, $peso),
            'Tartas' => new Tarta($nombre, $precio, $categoria, $relleno, $min_comensales, $max_comensales),
            default => null,
        };

        // Intentar guardar el dulce en la base de datos
        if ($dulce && $dulce->crearDulce($pdo)) {
            $_SESSION['mensaje'] = "Dulce '$nombre' creado exitosamente!";
        } else {
            $_SESSION['mensaje'] = "Error al crear el dulce. Por favor, verifica los datos.";
        }

        header('Location: ' . $_SERVER['PHP_SELF']);
        exit();
    } else {
        $_SESSION['mensaje'] = "Por favor, completa todos los campos obligatorios.";
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
    <title>Bienvenido Admin - Pastelería</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">Pastelería</a>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <span class="nav-link active">Bienvenido, <?php echo $usuario; ?> (Admin)</span>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link btn btn-danger text-white ms-3" href="logout.php">Cerrar sesión</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <div class="container mt-5">
        <!-- Mostrar mensajes de sesión -->
        <?php
        if (isset($_SESSION['mensaje'])) {
            echo "<div class='alert alert-info'>{$_SESSION['mensaje']}</div>";
            unset($_SESSION['mensaje']); // Eliminar mensaje después de mostrarlo
        }
        ?>

        <!-- Formulario para agregar un dulce -->
        <h3>Crear un dulce:</h3>
        <form method="POST" action="" class="needs-validation" novalidate>
            <input type="hidden" name="crear_dulce" value="1">

            <div class="mb-3">
                <label for="nombre" class="form-label">Nombre del dulce:</label>
                <input type="text" name="nombre" id="nombre" class="form-control" required>
            </div>

            <div class="mb-3">
                <label for="precio" class="form-label">Precio (€):</label>
                <input type="number" step="0.01" name="precio" id="precio" class="form-control" required>
            </div>

            <div class="mb-3">
                <label for="categoria" class="form-label">Categoría:</label>
                <select name="categoria" id="categoria" class="form-select" required>
                    <option value="Bollería">Bollería</option>
                    <option value="Chocolates">Chocolates</option>
                    <option value="Tartas">Tartas</option>
                </select>
            </div>

            <div class="mb-3">
            <label for="relleno" class="form-label">Relleno (opcional):</label>
            <input type="text" name="relleno" id="relleno" class="form-control" placeholder="Separar por coma si hay varios rellenos">
            </div>

            <div class="mb-3">
            <label for="porcentaje_cacao" class="form-label">Porcentaje de cacao (solo para chocolates):</label>
            <input type="number" name="porcentaje_cacao" id="porcentaje_cacao" class="form-control" min="0" max="100">
            </div>

            <div class="mb-3">
            <label for="peso" class="form-label">Peso (solo para chocolates y tartas):</label>
            <input type="number" name="peso" id="peso" class="form-control">
            </div>

            <div class="mb-3">
                <label for="min_comensales" class="form-label">Min. comensales:</label>
                <input type="number" name="min_comensales" id="min_comensales" class="form-control" value="2" min="1">
            </div>

            <div class="mb-3">
                <label for="max_comensales" class="form-label">Max. comensales:</label>
                <input type="number" name="max_comensales" id="max_comensales" class="form-control" value="2" min="1">
            </div>

            <button type="submit" class="btn btn-primary">Crear Dulce</button>
        </form>

        <!-- Mostrar los dulces existentes -->
        <h3 class="mt-5">Lista de dulces:</h3>
<div class="list-group">
    <?php
    // Obtener todos los IDs de los dulces
    $sql = "SELECT id FROM dulces";
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    $ids = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Iterar sobre los IDs y obtener los dulces usando obtenerDulcePorId
    foreach ($ids as $id) {
        $dulce = Dulce::obtenerDulcePorId($pdo, $id['id']);
        
        if ($dulce) {
            echo "<div class='list-group-item list-group-item-action'>";
            echo "<strong>{$dulce->getNombre()}</strong><br>";
            echo "Precio: {$dulce->getPrecio()}€, Categoría: {$dulce->getCategoria()}<br>";
            echo "</div><br>";
        }
    }
    ?>
</div>

<!-- Mostrar los clientes existentes -->
<h3 class="mt-5">Lista de clientes:</h3>
<div class="list-group">
    <?php
    // Obtener todos los clientes de la base de datos
    $sql = "SELECT numero FROM clientes";
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    $numerosClientes = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Iterar sobre los números de cliente y crear instancias de Cliente
    foreach ($numerosClientes as $row) {
        $cliente = Cliente::obtenerClientePorNumero($pdo, $row['numero']);
        if ($cliente) {
            echo "<div class='list-group-item list-group-item-action'>";
            echo "<strong>Nombre: {$cliente->getNombre()}</strong><br>";
            echo "Número: {$cliente->getNumero()}<br>";
            echo "Pedidos Efectuados: {$cliente->getNumPedidosEfectuados()}";
            echo "</div><br>";
        } else {
            echo "<div class='list-group-item list-group-item-danger'>";
            echo "Error al cargar los datos del cliente con número {$row['numero']}.";
            echo "</div>";
        }
    }
    ?>
</div>


    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
