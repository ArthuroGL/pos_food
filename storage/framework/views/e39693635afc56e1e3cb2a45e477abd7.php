<?php $__env->startSection('title', 'Reporte de Ventas'); ?>
<?php $__env->startSection('view_title', '📊 Reportes Administrativos'); ?>
<?php $__env->startSection('view_subtitle', 'Auditoría de ingresos y flujo de caja operativo'); ?>

<?php $__env->startSection('content'); ?>
<div class="h-full w-full p-6 overflow-y-auto sheet-layout bg-slate-100 text-slate-800 scroll-custom flex flex-col">

    
    <div class="w-full max-w-6xl mx-auto flex flex-col flex-1 gap-6">

        
        <?php if(session('error_reporte')): ?>
        <div class="p-4 rounded-xl bg-rose-50 border border-rose-200 text-rose-700 text-xs font-bold flex items-center gap-2">
            <i class="fas fa-exclamation-circle text-sm"></i>
            <?php echo e(session('error_reporte')); ?>

        </div>
        <?php endif; ?>

        <?php if(session('warning_reporte')): ?>
        <div class="p-4 rounded-xl bg-amber-50 border border-amber-200 text-amber-700 text-xs font-bold flex items-center gap-2">
            <i class="fas fa-exclamation-triangle text-sm"></i>
            <?php echo e(session('warning_reporte')); ?>

        </div>
        <?php endif; ?>

        
        <div class="flex flex-col xl:flex-row justify-between items-start xl:items-center gap-4">
            <div>
                <h2 class="text-xl font-black text-slate-900 tracking-tight m-0">
                    Resumen de ventas — Filtro:
                    <span class="text-orange-600">
                        <?php if($filtro === 'personalizado'): ?>
                        Personalizado (<?php echo e(\Carbon\Carbon::parse($fecha_inicio)->format('d/m/Y')); ?> al <?php echo e(\Carbon\Carbon::parse($fecha_fin)->format('d/m/Y')); ?>)
                        <?php else: ?>
                        <?php echo e(ucfirst($filtro)); ?>

                        <?php endif; ?>
                    </span>
                </h2>
                <p class="text-xs font-medium text-slate-400 mt-1 m-0">Historial detallado de comandas liquidadas e ingresos generados</p>
            </div>

            
            <form method="GET" action="<?php echo e(route('reportes.index')); ?>" id="form-filtros" class="w-full xl:w-auto flex flex-col sm:flex-row items-end gap-3 m-0 bg-white p-3 rounded-xl border border-slate-200/80 shadow-xs">

                
                <div class="flex flex-col gap-1 w-full sm:w-44">
                    <span class="text-[10px] font-black uppercase tracking-wider text-slate-400">Periodo</span>
                    <select name="filtro" id="selector-filtro" onchange="evaluarFiltro(this.value)"
                        class="w-full bg-slate-50 border border-slate-200 focus:border-orange-500 rounded-lg px-3 py-1.5 text-xs font-black text-slate-700 tracking-wide outline-hidden appearance-none cursor-pointer uppercase">
                        <?php $__currentLoopData = $filtrosDisponibles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $label): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($key); ?>" <?php echo e($filtro == $key ? 'selected' : ''); ?>><?php echo e($label); ?></option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                </div>

                
                <div id="contenedor-fechas" class="<?php echo e($filtro === 'personalizado' ? 'flex' : 'hidden'); ?> flex-col sm:flex-row items-center gap-2 w-full sm:w-auto">
                    <div class="flex flex-col gap-1 w-full sm:w-36">
                        <span class="text-[10px] font-black uppercase tracking-wider text-slate-400">Desde</span>
                        <input type="date" name="fecha_inicio" value="<?php echo e($fecha_inicio); ?>" class="w-full bg-slate-50 border border-slate-200 focus:border-orange-500 rounded-lg px-2 py-1 text-xs font-bold text-slate-700">
                    </div>
                    <div class="flex flex-col gap-1 w-full sm:w-36">
                        <span class="text-[10px] font-black uppercase tracking-wider text-slate-400">Hasta</span>
                        <input type="date" name="fecha_fin" value="<?php echo e($fecha_fin); ?>" class="w-full bg-slate-50 border border-slate-200 focus:border-orange-500 rounded-lg px-2 py-1 text-xs font-bold text-slate-700">
                    </div>
                    <button type="submit" class="btn-primary h-[29px] mt-auto flex items-center justify-center">
                        <i class="fas fa-search"></i>
                    </button>
                </div>

                
                <a href="<?php echo e(route('reportes.exportar', ['filtro' => $filtro, 'fecha_inicio' => $fecha_inicio, 'fecha_fin' => $fecha_fin])); ?>"
                    class="bg-emerald-600 hover:bg-emerald-700 active:scale-[0.98] transition-all text-white font-black px-4 h-[29px] rounded-lg text-xs tracking-wide cursor-pointer flex items-center justify-center gap-2 shadow-3xs uppercase border-0 self-stretch sm:self-auto mt-auto">
                    <i class="fas fa-file-excel text-xs"></i> Exportar
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
                <span class="text-xs font-bold text-slate-500">Comandas cerradas: <strong class="text-slate-800"><?php echo e($comandas->count()); ?></strong></span>
            </div>

            <div class="hidden md:flex bg-white/40 border border-dashed border-slate-200 p-5 rounded-2xl items-center gap-3">
                <div class="h-8 w-8 rounded-lg bg-slate-200/60 flex items-center justify-center text-slate-400 text-xs">
                    <i class="fas fa-calculator"></i>
                </div>
                <span class="text-xs font-bold text-slate-500">Promedio por comanda: <strong class="text-slate-800">$<?php echo e($comandas->count() > 0 ? number_format($total / $comandas->count(), 2) : '0.00'); ?></strong></span>
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
                                    <?php echo e($comanda->mesa->nombre ?? 'N/A'); ?>

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
                                    <i class="fas fa-folder-open text-4xl text-slate-300"></i>
                                    <div class="text-xs font-bold uppercase tracking-wider text-slate-400">
                                        <?php echo e($mensajeInformativo ?? 'No se encontraron registros de ventas'); ?>

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

<script>
    function evaluarFiltro(val) {
        const contenedor = document.getElementById('contenedor-fechas');
        if (val === 'personalizado') {
            contenedor.classList.remove('hidden');
            contenedor.classList.add('flex');
        } else {
            contenedor.classList.remove('flex');
            contenedor.classList.add('hidden');
            document.getElementById('form-filtros').submit();
        }
    }
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.pos', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\comida-app\resources\views/reportes/index.blade.php ENDPATH**/ ?>