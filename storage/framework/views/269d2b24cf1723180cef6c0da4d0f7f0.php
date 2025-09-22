<?php $__env->startSection('content'); ?>
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <?php if(session('success')): ?>
                <div class="alert alert-success"><?php echo e(session('success')); ?></div>
            <?php endif; ?>

            <div class="card shadow">
                <div class="card-header bg-primary text-white">Registro de Usuario</div>

                <div class="card-body">
                    <form method="POST" action="<?php echo e(route('registration_post')); ?>">
                        <?php echo csrf_field(); ?>

                        
                        <div class="form-group mb-3">
                            <label>Nombre</label>
                            <input type="text" name="name" class="form-control" value="<?php echo e(old('name')); ?>" required>
                        </div>

                        
                        <div class="form-row mb-3">
                            <div class="col">
                                <label>Apellido Paterno</label>
                                <input type="text" name="apellido_p" class="form-control" value="<?php echo e(old('apellido_p')); ?>" required>
                            </div>
                            <div class="col">
                                <label>Apellido Materno</label>
                                <input type="text" name="apellido_m" class="form-control" value="<?php echo e(old('apellido_m')); ?>" required>
                            </div>
                        </div>

                        
                        <div class="form-row mb-3">
                            <div class="col">
                                <label>Edad</label>
                                <input type="number" name="edad" class="form-control" value="<?php echo e(old('edad')); ?>" required>
                            </div>
                            <div class="col">
                                <label>Género</label>
                                <select name="genero" class="form-control" required>
                                    <option value="">Seleccionar</option>
                                    <option value="masculino" <?php echo e(old('genero') == 'masculino' ? 'selected' : ''); ?>>Masculino</option>
                                    <option value="femenino" <?php echo e(old('genero') == 'femenino' ? 'selected' : ''); ?>>Femenino</option>
                                    <option value="otro" <?php echo e(old('genero') == 'otro' ? 'selected' : ''); ?>>Otro</option>
                                </select>
                            </div>
                        </div>

                        
                        <div class="form-row mb-3">
                            <div class="col">
                                <label>Tipo de Sangre</label>
                                <input type="text" name="tipo_sangre" class="form-control" value="<?php echo e(old('tipo_sangre')); ?>">
                            </div>
                            <div class="col">
                                <label>Alergias</label>
                                <input type="text" name="alergias" class="form-control" value="<?php echo e(old('alergias')); ?>">
                            </div>
                        </div>

                        
                        <div class="form-group mb-3">
                            <label>CURP</label>
                            <input type="text" name="curp" class="form-control" value="<?php echo e(old('curp')); ?>" required maxlength="18">
                        </div>

                        
                        <div class="form-group mb-3">
                            <label>Email</label>
                            <input type="email" name="email" class="form-control" value="<?php echo e(old('email')); ?>" required>
                        </div>
                        <div class="form-row mb-3">
                            <div class="col">
                                <label>Teléfono</label>
                                <input type="text" name="phone" class="form-control" value="<?php echo e(old('phone')); ?>" required maxlength="10">
                            </div>
                            <div class="col">
                                <label>Celular</label>
                                <input type="text" name="mobile" class="form-control" value="<?php echo e(old('mobile')); ?>" required maxlength="10">
                            </div>
                        </div>

                        
                        <div class="form-group mb-3">
                            <label>Tipo de Rol</label>
                            <select name="is_role" class="form-control" required>
                                <option value="">Seleccionar Rol</option>
                                <option value="2" <?php echo e(old('is_role') == '2' ? 'selected' : ''); ?>>Administrador</option>
                                <option value="1" <?php echo e(old('is_role') == '1' ? 'selected' : ''); ?>>Cocina</option>
                                <option value="0" <?php echo e(old('is_role') == '0' ? 'selected' : ''); ?>>Mesero</option>
                            </select>
                        </div>

                        
                        <div class="form-group mb-3">
                            <label>Contraseña</label>
                            <input type="password" name="password" class="form-control" required>
                        </div>
                        <div class="form-group mb-3">
                            <label>Confirmar Contraseña</label>
                            <input type="password" name="password_confirmation" class="form-control" required>
                        </div>

                        <button type="submit" class="btn btn-success w-100">Registrar</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\comida-app\resources\views/auth/registration.blade.php ENDPATH**/ ?>