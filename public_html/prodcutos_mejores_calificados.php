<?php
require_once '../php/controllers/ProductoController.php';

$controller = new ProductoController();
$data = $controller->listar();

require '../views/productos_mejores_calificados.php';
