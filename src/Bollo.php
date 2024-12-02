<?php

require_once "Dulce.php";

class Bollo extends Dulce {
    // Atributos
    private $relleno;

    // Sobrescribir el constructor
    public function __construct($nombre, $precio, $categoria, $relleno) {
        // Llamar al constructor de la clase base Dulce
        parent::__construct($nombre, $precio, $categoria);
        $this->relleno = $relleno;
    }

    // Método sobrescrito para mostrar el resumen del bollo
    public function muestraResumen() {
        echo "Nombre: " . $this->getNombre() . "<br>";
        echo "Precio: " . $this->getPrecio() . "€<br>";
        echo "Categoría: " . $this->getCategoria() . "<br>";
        echo "Relleno: " . $this->relleno . "<br>";
        echo "IVA: " . (Dulce::getIVA() * 100) . "%<br>";
    }
}

// Creación de objeto de la clase Bollo
$bollo = new Bollo("Bollo de Chocolate", 2.50, "Bollos", "Chocolate con leche");
$bollo->muestraResumen();

?>
