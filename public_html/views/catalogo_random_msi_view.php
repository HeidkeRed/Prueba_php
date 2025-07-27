<?php
require 'includes/header.php'; // Agrega el header
?>

<h1>Catálogo aleatorio (<?= $meses ?> meses)</h1>

<?php foreach ($productos as $p): ?>
    <div style="border: 1px solid #ccc; padding: 10px; margin-bottom: 15px;">
        <h3><?= htmlspecialchars($p['modelo']) ?></h3>
        <p><strong>Especificaciones:</strong> <?= nl2br(htmlspecialchars($p['especificaciones'])) ?></p>
        <p><strong>Precio:</strong> $<?= number_format($p['precio'], 2) ?></p>
        <p><strong>Mensualidad estimada a <?= $meses ?> meses:</strong> $<?= number_format($p['precio'] / $meses, 2) ?></p>
        <p>👍 Likes: <?= $p['likes'] ?> | 👁️ Visitas: <?= $p['visitas'] ?></p>
    </div>
<?php endforeach; ?>

<?php
require 'includes/footer.php'; // Agrega el footer
?>
