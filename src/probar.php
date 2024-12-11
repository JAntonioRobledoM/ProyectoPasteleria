<?php
session_start(); // Iniciar la sesión para manejar mensajes

require_once '../db/db.php'; // Asegúrate de que la ruta sea correcta

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
    <title>Pastelería</title>
    <!-- Cargar Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
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
                <input type="text" name="relleno" id="relleno" class="form-control">
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
            $sql = "SELECT * FROM dulces";
            $stmt = $pdo->prepare($sql);
            $stmt->execute();
            $dulces = $stmt->fetchAll(PDO::FETCH_ASSOC);

            foreach ($dulces as $dulce) {
                echo "<div class='list-group-item list-group-item-action'>";
                echo "<strong>{$dulce['nombre']}</strong><br>";
                echo "Precio: {$dulce['precio']}€, Categoría: {$dulce['categoria']}<br>";

                // Mostrar información adicional si existe
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
                echo "</div><br>";
            }
            ?>
        </div>

        <!-- Mostrar cliente -->
        <h3 class="mt-5">Lista de clientes:</h3>
        <div class="list-group">
            <?php
            $sql = "SELECT * FROM clientes";
            $stmt = $pdo->prepare($sql);
            $stmt->execute();
            $clientes = $stmt->fetchAll(PDO::FETCH_ASSOC);

            foreach ($clientes as $cliente) {
                echo "<div class='list-group-item'>";
                echo "Nombre: {$cliente['nombre']}, Número: {$cliente['numero']}, Pedidos realizados: {$cliente['num_pedidos']}<br>";
                echo "</div>";
            }
            ?>
        </div>

        <!-- Mostrar la lista de compras del cliente "usuario" -->
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

    <!-- Cargar Bootstrap JS y dependencias -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
