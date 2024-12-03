<?php

class Dulce {
    // Constructor con promoción de propiedades
    public function __construct(
        private string $nombre,
        private float $precio,
        private string $categoria
    ) {}

    // Atributo estático para el IVA
    private static float $IVA = 0.21;

    // Getters
    public function getNombre(): string {
        return $this->nombre;
    }

    public function getPrecio(): float {
        return $this->precio;
    }

    public function getCategoria(): string {
        return $this->categoria;
    }

    // Método para obtener el IVA
    public static function getIVA(): float {
        return self::$IVA;
    }

    // Método para mostrar el resumen del dulce
    public function mostrarResumen(): void {
        echo "Dulce.php: <br>";
        echo "Nombre: " . $this->getNombre() . "<br>";
        echo "Precio: " . $this->getPrecio() . "€<br>";
        echo "Categoría: " . $this->getCategoria() . "<br>";
        echo "IVA: " . (self::getIVA() * 100) . "%<br>";
        echo "<br><br>";
    }
}

// Creación de objeto de la clase Dulce
$dulce = new Dulce("Tarta de Fresa", 15.50, "Tartas");

// Llamada al método mostrarResumen
$dulce->mostrarResumen();

?>
