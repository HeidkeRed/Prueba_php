<?php
include 'includes/header.php';
?>



<main class="home-main">
  <div class="home-container">
    
    <!-- Sección de Categorías Principales -->
    <section class="home-categories">
      <h2 class="home-categories__title">Categorías Principales</h2>
      <ul class="home-categories__list">
        <?php foreach ($categoriasPadre as $categoria): ?>
          <li class="home-categories__item">
            <button class="home-categories__button categoria-padre" data-id="<?= $categoria['id'] ?>">
              <?= htmlspecialchars($categoria['nombre']) ?>
            </button>
          </li>
        <?php endforeach; ?>
      </ul>
      
      <!-- Subcategorías -->
      <div class="home-subcategories">
        <h3 class="home-subcategories__title">Subcategorías</h3>
        <ul id="categorias-hijas" class="home-subcategories__list"></ul>
      </div>
    </section>

    <hr class="home-divider">

    <!-- Sección de Productos Destacados -->
    <section class="home-products-section">
      <h2 class="home-products-section__title home-products-section__title--featured">
        Productos Destacados
        <span class="home-badge home-badge--featured">Destacado</span>
      </h2>
      
      <div class="home-view-more" id="ver-mas-destacados"></div>
      
      <div id="productos-destacados" class="home-products-grid">
        <?php foreach ($productosDestacados as $producto): ?>
          <div class="home-product-card home-product-card--featured">
            <a href="/Proceso_seleccion/public_html/producto_detalle.php?id=<?= $producto['id'] ?>" class="home-product-card">
              <div class="home-product-card__image">
              </div>
              <div class="home-product-card__body">
                <h5 class="home-product-card__title"><?= htmlspecialchars($producto['modelo']) ?></h5>
                <div class="home-product-card__info">
                  <div class="home-product-card__brand">
                    Marca: <?= htmlspecialchars($producto['marca'] ?? 'Sin marca') ?>
                  </div>
                  <div class="home-product-card__price">
                    $<?= number_format($producto['precio'], 2) ?>
                  </div>
                  <div class="home-product-card__stats">
                    <span class="home-product-card__stat home-product-card__stat--likes">
                      ❤️ <?= number_format($producto['likes']) ?>
                    </span>
                    <span class="home-product-card__stat home-product-card__stat--views">
                      👁️ <?= number_format($producto['visitas']) ?>
                    </span>
                  </div>
                </div>
              </div>
            </a>
          </div>
        <?php endforeach; ?>
      </div>
    </section>

    <hr class="home-divider">

    <!-- Sección de Productos Mejor Calificados -->
    <section class="home-products-section">
      <h2 class="home-products-section__title home-products-section__title--rated">
        Productos Mejor Calificados
        <span class="home-badge home-badge--rated">Top Rated</span>
      </h2>
      
      <div class="home-view-more" id="ver-mas-calificados"></div>
      
      <div id="productos-mejor-calificados" class="home-products-grid">
        <?php foreach ($productosMejorCalificados as $producto): ?>
          <div class="home-product-card home-product-card--rated">
            <a href="/Proceso_seleccion/public_html/producto_detalle.php?id=<?= $producto['id'] ?>" class="home-product-card">
              <div class="home-product-card__image">
                <!-- Aquí puedes agregar la imagen del producto si la tienes -->
              </div>
              <div class="home-product-card__body">
                <h5 class="home-product-card__title"><?= htmlspecialchars($producto['modelo']) ?></h5>
                <div class="home-product-card__info">
                  <div class="home-product-card__brand">
                    Marca: <?= htmlspecialchars($producto['marca'] ?? 'Sin marca') ?>
                  </div>
                  <div class="home-product-card__stats">
                    <span class="home-product-card__stat home-product-card__stat--rating">
                      ⭐ <?= $producto['promedio_calificacion'] ?? 'Sin calificación' ?>
                    </span>
                  </div>
                  <div class="home-product-card__price">
                    $<?= number_format($producto['precio'], 2) ?>
                  </div>
                  <div class="home-product-card__stats">
                    <span class="home-product-card__stat home-product-card__stat--likes">
                      ❤️ <?= number_format($producto['likes']) ?>
                    </span>
                    <span class="home-product-card__stat home-product-card__stat--views">
                      👁️ <?= number_format($producto['visitas']) ?>
                    </span>
                  </div>
                </div>
              </div>
            </a>
          </div>
        <?php endforeach; ?>
      </div>
    </section>

  </div>
</main>

<?php include 'includes/footer.php'; ?>
