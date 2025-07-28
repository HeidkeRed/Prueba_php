<?php
require_once '../php/controllers/ProductoController.php';

$controller = new ProductoController();
$data = $controller->listar();

