<?php
require_once '../php/controllers/ProductoController.php';

$idProducto = $_GET['id'] ?? null;
if (!$idProducto) {
    die("ID de producto inválido");
}

$controller = new ProductoController();
$controller->mostrarProducto($idProducto);
