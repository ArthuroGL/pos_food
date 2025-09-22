<?php $__env->startSection('title', 'Agregar Productos Extra'); ?>

<?php $__env->startSection('content'); ?>
<div class="container">
    <h1 class="mb-4">Agregar Productos Extra - Mesa <?php echo e($comanda->mesa->nombre); ?></h1>

    <div class="alert alert-info">
        <i class="fas fa-info-circle"></i> Estás agregando productos adicionales a esta comanda.
        Los nuevos productos serán enviados directamente a cocina.
    </div>

    <form method="POST" action="<?php echo e(route('comandas.update', $comanda)); ?>">
        <?php echo csrf_field(); ?>
        <?php echo method_field('PUT'); ?>

        <input type="hidden" name="mesa_id" value="<?php echo e($comanda->mesa_id); ?>">

        <div class="form-group mb-4">
            <h4>Productos Actuales:</h4>
            <ul class="list-group">
                <?php $__currentLoopData = $comanda->productos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $producto): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <li class="list-group-item">
                    <?php echo e($producto->nombre); ?> - Cantidad: <?php echo e($producto->pivot->cantidad); ?>

                    <?php if($producto->pivot->comentarios): ?>
                    <br><small>Comentario: <?php echo e($producto->pivot->comentarios); ?></small>
                    <?php endif; ?>
                </li>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </ul>
        </div>

        <div class="form-group mb-4">
            <h4>Seleccionar Productos Adicionales:</h4>
            <div class="row">
                <?php $__currentLoopData = $productos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $producto): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="col-md-4 mb-3">
                    <div class="card h-100">
                        <div class="card-body">
                            <div class="form-check">
                                <input type="checkbox"
                                    class="form-check-input"
                                    name="productos[<?php echo e($producto->id); ?>][selected]"
                                    id="prod-<?php echo e($producto->id); ?>"
                                    value="1">
                                <label class="form-check-label" for="prod-<?php echo e($producto->id); ?>">
                                    <strong><?php echo e($producto->nombre); ?></strong> ($<?php echo e(number_format($producto->precio, 2)); ?>)
                                </label>
                            </div>
                            <div class="mt-2">
                                <label>Cantidad:</label>
                                <input type="number"
                                    name="productos[<?php echo e($producto->id); ?>][cantidad]"
                                    class="form-control"
                                    value="1"
                                    min="1">
                            </div>
                            <div class="mt-2">
                                <label>Comentarios:</label>
                                <input type="text"
                                    name="productos[<?php echo e($producto->id); ?>][comentarios]"
                                    class="form-control"
                                    placeholder="Ej. sin cebolla">
                            </div>
                        </div>
                    </div>
                </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
        </div>

        <div class="text-end mt-4">
            <a href="<?php echo e(route('comandas.index')); ?>" class="btn btn-secondary">
                <i class="fas fa-times"></i> Cancelar
            </a>
            <button type="submit" class="btn btn-primary">
                <i class="fas fa-paper-plane"></i> Enviar a Cocina
            </button>
        </div>
    </form>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\comida-app\resources\views/comandas/edit.blade.php ENDPATH**/ ?>