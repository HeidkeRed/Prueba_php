<?php
require_once '../php/controllers/ProductoController.php';

$idCategoria = $_GET['id_categoria'] ?? null;
$modo = $_GET['modo'] ?? 'aleatorios';
$pagina = $_GET['pagina'] ?? 1;

if (!$idCategoria) {
    die("Categoría inválida");
}

$controller = new ProductoController();
$controller->mostrarCatalogo($idCategoria, $modo, $pagina);
