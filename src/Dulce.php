<?php
require_once 'Resumible.php';

abstract class Dulce implements Resumible {
    private ?int $id = null;
    private static float $IVA = 0.21;

    public function __construct(
        private string $nombre,
        private float $precio,
        private string $categoria
    ) {}

    // Getters
    public function getId(): ?int {
        return $this->id;
    }

    public function getNombre(): string {
        return $this->nombre;
    }

    public function getPrecio(): float {
        return $this->precio;
    }

    public function getCategoria(): string {
        return $this->categoria;
    }

    public static function getIVA(): float {
        return self::$IVA;
    }

    public function setId(int $id): void {
        $this->id = $id;
    }

    // Implementación del método de la interfaz
    public function muestraResumen(): void {
        echo "Dulce: {$this->nombre}, Precio: {$this->precio}€, Categoría: {$this->categoria}, IVA: " . (self::$IVA * 100) . "%.<br>";
    }

    // Métodos CRUD para Dulce

    // Crear dulce en la base de datos
    public function crearDulce(PDO $pdo): bool {
        $sql = "INSERT INTO dulces (nombre, precio, categoria) VALUES (:nombre, :precio, :categoria)";
        $stmt = $pdo->prepare($sql);
        return $stmt->execute([
            ':nombre' => $this->nombre,
            ':precio' => $this->precio,
            ':categoria' => $this->categoria
        ]);
    }

// Obtener dulce por su id
public static function obtenerDulcePorId(PDO $pdo, int $id): ?Dulce {
    $sql = "SELECT * FROM dulces WHERE id = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([':id' => $id]);
    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($row) {
        // Verifica la categoría del dulce y crea la instancia correspondiente
        switch ($row['categoria']) {
            case 'Bollería':
                // Si relleno es NULL, asigna un valor por defecto (cadena vacía)
                $relleno = $row['relleno'] ?? ''; // Si es NULL, asigna una cadena vacía
                return new Bollo($row['nombre'], $row['precio'], $row['categoria'], $relleno);
            case 'Chocolates':
                // Verifica si porcentaje_cacao y peso son NULL y asigna valores por defecto
                $porcentajeCacao = $row['porcentaje_cacao'] ?? 0; // Si es NULL, asigna 0
                $peso = $row['peso'] ?? 0; // Si es NULL, asigna 0
                return new Chocolate($row['nombre'], $row['precio'], $row['categoria'], $porcentajeCacao, $peso);
            case 'Tartas':
                return new Tarta($row['nombre'], $row['precio'], $row['categoria'], explode(',', $row['relleno']), $row['min_comensales'], $row['max_comensales']);
            default:
                return null; // Si la categoría no coincide con ninguna de las anteriores
        }
    }
    return null; // Si no se encuentra el dulce
}


    // Actualizar dulce en la base de datos
    public function actualizarDulce(PDO $pdo): bool {
        $sql = "UPDATE dulces SET nombre = :nombre, precio = :precio, categoria = :categoria WHERE id = :id";
        $stmt = $pdo->prepare($sql);
        return $stmt->execute([
            ':nombre' => $this->nombre,
            ':precio' => $this->precio,
            ':categoria' => $this->categoria,
            ':id' => $this->id
        ]);
    }

    // Eliminar dulce de la base de datos
    public static function eliminarDulce(PDO $pdo, int $id) {
        // Preparar la consulta de eliminación
        $sql = "DELETE FROM dulces WHERE id = :id";
        $stmt = $pdo->prepare($sql);

        // Ejecutar la consulta
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);

        return $stmt->execute();
    }
}
