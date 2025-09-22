<?php $__env->startSection('title', 'Usuarios'); ?>

<?php $__env->startSection('content_header'); ?>
<h1>Usuarios registrados</h1>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<div class="container-fluid">
    
    <div class="mb-3">
        <a href="<?php echo e(route('registration')); ?>" class="btn btn-primary" style="background-color: #3c8dbc;">
            <i class="fas fa-user-plus"></i> Registrar nuevo usuario
        </a>
    </div>

    
    <div class="card card-info card-outline">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h3 class="card-title">Lista de usuarios</h3>

            
            <form method="GET" action="<?php echo e(route('users')); ?>">
                <div class="input-group input-group-sm" style="width: 250px;">
                    <input type="text" name="search" class="form-control float-right" placeholder="Buscar" value="<?php echo e(request('search')); ?>">
                    <div class="input-group-append">
                        <button type="submit" class="btn btn-default" title="Buscar">
                            <i class="fas fa-search"></i>
                        </button>
                    </div>
                </div>
            </form>
        </div>

        
        <div class="row p-3">
            <?php $__empty_1 = true; $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            <div class="col-md-3 col-sm-6 mb-4">
                <div class="card text-center h-100">
                    <h5 class="card-title"><?php echo e($user->full_name); ?> </h5>
                    <div class="card-body">
                        <img src="<?php echo e(asset('images/cook-svgrepo-com.svg')); ?>" alt="User Image" class="img-circle elevation-1" style="width: 80px; height: 80px;">
                        <p class="card-text text-muted"><?php echo e($user->email); ?></p>
                        <span class="badge" style="background-color: #274472; color: white;">
                            <?php if($user->is_role == 1): ?>
                            Admin
                            <?php else: ?>
                            Usuario
                            <?php endif; ?>
                        </span>
                        <p><strong>Rol:</strong> <?php echo e($user->getRoleNames()->implode(', ')); ?></p>
                    </div>
                    <div class="card-footer d-flex justify-content-around">
                        <a href="<?php echo e(route('users.view', $user->id)); ?>" class="btn btn-sm btn-info" style="background: #3c8dbc;" title="Ver información">
                            <i class="fas fa-eye"></i>
                        </a>

                        <?php if(Auth::user()->id !== $user->id): ?>
                        <form action="<?php echo e(route('users.destroy', $user->id)); ?>" method="POST" onsubmit="return confirm('¿Estás seguro de que deseas eliminar este usuario?');">
                            <?php echo csrf_field(); ?>
                            <?php echo method_field('DELETE'); ?>
                            <button type="submit" class="btn btn-sm btn-danger" title="Eliminar"><i class="fas fa-trash"></i></button>
                        </form>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            <div class="col-12">
                <div class="alert alert-info text-center">No hay usuarios registrados aún.</div>
            </div>
            <?php endif; ?>
        </div>


        
        <div class="card-footer clearfix">
            <?php echo e($users->appends(['search' => request('search')])->links('pagination::bootstrap-4')); ?>

        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\comida-app\resources\views/users/index.blade.php ENDPATH**/ ?>