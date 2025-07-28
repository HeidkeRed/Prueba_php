<?php
include 'includes/header.php';
?>

<main class="container-fluid" style="background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%); min-height: 100vh; padding: 2rem 0;">
    <div class="container">
        <!-- Hero Section del Producto -->
        <div class="product-hero p-4 mb-4">
            <div class="row align-items-center">
                <!-- Imagen del producto -->
                <div class="col-lg-6 mb-4 mb-lg-0">
                    <div class="product-image-placeholder">
                        📱
                    </div>
                </div>
                
                <!-- Información del producto -->
                <div class="col-lg-6">
                    <div class="mb-4">
                        <h1 class="display-4 fw-bold text-dark mb-2">
                            <?php echo htmlspecialchars($productoInfo['modelo']); ?>
                        </h1>
                        <p class="h4 text-muted">
                            <?php echo htmlspecialchars($productoInfo['marca'] ?? 'Sin marca'); ?>
                        </p>
                    </div>
                    
                    <!-- Precio -->
                    <div class="price-card mb-4">
                        <div class="h2 fw-bold text-success mb-1">
                            $<?php echo number_format($productoInfo['precio'] ?? 0, 2); ?>
                        </div>
                        <p class="text-success mb-0">Precio actual</p>
                    </div>
                    
                    <!-- Opciones de financiamiento -->
                    <?php if (isset($mensualidad12) && isset($mensualidad6)): ?>
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <div class="financing-card financing-12">
                                <div class="h5 fw-bold text-primary mb-1">
                                    $<?= number_format($mensualidad12, 2) ?>
                                </div>
                                <small class="text-primary">12 meses sin intereses</small>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="financing-card financing-6">
                                <div class="h5 fw-bold" style="color: #8e24aa;">
                                    $<?= number_format($mensualidad6, 2) ?>
                                </div>
                                <small style="color: #8e24aa;">6 meses sin intereses</small>
                            </div>
                        </div>
                    </div>
                    <?php endif; ?>
                    
                    <!-- Botón de Me Gusta -->
                    <button id="like-btn" class="like-btn">
                        <span style="font-size: 1.2rem;">❤️</span>
                        <span class="ms-2">Me gusta</span>
                    </button>
                </div>
            </div>
        </div>
        
        <!-- Especificaciones -->
        <div class="section-card">
            <div class="section-header">
                <div class="section-icon specs-icon">📋</div>
                <h2 class="h3 fw-bold mb-0">Especificaciones</h2>
            </div>
            <div class="text-muted" style="line-height: 1.6;">
                <?php echo nl2br(htmlspecialchars($productoInfo['especificaciones'] ?? 'No hay especificaciones disponibles')); ?>
            </div>
        </div>
        
        <!-- Sección de Comentarios -->
        <div class="section-card">
            <div class="section-header">
                <div class="section-icon comments-icon">💬</div>
                <h2 class="h3 fw-bold mb-0">Comentarios y Reseñas</h2>
            </div>
            
            <?php if (empty($comentarios)): ?>
                <div class="empty-state">
                    <div class="empty-state-icon">💭</div>
                    <h4 class="mb-2">No hay comentarios para este producto aún.</h4>
                    <p class="text-muted">¡Sé el primero en dejar una reseña!</p>
                </div>
            <?php else: ?>
                <div>
                    <?php foreach ($comentarios as $index => $comentario): ?>
                        <div class="comment-card" style="animation-delay: <?= $index * 0.1 ?>s;">
                            <div class="d-flex align-items-start mb-3">
                                <div class="user-avatar me-3">
                                    <?= strtoupper(substr(htmlspecialchars($comentario['nombre']), 0, 1)) ?>
                                </div>
                                <div class="flex-grow-1">
                                    <h5 class="fw-bold mb-1">
                                        <?= htmlspecialchars($comentario['nombre']) ?>
                                    </h5>
                                    <div class="d-flex align-items-center">
                                        <div class="rating-stars">
                                            <?php 
                                            $calificacion = intval($comentario['calificacion']);
                                            for ($i = 1; $i <= 5; $i++): 
                                            ?>
                                                <span class="<?= $i <= $calificacion ? '' : 'empty' ?>">⭐</span>
                                            <?php endfor; ?>
                                        </div>
                                        <small class="text-muted">
                                            (<?= $calificacion ?>/5)
                                        </small>
                                    </div>
                                </div>
                            </div>
                            <p class="mb-0" style="line-height: 1.6;">
                                <?= nl2br(htmlspecialchars($comentario['texto'])) ?>
                            </p>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>
    </div>
    
    <!-- Toast notification -->
    <div id="toast" class="toast">
        <span style="margin-right: 10px;">✅</span>
        <span>¡Te ha gustado este producto!</span>
    </div>
</main>

<script>
document.getElementById('like-btn').addEventListener('click', function() {
    const button = this;
    const originalContent = button.innerHTML;
    
    // Animación del botón
    button.classList.add('heart-animation');
    button.innerHTML = '<span style="font-size: 1.2rem;">💖</span><span class="ms-2">¡Gracias!</span>';
    button.disabled = true;
    
    fetch('../php/controllers/ProductoController.php?accion=like&id=<?php echo $productoInfo['id']; ?>')
        .then(response => {
            if (response.ok) {
                const toast = document.getElementById('toast');
                toast.classList.add('show');
                
                setTimeout(() => {
                    toast.classList.remove('show');
                }, 3000);
                
                setTimeout(() => {
                    button.classList.remove('heart-animation');
                    button.innerHTML = originalContent;
                    button.disabled = false;
                }, 2000);
            } else {
                throw new Error('Error en la respuesta del servidor');
            }
        })
        .catch(error => {
            console.error('Error al dar like:', error);
            button.classList.remove('heart-animation');
            button.innerHTML = originalContent;
            button.disabled = false;
            alert('Hubo un error al procesar tu solicitud. Inténtalo de nuevo.');
        });
});

document.addEventListener('DOMContentLoaded', function() {
    const comentarios = document.querySelectorAll('.comment-card');
    comentarios.forEach((comentario, index) => {
        comentario.style.opacity = '0';
        comentario.style.transform = 'translateY(20px)';
        
        setTimeout(() => {
            comentario.style.transition = 'all 0.5s ease-out';
            comentario.style.opacity = '1';
            comentario.style.transform = 'translateY(0)';
        }, index * 100);
    });
});
</script>

<?php include 'includes/footer.php'; ?>