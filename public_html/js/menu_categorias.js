document.addEventListener('DOMContentLoaded', () => {
    document.querySelectorAll('.categoria-padre').forEach(item => {
        item.addEventListener('click', () => {
            const id = item.getAttribute('data-id');
            cargarSubcategorias(id);
        });
    });
});

function cargarSubcategorias(idCategoriaPadre) {
    fetch(`../ajax/categorias_hijas.php?id_padre=${idCategoriaPadre}`)
        .then(res => res.json())
        .then(data => {
            const contenedor = document.getElementById('categorias-hijas');
            contenedor.innerHTML = '';

            if (data.length === 0) {
                contenedor.innerHTML = '<li class="list-group-item">No hay subcategorías</li>';
                return;
            }

            data.forEach(sub => {
                const li = document.createElement('li');
                li.className = 'list-group-item p-0 border-0'; // ajusta estilos del contenedor

                const btn = document.createElement('button');
                btn.textContent = sub.nombre;
                btn.className = 'btn btn-outline-primary btn-sm categoria-padre';
                btn.onclick = () => {
                    document.querySelectorAll('#categorias-hijas button').forEach(b => b.classList.remove('active'));
                    btn.classList.add('active');
                    actualizarProductos(sub.id);
                };

                li.appendChild(btn);
                contenedor.appendChild(li);
            });
        })
        .catch(err => console.error('Error al cargar subcategorías', err));
}



function actualizarProductos(idCategoriaHija) {
    fetch(`../ajax/productos_por_categoria.php?id_categoria=${idCategoriaHija}`)
        .then(response => response.json())
        .then(data => {
            const destacados = document.getElementById('productos-destacados');
            const calificados = document.getElementById('productos-mejor-calificados');

            const botonVerMasDestacados = document.getElementById('ver-mas-destacados');
            const botonVerMasCalificados = document.getElementById('ver-mas-calificados');

            // Limpiar contenido previo
            destacados.innerHTML = '';
            calificados.innerHTML = '';
            botonVerMasDestacados.innerHTML = '';
            botonVerMasCalificados.innerHTML = '';

            // Mostrar productos destacados
            if (data.destacados.length > 0) {
                data.destacados.forEach(p => {
                    destacados.innerHTML += `
    <div class="home-product-card home-product-card--featured">
      <a href="/Proceso_seleccion/public_html/producto_detalle.php?id=${p.id}" class="home-product-card">
        <div class="home-product-card__image">
          <!-- Aquí podrías agregar la imagen si tienes URL: <img src="${p.imagen}" alt="${p.modelo}"> -->
        </div>
        <div class="home-product-card__body">
          <h5 class="home-product-card__title">${p.modelo}</h5>
          <div class="home-product-card__info">
            <div class="home-product-card__brand">
              Marca: ${p.marca ?? 'Sin marca'}
            </div>
            <div class="home-product-card__price">
              $${parseFloat(p.precio).toFixed(2)}
            </div>
            <div class="home-product-card__stats">
              <span class="home-product-card__stat home-product-card__stat--likes">
                ❤️ ${p.likes ?? 0}
              </span>
              <span class="home-product-card__stat home-product-card__stat--views">
                👁️ ${p.visitas ?? 0}
              </span>
            </div>
          </div>
        </div>
      </a>
    </div>
  `;
                });


                // Crear botón "Ver más" para destacados
                botonVerMasDestacados.innerHTML = `
                    <a href="catalogo.php?id_categoria=${idCategoriaHija}&modo=destacados" class="btn btn-primary">
                        Ver más productos destacados
                    </a>
                `;
            } else {
                destacados.innerHTML = '<p class="text-center">No hay productos destacados en esta categoría.</p>';
            }

            // Mostrar productos mejor calificados
            if (data.calificados.length > 0) {
                data.calificados.forEach(p => {
                    calificados.innerHTML += `
    <div class="home-product-card home-product-card--rated">
      <a href="/Proceso_seleccion/public_html/producto_detalle.php?id=${p.id}" class="home-product-card">
        <div class="home-product-card__image">
          <!-- Imagen aquí si se desea -->
        </div>
        <div class="home-product-card__body">
          <h5 class="home-product-card__title">${p.modelo}</h5>
          <div class="home-product-card__info">
            <div class="home-product-card__brand">
              Marca: ${p.marca ?? 'Sin marca'}
            </div>
            <div class="home-product-card__stats">
              <span class="home-product-card__stat home-product-card__stat--rating">
                ⭐ ${p.promedio_calificacion ?? 'Sin calificación'}
              </span>
            </div>
            <div class="home-product-card__price">
              $${parseFloat(p.precio).toFixed(2)}
            </div>
            <div class="home-product-card__stats">
              <span class="home-product-card__stat home-product-card__stat--likes">
                ❤️ ${p.likes ?? 0}
              </span>
              <span class="home-product-card__stat home-product-card__stat--views">
                👁️ ${p.visitas ?? 0}
              </span>
            </div>
          </div>
        </div>
      </a>
    </div>
  `;
                });


                // Crear botón "Ver más" para mejor calificados
                botonVerMasCalificados.innerHTML = `
                    <a href="catalogo.php?id_categoria=${idCategoriaHija}&modo=calificados" class="btn btn-success">
                        Ver más productos mejor calificados
                    </a>
                `;
            } else {
                calificados.innerHTML = '<p class="text-center">No hay productos mejor calificados en esta categoría.</p>';
            }
        })
        .catch(err => console.error('Error al actualizar productos', err));
}




