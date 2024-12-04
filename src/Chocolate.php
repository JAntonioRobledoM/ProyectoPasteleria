<?php

require_once "Dulce.php";

class Chocolate extends Dulce {
    // Atributos promovidos al constructor
    public function __construct(
        string $nombre, 
        float $precio, 
        string $categoria, 
        private int $porcentajeCacao, 
        private int $peso
    ) {
        // Llamar al constructor de la clase base Dulce
        parent::__construct($nombre, $precio, $categoria);
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
}

// Creación de objeto de la clase Chocolate
$chocolate = new Chocolate("Chocolate Negro", 5.00, "Chocolates", 90, 98);
$chocolate->muestraResumen();

?>
