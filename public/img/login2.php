<?php
session_start();
require_once __DIR__ . '/../../src/Cliente.php';

// Usuarios permitidos
$usuarios = [
    'admin' => 'admin',
    'usuario' => 'usuario'
];

// Verificar si los datos del formulario fueron enviados
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $usuario = htmlspecialchars(trim($_POST['usuario']));
    $password = htmlspecialchars(trim($_POST['password']));

    // Verificar si el usuario y la contraseña son correctos
    if (isset($usuarios[$usuario]) && $usuarios[$usuario] === $password) {
        // Iniciar sesión para el usuario
        $_SESSION['usuario'] = $usuario;
        
        if ($usuario === 'admin') {
            $_SESSION['admin'] = true;
            $_SESSION['clientes'] = [
                new Cliente("OC", "12345", "ock", "12345"),
                new Cliente("Jose", "67890", "jose", "67890"),
                new Cliente("Matito", "11223", "matito", "11223")
            ];
            $_SESSION['dulces'] = ['Tarta de Chocolate', 'Bollo de Fresa', 'Chocolates'];
            header("Location: mainAdmin.php"); // Redirigir a la página principal del admin
            exit();
        }

        // Si es usuario normal, redirigir a main.php
        header("Location: main.php");
        exit();
    } else {
        // Si los datos son incorrectos, mostrar error
        $_SESSION['error'] = true;
        header("Location: index.php"); // Volver al formulario de login
        exit();
    }
}
?>
