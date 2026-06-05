<?php $__env->startSection('title', 'Panel de Control'); ?>

<?php $__env->startSection('content'); ?>
<div class="w-full max-w-7xl mx-auto pt-4 pb-12 px-2">

    <?php
    $rol = Auth::user()->is_role; // 0: Mesero, 1: Cocina, 2: Administrador
    ?>

    
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">

        
        <div class="lg:col-span-2 bg-white border border-slate-200 rounded-3xl p-6 shadow-xs flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
            <div class="flex items-center gap-4">
                
                <div class="relative shrink-0">
                    <div class="flex h-14 w-14 items-center justify-center rounded-2xl overflow-hidden bg-slate-100 text-slate-700 border border-slate-200 shadow-inner">
                        <?php if(Auth::user()->foto_de_perfil): ?>
                        <img src="<?php echo e(asset('storage/' . Auth::user()->foto_de_perfil)); ?>"
                            alt="<?php echo e(Auth::user()->name); ?>"
                            class="h-full w-full object-cover">
                        <?php else: ?>
                        <span class="font-black text-lg font-mono text-slate-500">
                            <?php echo e(strtoupper(substr(Auth::user()->name, 0, 2))); ?>

                        </span>
                        <?php endif; ?>
                    </div>
                    <span class="absolute -bottom-0.5 -right-0.5 h-3.5 w-3.5 rounded-full bg-emerald-500 border-2 border-white animate-pulse"></span>
                </div>
                <div>
                    <div class="flex items-center gap-2 flex-wrap">
                        <h1 class="text-xl font-black text-slate-900 tracking-tight m-0">¡Buen día, <?php echo e(Auth::user()->name); ?>!</h1>
                        <?php if($rol == 2): ?>
                        <span class="badge-rol-admin">Acceso Total</span>
                        <?php elseif($rol == 1): ?>
                        <span class="badge-rol-cocina">Estación Cocina</span>
                        <?php else: ?>
                        <span class="badge-rol-mesero">Estación Mesero</span>
                        <?php endif; ?>
                    </div>
                    <p class="text-xs font-medium text-slate-500 m-0 mt-1.5">Monitorea y despacha las órdenes asignadas a tu perfil operativo.</p>
                </div>
            </div>
        </div>

        
        <div class="bg-orange-50 text-orange-950 rounded-3xl p-5 border border-orange-100 shadow-sm flex flex-col justify-center items-center text-center relative overflow-hidden group">
            <div class="absolute -right-4 -bottom-4 text-orange-100 text-7xl font-black select-none pointer-events-none font-mono">
                TIME
            </div>

            <span class="text-[10px] font-black uppercase tracking-widest text-orange-600 block mb-1 font-mono">
                <i class="fas fa-clock mr-1 animate-pulse"></i> Tiempo Real de Estación
            </span>

            
            <div id="live-pos-clock" class="text-3xl font-black font-mono tracking-tight text-orange-950 leading-none">
                00:00:00
            </div>

            <div id="live-pos-date" class="text-[10px] font-bold text-orange-700/80 uppercase tracking-wider mt-1.5 font-mono">
                Cargando cronología...
            </div>
        </div>
    </div>

    
    <div class="mb-5 pl-1">
        <span class="text-[10px] font-black uppercase tracking-widest text-slate-400 block leading-none">Panel Operativo Principal</span>
    </div>

    
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">

        
        <?php if(in_array($rol, [0, 2])): ?>
        


        
        <a href="<?php echo e(route('comandas.index')); ?>"
            class="bg-white border border-slate-200 rounded-2xl p-6 flex flex-col justify-between group shadow-xs hover:shadow-md hover:border-orange-200 hover:bg-orange-50/10 hover:-translate-y-0.5 active:scale-[0.99] transition-all no-underline text-inherit cursor-pointer">
            <div>
                <div class="flex justify-between items-start mb-4">
                    <span class="h-12 w-12 rounded-xl bg-amber-50 border border-amber-100 text-amber-500 flex items-center justify-center text-xl transition-transform group-hover:scale-105">
                        <i class="fas fa-chair"></i>
                    </span>
                    <span class="text-[9px] font-black uppercase tracking-wider bg-amber-100/60 text-amber-800 px-2 py-0.5 rounded-md font-mono">Salón</span>
                </div>
                <h3 class="text-base font-black text-slate-900 tracking-tight m-0 group-hover:text-orange-500 transition-colors">Mesas y Comandas</h3>
                <p class="text-xs text-slate-500 font-medium mt-2 mb-6 leading-relaxed">Monitoreo de flujo físico en salón, apertura de cuentas y órdenes en tiempo real.</p>
            </div>
            <div class="inline-flex items-center gap-1.5 text-xs font-black text-slate-900 uppercase tracking-wider group-hover:text-orange-500">
                <span>Ver distribución</span>
                <i class="fas fa-arrow-right text-[10px] text-slate-300 transition-transform group-hover:translate-x-1 group-hover:text-orange-500"></i>
            </div>
        </a>
        <?php endif; ?>

        
        <?php if(in_array($rol, [1, 2])): ?>
        
        <a href="<?php echo e(route('comandas.vistaCocina')); ?>"
            class="bg-white border border-slate-200 rounded-2xl p-6 flex flex-col justify-between group shadow-xs hover:shadow-md hover:border-orange-200 hover:bg-orange-50/10 hover:-translate-y-0.5 active:scale-[0.99] transition-all no-underline text-inherit cursor-pointer">
            <div>
                <div class="flex justify-between items-start mb-4">
                    <span class="h-12 w-12 rounded-xl bg-amber-50 border border-amber-100 text-amber-500 flex items-center justify-center text-xl transition-transform group-hover:scale-105">
                        <i class="fas fa-fire"></i>
                    </span>
                    <span class="text-[9px] font-black uppercase tracking-wider bg-amber-100/60 text-amber-800 px-2 py-0.5 rounded-md font-mono">Línea</span>
                </div>
                <h3 class="text-base font-black text-slate-900 tracking-tight m-0 group-hover:text-orange-500 transition-colors">Monitor de Cocina</h3>
                <p class="text-xs text-slate-500 font-medium mt-2 mb-6 leading-relaxed">Pantalla de preparación de platillos, despacho de comandas y alertas de retraso.</p>
            </div>
            <div class="inline-flex items-center gap-1.5 text-xs font-black text-slate-900 uppercase tracking-wider group-hover:text-orange-500">
                <span>Despachar platos</span>
                <i class="fas fa-arrow-right text-[10px] text-slate-300 transition-transform group-hover:translate-x-1 group-hover:text-orange-500"></i>
            </div>
        </a>
        <?php endif; ?>

        
        <?php if($rol == 2): ?>
        
        <a href="<?php echo e(route('productos.index')); ?>"
            class="bg-white border border-slate-200 rounded-2xl p-6 flex flex-col justify-between group shadow-xs hover:shadow-md hover:border-orange-200 hover:bg-orange-50/10 hover:-translate-y-0.5 active:scale-[0.99] transition-all no-underline text-inherit cursor-pointer">
            <div>
                <div class="flex justify-between items-start mb-4">
                    <span class="h-12 w-12 rounded-xl bg-orange-50 border border-orange-100 text-orange-500 flex items-center justify-center text-xl transition-transform group-hover:scale-105">
                        <i class="fas fa-boxes"></i>
                    </span>
                    <span class="text-[9px] font-black uppercase tracking-wider bg-orange-100/60 text-orange-800 px-2 py-0.5 rounded-md font-mono">Almacén</span>
                </div>
                <h3 class="text-base font-black text-slate-900 tracking-tight m-0 group-hover:text-orange-500 transition-colors">Productos e Inventario</h3>
                <p class="text-xs text-slate-500 font-medium mt-2 mb-6 leading-relaxed">Verificación de stock general, insumos críticos e insumos disponibles de barra.</p>
            </div>
            <div class="inline-flex items-center gap-1.5 text-xs font-black text-slate-900 uppercase tracking-wider group-hover:text-orange-500">
                <span>Revisar existencias</span>
                <i class="fas fa-arrow-right text-[10px] text-slate-300 transition-transform group-hover:translate-x-1 group-hover:text-orange-500"></i>
            </div>
        </a>

        
        <a href="<?php echo e(route('reportes.index')); ?>"
            class="bg-white border border-slate-200 rounded-2xl p-6 flex flex-col justify-between group shadow-xs hover:shadow-md hover:border-orange-200 hover:bg-orange-50/10 hover:-translate-y-0.5 active:scale-[0.99] transition-all no-underline text-inherit cursor-pointer">
            <div>
                <div class="flex justify-between items-start mb-4">
                    <span class="h-12 w-12 rounded-xl bg-orange-50 border border-orange-100 text-orange-500 flex items-center justify-center text-xl transition-transform group-hover:scale-105">
                        <i class="fas fa-chart-line"></i>
                    </span>
                    <span class="text-[9px] font-black uppercase tracking-wider bg-orange-100/60 text-orange-800 px-2 py-0.5 rounded-md font-mono">Cierre</span>
                </div>
                <h3 class="text-base font-black text-slate-900 tracking-tight m-0 group-hover:text-orange-500 transition-colors">Reportes de Venta</h3>
                <p class="text-xs text-slate-500 font-medium mt-2 mb-6 leading-relaxed">Auditoría de rendimiento de caja, históricos financieros y conciliación del día.</p>
            </div>
            <div class="inline-flex items-center gap-1.5 text-xs font-black text-slate-900 uppercase tracking-wider group-hover:text-orange-500">
                <span>Ver estadísticas</span>
                <i class="fas fa-arrow-right text-[10px] text-slate-300 transition-transform group-hover:translate-x-1 group-hover:text-orange-500"></i>
            </div>
        </a>

        
        <a href="<?php echo e(route('users')); ?>"
            class="bg-white border border-slate-200 rounded-2xl p-6 flex flex-col justify-between group shadow-xs hover:shadow-md hover:border-orange-200 hover:bg-orange-50/10 hover:-translate-y-0.5 active:scale-[0.99] transition-all no-underline text-inherit cursor-pointer">
            <div>
                <div class="flex justify-between items-start mb-4">
                    <span class="h-12 w-12 rounded-xl bg-amber-50 border border-amber-100 text-amber-500 flex items-center justify-center text-xl transition-transform group-hover:scale-105">
                        <i class="fas fa-users-cog"></i>
                    </span>
                    <span class="text-[9px] font-black uppercase tracking-wider bg-amber-100/60 text-amber-800 px-2 py-0.5 rounded-md font-mono">Personal</span>
                </div>
                <h3 class="text-base font-black text-slate-900 tracking-tight m-0 group-hover:text-orange-500 transition-colors">Control de Usuarios</h3>
                <p class="text-xs text-slate-500 font-medium mt-2 mb-6 leading-relaxed">Alta de personal de piso, cambio de roles operativos y auditoría de accesos.</p>
            </div>
            <div class="inline-flex items-center gap-1.5 text-xs font-black text-slate-900 uppercase tracking-wider group-hover:text-orange-500">
                <span>Gestionar personal</span>
                <i class="fas fa-arrow-right text-[10px] text-slate-300 transition-transform group-hover:translate-x-1 group-hover:text-orange-500"></i>
            </div>
        </a>
        <?php endif; ?>

    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const clockElement = document.getElementById('live-pos-clock');
        const dateElement = document.getElementById('live-pos-date');

        function updateDashboardClock() {
            const now = new Date();

            if (clockElement) {
                const hours = String(now.getHours()).padStart(2, '0');
                const minutes = String(now.getMinutes()).padStart(2, '0');
                const seconds = String(now.getSeconds()).padStart(2, '0');
                clockElement.textContent = `${hours}:${minutes}:${seconds}`;
            }

            if (dateElement) {
                const options = {
                    weekday: 'short',
                    month: 'short',
                    day: 'numeric'
                };
                dateElement.textContent = now.toLocaleDateString('es-MX', options);
            }
        }

        updateDashboardClock();
        setInterval(updateDashboardClock, 1000);
    });
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.pos', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\comida-app\resources\views/admin/dashboard.blade.php ENDPATH**/ ?>