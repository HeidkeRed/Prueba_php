<?php
// Incluye el encabezado y el pie de página que ya hemos modernizado
include 'includes/header.php';


function urlPagina($pagina, $idCategoria, $modo) {
    return "catalogo.php?id_categoria=$idCategoria&modo=$modo&pagina=$pagina";
}
?>

<main class="main-content-catalog">
    <div class="container">
        <h2 class="catalog-title">Catálogo de productos (<?= htmlspecialchars($modo) ?>) - Categoría <?= htmlspecialchars($idCategoria) ?></h2>

        <div class="product-grid">
            <?php foreach ($productos as $producto): ?>
                <div class="product-grid-item">
                    <a href="/Proceso_seleccion/public_html/producto_detalle.php?id=<?= $producto['id'] ?>" class="product-card-link">
                        <div class="product-card <?= ($modo === 'calificados') ? 'product-card-featured' : '' ?>">
                            <div class="product-image-placeholder">
                                <!-- Aquí podrías poner una imagen real del producto si la tuvieras -->
                                <img src="/placeholder.svg?height=200&width=300&text=<?= urlencode($producto['modelo']) ?>" alt="Imagen de <?= htmlspecialchars($producto['modelo']) ?>" class="product-image">
                            </div>
                            <div class="product-card-body">
                                <h5 class="product-title"><?= htmlspecialchars($producto['modelo']) ?></h5>
                                <p class="product-details">
                                    Marca: <?= htmlspecialchars($producto['marca'] ?? 'Sin marca') ?><br>
                                    Precio: $<?= number_format($producto['precio'], 2) ?><br>
                                    <?php if ($modo === 'calificados'): ?>
                                        Calificación: <?= $producto['promedio_calificacion'] ?? 'Sin calificación' ?>
                                    <?php endif; ?>
                                </p>
                            </div>
                        </div>
                    </a>
                </div>
            <?php endforeach; ?>
        </div>

        <!-- Paginación -->
        <nav class="pagination-nav" aria-label="Paginación de productos">
            <ul class="pagination-list">
                <li class="pagination-item <?= ($pagina <= 1) ? 'disabled' : '' ?>">
                    <a class="pagination-link" href="<?= urlPagina($pagina - 1, $idCategoria, $modo) ?>">Anterior</a>
                </li>
                <?php for ($i = 1; $i <= $totalPaginas; $i++): ?>
                    <li class="pagination-item <?= ($pagina == $i) ? 'active' : '' ?>">
                        <a class="pagination-link" href="<?= urlPagina($i, $idCategoria, $modo) ?>"><?= $i ?></a>
                    </li>
                <?php endfor; ?>
                <li class="pagination-item <?= ($pagina >= $totalPaginas) ? 'disabled' : '' ?>">
                    <a class="pagination-link" href="<?= urlPagina($pagina + 1, $idCategoria, $modo) ?>">Siguiente</a>
                </li>
            </ul>
        </nav>
    </div>
</main>

<?php include 'includes/footer.php'; ?>
