<style>
    .card .form-check-input {
        transform: scale(1.2);
    }

    .card .form-control-sm {
        font-size: 0.85rem;
    }

    .img-thumbnail {
        border-radius: 0.5rem;
    }
</style>


<?php $__env->startSection('title', 'Crear Comanda'); ?>
<?php $__env->startSection('content'); ?>
<div class="container-fluid">
    <h1 class="h3 mb-4"><i class="fas fa-concierge-bell"></i> Tomar Comanda</h1>
    <?php if(session('success')): ?>
    <div class="alert alert-success"><?php echo e(session('success')); ?></div>
    <?php endif; ?>
    <form method="GET" action="<?php echo e(route('comandas.create')); ?>" class="mb-4">
        <div class="input-group input-group-sm" style="max-width: 300px;">
            <input type="text" name="search" class="form-control" placeholder="Buscar producto..."
                value="<?php echo e(request('search')); ?>">
            <div class="input-group-append">
                <button type="submit" class="btn btn-outline-secondary">
                    <i class="fas fa-search"></i>
                </button>
            </div>
        </div>
    </form>
    <div id="productosSeleccionadosResumen" class="mb-4">
        <h5>Productos Seleccionados</h5>
        <ul id="listaSeleccionados" class="list-group">
        </ul>
    </div>
    <form method="POST" action="<?php echo e(route('comandas.store')); ?>">
        <?php echo csrf_field(); ?>
        <div class="form-group mb-4">
            <label for="mesa_id"><strong>Selecciona Mesa:</strong></label>
            <select name="mesa_id" class="form-control" required>
                <option value="">-- Seleccione una mesa --</option>
                <?php $__currentLoopData = $mesas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $mesa): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <?php
                $ocupada = $mesa->comandas->isNotEmpty();
                ?>
                <option value="<?php echo e($mesa->id); ?>"
                    <?php if($ocupada): ?>
                    disabled
                    class="text-danger"
                    <?php endif; ?>
                    <?php if(old('mesa_id')==$mesa->id): ?> selected <?php endif; ?>>
                    <?php echo e($mesa->nombre); ?>

                    <?php if($ocupada): ?> (OCUPADA) <?php endif; ?>
                </option>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </select>
        </div>
        <h5 class="mb-3">Selecciona Productos</h5>
        <div class="row">
            <?php if($productos->count() > 0): ?>
            <?php $__currentLoopData = $productos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $producto): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="col-12 col-md-6 col-lg-4 mb-4">
                <div class="card h-100 border shadow-sm">
                    <div class="card-body d-flex flex-column justify-content-between">
                        <div class="d-flex align-items-start">
                            <input type="checkbox" name="productos[<?php echo e($producto->id); ?>][selected]"
                                value="1"
                                class="form-check-input me-2 mt-1"
                                id="check_<?php echo e($producto->id); ?>">

                            <div class="flex-grow-1">
                                <label for="check_<?php echo e($producto->id); ?>" class="form-label">
                                    <strong><?php echo e($producto->nombre); ?></strong><br>
                                    <small class="text-muted"><?php echo e($producto->descripcion); ?></small>
                                </label>
                                <p class="text-success mt-1 fw-bold">$<?php echo e(number_format($producto->precio, 2)); ?></p>
                            </div>

                            <div class="ms-2" style="width: 60px; height: 60px;">
                                <?php if($producto->imagen): ?>
                                <img src="<?php echo e(asset('storage/' . $producto->imagen)); ?>" alt="<?php echo e($producto->nombre); ?>"
                                    class="img-thumbnail img-fluid" style="object-fit: cover; width: 100%; height: 100%;">
                                <?php else: ?>
                                <img src="https://via.placeholder.com/60x60?text=No+img" class="img-thumbnail img-fluid" alt="Sin imagen">
                                <?php endif; ?>
                            </div>
                        </div>

                        <div class="mt-3">
                            <div class="row">
                                <div class="col-4">
                                    <label class="form-label">Cant.</label>
                                    <input type="number" name="productos[<?php echo e($producto->id); ?>][cantidad]"
                                        value="1" min="1" class="form-control form-control-sm">
                                </div>
                                <div class="col-8">
                                    <label class="form-label">Comentarios</label>
                                    <input type="text" name="productos[<?php echo e($producto->id); ?>][comentarios]"
                                        class="form-control form-control-sm"
                                        placeholder="Ej. sin cebolla, bien cocido">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            <?php else: ?>
            <p class="text-muted">No se encontraron productos para esta búsqueda.</p>
            <?php endif; ?>
        </div>
        <div class="card-footer clearfix">
            <?php echo e($productos->links('pagination::bootstrap-4')); ?>

        </div>
        <div id="hiddenInputsContainer"></div>
        <button type="submit" class="btn btn-primary btn-lg mt-3">
            <i class="fas fa-paper-plane"></i> Enviar comanda
        </button>
    </form>
</div>
<script>
    // Cargar del localStorage (persistencia entre búsquedas/paginación)
    let productosSeleccionados = JSON.parse(localStorage.getItem('productosSeleccionados') || '{}');

    function renderSeleccionados() {
        const lista = document.getElementById('listaSeleccionados');
        lista.innerHTML = '';

        Object.entries(productosSeleccionados).forEach(([id, p]) => {
            const li = document.createElement('li');
            li.className = 'list-group-item d-flex justify-content-between align-items-center';
            li.innerHTML = `
                <span><strong>${p.nombre}</strong> x${p.cantidad} <br><small>${p.comentarios || ''}</small></span>
                <button type="button" class="btn btn-sm btn-danger" onclick="quitarProducto('${id}')">
                    <i class="fas fa-times"></i>
                </button>
            `;
            lista.appendChild(li);
        });
    }

    function quitarProducto(id) {
        delete productosSeleccionados[id];
        localStorage.setItem('productosSeleccionados', JSON.stringify(productosSeleccionados));
        renderSeleccionados();
        const check = document.getElementById('check_' + id);
        if (check) check.checked = false;
    }
    // Escuchar checkboxes
    document.querySelectorAll('[id^="check_"]').forEach(check => {
        check.addEventListener('change', () => {
            const id = check.id.replace('check_', '');
            const card = check.closest('.card-body');
            const nombre = card.querySelector('label strong').innerText.trim();
            const cantidad = card.querySelector(`input[name="productos[${id}][cantidad]"]`).value;
            const comentarios = card.querySelector(`input[name="productos[${id}][comentarios]"]`).value;

            if (check.checked) {
                productosSeleccionados[id] = {
                    nombre,
                    cantidad,
                    comentarios
                };
            } else {
                delete productosSeleccionados[id];
            }

            localStorage.setItem('productosSeleccionados', JSON.stringify(productosSeleccionados));
            renderSeleccionados();
        });
    });
    // Escuchar cambios en cantidad y comentarios
    document.querySelectorAll('input[name*="[cantidad]"], input[name*="[comentarios]"]').forEach(input => {
        input.addEventListener('input', () => {
            const id = input.name.match(/\[(\d+)\]/)[1];
            if (productosSeleccionados[id]) {
                const cantidad = document.querySelector(`input[name="productos[${id}][cantidad]"]`).value;
                const comentarios = document.querySelector(`input[name="productos[${id}][comentarios]"]`).value;
                productosSeleccionados[id].cantidad = cantidad;
                productosSeleccionados[id].comentarios = comentarios;
                localStorage.setItem('productosSeleccionados', JSON.stringify(productosSeleccionados));
                renderSeleccionados();
            }
        });
    });

    // Al cargar la página
    window.addEventListener('DOMContentLoaded', () => {
        renderSeleccionados();

        // Rellenar los campos visibles con los datos del localStorage
        Object.entries(productosSeleccionados).forEach(([id, data]) => {
            const check = document.getElementById('check_' + id);
            if (check) check.checked = true;

            const cantidad = document.querySelector(`input[name="productos[${id}][cantidad]"]`);
            if (cantidad) cantidad.value = data.cantidad;

            const comentarios = document.querySelector(`input[name="productos[${id}][comentarios]"]`);
            if (comentarios) comentarios.value = data.comentarios;
        });
    });

    // Limpiar al enviar CHECAR SI ESTA BIEN USAR LA DOBLECOMILLA
    document.querySelector('form[action="<?php echo e(route("comandas.store")); ?>"]').addEventListener('submit', () => {
        const container = document.getElementById('hiddenInputsContainer');
        container.innerHTML = ''; // Limpia antes de regenerar

        // Recorremos productosSeleccionados del localStorage
        Object.entries(productosSeleccionados).forEach(([id, data]) => {
            // Checkbox marcado
            const inputCheck = document.createElement('input');
            inputCheck.type = 'hidden';
            inputCheck.name = `productos[${id}][selected]`;
            inputCheck.value = 1;
            container.appendChild(inputCheck);

            // Cantidad
            const inputCantidad = document.createElement('input');
            inputCantidad.type = 'hidden';
            inputCantidad.name = `productos[${id}][cantidad]`;
            inputCantidad.value = data.cantidad || 1;
            container.appendChild(inputCantidad);

            // Comentarios
            const inputComentarios = document.createElement('input');
            inputComentarios.type = 'hidden';
            inputComentarios.name = `productos[${id}][comentarios]`;
            inputComentarios.value = data.comentarios || '';
            container.appendChild(inputComentarios);
        });

        // Eliminar después de enviar
        localStorage.removeItem('productosSeleccionados');
    });
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\comida-app\resources\views/comandas/create.blade.php ENDPATH**/ ?>