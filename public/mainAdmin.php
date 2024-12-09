<?php
require_once __DIR__ . '/../src/Cliente.php';
session_start();

// Verificar si el usuario está logueado y es admin
if (!isset($_SESSION['usuario']) || !isset($_SESSION['admin'])) {
    header("Location: index.php");
    exit();
}

$usuario = htmlspecialchars($_SESSION['usuario']);
$clientes = $_SESSION['clientes'] ?? [];
$dulces = $_SESSION['dulces'] ?? [];
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bienvenido Admin - Pastelería</title>
</head>
<body>
    <h1>Bienvenido, <?php echo $usuario; ?> (Admin)</h1>
    <a href="logout.php">Cerrar sesión</a>

    <h2>Listado de Clientes:</h2>
    <ul>
        <?php 
        if (!is_array($clientes) || empty($clientes)) {
            echo "<p>No hay clientes registrados</p>";
        } else {
            foreach ($clientes as $cliente): 
        ?>
            <li>
                <?php 
                    if ($cliente instanceof Cliente) {
                        echo "Nombre: " . htmlspecialchars($cliente->getNombre()) . 
                             " - Usuario: " . htmlspecialchars($cliente->getUsuario());
                    } else {
                        echo "Error: Cliente no válido.";
                    }
                ?>
            </li>
        <?php 
            endforeach; 
        } 
        ?>
    </ul>

    <h2>Listado de Dulces:</h2>
    <ul>
        <?php 
        if (!empty($dulces)) {
            foreach ($dulces as $dulce): 
        ?>
                <li><?php echo htmlspecialchars($dulce); ?></li>
        <?php 
            endforeach; 
        } else {
            echo "<li>No hay dulces registrados.</li>";
        }
        ?>
    </ul>
</body>
</html>
