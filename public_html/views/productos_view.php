<?php include 'includes/header.php'; ?>

<main class="container py-4">
    <h1 class="mb-4">Lista de Productos con sus Comentarios</h1>

    <?php if (!empty($productos) && is_array($productos)): ?>
        <?php foreach ($productos as $producto): ?>
            <a href="/Proceso_seleccion/public_html/producto_detalle.php?id=<?= $producto['id'] ?>" class="producto_mc d-block text-decoration-none text-reset">
                <h2 class="producto_mc__titulo">
                    <?= htmlspecialchars($producto['modelo']) ?>
                    <small class="producto_mc__info">(Calificación: <?= $producto['promedio_calificacion'] ?? 'N/A' ?>)</small>
                </h2>

                <p class="producto_mc__info">
                    <strong>Especificaciones:</strong> <?= htmlspecialchars($producto['especificaciones']) ?>
                </p>
                <p class="producto_mc__info">
                    <strong>Precio:</strong> $<?= number_format($producto['precio'], 2) ?>
                </p>

                <div class="producto_mc__comentarios">
                    <h4 class="producto_mc__comentarios_titulo">Comentarios:</h4>
                    <?php
                    $comentarios = $comentariosPorProducto[$producto['id']] ?? [];
                    if (count($comentarios) > 0):
                        foreach ($comentarios as $comentario):
                    ?>
                            <div class="producto_mc__comentario">
                                <p><?= htmlspecialchars($comentario['texto']) ?></p>
                                <p><em>Nombre:</em> <?= htmlspecialchars($comentario['nombre']) ?></p>
                                <small>Calificación: <?= $comentario['calificacion'] ?>/5</small>
                            </div>
                        <?php
                        endforeach;
                    else:
                        ?>
                        <p class="producto_mc__sin_comentarios">Este producto aún no tiene comentarios.</p>
                    <?php endif; ?>
                </div>
            </a>


        <?php endforeach; ?>
    <?php else: ?>
        <p>No hay productos para mostrar.</p>
    <?php endif; ?>
</main>

<?php include 'includes/footer.php'; ?>