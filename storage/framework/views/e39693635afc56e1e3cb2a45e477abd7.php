<?php $__env->startSection('title', 'Reporte de Ventas'); ?>
<?php $__env->startSection('view_title', '📊 Reportes Administrativos'); ?>
<?php $__env->startSection('view_subtitle', 'Auditoría de ingresos y flujo de caja operativo'); ?>

<?php $__env->startSection('content'); ?>
<div class="h-full w-full p-6 overflow-y-auto sheet-layout bg-slate-100 text-slate-800 scroll-custom flex flex-col">

    
    <div class="w-full max-w-6xl mx-auto flex flex-col flex-1 gap-6">

        
        <div class="flex flex-col lg:flex-row justify-between items-start lg:items-center gap-4">
            <div>
                <h2 class="text-xl font-black text-slate-900 tracking-tight m-0">
                    Resumen de ventas — Filtro: <span class="text-orange-600"><?php echo e(ucfirst($filtro)); ?></span>
                </h2>
                <p class="text-xs font-medium text-slate-400 mt-1 m-0">Historial detallado de comandas liquidadas e ingresos generados</p>
            </div>

            
            <form method="GET" action="#" class="w-full lg:w-auto flex flex-col sm:flex-row items-stretch sm:items-center gap-3 m-0">
                
                <div class="relative min-w-[160px]">
                    <select name="filtro" onchange="this.form.submit()"
                            class="w-full bg-white border border-slate-200 focus:border-orange-500 rounded-xl pl-4 pr-10 py-2.5 text-xs font-black text-slate-700 tracking-wide transition-all outline-hidden shadow-3xs appearance-none cursor-pointer uppercase">
                        <option value="hoy" <?php echo e($filtro == 'hoy' ? 'selected' : ''); ?>>📅 Hoy</option>
                        <option value="semana" <?php echo e($filtro == 'semana' ? 'selected' : ''); ?>>🗓️ Esta Semana</option>
                        <option value="mes" <?php echo e($filtro == 'mes' ? 'selected' : ''); ?>>🗂️ Este Mes</option>
                        <option value="año" <?php echo e($filtro == 'año' ? 'selected' : ''); ?>>📈 Este Año</option>
                    </select>
                    <div class="absolute inset-y-0 right-4 flex items-center pointer-events-none text-slate-400 text-[10px]">
                        <i class="fas fa-chevron-down"></i>
                    </div>
                </div>

                
                <a href="#"
                   class="bg-emerald-600 hover:bg-emerald-700 active:scale-[0.98] transition-all text-white font-black px-4 py-2.5 rounded-xl text-xs tracking-wide cursor-pointer flex items-center justify-center gap-2 shadow-sm shadow-emerald-600/10 border-0 uppercase">
                    <i class="fas fa-file-excel text-sm"></i> Exportar a Excel
                </a>
            </form>
        </div>

        
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="bg-white border border-slate-200 p-5 rounded-2xl shadow-2xs flex items-center justify-between">
                <div class="space-y-1">
                    <span class="text-xs font-black uppercase tracking-wider text-slate-400 block">Total Recaudado</span>
                    <span class="text-[11px] font-medium text-slate-400 block">Suma acumulada del periodo activo</span>
                </div>
                <div class="text-right">
                    <span class="font-mono font-black text-2xl md:text-3xl text-emerald-600 tracking-tight block">
                        $<?php echo e(number_format($total, 2)); ?>

                    </span>
                </div>
            </div>

            
            <div class="bg-white/40 border border-dashed border-slate-200 p-5 rounded-2xl flex items-center gap-3">
                <div class="h-8 w-8 rounded-lg bg-slate-200/60 flex items-center justify-center text-slate-400 text-xs">
                    <i class="fas fa-receipt"></i>
                </div>
                <span class="text-xs font-bold text-slate-400">Comandas cerradas: <?php echo e($comandas->count()); ?></span>
            </div>
            <div class="hidden md:flex bg-white/40 border border-dashed border-slate-200 p-5 rounded-2xl items-center gap-3">
                <div class="h-8 w-8 rounded-lg bg-slate-200/60 flex items-center justify-center text-slate-400 text-xs">
                    <i class="fas fa-calculator"></i>
                </div>
                <span class="text-xs font-bold text-slate-400">Promedio por mesa: $<?php echo e($comandas->count() > 0 ? number_format($total / $comandas->count(), 2) : '0.00'); ?></span>
            </div>
        </div>

        
        <div class="bg-white border border-slate-200 rounded-2xl shadow-2xs overflow-hidden w-full">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse m-0">
                    <thead>
                        <tr class="bg-slate-50 border-b border-slate-200">
                            <th class="p-4 text-xs font-black uppercase tracking-wider text-slate-400 w-1/6">Mesa / Ubicación</th>
                            <th class="p-4 text-xs font-black uppercase tracking-wider text-slate-400 w-1/4">Fecha y Hora</th>
                            <th class="p-4 text-xs font-black uppercase tracking-wider text-slate-400 w-2/5">Desglose de Consumo</th>
                            <th class="p-4 text-xs font-black uppercase tracking-wider text-slate-400 text-right w-1/6">Subtotal</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        <?php $__empty_1 = true; $__currentLoopData = $comandas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $comanda): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <?php $suma = 0; ?>
                            <tr class="hover:bg-slate-50/50 transition-colors">
                                
                                <td class="p-4 align-top">
                                    <span class="inline-flex items-center gap-1.5 bg-slate-100 text-slate-800 px-2.5 py-1 rounded-lg text-xs font-black border border-slate-200">
                                        <i class="fas fa-chair text-[10px] text-slate-400"></i>
                                        <?php echo e($comanda->mesa->nombre); ?>

                                    </span>
                                </td>

                                
                                <td class="p-4 align-top">
                                    <div class="flex flex-col gap-0.5">
                                        <span class="text-xs font-bold text-slate-700">
                                            <?php echo e($comanda->created_at->format('d/m/Y')); ?>

                                        </span>
                                        <span class="text-[10px] font-mono font-medium text-slate-400">
                                            <i class="far fa-clock text-[9px] mr-0.5"></i> <?php echo e($comanda->created_at->format('H:i')); ?> hrs
                                        </span>
                                    </div>
                                </td>

                                
                                <td class="p-4 align-top">
                                    <div class="space-y-1.5">
                                        <?php $__currentLoopData = $comanda->productos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $producto): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <?php
                                                $subtotal = $producto->precio * $producto->pivot->cantidad;
                                                $suma += $subtotal;
                                            ?>
                                            <div class="flex items-center justify-between text-xs font-medium border-b border-dashed border-slate-100 pb-1 last:border-0 last:pb-0">
                                                <div class="text-slate-700 truncate max-w-xs" title="<?php echo e($producto->nombre); ?>">
                                                    <span class="font-mono font-black text-orange-600 bg-orange-50 px-1.5 py-0.5 rounded-md mr-1.5 text-[11px]">
                                                        <?php echo e($producto->pivot->cantidad); ?>x
                                                    </span>
                                                    <?php echo e($producto->nombre); ?>

                                                </div>
                                                <span class="font-mono text-slate-400 text-[11px]">
                                                    $<?php echo e(number_format($subtotal, 2)); ?>

                                                </span>
                                            </div>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </div>
                                </td>

                                
                                <td class="p-4 align-top text-right">
                                    <span class="font-mono font-black text-sm text-slate-900 tracking-tight">
                                        $<?php echo e(number_format($suma, 2)); ?>

                                    </span>
                                </td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <tr>
                                <td colspan="4" class="p-12 text-center">
                                    <div class="flex flex-col items-center justify-center text-slate-300 gap-3">
                                        <i class="fas fa-folder-open text-4xl"></i>
                                        <div class="text-xs font-bold uppercase tracking-wider text-slate-400">
                                            No se encontraron ventas registrados en este rango
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>

    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.pos', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\comida-app\resources\views/reportes/index.blade.php ENDPATH**/ ?>