<?php

class Dulce {
    // Atributos
    private $nombre;
    private $precio;
    private $categoria;
    private static $IVA = 0.21;

    // Constructor para inicializar propiedades
    public function __construct($nombre, $precio, $categoria) {
        $this->nombre = $nombre;
        $this->precio = $precio;
        $this->categoria = $categoria;
    }

    // Getters
    public function getNombre() {
        return $this->nombre;
    }

    public function getPrecio() {
        return $this->precio;
    }

    public function getCategoria() {
        return $this->categoria;
    }

    // Método para obtener el IVA
    public static function getIVA() {
        return self::$IVA;
    }
}

// Creación de objeto de la clase Dulce
$dulce = new Dulce("Tarta de Fresa", 15.50, "Tartas");

// Mostrar las propiedades por pantalla
echo "Nombre: " . $dulce->getNombre() . "<br>";
echo "Precio: " . $dulce->getPrecio() . "€<br>";
echo "Categoría: " . $dulce->getCategoria() . "<br>";
echo "IVA: " . (Dulce::getIVA() * 100) . "%<br>";

?>
