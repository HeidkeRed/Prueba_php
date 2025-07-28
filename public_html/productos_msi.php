<?php
require_once '../php/controllers/ProductoController.php';

$categoriaId = isset($_GET['categoria']) ? (int)$_GET['categoria'] : 1;
$productos = ProductoController::verCatalogoMSIPorCategoria($categoriaId, 10);

