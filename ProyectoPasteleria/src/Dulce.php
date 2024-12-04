<?php

require_once "Resumible.php";

// Clase abstracta Dulce implementando la interfaz Resumible
abstract class Dulce implements Resumible {
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

    // Implementación del método muestraResumen() desde la interfaz
    public function muestraResumen(): void {
        echo "Dulce.php: <br>";
        echo "Nombre: " . $this->getNombre() . "<br>";
        echo "Precio: " . $this->getPrecio() . "€<br>";
        echo "Categoría: " . $this->getCategoria() . "<br>";
        echo "IVA: " . (self::getIVA() * 100) . "%<br>";
        echo "<br><br>";
    }
}
/* Convertir "Dulce" en abstracta permite:
 1. Evitar que se creen instancias directas de `Dulce`.
 2. Forzar a las clases hijas a implementar ciertos métodos clave.
 Esto mejora la estructura y asegura que cada clase derivada cumpla con un contrato común.*/
 
/*
 * Al hacer que "Dulce" implemente la interfaz `Resumible`, forzamos a todas las clases
 * que heredan de `Dulce` a implementar el método `muestraResumen()`. Sin embargo, 
 * las clases hijas pueden sobrescribir este método si necesitan una implementación específica.
 */
?>


