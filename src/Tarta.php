<?php

require_once 'Dulce.php';

class Tarta extends Dulce {
    // Atributos 
    private $relleno;  // Array de rellenos (uno por piso)
    private $numeroDePisos;
    private $minNumComensales;
    private $maxNumComensales;

    // Sobrescribir el constructor
    public function __construct($nombre, $precio, $categoria, $numeroDePisos, $relleno, $minNumComensales = 2, $maxNumComensales = 10) {
        // Llamar al constructor de la clase base Dulce
        parent::__construct($nombre, $precio, $categoria);
        $this->numeroDePisos = $numeroDePisos;
        $this->relleno = $relleno;
        $this->minNumComensales = $minNumComensales;
        $this->maxNumComensales = $maxNumComensales;
    }

    // Método para mostrar el rango de comensales posibles
    public function muestraComensalesPosibles() {
        if ($this->minNumComensales == $this->maxNumComensales) {
            echo "Para " . $this->minNumComensales . " comensales<br>";
        } elseif ($this->minNumComensales == 2 && $this->maxNumComensales > 2) {
            echo "Para dos comensales<br>";
        } else {
            echo "De " . $this->minNumComensales . " a " . $this->maxNumComensales . " comensales<br>";
        }
    }

    // Sobrescribir el método muestraResumen para mostrar la información de la tarta
    public function muestraResumen() {
        echo "Nombre: " . $this->getNombre() . "<br>";
        echo "Precio: " . $this->getPrecio() . "€<br>";
        echo "Categoría: " . $this->getCategoria() . "<br>";
        echo "Número de pisos: " . $this->numeroDePisos . "<br>";
        echo "Rellenos: " . implode(", ", $this->relleno) . "<br>";
        echo "IVA: " . (Dulce::getIVA() * 100) . "%<br>";
        $this->muestraComensalesPosibles();
    }
}

// Creación de objeto de la clase Tarta
$rellenos = ["Fresa", "Crema", "Chocolate"];
$tarta = new Tarta("Tarta de Tres Pisos", 25.00, "Tartas", 3, $rellenos, 3, 6);
$tarta->muestraResumen();

?>
