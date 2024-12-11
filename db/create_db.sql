-- Creación de la base de datos
DROP DATABASE IF EXISTS pasteleria;
CREATE DATABASE IF NOT EXISTS pasteleria;
USE pasteleria;

CREATE TABLE IF NOT EXISTS clientes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(255) NOT NULL,
    numero VARCHAR(15) NOT NULL UNIQUE,
    num_pedidos INT DEFAULT 0
);

CREATE TABLE IF NOT EXISTS dulces (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(255) NOT NULL,
    precio DECIMAL(10, 2) NOT NULL,
    categoria ENUM('Bollería', 'Chocolates', 'Tartas') NOT NULL,
    relleno TEXT,
    porcentaje_cacao INT,
    peso INT,
    min_comensales INT DEFAULT 2,
    max_comensales INT DEFAULT 2
);

CREATE TABLE IF NOT EXISTS compras (
    id INT AUTO_INCREMENT PRIMARY KEY,
    cliente_id INT NOT NULL,
    dulce_id INT NOT NULL,
    fecha_compra TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (cliente_id) REFERENCES clientes(id),
    FOREIGN KEY (dulce_id) REFERENCES dulces(id)
);

-- Insertar un bollo
INSERT INTO dulces (nombre, precio, categoria, relleno) VALUES
('Bollo de chocolate', 1.50, 'Bollería', 'Chocolate');

-- Insertar un chocolate
INSERT INTO dulces (nombre, precio, categoria, porcentaje_cacao, peso) VALUES
('Chocolate oscuro', 2.00, 'Chocolates', 70, 100);

-- Insertar una tarta
INSERT INTO dulces (nombre, precio, categoria, relleno, min_comensales, max_comensales) VALUES
('Tarta de fresa', 20.00, 'Tartas', 'Fresa, nata', 2, 6);

-- Insertar clientes
INSERT INTO clientes (nombre, numero, num_pedidos) VALUES
('', '12345', 0),
('María López', '67890', 0),
('Carlos García', '11223', 0);

UPDATE clientes 
SET nombre = 'Usuario' 
WHERE numero = '12345'; 




