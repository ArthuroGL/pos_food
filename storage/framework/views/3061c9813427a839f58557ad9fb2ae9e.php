<div class="col-12 col-md-6 col-lg-4 mb-4">
    <div class="card h-100 border shadow-sm">
        <div class="card-body d-flex flex-column justify-content-between">
            <div class="d-flex align-items-start">
                <input type="checkbox" name="productos[<?php echo e($producto->id); ?>][selected]"
                    value="1" class="form-check-input me-2 mt-1" id="check_<?php echo e($producto->id); ?>">

                <div class="flex-grow-1">
                    <label for="check_<?php echo e($producto->id); ?>" class="form-label">
                        <strong><?php echo e($producto->nombre); ?></strong><br>
                        <small class="text-muted"><?php echo e($producto->descripcion); ?></small>
                    </label>
                    <p class="text-success mt-1 fw-bold">$<?php echo e(number_format($producto->precio, 2)); ?></p>
                </div>

                <div class="ms-2" style="width: 60px; height: 60px;">
                    <img src="<?php echo e($producto->imagen ? asset('storage/' . $producto->imagen) : 'https://via.placeholder.com/60x60?text=No+img'); ?>"
                        alt="<?php echo e($producto->nombre); ?>" class="img-thumbnail img-fluid"
                        style="object-fit: cover; width: 100%; height: 100%;">
                </div>
            </div>

            <div class="mt-3">
                <div class="row">
                    <div class="col-4">
                        <label class="form-label">Cant.</label>
                        <input type="number" name="productos[<?php echo e($producto->id); ?>][cantidad]" value="1"
                            min="1" class="form-control form-control-sm">
                    </div>
                    <div class="col-8">
                        <label class="form-label">Comentarios</label>
                        <input type="text" name="productos[<?php echo e($producto->id); ?>][comentarios]"
                            class="form-control form-control-sm" placeholder="Ej. sin cebolla, bien cocido">
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php /**PATH C:\laragon\www\comida-app\resources\views/comandas/_producto_card.blade.php ENDPATH**/ ?>