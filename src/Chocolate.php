<?php

require_once 'Dulce.php';

class Chocolate extends Dulce {
    private int $porcentajeCacao;
    private int $peso;

    public function __construct(
        string $nombre,
        float $precio,
        string $categoria,
        int $porcentajeCacao,
        int $peso
    ) {
        parent::__construct($nombre, $precio, $categoria);
        $this->porcentajeCacao = $porcentajeCacao;
        $this->peso = $peso;
    }

    public function muestraResumen(): void {
        echo "Chocolate: {$this->getNombre()}, Cacao: {$this->porcentajeCacao}%, Peso: {$this->peso}g, Precio: {$this->getPrecio()}€.<br>";
    }

    public function getPorcentajeCacao(): float {
        return $this->porcentajeCacao;
    }

    public function getPeso(): float {
        return $this->peso;
    }

    // Crear un chocolate en la base de datos
    public static function crearChocolate(PDO $pdo, string $nombre, float $precio, string $categoria, int $porcentajeCacao, int $peso): bool {
        $sql = "INSERT INTO dulces (nombre, precio, categoria) VALUES (:nombre, :precio, :categoria)";
        $stmt = $pdo->prepare($sql);
        return $stmt->execute([
            ':nombre' => $nombre,
            ':precio' => $precio,
            ':categoria' => $categoria
        ]);
    }

    // Leer todos los chocolates desde la base de datos
    public static function obtenerChocolates(PDO $pdo): array {
        $sql = "SELECT * FROM dulces WHERE categoria = 'Chocolates'";
        $stmt = $pdo->query($sql);
        $chocolates = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $chocolates[] = new Chocolate($row['nombre'], $row['precio'], $row['categoria'], $row['porcentaje_cacao'], $row['peso']);
        }
        return $chocolates;
    }

    // Actualizar un chocolate en la base de datos
    public function actualizarChocolate(PDO $pdo): bool {
        $sql = "UPDATE dulces SET nombre = :nombre, precio = :precio, categoria = :categoria WHERE id = :id";
        $stmt = $pdo->prepare($sql);
        return $stmt->execute([
            ':nombre' => $this->getNombre(),
            ':precio' => $this->getPrecio(),
            ':categoria' => $this->getCategoria(),
            ':id' => $this->getId() // Asegurándonos de que el id está disponible
        ]);
    }

    // Eliminar un chocolate de la base de datos
    public function eliminarChocolate(PDO $pdo): bool {
        $sql = "DELETE FROM dulces WHERE id = :id";
        $stmt = $pdo->prepare($sql);
        return $stmt->execute([':id' => $this->getId()]);
    }
}
