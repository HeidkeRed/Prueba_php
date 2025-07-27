-- ==========================
-- Script completo con tablas y procedimiento
-- ==========================

CREATE DATABASE IF NOT EXISTS tienda1 CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;

USE tienda1;

DROP TABLE IF EXISTS comentarios;
DROP TABLE IF EXISTS accesorios;
DROP TABLE IF EXISTS productos;
DROP TABLE IF EXISTS categorias;

-- =====================================
-- Tabla de categorías (con anidación)
-- =====================================
CREATE TABLE categorias (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL,
    id_padre INT DEFAULT NULL,
    FOREIGN KEY (id_padre) REFERENCES categorias(id) ON DELETE SET NULL
);

INSERT INTO categorias (nombre, id_padre) VALUES 
('Laptops', NULL),
('Escritorio', NULL),
('Gaming', 1),
('Ultrabooks', 1),
('All-in-One', 2),
('Workstation', 2),
('Mini PC', 2),
('Convertible', 1),
('Chromebook', 1),
('Servidor', NULL);

-- ==========================
-- Tabla de productos
-- ==========================
CREATE TABLE productos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    modelo VARCHAR(100) NOT NULL,
    especificaciones TEXT NOT NULL,
    marca VARCHAR(100) NOT NULL,
    precio DECIMAL(10, 2) NOT NULL,
    id_categoria INT NOT NULL,
    FOREIGN KEY (id_categoria) REFERENCES categorias(id)
);

-- Agregar columna de visitas a productos
ALTER TABLE productos ADD visitas INT DEFAULT 0;

-- Agregar columnas de metainformación y likes
ALTER TABLE productos
ADD fecha_registro DATETIME DEFAULT CURRENT_TIMESTAMP,
ADD fecha_modificacion DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
ADD likes INT DEFAULT 0;

INSERT INTO productos (modelo, especificaciones, precio, id_categoria) VALUES
('Dell Inspiron 15', 'Intel i5, 8GB RAM, 256GB SSD', 12999.00, 1),
('HP Pavilion x360', 'Intel i3, 4GB RAM, 128GB SSD, pantalla táctil', 11499.00, 8),
('Lenovo IdeaCentre AIO', 'AMD Ryzen 5, 8GB RAM, 1TB HDD', 15299.00, 5),
('ASUS ROG Strix', 'Intel i7, 16GB RAM, RTX 3060, 512GB SSD', 25999.00, 3),
('MacBook Air M1', 'Apple M1, 8GB RAM, 256GB SSD', 23999.00, 4),
('Acer Aspire 5', 'Intel i5, 8GB RAM, 512GB SSD', 13599.00, 1),
('Dell OptiPlex 3080', 'Intel i5, 8GB RAM, 1TB HDD', 11899.00, 2),
('MSI Modern 14', 'Intel i7, 16GB RAM, 512GB SSD', 17499.00, 4),
('HP Chromebox G3', 'Intel Celeron, 4GB RAM, 32GB eMMC', 8999.00, 9),
('Lenovo ThinkStation', 'Intel Xeon, 32GB RAM, 1TB SSD', 38999.00, 6);

-- ==========================
-- Tabla de comentarios
-- ==========================
CREATE TABLE comentarios (
    id INT AUTO_INCREMENT PRIMARY KEY,
    texto TEXT NOT NULL,
    nombre VARCHAR(100) NOT NULL,
    calificacion INT CHECK (calificacion BETWEEN 1 AND 5),
    id_producto INT NOT NULL,
    FOREIGN KEY (id_producto) REFERENCES productos(id)
);



-- ==========================
-- Tabla de accesorios
-- ==========================
CREATE TABLE accesorios (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL,
    descripcion TEXT NOT NULL,
    precio DECIMAL(10, 2) NOT NULL,
    id_categoria INT NOT NULL,
    FOREIGN KEY (id_categoria) REFERENCES categorias(id)
);

INSERT INTO accesorios (nombre, descripcion, precio, id_categoria) VALUES
('Mouse inalámbrico', 'Mouse óptico 2.4GHz USB', 299.00, 1),
('Teclado mecánico', 'Switches azules, retroiluminado', 849.00, 3),
('Monitor 24 pulgadas', 'Full HD IPS', 2299.00, 2),
('Base enfriadora', 'Con ventiladores dobles para laptop', 399.00, 1),
('SSD Externo 1TB', 'USB-C, alta velocidad', 1699.00, 2),
('Webcam Full HD', '1080p con micrófono integrado', 699.00, 5),
('Cargador universal', 'Compatible con la mayoría de laptops', 499.00, 1),
('Funda para laptop 15"', 'Material acolchonado', 349.00, 1),
('Kit limpieza PC', 'Aire comprimido, brochas y paño', 199.00, 2),
('Hub USB-C', '4 puertos USB 3.0', 459.00, 4);

-- ================================
-- Procedimiento almacenado calcular_mensualidad
-- ================================
DELIMITER $$

CREATE PROCEDURE calcular_mensualidad(
    IN precio_in DECIMAL(10,2),
    IN meses_in INT,
    OUT mensualidad_out DECIMAL(10,2)
)
BEGIN
    DECLARE tasa_anual DECIMAL(5,4) DEFAULT 0.10;
    DECLARE tasa_mensual DECIMAL(10,8);
    DECLARE numerador DECIMAL(20,10);
    DECLARE denominador DECIMAL(20,10);

    SET tasa_mensual = tasa_anual / 12;

    SET numerador = tasa_mensual * POW(1 + tasa_mensual, meses_in);
    SET denominador = POW(1 + tasa_mensual, meses_in) - 1;

    SET mensualidad_out = ROUND(precio_in * (numerador / denominador), 2);
END $$

DELIMITER ;
