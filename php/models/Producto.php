<?php
require_once 'Conexion.php';

class Producto
{
    private $pdo;

    public function __construct()
    {
        $this->pdo = Conexion::conectar();
    }

    public function obtenerTodosConPromedio()
    {
        $sql = "
            SELECT p.id, p.modelo, p.especificaciones, p.precio,
                   ROUND(AVG(c.calificacion), 2) AS promedio_calificacion
            FROM productos p
            LEFT JOIN comentarios c ON p.id = c.id_producto
            GROUP BY p.id
            ORDER BY promedio_calificacion DESC
        ";
        $stmt = $this->pdo->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function obtenerComentariosPorProducto()
    {
        $sql = "SELECT id_producto, texto, nombre, calificacion FROM comentarios ORDER BY id_producto";
        $stmt = $this->pdo->query($sql);
        $comentarios = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $comentariosPorProducto = [];
        foreach ($comentarios as $c) {
            $comentariosPorProducto[$c['id_producto']][] = $c;
        }
        return $comentariosPorProducto;
    }

    public static function obtenerCatalogoAleatorioPorCategoria($idCategoria, $limite = 10)
    {
        $conn = Conexion::conectar();

        $sql = "SELECT * FROM productos WHERE id_categoria = :categoria ORDER BY RAND() LIMIT :limite";
        $stmt = $conn->prepare($sql);
        $stmt->bindValue(':categoria', $idCategoria, PDO::PARAM_INT);
        $stmt->bindValue(':limite', $limite, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchAll();
    }

    public function obtenerProductosAleatorios($limite = 10)
    {
        $sql = "SELECT * FROM productos ORDER BY RAND() LIMIT :limite";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':limite', $limite, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function obtenerProductosMejorCalificados($limite = 10)
    {
        $sql = "
        SELECT p.id, p.modelo, p.marca, p.precio, p.visitas, p.likes,
               ROUND(AVG(c.calificacion), 2) AS promedio_calificacion
        FROM productos p
        LEFT JOIN comentarios c ON p.id = c.id_producto
        GROUP BY p.id
        ORDER BY promedio_calificacion DESC
        LIMIT :limite
    ";

        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':limite', $limite, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }


    public function vistaProducto($idProducto)
    {
        $sql = "
        SELECT
            p.id as producto_id,
            p.modelo,
            p.marca,
            p.precio,
            p.especificaciones,
            c.nombre AS nombre_comentario,
            c.texto AS texto_comentario,
            c.calificacion
            FROM productos p
            LEFT JOIN comentarios c ON c.id_producto = p.id
            WHERE p.id = ?
    ";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$idProducto]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    public function calcularMensualidad($precio, $meses)
    {
        $stmt = $this->pdo->prepare("CALL calcular_mensualidad(:precio_in, :meses_in, @mensualidad_out)");
        $stmt->bindValue(':precio_in', $precio);
        $stmt->bindValue(':meses_in', $meses, PDO::PARAM_INT);
        $stmt->execute();

        $result = $this->pdo->query("SELECT @mensualidad_out AS mensualidad")->fetch(PDO::FETCH_ASSOC);

        return $result['mensualidad'] ?? 0;
    }

    public function obtenerPrecioPorId($idProducto)
    {
        $sql = "SELECT precio FROM productos WHERE id = ?";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$idProducto]);
        $resultado = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($resultado) {
            return $resultado['precio'];
        } else {
            return null; // Producto no encontrado
        }
    }


    // Funciones para paginacion por subcategoria
    public function obtenerProductosAleatoriosPorCategoria($idCategoria, $inicio = 0, $porPagina = 10)
    {
        $inicio = (int) $inicio;
        $porPagina = (int) $porPagina;

        $sql = "SELECT * FROM productos WHERE id_categoria = :idCategoria ORDER BY RAND() LIMIT $inicio, $porPagina";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':idCategoria', $idCategoria, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }


    public function obtenerProductosMejorCalificadosPorCategoria($idCategoria, $inicio = 0, $porPagina = 10)
    {
        $inicio = (int) $inicio;
        $porPagina = (int) $porPagina;

        $sql = "
    SELECT p.id, p.modelo, p.marca, p.precio, p.visitas, p.likes,
           ROUND(AVG(c.calificacion), 2) AS promedio_calificacion
    FROM productos p
    LEFT JOIN comentarios c ON p.id = c.id_producto
    WHERE p.id_categoria = :idCategoria
    GROUP BY p.id
    ORDER BY promedio_calificacion DESC
    LIMIT $inicio, $porPagina
    ";

        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':idCategoria', $idCategoria, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function contarProductosPorCategoria($idCategoria)
    {
        $sql = "SELECT COUNT(*) FROM productos WHERE id_categoria = :idCategoria";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':idCategoria', $idCategoria, PDO::PARAM_INT);
        $stmt->execute();

        return (int) $stmt->fetchColumn();
    }

    public function aumentarLikes($idProducto)
    {
        $sql = "UPDATE productos SET likes = likes + 1 WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':id', $idProducto, PDO::PARAM_INT);
        return $stmt->execute();
    }

    public function incrementarVisitas($idProducto)
    {
        $sql = "UPDATE productos SET visitas = visitas + 1 WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':id', $idProducto, PDO::PARAM_INT);
        return $stmt->execute();
    }
    

}

if (isset($_GET['accion']) && $_GET['accion'] === 'like' && isset($_GET['id'])) {
    require_once '../models/Producto.php'; // Ajusta la ruta si es diferente

    $producto = new Producto();
    $id = intval($_GET['id']);

    if ($producto->aumentarLikes($id)) {
        echo 'ok'; // Puedes no devolver nada si no te interesa
    } else {
        echo 'error';
    }

    exit;
}
