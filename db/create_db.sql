-- Creación de la base de datos
CREATE DATABASE IF NOT EXISTS pasteleria;
USE pasteleria;

-- Creación de la tabla para los dulces (clase Dulce)
CREATE TABLE IF NOT EXISTS dulces (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(255) NOT NULL,
    precio DECIMAL(10, 2) NOT NULL,
    descripcion TEXT NOT NULL,
    categoria VARCHAR(100) NOT NULL
);

-- Creación de la tabla para los bollos (hereda de Dulce)
CREATE TABLE IF NOT EXISTS bollos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    dulce_id INT,
    relleno VARCHAR(255) NOT NULL,
    FOREIGN KEY (dulce_id) REFERENCES dulces(id)
);

-- Creación de la tabla para los chocolates (hereda de Dulce)
CREATE TABLE IF NOT EXISTS chocolates (
    id INT AUTO_INCREMENT PRIMARY KEY,
    dulce_id INT,
    porcentajeCacao DECIMAL(5, 2) NOT NULL,
    peso DECIMAL(5, 2) NOT NULL,
    FOREIGN KEY (dulce_id) REFERENCES dulces(id)
);

-- Creación de la tabla para las tartas (hereda de Dulce)
CREATE TABLE IF NOT EXISTS tartas (
    id INT AUTO_INCREMENT PRIMARY KEY,
    dulce_id INT,
    rellenos TEXT NOT NULL, 
    numPisos INT NOT NULL,
    minNumComensales INT DEFAULT 2,
    maxNumComensales INT DEFAULT 10,
    FOREIGN KEY (dulce_id) REFERENCES dulces(id)
);

-- Creación de la tabla para los clientes
CREATE TABLE IF NOT EXISTS clientes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(255) NOT NULL,
    usuario VARCHAR(100) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    numPedidosEfectuados INT DEFAULT 0
);

-- Creación de la tabla para los pedidos de los clientes
CREATE TABLE IF NOT EXISTS pedidos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    cliente_id INT,
    dulce_id INT,
    fecha TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (cliente_id) REFERENCES clientes(id),
    FOREIGN KEY (dulce_id) REFERENCES dulces(id)
);

-- Creación de la tabla para las valoraciones de los dulces
CREATE TABLE IF NOT EXISTS valoraciones (
    id INT AUTO_INCREMENT PRIMARY KEY,
    cliente_id INT,
    dulce_id INT,
    comentario TEXT,
    fecha TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (cliente_id) REFERENCES clientes(id),
    FOREIGN KEY (dulce_id) REFERENCES dulces(id)
);
