<?php

require_once 'Dulce.php';
require_once __DIR__ . '/../util/DulceNoCompradoException.php';
require_once __DIR__ . '/../util/PasteleriaException.php';
require_once __DIR__ . '/../db/DB.php'; 

use util\DulceNoCompradoException; 
use util\ClienteNoEncontradoException;

class Cliente {
    private $pdo;
    private int $id;  

    // Constructor con atributos de usuario y contraseña
    public function __construct(
        private string $nombre,
        private string $numero, 
        private string $usuario,  
        private string $password, 
        private int $numPedidosEfectuados = 0,
        private array $dulcesComprados = [],
        private array $comentarios = [],   
        int $id = 0                         
    ) {
        $this->id = $id; 
        $this->pdo = DB::getConnection();
    }

    // Getters
    public function getNombre(): string {
        return $this->nombre;
    }

    public function getNumero(): string {
        return $this->numero;
    }

    public function getUsuario(): string {
        return $this->usuario;  
    }

    public function getPassword(): string {
        return $this->password;  
    }

    public function getNumPedidosEfectuados(): int {
        return $this->numPedidosEfectuados;
    }

    public function getDulcesComprados(): array {
        return $this->dulcesComprados;
    }

    public function getId(): int {
        return $this->id;
    }

    // Método para guardar el cliente en la base de datos
    public function guardar(): bool {
        // Verificar si el cliente ya existe
        $stmt = $this->pdo->prepare('SELECT id FROM clientes WHERE usuario = :usuario');
        $stmt->bindParam(':usuario', $this->usuario);
        $stmt->execute();
        $cliente = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($cliente) {
            // Si el cliente ya existe, asignamos el id
            $this->id = $cliente['id'];
            echo "Cliente ya registrado en la base de datos.<br>";
            return false;
        }

        // Insertar el cliente en la base de datos
        $stmt = $this->pdo->prepare('INSERT INTO clientes (nombre, usuario, password, numPedidosEfectuados) VALUES (:nombre, :usuario, :password, :numPedidosEfectuados)');
        $stmt->bindParam(':nombre', $this->nombre);
        $stmt->bindParam(':usuario', $this->usuario);
        $stmt->bindValue(':password', password_hash($this->password, PASSWORD_DEFAULT)); // Hash de la contraseña
        $stmt->bindParam(':numPedidosEfectuados', $this->numPedidosEfectuados);
        $stmt->execute();

        // Recuperar el id del cliente recién insertado
        $this->id = $this->pdo->lastInsertId();

        echo "Cliente registrado con éxito.<br>";
        return true;
    }

    // Método para registrar un pedido
    public function registrarPedido(): bool {
        $this->pdo->beginTransaction();

        try {
            // Insertar cada dulce comprado en la tabla de pedidos
            foreach ($this->dulcesComprados as $dulce) {
                $stmt = $this->pdo->prepare('INSERT INTO pedidos (cliente_id, dulce_id) VALUES ((SELECT id FROM clientes WHERE usuario = :usuario LIMIT 1), :dulce_id)');
                $stmt->bindParam(':usuario', $this->numero);
                $stmt->bindParam(':dulce_id', $dulce->getId()); // Asumimos que la clase Dulce tiene un método getId()
                $stmt->execute();
            }

            // Actualizar el número de pedidos efectuados
            $stmt = $this->pdo->prepare('UPDATE clientes SET numPedidosEfectuados = numPedidosEfectuados + 1 WHERE usuario = :usuario');
            $stmt->bindParam(':usuario', $this->numero);
            $stmt->execute();

            $this->pdo->commit();
            echo "Pedido registrado con éxito.<br>";
            return true;
        } catch (Exception $e) {
            $this->pdo->rollBack();
            echo "Error al registrar el pedido: " . $e->getMessage() . "<br>";
            return false;
        }
    }

    // Método comprar
    public function comprar(Dulce $d): self {
        if ($this->listaDeDulces($d)) {
            echo "El dulce ya ha sido comprado anteriormente. Agregado nuevamente.<br>";
        } else {
            echo "Nuevo dulce agregado al carrito.<br>";
        }
        $this->dulcesComprados[] = $d;
        $this->numPedidosEfectuados++; // Actualizamos el número de pedidos
        return $this; // Permite encadenar métodos
    }
    
    // Método para registrar una valoración
    public function valorar(Dulce $d, string $comentario): self {
        if (!$this->listaDeDulces($d)) {
            throw new DulceNoCompradoException("No se puede valorar un dulce que no se ha comprado: " . $d->getNombre());
        }

        // Guardar la valoración en la base de datos
        $stmt = $this->pdo->prepare('INSERT INTO valoraciones (cliente_id, dulce_id, comentario) VALUES ((SELECT id FROM clientes WHERE usuario = :usuario LIMIT 1), :dulce_id, :comentario)');
        $stmt->bindParam(':usuario', $this->numero);
        $stmt->bindParam(':dulce_id', $d->getId()); 
        $stmt->bindParam(':comentario', $comentario);
        $stmt->execute();

        echo "Comentario añadido al dulce: \"" . $d->getNombre() . "\".<br>";
        return $this;
    }

    // Método listarPedidosvv
    public function listarPedidos(): self {
        echo "El cliente " . $this->nombre . " ha realizado " . $this->numPedidosEfectuados . " pedidos:<br>";
        foreach ($this->dulcesComprados as $index => $dulce) {
            echo ($index + 1) . ". " . $dulce->getNombre();
            if (isset($this->comentarios[spl_object_hash($dulce)])) {
                echo " - Comentario: " . $this->comentarios[spl_object_hash($dulce)];
            }
            echo "<br><br>";
        }
        return $this;
    }

    // Método para mostrar el resumen del cliente
    public function muestraResumen(): void {
        echo "Cliente.php: <br>";
        echo "Nombre: " . $this->nombre . "<br>";
        echo "Número de pedidos efectuados: " . $this->numPedidosEfectuados . "<br>";
        echo "<br><br>";
    }

    // Método para verificar si el cliente ha comprado un dulce
    private function listaDeDulces(Dulce $d): bool {
        return in_array($d, $this->dulcesComprados, true);
    }
}
?>
