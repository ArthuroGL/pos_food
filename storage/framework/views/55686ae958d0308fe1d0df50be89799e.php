<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Ticket</title>
    <style>
        body { font-family: Arial, sans-serif; font-size: 14px; }
        .header, .footer { text-align: center; }
        .line { border-top: 1px dashed #000; margin: 10px 0; }
    </style>
</head>
<body>
    <div class="header">
        <h3>Sistema de Comandas</h3>
        <p><strong>Mesa:</strong> <?php echo e($comanda->mesa->nombre); ?></p>
        <p><strong>Fecha:</strong> <?php echo e($comanda->created_at->format('d/m/Y H:i')); ?></p>
    </div>

    <div class="line"></div>

    <h4>Productos</h4>
    <ul>
        <?php $__currentLoopData = $comanda->productos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $producto): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <li>
                <?php echo e($producto->nombre); ?> x <?php echo e($producto->pivot->cantidad); ?>

                - $<?php echo e(number_format($producto->precio, 2)); ?>

                <br>
                <small>Subtotal: $<?php echo e(number_format($producto->precio * $producto->pivot->cantidad, 2)); ?></small>
                <?php if($producto->pivot->comentarios): ?>
                    <br><em>Comentario: <?php echo e($producto->pivot->comentarios); ?></em>
                <?php endif; ?>
                <hr>
            </li>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </ul>

    <h4>Total: $<?php echo e(number_format($total, 2)); ?></h4>

    <div class="footer">
        <p>¡Gracias por su visita!</p>
    </div>
</body>
</html>
<?php /**PATH C:\laragon\www\comida-app\resources\views/comandas/ticket.blade.php ENDPATH**/ ?>