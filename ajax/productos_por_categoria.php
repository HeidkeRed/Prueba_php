<?php
require_once(__DIR__ . '/../php/models/Producto.php');

$idCategoria = $_GET['id_categoria'] ?? null;

if ($idCategoria === null) {
    echo json_encode(['error' => 'Falta ID']);
    exit;
}

$productoModel = new Producto();

$destacados = $productoModel->obtenerProductosAleatoriosPorCategoria($idCategoria);
$calificados = $productoModel->obtenerProductosMejorCalificadosPorCategoria($idCategoria);

echo json_encode([
    'destacados' => $destacados,
    'calificados' => $calificados
]);
