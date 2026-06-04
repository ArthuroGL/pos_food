<?php $__env->startSection('title', 'Cocina'); ?>
<?php $__env->startSection('view_title', '👨‍🍳 Monitor de Cocina'); ?>
<?php $__env->startSection('view_subtitle', 'Comandas en preparación en tiempo real'); ?>

<?php $__env->startSection('content'); ?>

<div class="h-full w-full p-6 overflow-x-auto flex flex-col gap-6 sheet-layout bg-slate-100 text-slate-800 scroll-custom">

    
    <?php if($comandas->count() > 0): ?>
        <div class="flex gap-6 items-start items-stretch flex-1 pb-4">
            <?php $__currentLoopData = $comandas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $comanda): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="w-85 shrink-0 flex flex-col rounded-2xl bg-white border border-slate-200 shadow-md overflow-hidden max-h-[calc(100vh-12rem)] transition-all duration-300 hover:shadow-lg"
                 id="comanda-<?php echo e($comanda->id); ?>">

                
                <div class="card-header p-4 flex justify-between items-start border-b border-slate-200 bg-slate-50/80">
                    <div>
                        <span class="text-[10px] font-black uppercase tracking-widest text-slate-400 block leading-none">Mesa</span>
                        <h3 class="text-2xl font-black text-slate-900 leading-none mt-1 tracking-tight"><?php echo e($comanda->mesa->nombre); ?></h3>
                    </div>
                    <div class="text-right flex flex-col items-end">
                        <span class="badge inline-block px-2.5 py-1 rounded-lg text-xs font-black tracking-tight font-mono bg-amber-50 text-amber-800 border border-amber-200 shadow-xs">
                            ⏳ <?php echo e($comanda->productos->where('pivot.estado', 'pendiente')->count()); ?> pendientes
                        </span>
                        <p class="text-[10px] font-bold text-slate-400 mt-2 m-0 font-mono">
                            <i class="far fa-clock mr-1"></i><?php echo e($comanda->updated_at->locale('es')->diffForHumans()); ?>

                        </p>
                    </div>
                </div>

                
                <div class="card-body p-4 flex-1 overflow-y-auto space-y-4 bg-white scroll-custom">
                    <div class="row flex flex-col gap-4">

                        
                        <div class="col-md-6 space-y-2">
                            <h5 class="text-warning text-xs font-black uppercase tracking-wider text-amber-700 flex items-center gap-2 mb-2.5">
                                Nuevos para preparar
                                <span class="badge bg-warning text-dark ml-auto bg-amber-100/80 text-amber-900 px-2 py-0.5 rounded-lg font-mono text-xs font-black border border-amber-200">
                                    <?php echo e($comanda->productos->where('pivot.estado', 'pendiente')->count()); ?>

                                </span>
                            </h5>

                            <?php $__empty_1 = true; $__currentLoopData = $comandas->where('id', $comanda->id)->first()->productos->where('pivot.estado', 'pendiente'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $producto): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <div class="alert alert-warning producto-item p-3.5 rounded-xl bg-amber-50/40 border border-amber-200/70 hover:border-amber-400 transition-all text-slate-900 shadow-xs group"
                                 id="producto-<?php echo e($comanda->id); ?>-<?php echo e($producto->id); ?>">
                                <div class="row align-items-start flex items-center justify-between gap-3">

                                    
                                    <div class="row align-items-start d-flex flex-col min-w-0 flex-1">
                                        <span class="text-[15px] font-bold tracking-tight text-slate-800 block leading-tight">
                                            <strong class="font-mono font-black text-orange-600 text-base mr-1.5 bg-orange-50 px-1.5 py-0.5 rounded-lg border border-orange-100 shadow-2xs"><?php echo e($producto->pivot->cantidad); ?>x</strong>
                                            <?php echo e($producto->nombre); ?>

                                        </span>

                                        
                                        <?php if($producto->pivot->comentarios): ?>
                                        <small class="text-muted mt-2 text-xs font-black text-rose-700 bg-rose-50 border border-rose-200 rounded-lg px-2 py-1 inline-block w-fit uppercase tracking-wide">
                                            <em>⚠️ <?php echo e($producto->pivot->comentarios); ?></em>
                                        </small>
                                        <?php endif; ?>
                                    </div>

                                    
                                    <div class="col pt-1 shrink-0 flex items-center justify-center">
                                        <label class="relative flex items-center justify-center h-9 w-9 rounded-xl bg-white border-2 border-slate-300 group-hover:border-emerald-500 cursor-pointer transition-all active:scale-90 shadow-sm">
                                            <input type="checkbox"
                                                   class="form-check-input producto-check sr-only"
                                                   data-comanda="<?php echo e($comanda->id); ?>"
                                                   data-producto="<?php echo e($productoId = $producto->id); ?>"
                                                   autocomplete="off">
                                            <i class="fas fa-check text-emerald-600 opacity-0 transition-opacity text-sm check-icon"></i>
                                        </label>
                                    </div>

                                </div>
                            </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <div class="alert alert-light text-center py-4 bg-slate-50 rounded-xl border border-dashed border-slate-200 text-slate-400 text-xs font-bold">
                                <i class="fas fa-check-circle text-success text-emerald-600 mr-1.5 text-sm"></i> Todos los productos preparados
                            </div>
                            <?php endif; ?>
                        </div>

                        
                        <div class="col-md-6 space-y-2 pt-3 border-t border-slate-100">
                            <h5 class="text-success text-xs font-black uppercase tracking-wider text-slate-400 flex items-center gap-2 mb-2.5">
                                <i class="fas fa-check-circle text-emerald-500"></i> Listos para entregar
                                <span class="badge bg-success text-white ml-auto bg-slate-50 text-slate-400 px-2 py-0.5 rounded-lg font-mono text-xs font-bold border border-slate-200">
                                    <?php echo e($comanda->productos->where('pivot.estado', 'preparado')->count()); ?>

                                </span>
                            </h5>

                            <?php $__empty_1 = true; $__currentLoopData = $comanda->productos->where('pivot.estado', 'preparado'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $producto): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <div class="alert alert-success mb-2 p-3 rounded-xl bg-slate-50 border border-slate-200/50 opacity-60 text-slate-500 strike-through transition-all">
                                <div class="d-flex justify-content-between flex justify-between items-center gap-2">
                                    <div class="truncate pr-2 flex-1">
                                        <span class="font-mono font-bold text-slate-400 text-sm mr-1.5"><?php echo e($producto->pivot->cantidad); ?>x</span>
                                        <strong class="font-medium text-sm line-through text-slate-400"><?php echo e($producto->nombre); ?></strong>
                                        <?php if($producto->pivot->comentarios): ?>
                                        <br><small class="text-[11px] text-slate-400 font-medium italic"><em><?php echo e($producto->pivot->comentarios); ?></em></small>
                                        <?php endif; ?>
                                    </div>
                                    <span class="text-success text-emerald-600 shrink-0 bg-emerald-50 h-6 w-6 rounded-full flex items-center justify-center border border-emerald-100 shadow-2xs">
                                        <i class="fas fa-check text-[10px]"></i>
                                    </span>
                                </div>
                            </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <div class="alert alert-light text-center py-3 bg-slate-50 rounded-xl border border-dashed border-slate-200 text-slate-400 text-xs font-medium">
                                <i class="fas fa-clock text-amber-400 mr-1.5"></i> Esperando productos
                            </div>
                            <?php endif; ?>
                        </div>

                    </div>

                    
                    <?php if($comanda->productos->where('pivot.estado', 'pendiente')->count() == 0): ?>
                    <div class="mt-4 pt-3 border-t border-slate-100">
                        <h5 class="text-center text-success mb-3 text-emerald-600 flex items-center justify-center gap-2 text-xs font-black uppercase tracking-wider animate-bounce">
                            <i class="fas fa-check-double"></i> ¡Comanda completa!
                        </h5>
                        <form method="POST" action="<?php echo e(route('comandas.cambiarEstado', $comanda->id)); ?>" class="m-0">
                            <?php echo csrf_field(); ?>
                            <?php echo method_field('PUT'); ?>
                            <input type="hidden" name="estado" value="lista">
                            <button class="w-full bg-emerald-600 hover:bg-emerald-700 active:scale-[0.98] transition-all text-white font-black py-3.5 rounded-xl text-center text-sm tracking-wide cursor-pointer flex items-center justify-center gap-2 shadow-lg shadow-emerald-600/20 border-0 uppercase">
                                <i class="fas fa-paper-plane text-xs"></i> MARCAR COMO LISTA
                            </button>
                        </form>
                    </div>
                    <?php endif; ?>

                </div>
            </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
    <?php else: ?>
        
        <div class="flex-1 flex flex-col items-center justify-center bg-white rounded-3xl border border-dashed border-slate-300 p-12 text-center my-auto min-h-[50vh] shadow-xs">
            
            <div class="relative flex h-20 w-20 items-center justify-center rounded-full bg-slate-50 text-slate-400 mb-5 border border-slate-100">
                <i class="fas fa-fire-burner text-3xl text-slate-300"></i>
                <span class="absolute inline-flex h-full w-full animate-ping rounded-full bg-emerald-400 opacity-15"></span>
                <span class="absolute bottom-1 right-1 block h-4 w-4 rounded-full bg-emerald-500 border-3 border-white"></span>
            </div>

            <h3 class="text-xl font-black text-slate-800 tracking-tight">Barra de cocina despejada</h3>
            <p class="text-sm font-medium text-slate-400 max-w-md mt-1.5 mx-auto leading-relaxed">
                No hay platos pendientes por preparar en este momento. El monitor se encuentra activo escuchando nuevas órdenes desde los terminales del salón.
            </p>
        </div>
    <?php endif; ?>

    
    <?php if(isset($ultimasEnCocina) && $ultimasEnCocina->count() > 0): ?>
        <div class="mt-auto pt-4 border-t border-slate-200">
            <h4 class="text-xs font-black uppercase tracking-wider text-slate-400 mb-3 flex items-center gap-2 select-none">
                <i class="fas fa-history text-xs"></i> Platos despachados recientemente.
            </h4>

            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4">
                <?php $__currentLoopData = $ultimasEnCocina; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $historial): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="bg-white/80 border border-slate-200 p-3.5 rounded-xl flex items-center justify-between shadow-2xs opacity-75 hover:opacity-100 transition-all duration-200">
                        <div class="flex items-center gap-3 min-w-0">
                            <div class="h-10 w-10 bg-slate-100 rounded-xl flex flex-col items-center justify-center shrink-0 border border-slate-200">
                                <span class="text-[8px] font-black uppercase tracking-tight text-slate-400 leading-none">Mesa</span>
                                <span class="text-sm font-black text-slate-700 leading-none mt-0.5 font-mono"><?php echo e($historial->mesa->nombre); ?></span>
                            </div>
                            <div class="truncate">
                                <p class="text-xs font-bold text-slate-800 truncate m-0">
                                    Comanda despachada con éxito
                                </p>
                                <span class="text-[10px] font-medium text-slate-400 flex items-center gap-1 mt-0.5">
                                    <i class="far fa-clock"></i> Terminado <?php echo e($historial->updated_at->locale('es')->diffForHumans()); ?>

                                </span>
                            </div>
                        </div>

                        <span class="bg-slate-100 text-slate-600 text-[10px] font-black uppercase tracking-wider px-2 py-1 rounded-lg border border-slate-200 shrink-0 shadow-3xs font-mono">
                            🏁 <?php echo e($historial->estado == 'lista' ? 'Listo' : 'Entregado'); ?>

                        </span>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
        </div>
    <?php endif; ?>

</div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('scripts'); ?>
<script>
    document.querySelectorAll('.producto-check').forEach(checkbox => {
        checkbox.addEventListener('change', function() {
            const comandaId = this.dataset.comanda;
            const productoId = this.dataset.producto;
            const productoItem = document.getElementById(`producto-${comandaId}-${productoId}`);

            if (this.checked) {
                this.disabled = true;

                productoItem.classList.add('processing');
                const labelIcon = this.parentElement.querySelector('.check-icon');
                if (labelIcon) labelIcon.classList.remove('opacity-0');

                fetch(`/comandas/${comandaId}/producto/${productoId}/estado`, {
                        method: 'PUT',
                        headers: {
                            'X-CSRF-TOKEN': '<?php echo e(csrf_token()); ?>',
                            'Content-Type': 'application/json',
                            'Accept': 'application/json'
                        },
                        body: JSON.stringify({
                            estado: 'preparado'
                        })
                    })
                    .then(response => {
                        if (!response.ok) throw new Error('Error en la respuesta');
                        return response.json();
                    })
                    .then(data => {
                        const comandaCard = document.getElementById(`comanda-${comandaId}`);
                        const preparadosSection = comandaCard.querySelector('.col-md-6:last-child');
                        const pendientesSection = comandaCard.querySelector('.col-md-6:first-child');

                        const emptyPrepAlert = preparadosSection.querySelector('.alert-light');
                        if (emptyPrepAlert && emptyPrepAlert.innerText.includes('Esperando')) {
                            emptyPrepAlert.remove();
                        }

                        const cantidadText = productoItem.querySelector('.font-mono').innerText;
                        const nombreText = productoItem.querySelector('span').innerText.replace(cantidadText, '').trim();
                        const comentarioElement = productoItem.querySelector('small');

                        const preparadoDiv = document.createElement('div');
                        preparadoDiv.className = 'alert alert-success mb-2 p-3 rounded-xl bg-slate-50 border border-slate-200/50 opacity-60 text-slate-500 strike-through';
                        preparadoDiv.innerHTML = `
                        <div class="d-flex justify-content-between flex justify-between items-center gap-2">
                            <div class="truncate pr-2 flex-1">
                                <span class="font-mono font-bold text-slate-400 text-sm mr-1.5">${cantidadText}</span>
                                <strong class="font-medium text-sm line-through text-slate-400">${nombreText}</strong><br>
                                ${comentarioElement ? comentarioElement.outerHTML : ''}
                            </div>
                            <span class="text-success text-emerald-600 shrink-0 bg-emerald-50 h-6 w-6 rounded-full flex items-center justify-center border border-emerald-100 shadow-2xs">
                                <i class="fas fa-check text-[10px]"></i>
                            </span>
                        </div>
                    `;

                        preparadosSection.querySelector('h5').insertAdjacentElement('afterend', preparadoDiv);
                        productoItem.remove();

                        const pendientesCount = pendientesSection.querySelectorAll('.producto-item').length;
                        const preparadosCount = preparadosSection.querySelectorAll('.alert-success').length;

                        pendientesSection.querySelector('h5 .badge').textContent = pendientesCount;
                        preparadosSection.querySelector('h5 .badge').textContent = preparadosCount;

                        if (pendientesCount === 0) {
                            const emptyPendAlert = pendientesSection.querySelector('.alert-light');
                            if (!emptyPendAlert) {
                                pendientesSection.innerHTML += `
                                    <div class="alert alert-light text-center py-4 bg-slate-50 rounded-xl border border-dashed border-slate-200 text-slate-400 text-xs font-bold">
                                        <i class="fas fa-check-circle text-success text-emerald-600 mr-1.5 text-sm"></i> Todos los productos preparados
                                    </div>
                                `;
                            }

                            const completeDiv = document.createElement('div');
                            completeDiv.className = 'mt-4 pt-3 border-t border-slate-100';
                            completeDiv.innerHTML = `
                            <h5 class="text-center text-success mb-3 text-emerald-600 flex items-center justify-center gap-2 text-xs font-black uppercase tracking-wider animate-bounce">
                                <i class="fas fa-check-double"></i> ¡Comanda completa!
                            </h5>
                            <form method="POST" action="/comandas/${comandaId}/estado" class="m-0">
                                <?php echo csrf_field(); ?>
                                <input type="hidden" name="_method" value="PUT">
                                <input type="hidden" name="estado" value="lista">
                                <button class="w-full bg-emerald-600 hover:bg-emerald-700 active:scale-[0.98] transition-all text-white font-black py-3.5 rounded-xl text-center text-sm tracking-wide cursor-pointer flex items-center justify-center gap-2 shadow-lg shadow-emerald-600/20 border-0 uppercase">
                                    <i class="fas fa-paper-plane text-xs"></i> MARCAR COMO LISTA
                                </button>
                            </form>
                        `;
                            comandaCard.querySelector('.card-body').appendChild(completeDiv);

                            const headerBadge = comandaCard.querySelector('.card-header .badge');
                            headerBadge.className = 'badge inline-block px-2.5 py-1 rounded-lg text-xs font-bold tracking-tight font-mono bg-emerald-100 text-emerald-800 border border-emerald-200';
                            headerBadge.textContent = 'Lista para entregar';
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        this.checked = false;
                        this.disabled = false;
                        productoItem.classList.remove('processing');
                        if (labelIcon) labelIcon.classList.add('opacity-0');
                        alert('Ocurrió un error al actualizar el estado');
                    });
            }
        });
    });
</script>

<style>
    .processing {
        opacity: 0.5;
        filter: grayscale(0.5);
        background-color: #f1f5f9 !important;
        pointer-events: none;
    }
</style>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.pos', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\comida-app\resources\views/cocina/index.blade.php ENDPATH**/ ?>