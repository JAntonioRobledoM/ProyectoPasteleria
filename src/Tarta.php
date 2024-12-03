<?php

require_once 'Dulce.php';

class Tarta extends Dulce {
    // Atributos 
    public function __construct(
        private string $nombre, 
        private float $precio, 
        private string $categoria, 
        private int $numeroDePisos, 
        private array $relleno, 
        private int $minNumComensales = 2, 
        private int $maxNumComensales = 10
    ) {
        // Llamar al constructor de la clase base Dulce
        parent::__construct($nombre, $precio, $categoria);
    }

    // Método para mostrar el rango de comensales posibles
    public function muestraComensalesPosibles(): void {
        if ($this->minNumComensales == $this->maxNumComensales) {
            echo "Para " . $this->minNumComensales . " comensales<br>";
        } elseif ($this->minNumComensales == 2 && $this->maxNumComensales > 2) {
            echo "Para dos comensales<br>";
        } else {
            echo "De " . $this->minNumComensales . " a " . $this->maxNumComensales . " comensales<br>";
        }
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
}

// Creación de objeto de la clase Tarta
$rellenos = ["Fresa", "Crema", "Chocolate"];
$tarta = new Tarta("Tarta de Tres Pisos", 25.00, "Tartas", 3, $rellenos, 3, 6);
$tarta->muestraResumen();

?>
