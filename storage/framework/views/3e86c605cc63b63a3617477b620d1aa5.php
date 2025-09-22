<?php
$rol = Auth::user()->is_role;
?>


<?php $__env->startSection('title', 'Comandas'); ?>

<?php $__env->startSection('content'); ?>
<div>
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Comandas Activas</h2>
        <?php if($rol != 1): ?> 
        <a href="<?php echo e(route('comandas.create')); ?>" class="btn btn-primary">
            <i class="fas fa-plus"></i> Nueva Comanda
        </a>
        <?php endif; ?>
    </div>

    <?php $__currentLoopData = $comandas->whereIn('estado', ['pendiente', 'en_cocina', 'lista']); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $comanda): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
    <div class="card mb-3">
        <div class="card-header">
            <strong><?php echo e($comanda->mesa->nombre); ?></strong> - <?php echo e($comanda->created_at->format('d/m/Y H:i')); ?>

        </div>
        <div class="card-body">
            <ul>
                <?php $total = 0; ?>
                <?php $__empty_1 = true; $__currentLoopData = $comanda->productos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $producto): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <?php
                $subtotal = $producto->precio * $producto->pivot->cantidad;
                $total += $subtotal;
                ?>
                <li>
                    <?php echo e($producto->nombre); ?> - $<?php echo e(number_format($producto->precio, 2)); ?>

                    <strong>x <?php echo e($producto->pivot->cantidad); ?></strong>
                    <br>
                    <small>Subtotal: $<?php echo e(number_format($subtotal, 2)); ?></small>

                    <?php if($producto->pivot->comentarios): ?>
                    <br><em>Comentario: <?php echo e($producto->pivot->comentarios); ?></em>
                    <?php endif; ?>
                </li>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <li>No hay productos</li>
                <?php endif; ?>
            </ul>

            <div class="mt-3">
                <strong>Total: $<?php echo e(number_format($total, 2)); ?></strong>
            </div>


            <div class="text-end">
                <a href="<?php echo e(route('comandas.edit', $comanda)); ?>" class="btn btn-sm btn-warning">
                    <i class="fas fa-edit"></i>
                </a>
            </div>
            
            <form method="POST" action="<?php echo e(route('comandas.cambiarEstado', $comanda->id)); ?>" class="d-inline">
                <?php echo csrf_field(); ?>
                <?php echo method_field('PUT'); ?>
                <div class="btn-group mt-2">
                    <?php
                    $colores = [
                    'pendiente' => 'bg-orange',
                    'en_cocina' => 'btn-warning text-dark',
                    'lista' => 'btn-success',
                    'entregada' => 'btn-secondary',
                    'cancelada' => 'btn-danger',
                    ];

                    $botones_estado = [];

                    if ($rol == 2) {
                    $botones_estado = ['pendiente', 'en_cocina', 'lista', 'entregada', 'cancelada'];
                    } elseif ($rol == 0) {
                    $botones_estado = ['pendiente', 'en_cocina', 'lista'];
                    }
                    ?>

                    <?php $__currentLoopData = $botones_estado; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $estado): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <button class="btn btn-sm <?php echo e($comanda->estado === $estado ? $colores[$estado] : 'btn-outline-secondary'); ?>"
                        name="estado" value="<?php echo e($estado); ?>">
                        <?php echo e(ucfirst(str_replace('_', ' ', $estado))); ?>

                    </button>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            </form>

            
            <?php if($rol == 0 && $comanda->estado === 'lista' && !$comanda->cuenta_generada): ?>
            <form action="<?php echo e(route('comandas.generarCuenta', $comanda->id)); ?>" method="POST" class="d-inline">
                <?php echo csrf_field(); ?>
                <button type="submit" class="btn btn-sm btn-info mt-2">
                    <i class="fas fa-receipt"></i> Generar Cuenta
                </button>
            </form>
            <?php endif; ?>

            
            <?php if($rol == 0 && $comanda->estado === 'lista' && $comanda->cuenta_generada): ?>
            <form method="POST" action="<?php echo e(route('comandas.cambiarEstado', $comanda->id)); ?>" class="d-inline">
                <?php echo csrf_field(); ?>
                <?php echo method_field('PUT'); ?>
                <button type="submit" name="estado" value="entregada" class="btn btn-sm btn-secondary mt-2">
                    <i class="fas fa-check"></i> Marcar como Entregada
                </button>
            </form>
            <?php endif; ?>

            
            <?php if($rol == 2): ?>
            <form action="<?php echo e(route('comandas.generarCuenta', $comanda->id)); ?>" method="POST" class="d-inline">
                <?php echo csrf_field(); ?>
                <button type="submit" class="btn btn-sm btn-info mt-2">
                    <i class="fas fa-receipt"></i> Generar Cuenta
                </button>
            </form>

            <form method="POST" action="<?php echo e(route('comandas.cambiarEstado', $comanda->id)); ?>" class="d-inline">
                <?php echo csrf_field(); ?>
                <?php echo method_field('PUT'); ?>
                <button type="submit" name="estado" value="entregada" class="btn btn-sm btn-secondary mt-2">
                    <i class="fas fa-check"></i> Marcar como Entregada
                </button>
            </form>
            <?php endif; ?>

        </div>
    </div>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\comida-app\resources\views/comandas/index.blade.php ENDPATH**/ ?>