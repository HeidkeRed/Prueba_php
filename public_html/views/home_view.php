<?php
// Incluye el encabezado y el pie de página que ya hemos modernizado
include 'includes/header.php';
?>

<main class="container py-4">
  <div class="container py-4">
    <h2 class="mb-3">Categorías principales</h2>
    <ul class="list-group mb-4">
      <?php foreach ($categoriasPadre as $categoria): ?>
        <li class="list-group-item">
          <button class="btn btn-outline-primary w-100 categoria-padre" data-id="<?= $categoria['id'] ?>">
            <?= htmlspecialchars($categoria['nombre']) ?>
          </button>
        </li>
      <?php endforeach; ?>
    </ul>

    <h3>Subcategorías</h3>
    <ul id="categorias-hijas" class="btn btn-outline-primary btn-sm categoria-padre"></ul>


    <h2>Productos Destacados</h2>
    <div id="ver-mas-destacados" class="text-center my-4"></div>
    <div id="productos-destacados" class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-3 mb-5">
      <?php foreach ($productosDestacados as $producto): ?>
        <div class="col">
          <a href="/Proceso_seleccion/public_html/producto_detalle.php?id=<?= $producto['id'] ?>" class="text-decoration-none text-dark">
            <div class="card h-100 d-flex flex-column"> <!-- <- esto es clave -->
              <div class="card-body flex-grow-1 d-flex flex-column">
                <h5 class="card-title"><?= htmlspecialchars($producto['modelo']) ?></h5>
                <p class="card-text mt-auto">
                  Marca: <?= htmlspecialchars($producto['marca'] ?? 'Sin marca') ?><br>
                  Precio: $<?= number_format($producto['precio'], 2) ?>
                  Likes: <?= number_format($producto['likes']) ?>
                  Visitas: <?= number_format($producto['visitas']) ?>
                </p>
              </div>
            </div>
          </a>
        </div>
      <?php endforeach; ?>
    </div>

    <h2>Productos Mejor Calificados</h2>
    <div id="ver-mas-calificados" class="text-center my-4"></div>
    <div id="productos-mejor-calificados" class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-3">
      <?php foreach ($productosMejorCalificados as $producto): ?>
        <div class="col">
          <a href="/Proceso_seleccion/public_html/producto_detalle.php?id=<?= $producto['id'] ?>" class="text-decoration-none text-dark">
            <div class="card h-100 d-flex flex-column border-success">
              <div class="card-body flex-grow-1 d-flex flex-column">
                <h5 class="card-title"><?= htmlspecialchars($producto['modelo']) ?></h5>
                <p class="card-text mt-auto">
                  Marca: <?= htmlspecialchars($producto['marca'] ?? 'Sin marca') ?><br>
                  Calificación: <?= $producto['promedio_calificacion'] ?? 'Sin calificación' ?><br>
                  Precio: $<?= number_format($producto['precio'], 2) ?>
                  Likes: <?= number_format($producto['likes']) ?>
                  Visitas: <?= number_format($producto['visitas']) ?>
                </p>
              </div>
            </div>
        </div>
      <?php endforeach; ?>
    </div>

</main>
<?php include 'includes/footer.php'; ?>