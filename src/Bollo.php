<?php

require_once "Dulce.php";
require_once __DIR__ . '/../db/DB.php';  

class Bollo extends Dulce {
    // Atributos
    private string $relleno;

    // Constructor
    public function __construct(
        string $nombre, 
        float $precio, 
        string $categoria, 
        string $relleno  
    ) {
        parent::__construct($nombre, $precio, $categoria);  // Llamamos al constructor de la clase base
        $this->relleno = $relleno;
    }

    // Implementación del método abstracto para mostrar el resumen del bollo
    public function muestraResumen(): void {
        echo "Bollo.php: <br>";
        echo "Nombre: " . $this->getNombre() . "<br>";
        echo "Precio: " . $this->getPrecio() . "€<br>";
        echo "Categoría: " . $this->getCategoria() . "<br>";
        echo "Relleno: " . $this->relleno . "<br>";
        echo "IVA: " . (Dulce::getIVA() * 100) . "%<br>";
        echo "<br><br>";
    }

    // Operación CRUD: Crear un bollo en la base de datos
    public function crearBollo(): bool {
        try {
            $db = DB::getConnection();  // Obtener conexión a la base de datos
            $nombre = $this->getNombre();
            $precio = $this->getPrecio();
            $categoria = $this->getCategoria();
            $descripcion = $this->relleno;  

            $query = "INSERT INTO dulces (nombre, precio, categoria, descripcion) VALUES (:nombre, :precio, :categoria, :descripcion)";
            $stmt = $db->prepare($query);
            $stmt->bindParam(':nombre', $nombre);
            $stmt->bindParam(':precio', $precio);
            $stmt->bindParam(':categoria', $categoria);
            $stmt->bindParam(':descripcion', $descripcion);
            $stmt->execute();

            $dulceId = $db->lastInsertId();  // Obtener el ID del dulce insertado
            // Ahora insertar en la tabla bollos, asociando el dulce_id
            $query = "INSERT INTO bollos (dulce_id, relleno) VALUES (:dulce_id, :relleno)";
            $stmt = $db->prepare($query);
            $stmt->bindParam(':dulce_id', $dulceId);
            $stmt->bindParam(':relleno', $this->relleno);
            return $stmt->execute();
        } catch (PDOException $e) {
            echo "Error al crear el bollo: " . $e->getMessage();
            return false;
        }
    }

    // Operación CRUD: Leer todos los bollos
    public static function obtenerBollos(): array {
        try {
            $db = DB::getConnection();
            $query = "SELECT b.id, d.nombre, d.precio, d.categoria, b.relleno 
                      FROM bollos b 
                      JOIN dulces d ON b.dulce_id = d.id";
            $stmt = $db->query($query);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            echo "Error al obtener los bollos: " . $e->getMessage();
            return [];
        }
    }

    // Operación CRUD: Actualizar un bollo
    public function actualizarBollo(int $id): bool {
        try {
            $db = DB::getConnection();
            $query = "UPDATE dulces d JOIN bollos b ON d.id = b.dulce_id 
                      SET d.nombre = :nombre, d.precio = :precio, d.categoria = :categoria, 
                          b.relleno = :relleno 
                      WHERE b.id = :id";
            $stmt = $db->prepare($query);

            $nombre = $this->getNombre();
            $precio = $this->getPrecio();
            $categoria = $this->getCategoria();

            $stmt->bindParam(':nombre', $nombre);
            $stmt->bindParam(':precio', $precio);
            $stmt->bindParam(':categoria', $categoria);
            $stmt->bindParam(':relleno', $this->relleno);
            $stmt->bindParam(':id', $id);
            return $stmt->execute();
        } catch (PDOException $e) {
            echo "Error al actualizar el bollo: " . $e->getMessage();
            return false;
        }
    }

    // Operación CRUD: Eliminar un bollo
    public static function eliminarBollo(int $id): bool {
        try {
            $db = DB::getConnection();
            $query = "DELETE b, d FROM bollos b JOIN dulces d ON b.dulce_id = d.id WHERE b.id = :id";
            $stmt = $db->prepare($query);
            $stmt->bindParam(':id', $id);
            return $stmt->execute();
        } catch (PDOException $e) {
            echo "Error al eliminar el bollo: " . $e->getMessage();
            return false;
        }
    }
}
?>
