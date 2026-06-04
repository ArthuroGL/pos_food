<?php $__env->startSection('title', 'Detalles del Usuario'); ?>
<?php $__env->startSection('view_title', '🪪 Expediente de Personal'); ?>
<?php $__env->startSection('view_subtitle', 'Visualización de datos generales del empleado y gestión de identidad visual'); ?>

<?php $__env->startSection('content'); ?>
<div class="h-full w-full p-6 overflow-y-auto sheet-layout bg-slate-100 text-slate-800 scroll-custom flex flex-col">

    
    <div class="w-full max-w-4xl mx-auto flex flex-col flex-1">

        
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-6 w-full">
            <div>
                <h2 class="text-xl font-black text-slate-900 tracking-tight m-0">Ficha del Usuario</h2>
                <p class="text-xs font-medium text-slate-400 mt-1 m-0">Información detallada del operador y credenciales asignadas</p>
            </div>
            <a href="<?php echo e(route('users')); ?>"
               class="w-full sm:w-auto bg-slate-200 hover:bg-slate-300 active:scale-[0.98] transition-all text-slate-700 font-black px-4 py-2.5 rounded-xl text-xs tracking-wide cursor-pointer flex items-center justify-center gap-2 border border-slate-300 uppercase">
                <i class="fas fa-arrow-left text-[10px]"></i> Volver a la lista
            </a>
        </div>

        
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 items-start w-full mb-6">

            
            <div class="bg-white border border-slate-200 rounded-2xl p-6 flex flex-col items-center text-center shadow-3xs">
                <span class="text-[10px] font-black uppercase tracking-wider text-slate-400 block mb-4">
                    Fotografía Oficial
                </span>

               <div class="relative group h-32 w-32 bg-slate-50 border border-slate-200 rounded-full flex items-center justify-center p-2 mb-4 shadow-2xs overflow-hidden">
    <img id="profile-avatar-preview"
         src="<?php echo e($user->profile_avatar_url); ?>"
         alt="Avatar de <?php echo e($user->name); ?>"
         class="w-full h-full object-cover rounded-full transition-transform duration-300 group-hover:scale-105">
</div>

<p class="text-[11px] font-medium text-slate-400 max-w-[200px] mb-4">
    Formatos admitidos: JPG, PNG. Máximo 2MB de tamaño.
</p>


<form action="<?php echo e(route('users.updateAvatar', $user->id)); ?>" method="POST" enctype="multipart/form-data" class="w-full m-0">
    <?php echo csrf_field(); ?>
    <input type="file" name="avatar" id="avatar-input" class="hidden" accept="image/*" onchange="previewImage(this)">

    <button type="button"
            onclick="document.getElementById('avatar-input').click()"
            class="w-full bg-slate-100 hover:bg-slate-200 active:scale-[0.98] transition-all text-slate-700 font-black px-4 py-2.5 rounded-xl text-xs tracking-wide cursor-pointer flex items-center justify-center gap-2 border border-slate-200 uppercase">
        <i class="fas fa-camera text-slate-400 text-xs"></i> Cambiar Imagen
    </button>

    
    <button type="submit"
            id="btn-save-avatar"
            class="hidden w-full mt-2 bg-emerald-600 hover:bg-emerald-700 active:scale-[0.98] transition-all text-white font-black px-4 py-2.5 rounded-xl text-xs tracking-wide cursor-pointer flex items-center justify-center gap-2 border-0 uppercase shadow-xs">
        <i class="fas fa-check text-xs"></i> Confirmar Cambio
    </button>
</form>
            </div>

            
            <div class="bg-white border border-slate-200 rounded-2xl shadow-3xs overflow-hidden md:col-span-2 h-full flex flex-col">
                <div class="p-6 flex-1 space-y-5">
                    <span class="text-xs font-black uppercase tracking-wider text-orange-600 block pb-1 border-b border-slate-100">
                        📄 Datos Generales del Empleado
                    </span>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                        
                        <div class="sm:col-span-2">
                            <label class="text-[10px] font-black uppercase tracking-wider text-slate-400 block mb-1">Nombre Completo</label>
                            <div class="bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-sm font-black text-slate-800">
                                <?php echo e($user->full_name); ?>

                            </div>
                        </div>

                        
                        <div>
                            <label class="text-[10px] font-black uppercase tracking-wider text-slate-400 block mb-1">Correo Electrónico</label>
                            <div class="bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-sm font-mono font-bold text-slate-700 truncate" title="<?php echo e($user->email); ?>">
                                <?php echo e($user->email); ?>

                            </div>
                        </div>

                        
                        <div>
                            <label class="text-[10px] font-black uppercase tracking-wider text-slate-400 block mb-1">Teléfono de Contacto</label>
                            <div class="bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-sm font-mono font-bold text-slate-700">
                                <?php echo e($user->phone ?: 'No registrado'); ?>

                            </div>
                        </div>

                        
                        <div class="sm:col-span-2">
                            <label class="text-[10px] font-black uppercase tracking-wider text-slate-400 block mb-1">Rol Operativo Asignado</label>
                            <div class="flex items-center gap-2 bg-slate-50 border border-slate-200 rounded-xl px-4 py-3">
                                <span class="h-2 w-2 rounded-full bg-orange-500 animate-pulse"></span>
                                <span class="text-xs font-black uppercase tracking-wide text-slate-800">
                                    <?php echo e($user->getRoleNames()->implode(', ') ?: 'Sin Rol Comercial'); ?>

                                </span>
                            </div>
                        </div>
                    </div>
                </div>

                
                <div class="px-6 py-3.5 bg-slate-50 border-t border-slate-200 flex items-center justify-between text-[11px] font-medium text-slate-400">
                    <span>Estatus en plataforma: <strong class="text-emerald-600 font-bold uppercase">Activo</strong></span>
                    <span>ID de Control: #<?php echo e(str_pad($user->id, 5, '0', STR_PAD_LEFT)); ?></span>
                </div>
            </div>

        </div>

    </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('scripts'); ?>
<script>
    /**
     * Previsualiza la imagen local seleccionada por el usuario antes de subirla
     */
    function previewImage(input) {
        if (input.files && input.files[0]) {
            const reader = new FileReader();

            reader.onload = function(e) {
                // Actualiza el src de la imagen de prueba
                document.getElementById('profile-avatar-preview').src = e.target.result;

                // Muestra el botón de confirmación de manera fluida
                const btnSave = document.getElementById('btn-save-avatar');
                btnSave.classList.remove('hidden');
                btnSave.classList.add('flex');
            }

            reader.readAsDataURL(input.files[0]);
        }
    }
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.pos', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\comida-app\resources\views/users/show.blade.php ENDPATH**/ ?>