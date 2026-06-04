<?php $__env->startSection('title', 'Usuarios'); ?>
<?php $__env->startSection('view_title', '👥 Control de Personal'); ?>
<?php $__env->startSection('view_subtitle', 'Gestión de accesos, roles y perfiles operativos del sistema'); ?>

<?php $__env->startSection('content'); ?>
<div class="h-full w-full p-6 overflow-y-auto sheet-layout bg-slate-100 text-slate-800 scroll-custom flex flex-col">

    
    <div class="w-full max-w-6xl mx-auto flex flex-col flex-1 gap-6">

        
        <div class="flex flex-col lg:flex-row justify-between items-start lg:items-center gap-4">
            <div>
                <h2 class="text-xl font-black text-slate-900 tracking-tight m-0">Usuarios registrados</h2>
                <p class="text-xs font-medium text-slate-400 mt-1 m-0">Lista de personal con permisos activos en la plataforma</p>
            </div>

            
            <div class="w-full lg:w-auto flex flex-col sm:flex-row items-stretch sm:items-center gap-3">
                
                <form method="GET" action="<?php echo e(route('users')); ?>" class="m-0 relative flex-1 sm:flex-initial">
                    <input type="text" name="search"
                           class="w-full sm:w-64 bg-white border border-slate-200 focus:border-orange-500 rounded-xl pl-4 pr-10 py-2.5 text-xs font-bold text-slate-700 transition-all outline-hidden shadow-3xs placeholder-slate-400"
                           placeholder="Buscar usuario..." value="<?php echo e(request('search')); ?>">
                    <button type="submit" class="absolute right-3 inset-y-0 flex items-center text-slate-400 hover:text-slate-600 bg-transparent border-0 cursor-pointer text-xs" title="Buscar">
                        <i class="fas fa-search"></i>
                    </button>
                </form>

                
                <a href="<?php echo e(route('registration')); ?>"
                   class="bg-orange-600 hover:bg-orange-700 active:scale-[0.98] transition-all text-white font-black px-4 py-2.5 rounded-xl text-xs tracking-wide cursor-pointer flex items-center justify-center gap-2 shadow-lg shadow-orange-600/20 border-0 uppercase">
                    <i class="fas fa-user-plus text-xs"></i> Registrar nuevo usuario
                </a>
            </div>
        </div>

        
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
            <?php $__empty_1 = true; $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <div class="group bg-white border border-slate-200 rounded-2xl p-5 flex flex-col items-center text-center shadow-2xs transition-all duration-300 hover:shadow-md hover:border-slate-300 relative overflow-hidden">

                    
                    <div class="absolute top-3 right-3">
                        <?php if($user->is_role == 2): ?>
                            <span class="bg-slate-900 text-white font-mono text-[9px] font-black uppercase tracking-wider px-2 py-0.5 rounded-md">
                                Admin
                            </span>
                        <?php elseif($user->is_role == 1): ?>
                            <span class="bg-orange-600 text-white font-mono text-[9px] font-black uppercase tracking-wider px-2 py-0.5 rounded-md">
                                Cocina
                            </span>
                        <?php else: ?>
                            <span class="bg-slate-100 text-slate-600 border border-slate-200 font-mono text-[9px] font-black uppercase tracking-wider px-2 py-0.5 rounded-md">
                                Staff
                            </span>
                        <?php endif; ?>
                    </div>

                    
                    <div class="h-20 w-20 bg-slate-50 border border-slate-100 rounded-full flex items-center justify-center p-1 mb-4 shrink-0 shadow-3xs group-hover:scale-105 transition-transform duration-300 overflow-hidden">
                        <img src="<?php echo e($user->profile_avatar_url); ?>"
                             alt="Avatar de <?php echo e($user->name); ?>"
                             class="w-full h-full object-cover rounded-full"
                             onerror="this.onerror=null; this.src='<?php echo e(asset('images/cook-svgrepo-com.svg')); ?>'; this.className='w-full h-full object-contain';">
                    </div>

                    
                    <div class="w-full flex-1 min-w-0 mb-4">
                        <strong class="text-base font-black text-slate-900 tracking-tight block truncate" title="<?php echo e($user->full_name); ?>">
                            <?php echo e($user->full_name); ?>

                        </strong>
                        <span class="text-[11px] font-medium text-slate-400 block truncate mb-2" title="<?php echo e($user->email); ?>">
                            <?php echo e($user->email); ?>

                        </span>

                        <div class="inline-flex items-center gap-1 bg-orange-50 text-orange-800 border border-orange-100 px-2.5 py-0.5 rounded-lg text-[10px] font-black uppercase tracking-wide">
                            <i class="fas fa-shield-alt text-[9px] text-orange-400"></i>
                            <?php echo e($user->getRoleNames()->implode(', ') ?: 'Sin Rol asignado'); ?>

                        </div>
                    </div>

                    
                    <div class="w-full pt-3 border-t border-slate-100 flex items-center justify-center gap-2">
                        
                        <a href="<?php echo e(route('users.view', $user->id)); ?>"
                           class="h-9 flex-1 bg-slate-50 hover:bg-slate-100 text-slate-700 font-bold rounded-xl flex items-center justify-center gap-1.5 border border-slate-200 transition-all shadow-3xs text-xs active:scale-95"
                           title="Ver expediente completo">
                            <i class="fas fa-eye text-[11px] text-slate-400"></i> Ver Perfil
                        </a>

                        
                        <?php if(Auth::user()->id !== $user->id): ?>
                            <form action="<?php echo e(route('users.destroy', $user->id)); ?>"
                                  method="POST"
                                  class="m-0 form-eliminar-usuario">
                                <?php echo csrf_field(); ?>
                                <?php echo method_field('DELETE'); ?>
                                <button type="button"
                                        onclick="confirmarBajaUsuario(this, '<?php echo e($user->full_name); ?>')"
                                        class="h-9 w-9 bg-rose-50 hover:bg-rose-100 text-rose-700 rounded-xl flex items-center justify-center border border-rose-200 transition-all shadow-3xs active:scale-95 cursor-pointer"
                                        title="Dar de baja del sistema">
                                    <i class="fas fa-trash text-xs"></i>
                                </button>
                            </form>
                        <?php endif; ?>
                    </div>
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <div class="col-span-full bg-white border border-slate-200 rounded-2xl p-12 text-center shadow-2xs">
                    <div class="flex flex-col items-center justify-center text-slate-300 gap-3">
                        <i class="fas fa-users-slash text-4xl"></i>
                        <div class="text-xs font-bold uppercase tracking-wider text-slate-400">
                            No se encontraron usuarios que coincidan con la búsqueda
                        </div>
                    </div>
                </div>
            <?php endif; ?>
        </div>

        
        <?php if($users->hasPages()): ?>
            <div class="bg-white border border-slate-200 rounded-2xl p-4 shadow-2xs flex justify-center custom-pagination-wrapper">
                <?php echo e($users->appends(['search' => request('search')])->links()); ?>

            </div>
        <?php endif; ?>

    </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('scripts'); ?>
<script>
    function confirmarBajaUsuario(button, nombreUsuario) {
        const form = button.closest('.form-eliminar-usuario');

        Swal.fire({
            title: '¿Revocar acceso?',
            text: `El usuario "${nombreUsuario}" perderá todos los permisos de ingreso al sistema POS.`,
            icon: 'warning',
            style: 'margin: 0',
            showCancelButton: true,
            confirmButtonColor: '#dc2626',
            cancelButtonColor: '#64748b',
            confirmButtonText: 'Sí, dar de baja',
            cancelButtonText: 'Conservar',
            background: '#ffffff',
            color: '#0f172a',
            customClass: {
                popup: 'rounded-2xl border border-slate-200 shadow-xl font-sans',
                title: 'text-lg font-black text-slate-900 tracking-tight',
                htmlContainer: 'text-xs font-medium text-slate-500',
                confirmButton: 'rounded-xl px-4 py-2.5 text-xs font-bold uppercase tracking-wide border-0',
                cancelButton: 'rounded-xl px-4 py-2.5 text-xs font-bold uppercase tracking-wide border-0'
            }
        }).then((result) => {
            if (result.isConfirmed) {
                form.submit();
            }
        });
    }
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.pos', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\comida-app\resources\views/users/index.blade.php ENDPATH**/ ?>