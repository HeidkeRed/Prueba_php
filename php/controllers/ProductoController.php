<?php
require_once __DIR__ . '/../models/Producto.php';

class ProductoController
{
    public function listar()
    {
        $productoModel = new Producto();

        $productos = $productoModel->obtenerTodosConPromedio();
        $comentariosPorProducto = $productoModel->obtenerComentariosPorProducto();

        include __DIR__ . '/../../public_html/views/productos_view.php';
    }

    public function mostrarProducto($idProducto)
    {
        $productoModel = new Producto();
        $datosProducto = $productoModel->vistaProducto($idProducto);

        if (!$datosProducto || count($datosProducto) === 0) {
            echo "Producto no encontrado";
            return;
        }

        $primeraFila = $datosProducto[0];

        $productoInfo = [
            'id' => $primeraFila['producto_id'] ?? null,
            'modelo' => $primeraFila['modelo'] ?? '',
            'marca' => $primeraFila['marca'] ?? '',
            'precio' => $primeraFila['precio'] ?? '',
            'especificaciones' => $primeraFila['especificaciones'] ?? '',
        ];

        $comentarios = [];
        foreach ($datosProducto as $fila) {
            if (!empty($fila['nombre_comentario'])) {
                $comentarios[] = [
                    'nombre' => $fila['nombre_comentario'] ?? '',
                    'texto' => $fila['texto_comentario'] ?? '',
                    'calificacion' => $fila['calificacion'] ?? '',
                ];
            }
        }
        $visita = $productoModel->incrementarVisitas($idProducto);
        // Calcular mensualidades
        $mensualidad12 = $productoModel->calcularMensualidad($productoInfo['precio'], 12);
        $mensualidad6 = $productoModel->calcularMensualidad($productoInfo['precio'], 6);



        include __DIR__ . '/../../public_html/views/producto_detalle_view.php';
    }
    public function mostrarCatalogo($idCategoria, $modo = 'aleatorios', $pagina = 1)
    {
        $porPagina = 9;
        $inicio = ($pagina - 1) * $porPagina;

        $productoModel = new Producto();

        if ($modo === 'calificados') {
            $productos = $productoModel->obtenerProductosMejorCalificadosPorCategoria($idCategoria, $inicio, $porPagina);
        } else {
            $productos = $productoModel->obtenerProductosAleatoriosPorCategoria($idCategoria, $inicio, $porPagina);
        }

        $totalProductos = $productoModel->contarProductosPorCategoria($idCategoria);
        $totalPaginas = ceil($totalProductos / $porPagina);

        require '../public_html/views/catalogo_categoria_view.php';
    }
    public function aumentarLikeProducto($idProducto)
    {
        $producto = new Producto();
        $producto->aumentarLikes($idProducto);
    }




    public static function verCatalogoMSIPorCategoria($idCategoria, $limite = 10)
    {
        $categoriaId = isset($_GET['categoria']) ? (int)$_GET['categoria'] : 1;
        $meses = isset($_GET['meses']) ? (int)$_GET['meses'] : 12;
        $productos = Producto::obtenerCatalogoAleatorioPorCategoria($idCategoria, $limite);
        // Haz disponible la variable $productos para la vista
        include __DIR__ . '/../../public_html/views/catalogo_random_msi_view.php';
    }
}
