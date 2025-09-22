<?php $__env->startSection('title', 'Reporte de Ventas'); ?>

<?php $__env->startSection('content'); ?>
<div class="container">
    <h2>Reporte de Ventas - Filtro: <?php echo e(ucfirst($filtro)); ?></h2>

    <form method="GET" action="#" class="mb-3">
        <select name="filtro" onchange="this.form.submit()" class="form-select w-auto d-inline">
            <option value="hoy" <?php echo e($filtro == 'hoy' ? 'selected' : ''); ?>>Hoy</option>
            <option value="semana" <?php echo e($filtro == 'semana' ? 'selected' : ''); ?>>Esta Semana</option>
            <option value="mes" <?php echo e($filtro == 'mes' ? 'selected' : ''); ?>>Este Mes</option>
            <option value="año" <?php echo e($filtro == 'año' ? 'selected' : ''); ?>>Este Año</option>
        </select>

        <a href="#" class="btn btn-success ms-3">
            Exportar a Excel
        </a>
    </form>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Mesa</th>
                <th>Fecha</th>
                <th>Productos</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody>
            <?php $__currentLoopData = $comandas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $comanda): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <?php $suma = 0; ?>
            <tr>
                <td><?php echo e($comanda->mesa->nombre); ?></td>
                <td><?php echo e($comanda->created_at->format('d/m/Y H:i')); ?></td>
                <td>
                    <ul>
                        <?php $__currentLoopData = $comanda->productos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $producto): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <?php
                        $subtotal = $producto->precio * $producto->pivot->cantidad;
                        $suma += $subtotal;
                        ?>
                        <li><?php echo e($producto->nombre); ?> x<?php echo e($producto->pivot->cantidad); ?> - $<?php echo e(number_format($subtotal, 2)); ?></li>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </ul>
                </td>
                <td>$<?php echo e(number_format($suma, 2)); ?></td>
            </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </tbody>
    </table>

    <h4 class="mt-4">Total general: $<?php echo e(number_format($total, 2)); ?></h4>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\comida-app\resources\views/reportes/index.blade.php ENDPATH**/ ?>