<?php
require_once '../php/controllers/ProductoController.php';

$categoriaId = isset($_GET['categoria']) ? (int)$_GET['categoria'] : 1;
$meses = isset($_GET['meses']) ? (int)$_GET['meses'] : 12;

$productos = ProductoController::verCatalogoPorCategoria($categoriaId, 10);

include 'views/catalogo_random_msi_view.php';
