<?php

require_once "Dulce.php";

class Bollo extends Dulce {
    // Atributos promovidos al constructor
    public function __construct(
        string $nombre, 
        float $precio, 
        string $categoria, 
        private string $relleno
    ) {
        // Llamar al constructor de la clase base Dulce
        parent::__construct($nombre, $precio, $categoria);
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
}

// Creación de objeto de la clase Bollo
$bollo = new Bollo("Bollo de Chocolate", 2.50, "Bollos", "Chocolate con leche");
$bollo->muestraResumen();

?>
