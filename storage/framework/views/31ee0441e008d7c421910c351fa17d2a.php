<?php $__env->startSection('content'); ?>
<div class="container">
    <h2>Editar Producto</h2>

    <form action="<?php echo e(route('productos.update', $producto)); ?>" method="POST" enctype="multipart/form-data">
        <?php echo csrf_field(); ?>
        <?php echo method_field('PUT'); ?>
        <div class="mb-3">
            <label for="imagen" class="form-label">Imagen del producto</label>
            <input type="file" name="imagen" class="form-control">

            <?php if($producto->imagen): ?>
            <div class="mt-2">
                <img src="<?php echo e(asset('storage/' . $producto->imagen)); ?>" alt="Imagen actual" style="height: 100px;">
            </div>
            <?php endif; ?>
        </div>

        <div class="mb-3">
            <label for="nombre" class="form-label">Nombre</label>
            <input type="text" name="nombre" class="form-control" value="<?php echo e(old('nombre', $producto->nombre)); ?>" required>
        </div>

        <div class="mb-3">
            <label for="precio" class="form-label">Precio</label>
            <input type="number" step="0.01" name="precio" class="form-control" value="<?php echo e(old('precio', $producto->precio)); ?>" required>
        </div>

        <div class="mb-3">
            <label for="descripcion" class="form-label">Descripción</label>
            <textarea name="descripcion" class="form-control"><?php echo e(old('descripcion', $producto->descripcion)); ?></textarea>
        </div>

        <div class="mb-3">
            <label for="categoria_id" class="form-label">Categoría</label>
            <select name="categoria_id" class="form-control" required>
                <?php $__currentLoopData = $categorias; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $categoria): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <option value="<?php echo e($categoria->id); ?>" <?php echo e($producto->categoria_id == $categoria->id ? 'selected' : ''); ?>>
                    <?php echo e($categoria->nombre); ?>

                </option>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </select>
        </div>

        <button type="submit" class="btn btn-primary">Guardar Cambios</button>
    </form>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\comida-app\resources\views/productos/edit.blade.php ENDPATH**/ ?>