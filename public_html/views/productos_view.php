<?php include 'includes/header.php'; ?>

<main class="container py-4">
    <h1>Lista de Productos con sus Comentarios</h1>

    <?php if (!empty($productos) && is_array($productos)): ?>
        <?php foreach ($productos as $producto): ?>
            <div class="producto border rounded p-3 mb-4">
                <h2>
                    <?= htmlspecialchars($producto['modelo']) ?>
                    (Calificación: <?= $producto['promedio_calificacion'] ?? 'N/A' ?>)
                </h2>
                <p><strong>Especificaciones:</strong> <?= htmlspecialchars($producto['especificaciones']) ?></p>
                <p><strong>Precio:</strong> $<?= number_format($producto['precio'], 2) ?></p>

                <div class="comentarios mt-3 ps-3 border-start">
                    <h4>Comentarios:</h4>
                    <?php
                    $comentarios = $comentariosPorProducto[$producto['id']] ?? [];
                    if (count($comentarios) > 0):
                        foreach ($comentarios as $comentario):
                    ?>
                        <div class="comentario mb-3">
                            <p><?= htmlspecialchars($comentario['texto']) ?></p>
                            <p><em>Nombre:</em> <?= htmlspecialchars($comentario['nombre']) ?></p>
                            <small>Calificación: <?= $comentario['calificacion'] ?>/5</small>
                        </div>
                    <?php
                        endforeach;
                    else:
                    ?>
                        <p class="sin-comentarios fst-italic text-muted">Este producto aún no tiene comentarios.</p>
                    <?php endif; ?>
                </div>
            </div>
        <?php endforeach; ?>
    <?php else: ?>
        <p>No hay productos para mostrar.</p>
    <?php endif; ?>
</main>

<?php include 'includes/footer.php'; ?>
