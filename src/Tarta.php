<?php

require_once 'Dulce.php';
require_once __DIR__ . '/../db/DB.php';

class Tarta extends Dulce {
    // Atributos
    private int $id;

    public function __construct(
        private string $nombre, 
        private float $precio, 
        private string $categoria, 
        private int $numeroDePisos, 
        private array $relleno, 
        private int $minNumComensales = 2, 
        private int $maxNumComensales = 10,
        int $id = 0 
    ) {
        parent::__construct($nombre, $precio, $categoria);
        $this->id = $id;
    }

    // Métodos CRUD

    // Crear (Insertar una nueva tarta en la base de datos)
    public function guardar(): bool {
        $pdo = DB::getConnection(); // Obtener conexión a la base de datos

        if ($this->id) {
            // Si ya tiene un id, actualizamos la tarta
            return $this->actualizar();
        }

        // Insertar la tarta en la base de datos
        $stmt = $pdo->prepare('INSERT INTO productos (nombre, precio, categoria, numeroDePisos, relleno, minNumComensales, maxNumComensales) 
                               VALUES (:nombre, :precio, :categoria, :numeroDePisos, :relleno, :minNumComensales, :maxNumComensales)');
        $stmt->bindParam(':nombre', $this->nombre);
        $stmt->bindParam(':precio', $this->precio);
        $stmt->bindParam(':categoria', $this->categoria);
        $stmt->bindParam(':numeroDePisos', $this->numeroDePisos);
        $stmt->bindParam(':relleno', implode(", ", $this->relleno)); // Guardamos los rellenos como un string
        $stmt->bindParam(':minNumComensales', $this->minNumComensales);
        $stmt->bindParam(':maxNumComensales', $this->maxNumComensales);

        if ($stmt->execute()) {
            $this->id = $pdo->lastInsertId(); // Asignamos el ID recién creado
            echo "Tarta guardada con éxito.<br>";
            return true;
        }

        echo "Error al guardar la tarta.<br>";
        return false;
    }

    // Leer (Obtener una tarta de la base de datos por ID)
    public static function obtenerPorId(int $id): ?Tarta {  // Cambiar a estático si lo prefieres
        $pdo = DB::getConnection();
        $stmt = $pdo->prepare('SELECT * FROM productos WHERE id = :id AND categoria = "Tartas" LIMIT 1');
        $stmt->bindParam(':id', $id);
        $stmt->execute();

        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($result) {
            $relleno = explode(", ", $result['relleno']); // Convertimos el string de rellenos a un array
            return new Tarta($result['nombre'], $result['precio'], $result['categoria'], 
                             $result['numeroDePisos'], $relleno, $result['minNumComensales'], 
                             $result['maxNumComensales'], $result['id']);
        }

        return null; // Si no se encuentra la tarta
    }

    // Actualizar (Actualizar los detalles de una tarta en la base de datos)
    public function actualizar(): bool {
        if (!$this->id) {
            echo "Tarta no encontrada.<br>";
            return false;
        }

        $pdo = DB::getConnection();
        $stmt = $pdo->prepare('UPDATE productos 
                               SET nombre = :nombre, precio = :precio, categoria = :categoria, 
                                   numeroDePisos = :numeroDePisos, relleno = :relleno, 
                                   minNumComensales = :minNumComensales, maxNumComensales = :maxNumComensales
                               WHERE id = :id');
        $stmt->bindParam(':nombre', $this->nombre);
        $stmt->bindParam(':precio', $this->precio);
        $stmt->bindParam(':categoria', $this->categoria);
        $stmt->bindParam(':numeroDePisos', $this->numeroDePisos);
        $stmt->bindParam(':relleno', implode(", ", $this->relleno)); // Guardamos los rellenos como un string
        $stmt->bindParam(':minNumComensales', $this->minNumComensales);
        $stmt->bindParam(':maxNumComensales', $this->maxNumComensales);
        $stmt->bindParam(':id', $this->id);

        if ($stmt->execute()) {
            echo "Tarta actualizada con éxito.<br>";
            return true;
        }

        echo "Error al actualizar la tarta.<br>";
        return false;
    }

    // Eliminar (Eliminar una tarta de la base de datos)
    public function eliminar(): bool {
        if (!$this->id) {
            echo "Tarta no encontrada.<br>";
            return false;
        }

        $pdo = DB::getConnection();
        $stmt = $pdo->prepare('DELETE FROM productos WHERE id = :id AND categoria = "Tartas"');
        $stmt->bindParam(':id', $this->id);

        if ($stmt->execute()) {
            echo "Tarta eliminada con éxito.<br>";
            return true;
        }

        echo "Error al eliminar la tarta.<br>";
        return false;
    }

    // Sobrescribir el método muestraResumen para mostrar la información de la tarta
    public function muestraResumen(): void {
        echo "Tarta.php: <br>";
        echo "Nombre: " . $this->getNombre() . "<br>";
        echo "Precio: " . $this->getPrecio() . "€<br>";
        echo "Categoría: " . $this->getCategoria() . "<br>";
        echo "Número de pisos: " . $this->numeroDePisos . "<br>";
        echo "Rellenos: " . implode(", ", $this->relleno) . "<br>";
        echo "IVA: " . (Dulce::getIVA() * 100) . "%<br>";
        $this->muestraComensalesPosibles();
        echo "<br><br>";
    }

    public function muestraComensalesPosibles(): void {
        if ($this->minNumComensales == $this->maxNumComensales) {
            echo "Para " . $this->minNumComensales . " comensales<br>";
        } elseif ($this->minNumComensales == 2 && $this->maxNumComensales > 2) {
            echo "Para dos comensales<br>";
        } else {
            echo "De " . $this->minNumComensales . " a " . $this->maxNumComensales . " comensales<br>";
        }
    }

    // Setter para precio
    public function setPrecio(float $precio): void {
        $this->precio = $precio;
    }
}

?>
