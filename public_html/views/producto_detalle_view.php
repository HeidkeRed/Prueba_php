<?php
// Incluye el encabezado y el pie de página que ya hemos modernizado
include 'includes/header.php';
?>

<main class="container py-4">
    <div class="container py-4">

        <h2><?php echo $productoInfo['modelo']; ?></h2>

        <div class="card mb-4">
            <div class="card-body">
                <h5 class="card-title">Marca: <?php echo $productoInfo['marca'] ?? 'Sin marca'; ?></h5>
                <p class="card-text"><strong>Precio:</strong> $<?php echo $productoInfo['precio'] ?? '0.00'; ?></p>
                <p class="card-text"><strong>Especificaciones:</strong> <?php echo $productoInfo['especificaciones'] ?? 'No hay especificaciones'; ?></p>
            </div>
        </div>
        <?php if (isset($mensualidad12) && isset($mensualidad6)): ?>
            <p><strong>Pago mensual a 12 meses:</strong> $<?= number_format($mensualidad12, 2) ?></p>
            <p><strong>Pago mensual a 6 meses:</strong> $<?= number_format($mensualidad6, 2) ?></p>
        <?php endif; ?>
        <button id="like-btn">❤️ Me gusta</button>



        <h3>Comentarios</h3>

        <?php if (empty($comentarios)): ?>
            <p>No hay comentarios para este producto.</p>
        <?php else: ?>
            <div class="list-group">
                <?php foreach ($comentarios as $comentario): ?>
                    <div class="list-group-item">
                        <h5><?= htmlspecialchars($comentario['nombre']) ?></h5>
                        <p><?= nl2br(htmlspecialchars($comentario['texto'])) ?></p>
                        <small>Calificación: <?= htmlspecialchars($comentario['calificacion']) ?>/5</small>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>

    </div>

    <script>
        document.getElementById('like-btn').addEventListener('click', function() {
            fetch('../php/controllers/ProductoController.php?accion=like&id=<?php echo $productoInfo['id']; ?>')
                .then(() => {
                    alert('¡Te ha gustado este producto!');
                    // Opcionalmente: actualiza la página, o desactiva el botón
                })
                .catch(error => {
                    console.error('Error al dar like:', error);
                });
        });
    </script>
</main>
<?php include 'includes/footer.php'; ?>