<?php $__env->startSection('title', 'Cocina'); ?>

<?php $__env->startSection('content'); ?>
<h2 class="mb-4">👨‍🍳 Cocina - Comandas en preparación</h2>

<?php $__currentLoopData = $comandas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $comanda): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
<div class="card shadow-sm mb-4" id="comanda-<?php echo e($comanda->id); ?>">
    <div class="card-header bg-primary text-white d-flex justify-content-between">
        <div>
            <strong>Mesa:</strong> <?php echo e($comanda->mesa->nombre); ?>

            <span class="badge bg-light text-dark ms-2">
                <?php echo e($comanda->productos->where('pivot.estado', 'pendiente')->count()); ?> pendientes
            </span>
        </div>
        <small>Última actualización: <?php echo e($comanda->updated_at->diffForHumans()); ?></small>
    </div>

    <div class="card-body">
        <div class="row">
            <!-- Productos pendientes -->
            <div class="col-md-6 border-end">
                <h5 class="text-warning mb-3">
                    <i class="fas fa-clock"></i> Nuevos para preparar
                    <span class="badge bg-warning text-dark ms-2">
                        <?php echo e($comanda->productos->where('pivot.estado', 'pendiente')->count()); ?>

                    </span>
                </h5>

                <?php $__empty_1 = true; $__currentLoopData = $comanda->productos->where('pivot.estado', 'pendiente'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $producto): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <div class="alert alert-warning producto-item" id="producto-<?php echo e($comanda->id); ?>-<?php echo e($producto->id); ?>">
                    <div class="row align-items-start">
                        <div class="col pt-1 ms-2">
                            <input type="checkbox"
                                class="form-check-input producto-check"
                                data-comanda="<?php echo e($comanda->id); ?>"
                                data-producto="<?php echo e($producto->id); ?>"
                                autocomplete="off">
                        </div>
                        <div class="row align-items-start d-flex gap-3">
                            <strong><?php echo e($producto->nombre); ?></strong> x <?php echo e($producto->pivot->cantidad); ?><br>
                            <?php if($producto->pivot->comentarios): ?>
                            <small class="text-muted "><em><?php echo e($producto->pivot->comentarios); ?></em></small>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>

                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <div class="alert alert-light text-center">
                    <i class="fas fa-check-circle text-success"></i> Todos los productos preparados
                </div>
                <?php endif; ?>
            </div>
            <!-- Productos preparados -->
            <div class="col-md-6">
                <h5 class="text-success mb-3">
                    <i class="fas fa-check-circle"></i> Listos para entregar
                    <span class="badge bg-success text-white ms-2">
                        <?php echo e($comanda->productos->where('pivot.estado', 'preparado')->count()); ?>

                    </span>
                </h5>
                <?php $__empty_1 = true; $__currentLoopData = $comanda->productos->where('pivot.estado', 'preparado'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $producto): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <div class="alert alert-success mb-2">
                    <div class="d-flex justify-content-between">
                        <div>
                            <strong><?php echo e($producto->nombre); ?></strong> x <?php echo e($producto->pivot->cantidad); ?><br>
                            <?php if($producto->pivot->comentarios): ?>
                            <small><em><?php echo e($producto->pivot->comentarios); ?></em></small>
                            <?php endif; ?>
                        </div>
                        <span class="text-success">
                            <i class="fas fa-check"></i>
                        </span>
                    </div>
                </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <div class="alert alert-light text-center">
                    <i class="fas fa-clock text-warning"></i> Esperando productos
                </div>
                <?php endif; ?>
            </div>
        </div>

        <?php if($comanda->productos->where('pivot.estado', 'pendiente')->count() == 0): ?>
        <div class="mt-4">
            <h5 class="text-center text-success mb-3">
                <i class="fas fa-check-double"></i> ¡Comanda completa!
            </h5>
            <form method="POST" action="<?php echo e(route('comandas.cambiarEstado', $comanda->id)); ?>">
                <?php echo csrf_field(); ?>
                <?php echo method_field('PUT'); ?>
                <input type="hidden" name="estado" value="lista">
                <button class="btn btn-success w-100 py-2 fw-bold" style="font-size: 1.1rem;">
                    <i class="fas fa-paper-plane"></i> MARCAR COMO LISTA PARA ENTREGAR
                </button>
            </form>
        </div>
        <?php endif; ?>
    </div>
</div>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('scripts'); ?>
<script>
    document.querySelectorAll('.producto-check').forEach(checkbox => {
        checkbox.addEventListener('change', function() {
            const comandaId = this.dataset.comanda;
            const productoId = this.dataset.producto;
            const productoItem = document.getElementById(`producto-${comandaId}-${productoId}`);

            if (this.checked) {
                // Deshabilitar el checkbox inmediatamente
                this.disabled = true;

                // Mostrar feedback visual
                productoItem.classList.add('processing');

                fetch(`/comandas/${comandaId}/producto/${productoId}/estado`, {
                        method: 'PUT',
                        headers: {
                            'X-CSRF-TOKEN': '<?php echo e(csrf_token()); ?>',
                            'Content-Type': 'application/json',
                            'Accept': 'application/json'
                        },
                        body: JSON.stringify({
                            estado: 'preparado'
                        })
                    })
                    .then(response => {
                        if (!response.ok) throw new Error('Error en la respuesta');
                        return response.json();
                    })
                    .then(data => {
                        // Actualizar la interfaz sin recargar
                        const comandaCard = document.getElementById(`comanda-${comandaId}`);
                        const preparadosSection = comandaCard.querySelector('.col-md-6:last-child');
                        const pendientesSection = comandaCard.querySelector('.col-md-6:first-child');

                        // Crear el elemento del producto preparado
                        const preparadoDiv = document.createElement('div');
                        preparadoDiv.className = 'alert alert-success mb-2';
                        preparadoDiv.innerHTML = `
                        <div class="d-flex justify-content-between">
                            <div>
                                <strong>${productoItem.querySelector('strong').innerText}</strong> ${productoItem.innerText.split('\n')[1].trim()}<br>
                                ${productoItem.querySelector('small') ? productoItem.querySelector('small').outerHTML : ''}
                            </div>
                            <span class="text-success">
                                <i class="fas fa-check"></i>
                            </span>
                        </div>
                    `;

                        // Agregar al inicio de la sección de preparados
                        preparadosSection.querySelector('h5').insertAdjacentElement('afterend', preparadoDiv);

                        // Eliminar el elemento de pendientes
                        productoItem.remove();

                        // Actualizar contadores
                        const pendientesCount = pendientesSection.querySelectorAll('.alert-warning').length;
                        const preparadosCount = preparadosSection.querySelectorAll('.alert-success').length + 1; // +1 porque aún no se ha agregado

                        pendientesSection.querySelector('h5 .badge').textContent = pendientesCount;
                        preparadosSection.querySelector('h5 .badge').textContent = preparadosCount;

                        // Verificar si no hay más pendientes para mostrar el botón
                        if (pendientesCount === 0) {
                            const completeDiv = document.createElement('div');
                            completeDiv.className = 'mt-4';
                            completeDiv.innerHTML = `
                            <h5 class="text-center text-success mb-3">
                                <i class="fas fa-check-double"></i> ¡Comanda completa!
                            </h5>
                            <form method="POST" action="/comandas/${comandaId}/estado">
                                <?php echo csrf_field(); ?>
                                <?php echo method_field('PUT'); ?>
                                <input type="hidden" name="estado" value="lista">
                                <button class="btn btn-success w-100 py-2 fw-bold" style="font-size: 1.1rem;">
                                    <i class="fas fa-paper-plane"></i> MARCAR COMO LISTA PARA ENTREGAR
                                </button>
                            </form>
                        `;
                            comandaCard.querySelector('.card-body').appendChild(completeDiv);

                            // Actualizar título de la tarjeta
                            comandaCard.querySelector('.card-header .badge').className = 'badge bg-success text-white';
                            comandaCard.querySelector('.card-header .badge').textContent = 'Lista para entregar';
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        this.checked = false;
                        this.disabled = false;
                        productoItem.classList.remove('processing');
                        alert('Ocurrió un error al actualizar el estado');
                    });
            }
        });
    });
</script>
<style>
    .processing {
        opacity: 0.6;
        background-color: #f8f9fa;
        transition: all 0.3s ease;
    }

    .producto-check {
        cursor: pointer;
        transform: scale(1.3);
        margin-left: 10px;
    }

    .alert {
        transition: all 0.3s ease;
    }

    .border-end {
        border-right: 1px solid #dee2e6 !important;
    }

    .btn-success {
        background-color: #28a745;
        border-color: #28a745;
        box-shadow: 0 2px 5px rgba(40, 167, 69, 0.3);
        transition: all 0.3s ease;
    }

    .btn-success:hover {
        background-color: #218838;
        border-color: #1e7e34;
        transform: translateY(-1px);
        box-shadow: 0 4px 8px rgba(40, 167, 69, 0.4);
    }

    .badge {
        font-size: 0.8em;
        padding: 0.35em 0.65em;
    }
</style>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\comida-app\resources\views/cocina/index.blade.php ENDPATH**/ ?>