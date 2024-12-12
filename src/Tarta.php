<?php
require_once "Dulce.php";
class Tarta extends Dulce
{
    private array $relleno;
    private int $minNumComensales;
    private int $maxNumComensales;

    public function __construct(
        string $nombre,
        float $precio,
        string $categoria,
        array $relleno,
        int $minNumComensales = 2,
        int $maxNumComensales = 2
    ) {
        if ($minNumComensales > $maxNumComensales) {
            throw new InvalidArgumentException("El número mínimo de comensales no puede ser mayor que el máximo.");
        }

        parent::__construct($nombre, $precio, $categoria);
        $this->relleno = $relleno;
        $this->minNumComensales = $minNumComensales;
        $this->maxNumComensales = $maxNumComensales;
    }

    public function getRelleno(): array
    {
        return $this->relleno;
    }
    public function getMinComensales(): int
    {
        return $this->minNumComensales;
    }

    public function getMaxComensales(): int
    {
        return $this->maxNumComensales;
    }

    public function muestraResumen(): void
    {
        echo "Tarta: {$this->getNombre()}, Precio: {$this->getPrecio()}€, Comensales: {$this->minNumComensales}-{$this->maxNumComensales}.<br>";
        echo "Rellenos: " . implode(", ", $this->relleno) . "<br>";
    }

    public function muestraComensalesPosibles(): void
    {
        if ($this->minNumComensales === $this->maxNumComensales) {
            echo "Para {$this->minNumComensales} comensales.<br>";
        } else {
            echo "De {$this->minNumComensales} a {$this->maxNumComensales} comensales.<br>";
        }
    }
}
