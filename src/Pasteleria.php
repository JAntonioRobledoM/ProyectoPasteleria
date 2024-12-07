<?php

require_once 'Dulce.php';
require_once 'Cliente.php';

use Util\DulceNoCompradoException;
use Util\ClienteNoEncontradoException;

class Pasteleria {
    // Propiedades privadas con promoción de constructor
    public function __construct(
        private array $productos = [],
        private array $clientes = []
    ) {}

    // Método público para incluir un dulce
    public function incluirDulce(Dulce $dulce): void {
        $this->incluirProducto($dulce);
        echo "Producto incluido: " . $dulce->getNombre() . "<br>";
    }

    // Método privado para incluir un producto en el array
    private function incluirProducto(Dulce $dulce): void {
        $this->productos[] = $dulce; // Agregar al array 
    }

    // Método para incluir un cliente
    public function incluirCliente(Cliente $cliente): void {
        $this->clientes[] = $cliente;
        echo "Cliente incluido: " . $cliente->getNombre() . "<br>";
    }

    // Método para listar los productos disponibles
    public function listarProductos(): void {
        echo "Productos disponibles en la pastelería:<br>";
        foreach ($this->productos as $index => $producto) {
            echo ($index + 1) . ". " . $producto->getNombre() . " - " . $producto->getPrecio() . "€<br>";
        }
    }

    // Método para listar los clientes
    public function listarClientes(): void {
        echo "Clientes registrados en la pastelería:<br>";
        foreach ($this->clientes as $index => $cliente) {
            echo ($index + 1) . ". " . $cliente->getNombre() . " (Pedidos realizados: " . $cliente->getNumPedidosEfectuados() . ")<br>";
        }
    }

    // Método para realizar compras 
    public function realizarCompra(Cliente $cliente, Dulce $dulce): void {
        try {
            // Intentamos realizar la compra
            $cliente->comprar($dulce);
            echo "Compra realizada: " . $dulce->getNombre() . " por " . $cliente->getNombre() . "<br>";
        } catch (DulceNoCompradoException $e) {
            // Si se lanza la excepción, informamos al usuario
            echo "Error: " . $e->getMessage() . "<br>";
        } catch (ClienteNoEncontradoException $e) {
            // Si se lanza la excepción, informamos al usuario
            echo "Error: " . $e->getMessage() . "<br>";
        }
    }

    // Método para realizar una valoración 
    public function valorarDulce(Cliente $cliente, Dulce $dulce, string $comentario): void {
        try {
            // Intentamos valorar el dulce
            $cliente->valorar($dulce, $comentario);
        } catch (DulceNoCompradoException $e) {
            // Si se lanza la excepción, informamos al usuario
            echo "Error: " . $e->getMessage() . "<br>";
        } catch (ClienteNoEncontradoException $e) {
            // Si se lanza la excepción, informamos al usuario
            echo "Error: " . $e->getMessage() . "<br>";
        }
    }
}

// Ejemplo de uso

// Crear instancia de Pasteleria
$pasteleria = new Pasteleria();

// Crear dulces
require_once 'Bollo.php';
require_once 'Chocolate.php';

$bollo = new Bollo("Bollo de Chocolate", 2.50, "Bollos", "Chocolate con leche");
$chocolate = new Chocolate("Chocolate Negro", 5.00, "Chocolates", 90, 100);

// Incluir dulces en la pastelería
$pasteleria->incluirDulce($bollo);
$pasteleria->incluirDulce($chocolate);

// Crear clientes
$cliente1 = new Cliente("Jose Robledo", "12345");
$cliente2 = new Cliente("Cristina Viera", "54321");

// Incluir clientes en la pastelería
$pasteleria->incluirCliente($cliente1);
$pasteleria->incluirCliente($cliente2);

// Realizar compras
$pasteleria->realizarCompra($cliente1, $bollo);
$pasteleria->realizarCompra($cliente1, $chocolate);
$pasteleria->realizarCompra($cliente2, $chocolate);

// Listar productos y clientes
$pasteleria->listarProductos();
$pasteleria->listarClientes();

// Realizar valoraciones (con manejo de excepciones)
$pasteleria->valorarDulce($cliente1, $bollo, "Delicioso");
$pasteleria->valorarDulce($cliente1, $chocolate, "Exquisito");
$pasteleria->valorarDulce($cliente2, $bollo, "Muy bueno");

?>
