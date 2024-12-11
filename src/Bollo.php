<?php
// Bollo.php
require_once 'Dulce.php';

class Bollo extends Dulce {
    private string $relleno;

    public function __construct(
        string $nombre,
        float $precio,
        string $categoria,
        string $relleno
    ) {
        parent::__construct($nombre, $precio, $categoria);
        $this->relleno = $relleno;
    }

    public function getRelleno(): string {
        return $this->relleno;
    }

    public function muestraResumen(): void {
        echo "Bollo: {$this->getNombre()}, Relleno: {$this->relleno}, Precio: {$this->getPrecio()}€.<br>";
    }

    // Crear un bollo en la base de datos
    public static function crearBollo(PDO $pdo, string $nombre, float $precio, string $categoria, string $relleno): bool {
        $sql = "INSERT INTO dulces (nombre, precio, categoria) VALUES (:nombre, :precio, :categoria)";
        $stmt = $pdo->prepare($sql);
        return $stmt->execute([
            ':nombre' => $nombre,
            ':precio' => $precio,
            ':categoria' => $categoria
        ]);
    }

    // Leer todos los bollos desde la base de datos
    public static function obtenerBollos(PDO $pdo): array {
        $sql = "SELECT * FROM dulces WHERE categoria = 'Bollería'";
        $stmt = $pdo->query($sql);
        $bollos = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $bollos[] = new Bollo($row['nombre'], $row['precio'], $row['categoria'], $row['relleno']);
        }
        return $bollos;
    }

    // Actualizar un bollo en la base de datos
    public function actualizarBollo(PDO $pdo): bool {
        $sql = "UPDATE dulces SET nombre = :nombre, precio = :precio, categoria = :categoria WHERE id = :id";
        $stmt = $pdo->prepare($sql);
        return $stmt->execute([
            ':nombre' => $this->getNombre(),
            ':precio' => $this->getPrecio(),
            ':categoria' => $this->getCategoria(),
            ':id' => $this->getId() // Asegurándonos de que el id está disponible
        ]);
    }

    // Eliminar un bollo de la base de datos
    public function eliminarBollo(PDO $pdo): bool {
        $sql = "DELETE FROM dulces WHERE id = :id";
        $stmt = $pdo->prepare($sql);
        return $stmt->execute([':id' => $this->getId()]);
    }
}
