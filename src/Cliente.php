<?php

require_once 'Dulce.php';

class Cliente {
    // Constructor con promoción de propiedades
    public function __construct(
        private string $nombre,
        private string $numero,
        private int $numPedidosEfectuados = 0,
        private array $dulcesComprados = [], // Array de objetos Dulce
        private array $comentarios = []      // Array para guardar comentarios sobre los dulces
    ) {}

    // Getters
    public function getNombre(): string {
        return $this->nombre;
    }

    public function getNumero(): string {
        return $this->numero;
    }

    public function getNumPedidosEfectuados(): int {
        return $this->numPedidosEfectuados;
    }

    public function getDulcesComprados(): array {
        return $this->dulcesComprados;
    }

    // Método listaDeDulces
    public function listaDeDulces(Dulce $d): bool {
        return in_array($d, $this->dulcesComprados, true);
    }

    // Método comprar
    public function comprar(Dulce $d): bool {
        if ($this->listaDeDulces($d)) {
            echo "El dulce ya ha sido comprado anteriormente. Agregado nuevamente.<br>";
        } else {
            echo "Nuevo dulce agregado al carrito.<br>";
        }
        $this->dulcesComprados[] = $d;
        $this->numPedidosEfectuados++;  // Actualizamos el número de pedidos cada vez que se compra un dulce
        return true;
    }

    // Método valorar
    public function valorar(Dulce $d, string $comentario): void {
        if ($this->listaDeDulces($d)) {
            $this->comentarios[spl_object_hash($d)] = $comentario;
            echo "Comentario añadido al dulce: \"" . $d->getNombre() . "\".<br>";
        } else {
            echo "No se puede valorar un dulce que no se ha comprado.<br>";
        }
    }

    // Método listarPedidos
    public function listarPedidos(): void {
        echo "El cliente " . $this->nombre . " ha realizado " . $this->numPedidosEfectuados . " pedidos:<br>";
        foreach ($this->dulcesComprados as $index => $dulce) {
            echo ($index + 1) . ". " . $dulce->getNombre();
            if (isset($this->comentarios[spl_object_hash($dulce)])) {
                echo " - Comentario: " . $this->comentarios[spl_object_hash($dulce)];
            }
            echo "<br><br>";
        }
    }

    // Método para mostrar el resumen del cliente
    public function muestraResumen(): void {
        echo "Cliente.php: <br>";
        echo "Nombre: " . $this->nombre . "<br>";
        echo "Número de pedidos efectuados: " . $this->numPedidosEfectuados . "<br>";
        echo "<br><br>";
    }

}
