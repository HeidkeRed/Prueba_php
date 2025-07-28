<?php require 'includes/header.php'; ?>

<main class="container py-4">
    <section class="catalogo-section">
        <h1 class="catalogo-title">Catálogo aleatorio (<?= $meses ?> meses)</h1>

        <div class="row g-4">
            <?php foreach ($productos as $p): ?>
                <div class="col-sm-6 col-md-4 col-lg-3">
                    <a href="/Proceso_seleccion/public_html/producto_detalle.php?id=<?= $p['id'] ?>" class="d-block text-decoration-none text-reset">
                        <div class="product-card">
                            <div class="product-icon">
                                <?= strtoupper(substr($p['modelo'], 0, 1)) ?>
                            </div>

                            <div class="product-info">
                                <h3><?= htmlspecialchars($p['modelo']) ?></h3>
                                <p><strong>Especificaciones:</strong><br><?= nl2br(htmlspecialchars($p['especificaciones'])) ?></p>
                                <p><strong>Precio:</strong> $<?= number_format($p['precio'], 2) ?></p>
                                <p><strong>Mensualidad (<?= $meses ?> meses):</strong> $<?= number_format($p['precio'] / $meses, 2) ?></p>
                            </div>

                            <div class="product-meta">
                                <span>👍 <?= $p['likes'] ?> | 👁️ <?= $p['visitas'] ?></span>
                            </div>
                        </div>
                    </a>
                </div>
            <?php endforeach; ?>
        </div>
    </section>
</main>

<?php require 'includes/footer.php'; ?>