<?php $__env->startSection('title', 'Detalles del Usuario'); ?>

<?php $__env->startSection('content'); ?>
<div class="container">
    <h1>Detalles del usuario</h1>
    <p><strong>Nombre:</strong> <?php echo e($user->full_name); ?></p>
    <p><strong>Email:</strong> <?php echo e($user->email); ?></p>
    <p><strong>Teléfono:</strong> <?php echo e($user->phone); ?></p>
    <p><strong>Rol:</strong> <?php echo e($user->getRoleNames()->implode(', ')); ?></p>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\comida-app\resources\views/users/show.blade.php ENDPATH**/ ?>