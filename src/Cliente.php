<?php

require_once __DIR__ . '/../util/DulceNoCompradoException.php';
require_once __DIR__ . '/../util/PasteleriaException.php';

use util\DulceNoCompradoException;
use util\ClienteNoEncontradoException;

class Cliente {
    private int $numPedidosEfectuados = 0;
    private array $dulcesComprados = [];

    public function __construct(
        private string $nombre,
        private string $numero,
        int $numPedidosEfectuados = 0
    ) {
        $this->numPedidosEfectuados = $numPedidosEfectuados;
    }

    public function getNombre(): string {
        return $this->nombre;
    }

    public function getNumero(): string {
        return $this->numero;
    }

    public function getNumPedidosEfectuados(): int {
        return $this->numPedidosEfectuados;
    }

// Crear cliente en la base de datos
public static function crearCliente(PDO $pdo, string $nombre, string $numero): bool {
    // Verificar si el cliente ya existe en la base de datos
    $clienteExistente = self::obtenerClientePorNumero($pdo, $numero);

    if ($clienteExistente) {
        // El cliente ya existe, no lo insertamos nuevamente
        echo "Error: El cliente con número '$numero' ya existe en la base de datos.<br>";
        return false;
    }

    // Si no existe, proceder con la creación del nuevo cliente
    $sql = "INSERT INTO clientes (nombre, numero) VALUES (:nombre, :numero)";
    $stmt = $pdo->prepare($sql);
    return $stmt->execute([
        ':nombre' => $nombre,
        ':numero' => $numero
    ]);
}


    // Obtener un cliente por su número
    public static function obtenerClientePorNumero(PDO $pdo, string $numero): ?Cliente {
        $sql = "SELECT * FROM clientes WHERE numero = :numero";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([':numero' => $numero]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($row) {
            return new Cliente($row['nombre'], $row['numero'], $row['num_pedidos']);
        }
        return null;
    }

    // Actualizar los datos del cliente en la base de datos
    public function actualizarCliente(PDO $pdo): bool {
        $sql = "UPDATE clientes SET nombre = :nombre, num_pedidos = :num_pedidos WHERE numero = :numero";
        $stmt = $pdo->prepare($sql);
        return $stmt->execute([
            ':nombre' => $this->nombre,
            ':num_pedidos' => $this->numPedidosEfectuados,
            ':numero' => $this->numero
        ]);
    }

    // Eliminar un cliente de la base de datos
    public function eliminarCliente(PDO $pdo): bool {
        $sql = "DELETE FROM clientes WHERE numero = :numero";
        $stmt = $pdo->prepare($sql);
        return $stmt->execute([':numero' => $this->numero]);
    }

    // Valorar un dulce
    public function valorar(Dulce $dulce, string $comentario): void {
        if (in_array($dulce, $this->dulcesComprados)) {
            echo "Valoración del dulce '{$dulce->getNombre()}': $comentario<br>";
        } else {
            throw new DulceNoCompradoException("No se puede valorar un dulce no comprado.");
        }
    }
}
