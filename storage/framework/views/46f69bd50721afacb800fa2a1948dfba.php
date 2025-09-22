<?php $__env->startSection('content'); ?>
<div class="container-fluid">
    <h2 class="mb-4">Lista de productos</h2>

    <a href="<?php echo e(route('productos.create')); ?>" class="btn btn-primary mb-3">
        <i class="fas fa-plus"></i> Agregar producto
    </a>

    <?php $__currentLoopData = $categorias; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $categoria): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
    <?php if($categoria->productos->isNotEmpty()): ?>
    <div class="card card-primary card-outline mb-4">
        <div class="card-header">
            <h5 class="card-title mb-0"><?php echo e(ucfirst($categoria->nombre)); ?></h5>
        </div>
        <div class="card-body">
            <div class="row">
                <?php $__currentLoopData = $categoria->productos->sortBy('nombre'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $producto): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="col-12 col-sm-6 col-md-4 col-lg-3 mb-4">
                    <div class="card producto-card h-100 border-0">
                        <?php if($producto->imagen): ?>
                        <img src="<?php echo e(asset('storage/' . $producto->imagen)); ?>"
                            alt="<?php echo e($producto->nombre); ?>"
                            class="producto-img">
                        <?php else: ?>
                        <img src="https://via.placeholder.com/300x180?text=Sin+imagen"
                            alt="Sin imagen"
                            class="producto-img">
                        <?php endif; ?>

                        <div class="card-body p-3 d-flex flex-column">

                            <div>
                                <strong><?php echo e($producto->nombre); ?></strong><br>
                                <small><?php echo e($producto->descripcion); ?></small>
                            </div>
                            <div class="d-flex justify-content-between align-items-center mt-2">
                                <span class="text-success fw-bold">$<?php echo e(number_format($producto->precio, 2)); ?></span>
                                <div>
                                    <a href="<?php echo e(route('productos.edit', $producto)); ?>" class="btn btn-sm btn-warning">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="<?php echo e(route('productos.destroy', $producto)); ?>" method="POST"
                                        class="d-inline" onsubmit="return confirm('¿Estás seguro?')">
                                        <?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
                                        <button class="btn btn-sm btn-danger"><i class="fas fa-trash"></i></button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>

        </div>
    </div>
    <?php endif; ?>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
</div>
<?php $__env->stopSection(); ?>


<style>
    .transition-hover {
        transition: all 0.3s ease-in-out;
    }

    .transition-hover:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.12);
    }

    .card-title,
    .card-text {
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .producto-img {
        width: 40%;
        height: 40%;
        object-fit: nherit;
        object-position: center;
        border-radius: .25rem;
        display: block;
        max-height: 150px;
    }

    .producto-card {
        transition: all 0.3s ease-in-out;
    }

    .producto-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 10px 20px rgba(0, 0, 0, 0.12);
    }
</style>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\comida-app\resources\views/productos/index.blade.php ENDPATH**/ ?>