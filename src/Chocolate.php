<?php

require_once "Dulce.php";

class Chocolate extends Dulce {
    // Atributos
    private $porcentajeCacao;
    private $peso;

    // Sobrescribir el constructor
    public function __construct($nombre, $precio, $categoria, $porcentajeCacao, $peso) {
        // Llamar al constructor de la clase base Dulce
        parent::__construct($nombre, $precio, $categoria);
        $this->porcentajeCacao = $porcentajeCacao;
        $this->peso = $peso;
    }

    // Método para mostrar el resumen del chocolate
    public function muestraResumen() {
        echo "Nombre: " . $this->getNombre() . "<br>";
        echo "Precio: " . $this->getPrecio() . "€<br>";
        echo "Categoría: " . $this->getCategoria() . "<br>";
        echo "Porcentaje de Cacao: " . $this->porcentajeCacao . "%<br>";
        echo "Peso: " . $this->peso . "g<br>";
        echo "IVA: " . (Dulce::getIVA() * 100) . "%<br>";
    }
}

// Creación de objeto de la clase Chocolate
$chocolate = new Chocolate("Chocolate Negro", 5.00, "Chocolates", 90, 98);
$chocolate->muestraResumen();

?>
