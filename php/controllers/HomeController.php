<?php
require_once __DIR__ . '/../models/Categoria.php';
require_once __DIR__ . '/../models/Producto.php';

class HomeController {
    private $categoriaModel;
    private $productoModel;

    public function __construct() {
        $this->categoriaModel = new Categoria();
        $this->productoModel = new Producto();
    }

    public function index() {
        // Categorías padres
        $categoriasPadre = $this->categoriaModel->obtenerCategoriasPadre();

        // Productos destacados: 10 productos aleatorios
        $productosDestacados = $this->productoModel->obtenerProductosAleatorios(10);

         $productosMejorCalificados = $this->productoModel->obtenerProductosMejorCalificados(10);

        require __DIR__ . '/../../public_html/views/home_view.php';
    }
}
