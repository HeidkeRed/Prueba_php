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
                        <div class="col">
                            <a href="/Proceso_seleccion/public_html/producto_detalle.php?id=${p.id}" class="text-decoration-none text-dark">
                                <div class="card h-100 d-flex flex-column">
                                    <div class="card-body flex-grow-1 d-flex flex-column">
                                        <h5 class="card-title">${p.modelo}</h5>
                                        <p class="card-text mt-auto">
                                            Marca: ${p.marca ?? 'Sin marca'}<br>
                                            Precio: $${parseFloat(p.precio).toFixed(2)}
                                            Likes: ${p.likes ?? 0} <br>
                                Visitas: ${p.visitas ?? 0}
                                        </p>
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
                        <div class="col">
                            <a href="/Proceso_seleccion/public_html/producto_detalle.php?id=${p.id}" class="text-decoration-none text-dark">
                                <div class="card h-100 d-flex flex-column border-success">
                                    <div class="card-body flex-grow-1 d-flex flex-column">
                                        <h5 class="card-title">${p.modelo}</h5>
                                        <p class="card-text mt-auto">
                                            Marca: ${p.marca ?? 'Sin marca'}<br>
                                            Calificación: ${p.promedio_calificacion ?? 'Sin calificación'}<br>
                                            Precio: $${parseFloat(p.precio).toFixed(2)}
                                            Likes: ${p.likes ?? 0} <br>
                                Visitas: ${p.visitas ?? 0}
                                        </p>
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




