<?php $__env->startSection('title', 'Nuevo Producto'); ?>

<?php $__env->startSection('content'); ?>
<h2 class="text-xl font-semibold mb-4">Nuevo producto</h2>

<form method="POST" action="<?php echo e(route('productos.store')); ?>" enctype="multipart/form-data">

    <?php echo csrf_field(); ?>
    <div class="form-group">
        <label for="imagen">Imagen del producto:</label>
        <input type="file" name="imagen" id="imagen" class="form-control-file">
    </div>

    <div class="form-group">
        <label for="nombre">Nombre:</label>
        <input type="text" name="nombre" id="nombre" required class="form-control">
    </div>

    <div class="form-group">
        <label for="precio">Precio:</label>
        <input type="number" name="precio" id="precio" step="0.01" required class="form-control">
    </div>

    <div class="form-group">
        <label for="categoria_id">Categoría:</label>
        <select name="categoria_id" id="categoria_id" class="form-control" required>
            <?php $__currentLoopData = $categorias; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $categoria): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <option value="<?php echo e($categoria->id); ?>"><?php echo e(ucfirst($categoria->nombre)); ?></option>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </select>
    </div>
    <div class="form-group">
        <label for="descripcion">Descripción:</label>
        <textarea name="descripcion" id="descripcion" rows="3" class="form-control"></textarea>
    </div>

    <div class="form-group">
        <label>Complementos:</label>
        <div class="form-check">
            <label><input type="checkbox" name="complementos[]" value="cebolla"> Cebolla</label>
        </div>
        <div class="form-check">
            <label><input type="checkbox" name="complementos[]" value="cilantro"> Cilantro</label>
        </div>
        <div class="form-check">
            <label><input type="checkbox" name="complementos[]" value="lechuga"> Lechuga</label>
        </div>
        <div class="form-check">
            <label><input type="checkbox" name="complementos[]" value="queso"> Queso</label>
        </div>
        <div class="form-check">
            <label><input type="checkbox" name="complementos[]" value="crema"> Crema</label>
        </div>
    </div>

    <button type="submit" class="btn btn-success mt-3">Guardar producto</button>
</form>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\comida-app\resources\views/productos/create.blade.php ENDPATH**/ ?>