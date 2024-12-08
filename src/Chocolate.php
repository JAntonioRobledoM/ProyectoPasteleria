<?php

require_once "Dulce.php";
require_once __DIR__ . '/../db/DB.php';  

class Chocolate extends Dulce {
    // Atributos promovidos al constructor
    private int $porcentajeCacao;
    private int $peso;

    // Constructor
    public function __construct(
        string $nombre, 
        float $precio, 
        string $categoria, 
        int $porcentajeCacao, 
        int $peso
    ) {
        // Llamar al constructor de la clase base Dulce
        parent::__construct($nombre, $precio, $categoria);
        $this->porcentajeCacao = $porcentajeCacao;
        $this->peso = $peso;
    }

    // Implementación del método abstracto para mostrar el resumen del chocolate
    public function muestraResumen(): void {
        echo "Chocolate.php: <br>";
        echo "Nombre: " . $this->getNombre() . "<br>";
        echo "Precio: " . $this->getPrecio() . "€<br>";
        echo "Categoría: " . $this->getCategoria() . "<br>";
        echo "Porcentaje de Cacao: " . $this->porcentajeCacao . "%<br>";
        echo "Peso: " . $this->peso . "g<br>";
        echo "IVA: " . (Dulce::getIVA() * 100) . "%<br>";
        echo "<br><br>";
    }

    // Operación CRUD: Crear un chocolate en la base de datos
    public function crearChocolate(): bool {
        try {
            $db = DB::getConnection();  // Obtener conexión a la base de datos
            // Primero, creamos el dulce (ya que chocolate hereda de dulce)
            $nombre = $this->getNombre();
            $precio = $this->getPrecio();
            $categoria = $this->getCategoria();
            $descripcion = "Chocolate con " . $this->porcentajeCacao . "% de cacao y " . $this->peso . "g"; // Descripción del chocolate

            // Insertar en la tabla de dulces
            $query = "INSERT INTO dulces (nombre, precio, descripcion, categoria) VALUES (:nombre, :precio, :descripcion, :categoria)";
            $stmt = $db->prepare($query);
            $stmt->bindParam(':nombre', $nombre);
            $stmt->bindParam(':precio', $precio);
            $stmt->bindParam(':descripcion', $descripcion);
            $stmt->bindParam(':categoria', $categoria);
            $stmt->execute();

            $dulceId = $db->lastInsertId();  // Obtener el ID del dulce insertado

            // Ahora insertamos en la tabla de chocolates
            $query = "INSERT INTO chocolates (dulce_id, porcentajeCacao, peso) VALUES (:dulce_id, :porcentajeCacao, :peso)";
            $stmt = $db->prepare($query);
            $stmt->bindParam(':dulce_id', $dulceId);
            $stmt->bindParam(':porcentajeCacao', $this->porcentajeCacao);
            $stmt->bindParam(':peso', $this->peso);
            return $stmt->execute();
        } catch (PDOException $e) {
            echo "Error al crear el chocolate: " . $e->getMessage();
            return false;
        }
    }

    // Operación CRUD: Leer todos los chocolates
    public static function obtenerChocolates(): array {
        try {
            $db = DB::getConnection();
            $query = "SELECT c.id, d.nombre, d.precio, d.categoria, c.porcentajeCacao, c.peso 
                      FROM chocolates c 
                      JOIN dulces d ON c.dulce_id = d.id";
            $stmt = $db->query($query);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            echo "Error al obtener los chocolates: " . $e->getMessage();
            return [];
        }
    }

    // Operación CRUD: Actualizar un chocolate
    public function actualizarChocolate(int $id): bool {
        try {
            $db = DB::getConnection();
            $query = "UPDATE dulces d JOIN chocolates c ON d.id = c.dulce_id 
                      SET d.nombre = :nombre, d.precio = :precio, d.categoria = :categoria, 
                          c.porcentajeCacao = :porcentajeCacao, c.peso = :peso 
                      WHERE c.id = :id";
            $stmt = $db->prepare($query);

            $nombre = $this->getNombre();
            $precio = $this->getPrecio();
            $categoria = $this->getCategoria();

            $stmt->bindParam(':nombre', $nombre);
            $stmt->bindParam(':precio', $precio);
            $stmt->bindParam(':categoria', $categoria);
            $stmt->bindParam(':porcentajeCacao', $this->porcentajeCacao);
            $stmt->bindParam(':peso', $this->peso);
            $stmt->bindParam(':id', $id);
            return $stmt->execute();
        } catch (PDOException $e) {
            echo "Error al actualizar el chocolate: " . $e->getMessage();
            return false;
        }
    }

    // Operación CRUD: Eliminar un chocolate
    public static function eliminarChocolate(int $id): bool {
        try {
            $db = DB::getConnection();
            $query = "DELETE c, d FROM chocolates c JOIN dulces d ON c.dulce_id = d.id WHERE c.id = :id";
            $stmt = $db->prepare($query);
            $stmt->bindParam(':id', $id);
            return $stmt->execute();
        } catch (PDOException $e) {
            echo "Error al eliminar el chocolate: " . $e->getMessage();
            return false;
        }
    }
}
?>
