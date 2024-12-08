<?php

require_once 'Dulce.php';
require_once 'Cliente.php';

require_once __DIR__ . '/../util/DulceNoCompradoException.php';
require_once __DIR__ . '/../util/PasteleriaException.php';

use util\DulceNoCompradoException;
use util\ClienteNoEncontradoException;

class Pasteleria {
    // Propiedades privadas con promoción de constructor
    public function __construct(
        private array $productos = [],
        private array $clientes = []
    ) {}

    // Método público para incluir un dulce en la base de datos
    public function incluirDulce(Dulce $dulce): void {
        $this->crearDulceEnBD($dulce);  // Crear dulce en la base de datos
        echo "Producto incluido: " . $dulce->getNombre() . "<br>";
    }

    // Método público para incluir un cliente en la base de datos
    public function incluirCliente(Cliente $cliente): void {
        $this->crearClienteEnBD($cliente);  // Crear cliente en la base de datos
        echo "Cliente incluido: " . $cliente->getNombre() . "<br>";
    }

    // Crear dulce en la base de datos
    private function crearDulceEnBD(Dulce $dulce): void {
        try {
            $db = DB::getConnection();  // Obtener conexión a la base de datos
            $query = "INSERT INTO dulces (nombre, precio, categoria) VALUES (:nombre, :precio, :categoria)";
            $stmt = $db->prepare($query);
            $stmt->bindParam(':nombre', $dulce->getNombre());
            $stmt->bindParam(':precio', $dulce->getPrecio());
            $stmt->bindParam(':categoria', $dulce->getCategoria());
            $stmt->execute();
        } catch (PDOException $e) {
            echo "Error al incluir el dulce: " . $e->getMessage() . "<br>";
        }
    }

    // Crear cliente en la base de datos
    private function crearClienteEnBD(Cliente $cliente): void {
        try {
            $db = DB::getConnection();
            $query = "INSERT INTO clientes (nombre, usuario) VALUES (:nombre, :usuario)";
            $stmt = $db->prepare($query);
            $stmt->bindParam(':nombre', $cliente->getNombre());
            $stmt->bindParam(':usuario', $cliente->getUsuario());
            $stmt->execute();
        } catch (PDOException $e) {
            echo "Error al incluir el cliente: " . $e->getMessage() . "<br>";
        }
    }

    // Listar todos los productos (dulces) de la base de datos
    public function listarProductos(): void {
        try {
            $db = DB::getConnection();
            $query = "SELECT * FROM dulces";
            $stmt = $db->query($query);
            $productos = $stmt->fetchAll(PDO::FETCH_ASSOC);
            
            echo "Productos disponibles en la pastelería:<br>";
            foreach ($productos as $index => $producto) {
                echo ($index + 1) . ". " . $producto['nombre'] . " - " . $producto['precio'] . "€<br>";
            }
        } catch (PDOException $e) {
            echo "Error al listar los productos: " . $e->getMessage() . "<br>";
        }
    }

    // Listar todos los clientes de la base de datos
    public function listarClientes(): void {
        try {
            $db = DB::getConnection();
            $query = "SELECT * FROM clientes";
            $stmt = $db->query($query);
            $clientes = $stmt->fetchAll(PDO::FETCH_ASSOC);

            echo "Clientes registrados en la pastelería:<br>";
            foreach ($clientes as $index => $cliente) {
                echo ($index + 1) . ". " . $cliente['nombre'] . " (Usuario: " . $cliente['usuario'] . ")<br>";
            }
        } catch (PDOException $e) {
            echo "Error al listar los clientes: " . $e->getMessage() . "<br>";
        }
    }

    // Actualizar dulce en la base de datos
    public function actualizarDulce(Dulce $dulce): void {
        try {
            $db = DB::getConnection();
            $query = "UPDATE dulces SET nombre = :nombre, precio = :precio, categoria = :categoria WHERE id = :id";
            $stmt = $db->prepare($query);
            $stmt->bindParam(':id', $dulce->getId());
            $stmt->bindParam(':nombre', $dulce->getNombre());
            $stmt->bindParam(':precio', $dulce->getPrecio());
            $stmt->bindParam(':categoria', $dulce->getCategoria());
            $stmt->execute();
        } catch (PDOException $e) {
            echo "Error al actualizar el dulce: " . $e->getMessage() . "<br>";
        }
    }

    // Actualizar cliente en la base de datos
    public function actualizarCliente(Cliente $cliente): void {
        try {
            $db = DB::getConnection();
            $query = "UPDATE clientes SET nombre = :nombre, usuario = :usuario WHERE id = :id";
            $stmt = $db->prepare($query);
            $stmt->bindParam(':id', $cliente->getId());
            $stmt->bindParam(':nombre', $cliente->getNombre());
            $stmt->bindParam(':usuario', $cliente->getUsuario());
            $stmt->execute();
        } catch (PDOException $e) {
            echo "Error al actualizar el cliente: " . $e->getMessage() . "<br>";
        }
    }

    // Eliminar dulce de la base de datos
    public function eliminarDulce(int $id): void {
        try {
            $db = DB::getConnection();
            $query = "DELETE FROM dulces WHERE id = :id";
            $stmt = $db->prepare($query);
            $stmt->bindParam(':id', $id);
            $stmt->execute();
        } catch (PDOException $e) {
            echo "Error al eliminar el dulce: " . $e->getMessage() . "<br>";
        }
    }

    // Eliminar cliente de la base de datos
    public function eliminarCliente(int $id): void {
        try {
            $db = DB::getConnection();
            $query = "DELETE FROM clientes WHERE id = :id";
            $stmt = $db->prepare($query);
            $stmt->bindParam(':id', $id);
            $stmt->execute();
        } catch (PDOException $e) {
            echo "Error al eliminar el cliente: " . $e->getMessage() . "<br>";
        }
    }

    // Realizar compras 
    public function realizarCompra(Cliente $cliente, Dulce $dulce): void {
        try {
            // Intentamos realizar la compra
            $cliente->comprar($dulce);
            echo "Compra realizada: " . $dulce->getNombre() . " por " . $cliente->getNombre() . "<br>";
        } catch (DulceNoCompradoException $e) {
            echo "Error: " . $e->getMessage() . "<br>";
        } catch (ClienteNoEncontradoException $e) {
            echo "Error: " . $e->getMessage() . "<br>";
        }
    }

    // Realizar valoraciones 
    public function valorarDulce(Cliente $cliente, Dulce $dulce, string $comentario): void {
        try {
            $cliente->valorar($dulce, $comentario);
        } catch (DulceNoCompradoException $e) {
            echo "Error: " . $e->getMessage() . "<br>";
        } catch (ClienteNoEncontradoException $e) {
            echo "Error: " . $e->getMessage() . "<br>";
        }
    }
}

?>
