<?php
require_once __DIR__ . '/../php/models/Conexion.php';

$log_file = __DIR__ . '/init_db.log';
$log = [];
$insertados = [
    'categorias' => 0,
    'accesorios' => 0,
    'productos' => 0,
    'comentarios' => 0
];

$nombres = ['Laptop', 'Monitor', 'Teclado', 'Mouse', 'Impresora', 'Tablet', 'Smartphone', 'Servidor'];
$marcas = ['Dell', 'HP', 'Asus', 'Lenovo', 'Samsung', 'Apple', 'Acer', 'MSI'];
$modelos = ['X100', 'Pro200', 'Elite15', 'GTX750', 'ZBook', 'ThinkPad', 'AirMax', 'GalaxyS'];
$especificaciones = [
    'Intel Core i7, 16GB RAM, SSD 512GB',
    'AMD Ryzen 5, 8GB RAM, HDD 1TB',
    'Pantalla 4K, HDMI, USB-C',
    'Teclado mecánico RGB, conexión USB',
    'Resolución 1080p, láser color',
    'Bluetooth 5.0, batería 10h',
    'Pantalla táctil, WiFi 6',
    'GPU RTX 3060, almacenamiento NVMe 1TB'
];

$comentariosLorem = [
    "Lorem ipsum dolor sit amet, consectetur adipiscing elit.",
    "Praesent sit amet tellus nec metus sodales sollicitudin.",
    "Donec a quam et augue efficitur lacinia.",
    "Suspendisse potenti. Vestibulum ante ipsum primis in.",
    "Aliquam erat volutpat. Curabitur suscipit blandit nulla.",
    "Nunc in justo a turpis pharetra luctus.",
    "Etiam ut eros id magna dapibus varius.",
    "Vivamus fermentum urna sed felis feugiat, a congue massa commodo.",
    "Fusce et sem sed justo rhoncus porttitor.",
    "Mauris quis libero ac massa vestibulum accumsan."
];

try {
    $pdo = Conexion::conectar();

    // Categorías
    for ($i = 1; $i <= 10; $i++) {
        $stmt = $pdo->prepare("INSERT INTO categorias (nombre) VALUES (:nombre)");
        $stmt->execute(['nombre' => "Categoría $i"]);
        $insertados['categorias']++;
    }

    // Accesorios
    for ($i = 1; $i <= 10; $i++) {
        $stmt = $pdo->prepare("INSERT INTO accesorios (nombre, descripcion, precio, id_categoria) VALUES (:nombre, :descripcion, :precio, :id_categoria)");
        $stmt->execute([
            'nombre' => "Accesorio $i",
            'descripcion' => "Descripción del accesorio $i",
            'precio' => rand(100, 1000),
            'id_categoria' => rand(1, 10),
        ]);
        $insertados['accesorios']++;
    }

    // Productos básicos
    for ($i = 1; $i <= 10; $i++) {
        $stmt = $pdo->prepare("INSERT INTO productos (modelo, especificaciones, precio, id_categoria) VALUES (:modelo, :especificaciones, :precio, :id_categoria)");
        $stmt->execute([
            'modelo' => "Producto $i",
            'especificaciones' => "Especificaciones del producto $i",
            'precio' => rand(500, 5000),
            'id_categoria' => rand(1, 10),
        ]);
        $insertados['productos']++;
    }

    // Comentarios básicos
    for ($i = 1; $i <= 10; $i++) {
        $stmt = $pdo->prepare("INSERT INTO comentarios (texto, nombre, calificacion, id_producto) VALUES (:texto, :nombre, :calificacion, :id_producto)");
        $stmt->execute([
            'texto' => "Comentario $i sobre producto",
            'nombre' => "Usuario $i",
            'calificacion' => rand(1, 5),
            'id_producto' => rand(1, 10),
        ]);
        $insertados['comentarios']++;
    }

    // 200 productos intermedios
    $pdo->beginTransaction();
    $stmt = $pdo->prepare("INSERT INTO productos (modelo, especificaciones, precio, id_categoria, marca) VALUES (?, ?, ?, ?, ?)");
    for ($i = 0; $i < 200; $i++) {
        $modelo = $modelos[array_rand($modelos)] . rand(100, 999);
        $especificacion = $especificaciones[array_rand($especificaciones)];
        $precio = rand(10000, 60000);
        $categoria = rand(1, 10);
        $marca = $marcas[array_rand($marcas)];
        $stmt->execute([$modelo, $especificacion, $precio, $categoria, $marca]);
    }
    $pdo->commit();
    $log[] = date('[Y-m-d H:i:s]') . " Generados 200 productos aleatorios";

    // Insertar 1000 comentarios aleatorios
    $comentariosInsertados = 0;
    $stmtProductos = $pdo->query("SELECT id FROM productos");
    $idsProductos = $stmtProductos->fetchAll(PDO::FETCH_COLUMN);
    $stmtInsertComentario = $pdo->prepare("INSERT INTO comentarios (id_producto, texto, calificacion) VALUES (?, ?, ?)");

    for ($i = 0; $i < 1000; $i++) {
        $comentario = $comentariosLorem[array_rand($comentariosLorem)];
        $calificacion = rand(1, 5);
        $producto_id = $idsProductos[array_rand($idsProductos)];

        $stmtInsertComentario->execute([$producto_id, $comentario, $calificacion]);
        $comentariosInsertados++;
    }
    $log[] = date('[Y-m-d H:i:s]') . " Insertados $comentariosInsertados comentarios aleatorios";

} catch (PDOException $e) {
    if ($pdo && $pdo->inTransaction()) {
        $pdo->rollBack();
    }
    $log[] = date('[Y-m-d H:i:s]') . " Error: " . $e->getMessage();
}

// Guardar el log al final
$fecha = date('Y-m-d H:i:s');
$log[] = "[$fecha] Registros básicos insertados:";
foreach ($insertados as $tabla => $cantidad) {
    $log[] = "  - $tabla: $cantidad";
}

file_put_contents($log_file, implode(PHP_EOL, $log) . PHP_EOL, FILE_APPEND);

echo "✅ Inicialización básica completada. Verifica el archivo de log en 'init_db.log'.";
