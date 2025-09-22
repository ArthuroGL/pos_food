<?php $__env->startSection('title', 'Panel de Administración'); ?>


<?php $__env->startSection('content_header', 'Panel de Control'); ?>
<?php $__env->startSection('content'); ?>
<div class="row">
    <div class="col-md-4">
        <div class="small-box bg-success">
            <div class="inner">
                <h3>Comidas</h3>
                <p>Gestión de platillos</p>
            </div>
            <div class="icon"><i class="fas fa-hamburger"></i></div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="small-box bg-info">
            <div class="inner">
                <h3>Mesas</h3>
                <p>Administrar ubicación</p>
            </div>
            <div class="icon"><i class="fas fa-chair"></i></div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="small-box bg-warning">
            <div class="inner">
                <h3>Productos</h3>
                <p>Inventario general</p>
            </div>
            <div class="icon"><i class="fas fa-boxes"></i></div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\comida-app\resources\views/admin/dashboard.blade.php ENDPATH**/ ?>