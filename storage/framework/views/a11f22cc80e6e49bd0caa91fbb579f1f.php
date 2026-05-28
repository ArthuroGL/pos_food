<?php $__env->startSection('title', 'Crear Comanda'); ?>

<?php $__env->startSection('content'); ?>
<div class="w-full p-4 min-h-screen bg-slate-50 text-slate-800 selection:bg-orange-500 selection:text-white">

    
   <div class="mb-6 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
    <div class="m-0">
        <h1 class="text-2xl font-black text-slate-900 tracking-tight m-0 flex items-center gap-2">
            <i class="fas fa-concierge-bell text-slate-400 text-xl"></i> Tomar Comanda
        </h1>
        <p class="text-xs font-medium text-slate-500 m-0 mt-0.5">Construye y envía la orden de servicio directamente a la cocina</p>
    </div>

    
    <div class="shrink-0">
        <a href="<?php echo e(route('comandas.index')); ?>" class="btn-back-nav no-underline">
            <i class="fas fa-arrow-left"></i> Regresar a Comandas
        </a>
    </div>
</div>

    
    <?php if(session('success')): ?>
    <div class="mb-6 p-4 rounded-xl bg-emerald-50 border border-emerald-200 text-emerald-900 text-sm font-bold flex items-center gap-2 shadow-sm">
        <i class="fas fa-check-circle text-emerald-600 text-base"></i> <?php echo e(session('success')); ?>

    </div>
    <?php endif; ?>

    
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 items-start">

        
        <div class="w-full lg:col-span-4 order-1 lg:order-2 lg:sticky lg:top-4">
            <form id="mainComandaForm" method="POST" action="<?php echo e(route('comandas.store')); ?>" class="m-0">
                <?php echo csrf_field(); ?>
                <div class="border border-slate-200 shadow-sm rounded-2xl overflow-hidden bg-white flex flex-col group hover:border-orange-200 transition-all">
                    <div class="p-4 bg-orange-50 border-b border-orange-100 flex justify-between items-center">
                        <div class="flex items-center gap-2">
                            <h2 class="text-xs font-black text-orange-900 uppercase tracking-wider m-0">Comanda</h2>
                        </div>
                        <button type="button" onclick="limpiarMesaYOrden()" class="text-[10px] font-black text-orange-700 bg-orange-100 hover:bg-orange-200 border-0 px-2 py-1 rounded-md transition-all cursor-pointer">
                            Vaciar todo
                        </button>
                    </div>

                    
                    <div class="p-4 bg-white border-b border-slate-100">
                        <label for="mesa_id" class="text-[10px] font-black uppercase tracking-widest text-slate-400 block mb-2">Asignación de Mesa</label>
                        <div class="relative">
                            <i class="fas fa-chair absolute left-3.5 top-1/2 -translate-y-1/2 text-slate-400 text-xs pointer-events-none"></i>
                            <select name="mesa_id" id="mesa_id" class="w-full pl-9 pr-10 py-3 bg-slate-50 border border-slate-200 focus:bg-white focus:border-orange-400 focus:ring-4 focus:ring-orange-100/60 text-slate-900 font-black text-sm rounded-xl outline-none transition-all cursor-pointer appearance-none" required>
                                <option value="">-- Seleccionar Mesa --</option>
                                <?php $__currentLoopData = $mesas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $mesa): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <?php $ocupada = $mesa->comandas->isNotEmpty(); ?>
                                <option value="<?php echo e($mesa->id); ?>"
                                    <?php if($ocupada): ?> disabled class="text-rose-500 font-medium bg-rose-50/50" <?php endif; ?>
                                    <?php if(old('mesa_id')==$mesa->id): ?> selected <?php endif; ?>>
                                    📍 <?php echo e($mesa->nombre); ?> <?php if($ocupada): ?> [Ocupada] <?php endif; ?>
                                </option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                            <div class="absolute right-3.5 top-1/2 -translate-y-1/2 pointer-events-none text-slate-400 text-xs">
                                <i class="fas fa-chevron-down"></i>
                            </div>
                        </div>
                    </div>

                    
                    <div class="p-4 flex-1">
                        <span class="text-[10px] font-black uppercase tracking-widest text-slate-400 block mb-3">Detalle de la Comanda</span>
                        <div class="min-h-[160px] max-h-[320px] overflow-y-auto space-y-2 pr-1 scroll-custom" id="listaSeleccionados">
                            
                        </div>
                    </div>

                    
                    <div class="p-4 bg-slate-50 border-t border-slate-100">
                        <div id="hiddenInputsContainer"></div>
                        <button type="submit" class="w-full inline-flex items-center justify-center gap-2 py-3.5 bg-orange-500 hover:bg-orange-600 active:scale-[0.98] border-0 text-white text-xs font-black tracking-wider uppercase rounded-xl shadow-md shadow-orange-500/20 transition-all cursor-pointer">
                            <i class="fas fa-paper-plane text-xs"></i> Enviar Comanda a Cocina
                        </button>
                    </div>
                </div>
            </form>
        </div>

        
        <div class="w-full lg:col-span-8 order-2 lg:order-1">

            
            <div class="bg-white p-3 rounded-2xl border border-slate-200 shadow-xs mb-6 relative">
                <form method="GET" action="<?php echo e(route('comandas.create')); ?>" id="searchForm" class="m-0">
                    <div class="relative flex items-center w-full">
                        <i class="fas fa-search absolute left-4 text-slate-400 text-sm pointer-events-none"></i>

                        <input type="text" name="search" id="searchInput" autocomplete="off"
                            class="w-full pl-10 pr-28 py-3 bg-slate-50/50 border border-slate-200 focus:border-orange-400 focus:bg-white rounded-xl text-sm font-medium text-slate-900 placeholder-slate-400 transition-all outline-none"
                            placeholder="Buscar por nombre o descripción de platillo..."
                            value="<?php echo e(request('search')); ?>">

                        
                        <button type="button" id="clearSearchBtn"
                            class="absolute right-26 text-slate-400 hover:text-slate-600 p-1 rounded-full hover:bg-slate-100 transition-all cursor-pointer <?php echo e(request('search') ? '' : 'hidden'); ?>">
                            <i class="fas fa-times-circle text-base"></i>
                        </button>

                        <button type="submit" class="absolute right-1.5 px-5 py-2 hover:text-orange-400 border-2  text-xs font-black uppercase tracking-wider rounded-lg transition-all cursor-pointer active:scale-95">

                            Buscar
                        </button>
                    </div>
                </form>

                
                <div id="suggestionsDropdown" class="absolute left-0 right-0 mt-2 bg-white border border-slate-200 rounded-xl shadow-lg z-50 overflow-hidden hidden max-h-60 overflow-y-auto">
                    
                </div>
            </div>

            <h2 class="text-[10px] font-black uppercase tracking-widest text-slate-400 mb-4 flex items-center gap-2">
                🍽️ Menú / Productos Disponibles
            </h2>

            
            <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-3 gap-4">
                <?php if($productos->count() > 0): ?>
                <?php $__currentLoopData = $productos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $producto): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="product-card border border-slate-200 bg-white rounded-2xl overflow-hidden shadow-xs hover:shadow-md transition-all duration-200 flex flex-col justify-between" id="card_container_<?php echo e($producto->id); ?>">

                    <div class="p-4 flex gap-3 items-start relative">
                        <input type="checkbox" name="productos[<?php echo e($producto->id); ?>][selected]" value="1"
                            class="absolute opacity-0 w-0 h-0 pointer-events-none manual-check"
                            id="check_<?php echo e($producto->id); ?>">

                        <div class="w-16 h-16 rounded-xl bg-slate-100 overflow-hidden shrink-0 border border-slate-100 flex items-center justify-center">
                            <?php if($producto->imagen): ?>
                            <img src="<?php echo e(asset('storage/' . $producto->imagen)); ?>" alt="<?php echo e($producto->nombre); ?>" class="w-full h-full object-cover">
                            <?php else: ?>
                            <div class="text-[9px] font-black text-slate-400 uppercase tracking-tighter text-center">Sin foto</div>
                            <?php endif; ?>
                        </div>

                        <div class="min-w-0 flex-1">
                            <h3 class="text-sm font-black text-slate-900 tracking-tight leading-snug truncate m-0"><?php echo e($producto->nombre); ?></h3>
                            <p class="text-xs font-medium text-slate-400 mt-1 line-clamp-2 leading-normal h-8 m-0"><?php echo e($producto->descripcion); ?></p>
                            <span class="inline-block text-sm font-mono font-black text-orange-600 mt-1.5">$<?php echo e(number_format($producto->precio, 2)); ?></span>
                        </div>
                    </div>

                    <div class="p-3 bg-slate-50/80 border-t border-slate-100 space-y-2.5">
                        <div class="flex items-center justify-between gap-2">
                            <span class="text-[10px] font-black text-slate-400 uppercase tracking-wider">Cantidad:</span>
                            <div class="flex items-center bg-white border border-slate-200 rounded-lg p-0.5 shadow-xs">
                                <button type="button" onclick="stepDownQty('<?php echo e($producto->id); ?>')" class="w-7 h-7 flex items-center justify-center rounded bg-slate-50 hover:bg-slate-100 border-0 text-slate-600 text-xs font-bold transition-all cursor-pointer select-none">-</button>
                                <input type="number" name="productos[<?php echo e($producto->id); ?>][cantidad]" id="qty_<?php echo e($producto->id); ?>"
                                    value="1" min="1" class="w-10 text-center bg-transparent border-0 font-mono font-black text-slate-900 text-sm focus:outline-none [appearance:textfield] [&::-webkit-outer-spin-button]:appearance-none [&::-webkit-inner-spin-button]:appearance-none">
                                <button type="button" onclick="stepUpQty('<?php echo e($producto->id); ?>')" class="w-7 h-7 flex items-center justify-center rounded bg-slate-50 hover:bg-slate-100 border-0 text-slate-600 text-xs font-bold transition-all cursor-pointer select-none">+</button>
                            </div>
                        </div>

                        <div class="relative flex items-center">
                            <i class="fas fa-pen absolute left-3 text-slate-300 text-[9px]"></i>
                            <input type="text" name="productos[<?php echo e($producto->id); ?>][comentarios]" id="comment_<?php echo e($producto->id); ?>"
                                class="w-full pl-7 pr-2 py-2 bg-white border border-slate-200 focus:border-slate-300 rounded-lg text-xs font-medium text-slate-700 placeholder-slate-400 outline-none transition-all"
                                placeholder="Ej: sin cebolla, término medio...">
                        </div>

                        <button type="button" id="btn_add_<?php echo e($producto->id); ?>" onclick="toggleProductSelection('<?php echo e($producto->id); ?>')"
                            class="w-full py-2 bg-white border border-slate-200 hover:bg-slate-900 hover:text-white text-slate-700 text-xs font-black tracking-wider uppercase rounded-xl transition-all shadow-xs flex items-center justify-center gap-1.5 cursor-pointer">
                            <i class="fas fa-plus text-[9px]"></i> Agregar a Orden
                        </button>
                    </div>
                </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                <?php else: ?>
                <div class="col-span-full py-12 text-center bg-white border border-dashed border-slate-200 rounded-2xl shadow-xs">
                    <i class="fas fa-search text-slate-300 text-4xl mb-3 block"></i>
                    <p class="text-xs font-bold text-slate-400 m-0">No se encontraron productos para esta búsqueda.</p>
                </div>
                <?php endif; ?>
            </div>

            
            <div class="mt-8 flex justify-center custom-pagination">
                <?php echo e($productos->links('pagination::bootstrap-4')); ?>

            </div>
        </div>

    </div>
</div>

<?php $__env->startSection('scripts'); ?>
<script>
    let productosSeleccionados = JSON.parse(localStorage.getItem('productosSeleccionados') || '{}');

    // LÓGICA COMPLEMENTARIA DEL BUSCADOR COMERCIAL
    const searchInput = document.getElementById('searchInput');
    const clearSearchBtn = document.getElementById('clearSearchBtn');
    const dropdown = document.getElementById('suggestionsDropdown');
    const searchForm = document.getElementById('searchForm');
    let debounceTimer;

    if (searchInput) {
        // Escucha cambios de escritura con Debounce para cuidar rendimiento
        searchInput.addEventListener('input', function() {
            const query = this.value.trim();

            if (query.length > 0) {
                clearSearchBtn.classList.remove('hidden');
            } else {
                clearSearchBtn.classList.add('hidden');
                dropdown.classList.add('hidden');
                return;
            }

            clearTimeout(debounceTimer);
            debounceTimer = setTimeout(() => {
                fetch(`<?php echo e(route('productos.sugerencias')); ?>?search=${encodeURIComponent(query)}`)
                    .then(response => response.json())
                    .then(data => {
                        dropdown.innerHTML = '';

                        if (data.length === 0) {
                            dropdown.innerHTML = `
                                <div class="p-4 text-center text-xs font-bold text-slate-400 flex items-center justify-center gap-2">
                                    <i class="fas fa-info-circle text-slate-300"></i> No se encontraron productos
                                </div>
                            `;
                        } else {
                            data.forEach(producto => {
                                const btn = document.createElement('button');
                                btn.type = 'button';
                                btn.className = "w-full text-left px-4 py-3 text-xs font-black text-slate-700 hover:bg-orange-50 hover:text-orange-900 border-0 border-b border-slate-100 last:border-0 bg-white transition-all cursor-pointer flex items-center gap-2";
                                btn.innerHTML = `<i class="fas fa-utensils text-slate-300 text-[10px]"></i> ${producto.nombre}`;

                                btn.addEventListener('click', () => {
                                    searchInput.value = producto.nombre;
                                    dropdown.classList.add('hidden');
                                    searchForm.submit(); // Lanza automáticamente el filtrado en el listado
                                });
                                dropdown.appendChild(btn);
                            });
                        }
                        dropdown.classList.remove('hidden');
                    })
                    .catch(error => console.error('Error cargando sugerencias:', error));
            }, 250); // 250ms de espera táctil
        });

        // Botón de Limpieza Completa
        clearSearchBtn.addEventListener('click', () => {
            searchInput.value = '';
            clearSearchBtn.classList.add('hidden');
            dropdown.classList.add('hidden');

            // Redirección directa para mostrar todo el catálogo limpio en segundos
            window.location.href = "<?php echo e(route('comandas.create')); ?>";
        });

        // Cerrar el dropdown si el usuario hace click fuera de él
        document.addEventListener('click', function(e) {
            if (!searchInput.contains(e.target) && !dropdown.contains(e.target)) {
                dropdown.classList.add('hidden');
            }
        });
    }

    // LÓGICA DE CONTROL DE ORDEN (MANTIENE TUS FUNCIONALIDADES ORIGINALES)
    function renderSeleccionados() {
        const lista = document.getElementById('listaSeleccionados');
        if (!lista) return;

        lista.innerHTML = '';
        const keys = Object.entries(productosSeleccionados);

        if (keys.length === 0) {
            lista.innerHTML = `
                <div class="flex flex-col items-center justify-center text-center py-8 px-4 border border-dashed border-slate-200 rounded-xl bg-slate-50/50">
                    <span class="text-xl mb-1">🛒</span>
                    <h4 class="text-xs font-black text-slate-700 m-0">La orden está vacía</h4>
                    <p class="text-[11px] text-slate-400 mt-1 max-w-[180px]">Selecciona platillos para comenzar.</p>
                </div>
            `;
            return;
        }

        keys.forEach(([id, p]) => {
            const div = document.createElement('div');
            div.className = 'p-3 rounded-xl bg-slate-50 border border-slate-200/60 flex justify-between items-center gap-3 animate-fade-in';
            div.innerHTML = `
                <div class="min-w-0 flex-1">
                    <div class="flex items-center gap-2">
                        <span class="inline-flex items-center justify-center px-1.5 py-0.5 font-mono font-black text-orange-600 bg-orange-50 text-xs rounded-md">x${p.cantidad}</span>
                        <strong class="text-xs font-black text-slate-900 tracking-tight truncate block">${p.nombre}</strong>
                    </div>
                    ${p.comentarios ? `<p class="text-[10px] font-bold text-rose-700 bg-rose-50 border border-rose-100 rounded-md px-2 py-0.5 mt-1.5 inline-block m-0">⚠️ ${p.comentarios}</p>` : ''}
                </div>
                <button type="button" class="w-7 h-7 flex items-center justify-center rounded-lg bg-white border border-slate-200 hover:bg-rose-50 hover:text-rose-600 text-slate-400 text-xs transition-all cursor-pointer shadow-xs shrink-0" onclick="quitarProducto('${id}')">
                    <i class="fas fa-times"></i>
                </button>
            `;
            lista.appendChild(div);
        });
    }

    function syncCardState(id) {
        const check = document.getElementById('check_' + id);
        const card = document.getElementById('card_container_' + id);
        const btn = document.getElementById('btn_add_' + id);

        if (!check || !card || !btn) return;

        if (check.checked) {
            card.classList.remove('border-slate-200', 'bg-white');
            card.classList.add('border-orange-500', 'bg-orange-50/10');
            btn.className = "w-full py-2 bg-orange-500 border border-orange-500 text-white text-xs font-black tracking-wider uppercase rounded-xl transition-all shadow-xs flex items-center justify-center gap-1.5 cursor-pointer";
            btn.innerHTML = '<i class="fas fa-check text-[9px]"></i> Agregado';
        } else {
            card.classList.remove('border-orange-500', 'bg-orange-50/10');
            card.classList.add('border-slate-200', 'bg-white');
            btn.className = "w-full py-2 bg-white border border-slate-200 hover:bg-slate-900 hover:text-white text-slate-700 text-xs font-black tracking-wider uppercase rounded-xl transition-all shadow-xs flex items-center justify-center gap-1.5 cursor-pointer";
            btn.innerHTML = '<i class="fas fa-plus text-[9px]"></i> Agregar a Orden';
        }
    }

    function toggleProductSelection(id) {
        const check = document.getElementById('check_' + id);
        if (!check) return;

        check.checked = !check.checked;
        saveOrUpdateProductFromDOM(id, check.checked);
    }

    function saveOrUpdateProductFromDOM(id, isSelected) {
        const check = document.getElementById('check_' + id);
        const card = document.getElementById('card_container_' + id);
        if (!card) return;

        const nombre = card.querySelector('h3').innerText.trim();
        const cantidad = document.getElementById('qty_' + id).value;
        const comentarios = document.getElementById('comment_' + id).value;

        if (isSelected) {
            productosSeleccionados[id] = { nombre, cantidad, comentarios };
            if (check) check.checked = true;
        } else {
            delete productosSeleccionados[id];
            if (check) check.checked = false;
        }

        localStorage.setItem('productosSeleccionados', JSON.stringify(productosSeleccionados));
        renderSeleccionados();
        syncCardState(id);
    }

    function quitarProducto(id) {
        delete productosSeleccionados[id];
        localStorage.setItem('productosSeleccionados', JSON.stringify(productosSeleccionados));
        renderSeleccionados();

        const check = document.getElementById('check_' + id);
        if (check) check.checked = false;
        syncCardState(id);
    }

    function stepUpQty(id) {
        const input = document.getElementById('qty_' + id);
        if (input) {
            input.stepUp();
            triggerInputsChange(id);
        }
    }

    function stepDownQty(id) {
        const input = document.getElementById('qty_' + id);
        if (input && input.value > 1) {
            input.stepDown();
            triggerInputsChange(id);
        }
    }

    function triggerInputsChange(id) {
        if (productosSeleccionados[id]) {
            const cantidad = document.getElementById('qty_' + id).value;
            const comentarios = document.getElementById('comment_' + id).value;
            productosSeleccionados[id].cantidad = cantidad;
            productosSeleccionados[id].comentarios = comentarios;
            localStorage.setItem('productosSeleccionados', JSON.stringify(productosSeleccionados));
            renderSeleccionados();
        }
    }

    function limpiarMesaYOrden() {
        if(confirm('¿Estás seguro de que deseas vaciar los ítems cargados en esta orden?')) {
            productosSeleccionados = {};
            localStorage.removeItem('productosSeleccionados');
            localStorage.removeItem('comanda_mesa_id');

            const selectMesa = document.getElementById('mesa_id');
            if(selectMesa) selectMesa.value = '';

            document.querySelectorAll('.manual-check').forEach(chk => chk.checked = false);
            document.querySelectorAll('[id^="qty_"]').forEach(input => input.value = 1);
            document.querySelectorAll('[id^="comment_"]').forEach(input => input.value = '');
            document.querySelectorAll('[id^="card_container_"]').forEach(card => {
                const id = card.id.split('_')[2];
                syncCardState(id);
            });

            renderSeleccionados();
        }
    }

    window.addEventListener('DOMContentLoaded', () => {
        renderSeleccionados();

        Object.entries(productosSeleccionados).forEach(([id, data]) => {
            const check = document.getElementById('check_' + id);
            if (check) check.checked = true;

            const qtyInput = document.getElementById('qty_' + id);
            if (qtyInput) qtyInput.value = data.cantidad;

            const commentInput = document.getElementById('comment_' + id);
            if (commentInput) commentInput.value = data.comentarios;

            syncCardState(id);
        });

        const selectMesa = document.getElementById('mesa_id');
        if (selectMesa) {
            const mesaGuardada = localStorage.getItem('comanda_mesa_id');
            if (mesaGuardada) selectMesa.value = mesaGuardada;
            selectMesa.addEventListener('change', () => {
                localStorage.setItem('comanda_mesa_id', selectMesa.value);
            });
        }

        document.querySelectorAll('input[name*="[cantidad]"], input[name*="[comentarios]"]').forEach(input => {
            input.addEventListener('input', () => {
                const id = input.id.split('_')[1];
                triggerInputsChange(id);
            });
        });
    });

    document.getElementById('mainComandaForm').addEventListener('submit', function(e) {
        const container = document.getElementById('hiddenInputsContainer');
        container.innerHTML = '';

        if (Object.keys(productosSeleccionados).length === 0) {
            e.preventDefault();
            alert('⚠️ Debes agregar al menos un producto a la comanda antes de enviarla a cocina.');
            return;
        }

        Object.entries(productosSeleccionados).forEach(([id, data]) => {
            const inputCheck = document.createElement('input');
            inputCheck.type = 'hidden';
            inputCheck.name = `productos[${id}][selected]`;
            inputCheck.value = 1;
            container.appendChild(inputCheck);

            const inputCantidad = document.createElement('input');
            inputCantidad.type = 'hidden';
            inputCantidad.name = `productos[${id}][cantidad]`;
            inputCantidad.value = data.cantidad || 1;
            container.appendChild(inputCantidad);

            const inputComentarios = document.createElement('input');
            inputComentarios.type = 'hidden';
            inputComentarios.name = `productos[${id}][comentarios]`;
            inputComentarios.value = data.comentarios || '';
            container.appendChild(inputComentarios);
        });

        localStorage.removeItem('productosSeleccionados');
        localStorage.removeItem('comanda_mesa_id');
    });
</script>

<style>
    .font-black { font-weight: 900 !important; }
    .shadow-xs { box-shadow: 0 1px 2px rgba(0, 0, 0, 0.05) !important; }
    .line-clamp-2 { display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; }

    .scroll-custom::-webkit-scrollbar { width: 4px; }
    .scroll-custom::-webkit-scrollbar-track { background: transparent; }
    .scroll-custom::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 4px; }

    .custom-pagination .pagination { display: flex; gap: 6px; list-style: none; padding: 0; margin: 0; }
    .custom-pagination .page-item .page-link { padding: 10px 16px; background: white; border: 1px solid #e2e8f0; color: #0f172a; font-weight: bold; font-size: 12px; border-radius: 10px; text-decoration: none; transition: all 0.15s ease; }
    .custom-pagination .page-item .page-link:hover { background: #f8fafc; border-color: #cbd5e1; }
    .custom-pagination .page-item.active .page-link { background: #f97316; border-color: #f97316; color: white; }

    @keyframes fadeIn { from { opacity: 0; transform: translateY(4px); } to { opacity: 1; transform: translateY(0); } }
    .animate-fade-in { animation: fadeIn 0.2s ease-out forwards; }
</style>
<?php $__env->stopSection(); ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.pos', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\comida-app\resources\views/comandas/create.blade.php ENDPATH**/ ?>