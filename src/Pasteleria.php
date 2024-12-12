<?php

class Pasteleria
{
    private array $productos = [];
    private array $clientes = [];

    public function incluirDulce(Dulce $dulce): void
    {
        $this->productos[] = $dulce;
        echo "Producto incluido: {$dulce->getNombre()}<br>";
    }

    public function incluirCliente(Cliente $cliente): void
    {
        $this->clientes[] = $cliente;
        echo "Cliente incluido: {$cliente->getNombre()}<br>";
    }

    public function listarProductos(): void
    {
        foreach ($this->productos as $producto) {
            $producto->muestraResumen();
        }
    }

    public function listarClientes(): void
    {
        foreach ($this->clientes as $cliente) {
            echo "Cliente: {$cliente->getNombre()}<br>";
        }
    }
}
