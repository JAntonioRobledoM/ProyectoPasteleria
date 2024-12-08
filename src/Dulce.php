<?php

require_once "Resumible.php";
require_once __DIR__ . '/../db/DB.php';  

// Clase abstracta Dulce implementando la interfaz Resumible
abstract class Dulce implements Resumible {

    private int $id;

    // Constructor con promoción de propiedades
    public function __construct(
        private string $nombre,
        private float $precio,
        private string $categoria
    ) {
    }

    // Atributo estático para el IVA
    private static float $IVA = 0.21;

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

    public function setId(int $id): void {
        $this->id = $id;
    }

    // Método para obtener el IVA
    public static function getIVA(): float {
        return self::$IVA;
    }

    // Implementación del método muestraResumen() desde la interfaz
    public function muestraResumen(): void {
        echo "Dulce.php: <br>";
        echo "Nombre: " . $this->getNombre() . "<br>";
        echo "Precio: " . $this->getPrecio() . "€<br>";
        echo "Categoría: " . $this->getCategoria() . "<br>";
        echo "IVA: " . (self::getIVA() * 100) . "%<br>";
        echo "ID: " . ($this->getId() ?? "No asignado") . "<br>";
        echo "<br><br>";
    }

    // Operación CRUD: Crear un dulce en la base de datos
    public function crearDulce(): bool {
        try {
            $db = DB::getConnection();  // Obtener conexión a la base de datos
            $nombre = $this->getNombre();
            $precio = $this->getPrecio();
            $categoria = $this->getCategoria();

            $query = "INSERT INTO dulces (nombre, precio, categoria) VALUES (:nombre, :precio, :categoria)";
            $stmt = $db->prepare($query);
            $stmt->bindParam(':nombre', $nombre);
            $stmt->bindParam(':precio', $precio);
            $stmt->bindParam(':categoria', $categoria);
            $stmt->execute();

            $this->setId($db->lastInsertId());  // Establecer el ID del dulce creado
            return true;
        } catch (PDOException $e) {
            echo "Error al crear el dulce: " . $e->getMessage();
            return false;
        }
    }

    // Operación CRUD: Leer todos los dulces
    public static function obtenerDulces(): array {
        try {
            $db = DB::getConnection();
            $query = "SELECT * FROM dulces";
            $stmt = $db->query($query);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            echo "Error al obtener los dulces: " . $e->getMessage();
            return [];
        }
    }

    // Operación CRUD: Actualizar un dulce
    public function actualizarDulce(): bool {
        try {
            $db = DB::getConnection();
            $query = "UPDATE dulces SET nombre = :nombre, precio = :precio, categoria = :categoria WHERE id = :id";
            $stmt = $db->prepare($query);

            $nombre = $this->getNombre();
            $precio = $this->getPrecio();
            $categoria = $this->getCategoria();
            $id = $this->getId();

            $stmt->bindParam(':nombre', $nombre);
            $stmt->bindParam(':precio', $precio);
            $stmt->bindParam(':categoria', $categoria);
            $stmt->bindParam(':id', $id);
            return $stmt->execute();
        } catch (PDOException $e) {
            echo "Error al actualizar el dulce: " . $e->getMessage();
            return false;
        }
    }

    // Operación CRUD: Eliminar un dulce
    public static function eliminarDulce(int $id): bool {
        try {
            $db = DB::getConnection();
            $query = "DELETE FROM dulces WHERE id = :id";
            $stmt = $db->prepare($query);
            $stmt->bindParam(':id', $id);
            return $stmt->execute();
        } catch (PDOException $e) {
            echo "Error al eliminar el dulce: " . $e->getMessage();
            return false;
        }
    }
}

?>
