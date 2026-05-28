<?php $__env->startSection('title', 'Agregar Productos Extra'); ?>

<?php $__env->startSection('content'); ?>
<div class="w-full p-4 min-h-screen bg-slate-50 text-slate-800 selection:bg-orange-500 selection:text-white">

    
    <div class="mb-6 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="text-2xl font-black text-slate-900 tracking-tight m-0 flex items-center gap-2">
                <i class="fas fa-plus-circle text-orange-500 text-xl"></i> Agregar Productos Extra
            </h1>
            <p class="text-xs font-medium text-slate-500 m-0 mt-0.5">
                Modificando la orden activa de la <span class="font-black text-slate-700">📍 <?php echo e($comanda->mesa->nombre); ?></span>
            </p>
        </div>

        
        
    <div class="shrink-0">
        <a href="<?php echo e(route('comandas.index')); ?>" class="btn-back-nav no-underline">
            <i class="fas fa-arrow-left"></i> Regresar a Comandas
        </a>
    </div>
    </div>

    
    <form id="editComandaForm" method="POST" action="<?php echo e(route('comandas.update', $comanda)); ?>" class="m-0">
        <?php echo csrf_field(); ?>
        <?php echo method_field('PUT'); ?>

        <input type="hidden" name="mesa_id" value="<?php echo e($comanda->mesa_id); ?>">
        
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 items-start">
            
            <div class="w-full lg:col-span-8 order-2 lg:order-1">
                
                <div class="bg-white p-3 rounded-2xl border border-slate-200 shadow-xs mb-6 relative">
                    <div class="relative flex items-center w-full">
                        <i class="fas fa-search absolute left-4 text-slate-400 text-sm pointer-events-none"></i>

                        <input type="text" id="searchInput" autocomplete="off"
                            class="w-full pl-10 pr-28 py-3 bg-slate-50/50 border border-slate-200 focus:border-orange-400 focus:bg-white rounded-xl text-sm font-medium text-slate-900 placeholder-slate-400 transition-all outline-none"
                            placeholder="Buscar extras por nombre o descripción de platillo...">

                        
                        <button type="button" id="clearSearchBtn"
                            class="absolute right-26 text-slate-400 hover:text-slate-600 p-1 rounded-full hover:bg-slate-100 transition-all cursor-pointer hidden">
                            <i class="fas fa-times-circle text-base"></i>
                        </button>

                        <button type="button" id="triggerSearchBtn" class="absolute right-1.5 px-5 py-2 hover:text-orange-400 border border-slate-200 text-xs font-black uppercase tracking-wider rounded-lg transition-all cursor-pointer active:scale-95 bg-white">
                            Buscar
                        </button>
                    </div>

                    
                    <div id="suggestionsDropdown" class="absolute left-0 right-0 mt-2 bg-white border border-slate-200 rounded-xl shadow-lg z-50 overflow-hidden hidden max-h-60 overflow-y-auto">
                    </div>
                </div>

                
                <?php if(isset($categorias) && $categorias->count() > 0): ?>
                <div class="mb-6">
                    <span class="text-[10px] font-black uppercase tracking-widest text-slate-400 block mb-2.5">🗂️ Filtrar por Categoría</span>
                    <div class="flex items-center gap-2 overflow-x-auto pb-2 scroll-custom" id="categoriesContainer">
                        <button type="button" onclick="filterCategory('all')" id="cat_btn_all"
                            class="category-btn shrink-0 px-4 py-2 rounded-xl text-xs font-black uppercase tracking-wider border transition-all cursor-pointer bg-orange-500 border-orange-500 text-white shadow-xs">
                            Todos
                        </button>
                        <?php $__currentLoopData = $categorias; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <button type="button" onclick="filterCategory('<?php echo e($cat->id); ?>')" id="cat_btn_<?php echo e($cat->id); ?>"
                            class="category-btn shrink-0 px-4 py-2 rounded-xl text-xs font-black uppercase tracking-wider border border-slate-200 bg-white text-slate-600 hover:bg-slate-50 transition-all cursor-pointer shadow-xs">
                            <?php echo e($cat->nombre); ?>

                        </button>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                </div>
                <?php endif; ?>

                <h2 class="text-[10px] font-black uppercase tracking-widest text-slate-400 mb-4 flex items-center gap-2">
                    🍔 Seleccionar Productos Adicionales
                </h2>

                
                <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-3 gap-4" id="catalogGrid">
                    <?php $__currentLoopData = $productos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $producto): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="product-card border border-slate-200 bg-white rounded-2xl overflow-hidden shadow-xs hover:shadow-md transition-all duration-200 flex flex-col justify-between"
                         id="card_container_<?php echo e($producto->id); ?>"
                         data-nombre="<?php echo e(strtolower($producto->nombre)); ?>"
                         data-descripcion="<?php echo e(strtolower($producto->descripcion)); ?>"
                         data-categoria="<?php echo e($producto->categoria_id ?? 'all'); ?>">

                        <div class="p-4 flex gap-3 items-start relative">
                            <input type="checkbox"
                                   name="productos[<?php echo e($producto->id); ?>][selected]"
                                   value="1"
                                   class="absolute opacity-0 w-0 h-0 pointer-events-none manual-check"
                                   id="check_<?php echo e($producto->id); ?>"
                                   onclick="syncExtraCardState('<?php echo e($producto->id); ?>')">

                            <div class="w-14 h-14 rounded-xl bg-slate-100 overflow-hidden shrink-0 border border-slate-100 flex items-center justify-center">
                                <?php if($producto->imagen): ?>
                                    <img src="<?php echo e(asset('storage/' . $producto->imagen)); ?>" alt="<?php echo e($producto->nombre); ?>" class="w-full h-full object-cover">
                                <?php else: ?>
                                    <div class="text-[9px] font-black text-slate-400 uppercase tracking-tighter text-center">Extras</div>
                                <?php endif; ?>
                            </div>

                            <div class="min-w-0 flex-1">
                                <label for="check_<?php echo e($producto->id); ?>" class="text-sm font-black text-slate-900 tracking-tight leading-snug truncate block m-0 cursor-pointer hover:text-orange-600 transition-colors">
                                    <?php echo e($producto->nombre); ?>

                                </label>
                                <p class="text-[11px] font-medium text-slate-400 mt-0.5 line-clamp-2 leading-tight h-7 m-0"><?php echo e($producto->descripcion); ?></p>
                                <span class="inline-block text-xs font-mono font-black text-orange-600 mt-1">$<?php echo e(number_format($producto->precio, 2)); ?></span>
                            </div>
                        </div>

                        <div class="p-3 bg-slate-50/80 border-t border-slate-100 space-y-2.5">
                            <div class="flex items-center justify-between gap-2">
                                <span class="text-[10px] font-black text-slate-400 uppercase tracking-wider">Cantidad:</span>
                                <div class="flex items-center bg-white border border-slate-200 rounded-lg p-0.5 shadow-xs">
                                    <button type="button" onclick="stepDownExtra('<?php echo e($producto->id); ?>')" class="w-7 h-7 flex items-center justify-center rounded bg-slate-50 hover:bg-slate-100 border-0 text-slate-600 text-xs font-bold transition-all cursor-pointer select-none">-</button>
                                    <input type="number"
                                           name="productos[<?php echo e($producto->id); ?>][cantidad]"
                                           id="qty_<?php echo e($producto->id); ?>"
                                           value="1"
                                           min="1"
                                           class="w-10 text-center bg-transparent border-0 font-mono font-black text-slate-900 text-sm focus:outline-none">
                                    <button type="button" onclick="stepUpExtra('<?php echo e($producto->id); ?>')" class="w-7 h-7 flex items-center justify-center rounded bg-slate-50 hover:bg-slate-100 border-0 text-slate-600 text-xs font-bold transition-all cursor-pointer select-none">+</button>
                                </div>
                            </div>

                            <div class="relative flex items-center">
                                <i class="fas fa-pen absolute left-3 text-slate-300 text-[9px]"></i>
                                <input type="text"
                                       name="productos[<?php echo e($producto->id); ?>][comentarios]"
                                       id="comment_<?php echo e($producto->id); ?>"
                                       class="w-full pl-7 pr-2 py-2 bg-white border border-slate-200 focus:border-slate-300 rounded-lg text-xs font-medium text-slate-700 placeholder-slate-400 outline-none transition-all"
                                       placeholder="Ej: sin aderezo, bien tostado...">
                            </div>

                            <button type="button" id="btn_add_<?php echo e($producto->id); ?>" onclick="toggleExtraSelection('<?php echo e($producto->id); ?>')"
                                class="w-full py-2 bg-white border border-slate-200 hover:bg-slate-900 hover:text-white text-slate-700 text-xs font-black tracking-wider uppercase rounded-xl transition-all shadow-xs flex items-center justify-center gap-1.5 cursor-pointer">
                                <i class="fas fa-plus text-[9px]"></i> Incluir Extra
                            </button>
                        </div>
                    </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>

                
                <div id="emptySearchState" class="hidden py-12 text-center bg-white border border-dashed border-slate-200 rounded-2xl shadow-xs">
                    <i class="fas fa-search text-slate-300 text-4xl mb-3 block"></i>
                    <p class="text-xs font-bold text-slate-400 m-0">No se encontraron productos que coincidan con el filtro aplicado.</p>
                </div>
            </div>

            
            <div class="w-full lg:col-span-4 order-1 lg:order-2 lg:sticky lg:top-4">
                <div class="border border-slate-200 shadow-sm rounded-2xl overflow-hidden bg-white flex flex-col">

                    <div class="p-4 bg-slate-900 border-b border-slate-800 flex justify-between items-center">
                        <div class="flex items-center gap-2">
                            <i class="fas fa-receipt text-slate-400 text-xs"></i>
                            <h2 class="text-xs font-black text-white uppercase tracking-wider m-0">Resumen de Ticket</h2>
                        </div>
                        <span class="px-2 py-0.5 text-[10px] font-mono font-black text-slate-300 bg-slate-800 rounded-md">
                            Mesa: <?php echo e($comanda->mesa->nombre); ?>

                        </span>
                    </div>

                    
                    <div class="p-4 bg-white border-b border-slate-100">
                        <span class="text-[10px] font-black uppercase tracking-widest text-slate-400 block mb-3">Productos ya Enviados</span>
                        <div class="max-h-[180px] overflow-y-auto space-y-2 pr-1 scroll-custom">
                            <?php $__currentLoopData = $comanda->productos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $producto): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <div class="p-2.5 rounded-xl bg-slate-50 border border-slate-200/60 flex items-start justify-between gap-3 opacity-80">
                                <div class="min-w-0 flex-1">
                                    <div class="flex items-center gap-2">
                                        <span class="inline-flex items-center justify-center px-1.5 py-0.5 font-mono font-black text-slate-500 bg-slate-200/60 text-[10px] rounded-md">
                                            x<?php echo e($producto->pivot->cantidad); ?>

                                        </span>
                                        <strong class="text-xs font-black text-slate-800 tracking-tight truncate block">
                                            <?php echo e($producto->nombre); ?>

                                        </strong>
                                    </div>
                                    <?php if($producto->pivot->comentarios): ?>
                                    <p class="text-[9px] font-bold text-slate-500 bg-slate-200/40 border border-slate-200 rounded-md px-1.5 py-0.5 mt-1 inline-block m-0">
                                        📌 <?php echo e($producto->pivot->comentarios); ?>

                                    </p>
                                    <?php endif; ?>
                                </div>
                                <span class="text-[9px] font-black uppercase tracking-widest px-1.5 py-0.5 bg-slate-200 text-slate-600 rounded-md">Listo</span>
                            </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </div>
                    </div>

                    
                    <div class="p-4 bg-white flex-1 border-b border-slate-100">
                        <span class="text-[10px] font-black uppercase tracking-widest text-orange-600 block mb-3">Nuevos Extras por Añadir</span>
                        <div class="min-h-[100px] max-h-[220px] overflow-y-auto space-y-2 pr-1 scroll-custom" id="listaNuevosExtras">
                            
                        </div>
                    </div>

                    
                    <div class="p-4 bg-slate-50 border-t border-slate-100 space-y-2">
                        <button type="submit" class="w-full inline-flex items-center justify-center gap-2 py-3.5 bg-orange-500 hover:bg-orange-600 active:scale-[0.98] border-0 text-white text-xs font-black tracking-wider uppercase rounded-xl shadow-md shadow-orange-500/20 transition-all cursor-pointer">
                            <i class="fas fa-paper-plane text-xs"></i> Actualizar y Mandar a Cocina
                        </button>

                        <a href="<?php echo e(route('comandas.index')); ?>" onclick="limpiarAlmacenEdicion()" class="w-full inline-flex items-center justify-center gap-2 py-2.5 bg-white border border-slate-200 hover:bg-slate-100 active:scale-[0.98] text-slate-700 text-xs font-black tracking-wider uppercase rounded-xl transition-all text-decoration-none">
                            <i class="fas fa-times text-xs"></i> Cancelar Ajuste
                        </a>
                    </div>
                </div>
            </div>

        </div>
    </form>
</div>

<?php $__env->startSection('scripts'); ?>
<script>
    // Almacenamiento seguro por Comanda para evitar colisiones
    const storageKey = 'extras_comanda_<?php echo e($comanda->id); ?>';
    const categoryStorageKey = 'categoria_activa_<?php echo e($comanda->id); ?>';
    let extrasSeleccionados = JSON.parse(localStorage.getItem(storageKey) || '{}');
    let categoriaActiva = localStorage.getItem(categoryStorageKey) || 'all';

    // Elementos del DOM del Buscador
    const searchInput = document.getElementById('searchInput');
    const clearSearchBtn = document.getElementById('clearSearchBtn');
    const dropdown = document.getElementById('suggestionsDropdown');
    const triggerSearchBtn = document.getElementById('triggerSearchBtn');
    let debounceTimer;

    // --- MANEJO DEL BUSCADOR COMERCIAL Y FILTRADO INTERNO EN TIEMPO REAL ---
    if (searchInput) {
        searchInput.addEventListener('input', function() {
            const query = this.value.trim().toLowerCase();

            if (query.length > 0) {
                clearSearchBtn.classList.remove('hidden');
            } else {
                clearSearchBtn.classList.add('hidden');
                dropdown.classList.add('hidden');
                ejecutarFiltradoPantalla();
                return;
            }

            // Debounce táctil de alto desempeño
            clearTimeout(debounceTimer);
            debounceTimer = setTimeout(() => {
                fetch(`<?php echo e(route('productos.sugerencias')); ?>?search=${encodeURIComponent(query)}`)
                    .then(response => response.json())
                    .then(data => {
                        dropdown.innerHTML = '';
                        if (data.length === 0) {
                            dropdown.innerHTML = `
                                <div class="p-4 text-center text-xs font-bold text-slate-400 flex items-center justify-center gap-2 bg-white">
                                    <i class="fas fa-info-circle text-slate-300"></i> Sin coincidencias directas
                                </div>`;
                        } else {
                            data.forEach(producto => {
                                const btn = document.createElement('button');
                                btn.type = 'button';
                                btn.className = "w-full text-left px-4 py-3 text-xs font-black text-slate-700 hover:bg-orange-50 hover:text-orange-900 border-0 border-b border-slate-100 last:border-0 bg-white transition-all cursor-pointer flex items-center gap-2";
                                btn.innerHTML = `<i class="fas fa-plus text-orange-500 text-[9px]"></i> ${producto.nombre}`;

                                btn.addEventListener('click', () => {
                                    searchInput.value = producto.nombre;
                                    dropdown.classList.add('hidden');
                                    ejecutarFiltradoPantalla();
                                });
                                dropdown.appendChild(btn);
                            });
                        }
                        dropdown.classList.remove('hidden');
                    }).catch(error => console.error('Error cargando sugerencias:', error));
            }, 200);
        });

        // Botón de Limpiar Búsqueda
        clearSearchBtn.addEventListener('click', () => {
            searchInput.value = '';
            clearSearchBtn.classList.add('hidden');
            dropdown.classList.add('hidden');
            ejecutarFiltradoPantalla();
        });

        triggerSearchBtn.addEventListener('click', ejecutarFiltradoPantalla);
    }

    // --- FILTRADO DE COMPONENTES EN PANTALLA ---
    function filterCategory(catId) {
        categoriaActiva = catId;
        localStorage.setItem(categoryStorageKey, catId);

        document.querySelectorAll('.category-btn').forEach(btn => {
            btn.className = "category-btn shrink-0 px-4 py-2 rounded-xl text-xs font-black uppercase tracking-wider border border-slate-200 bg-white text-slate-600 hover:bg-slate-50 transition-all cursor-pointer shadow-xs";
        });

        const activeBtn = document.getElementById('cat_btn_' + catId);
        if (activeBtn) {
            activeBtn.className = "category-btn shrink-0 px-4 py-2 rounded-xl text-xs font-black uppercase tracking-wider border border-orange-500 bg-orange-500 text-white shadow-xs";
        }
        ejecutarFiltradoPantalla();
    }

    function ejecutarFiltradoPantalla() {
        const query = searchInput ? searchInput.value.trim().toLowerCase() : '';
        const cards = document.querySelectorAll('#catalogGrid .product-card');
        let visibles = 0;

        cards.forEach(card => {
            const nombre = card.getAttribute('data-nombre');
            const descripcion = card.getAttribute('data-descripcion');
            const categoria = card.getAttribute('data-categoria');

            const coincideQuery = !query || nombre.includes(query) || descripcion.includes(query);
            const coincideCategoria = categoriaActiva === 'all' || categoria == categoriaActiva;

            if (coincideQuery && coincideCategoria) {
                card.classList.remove('hidden');
                visibles++;
            } else {
                card.classList.add('hidden');
            }
        });

        const emptyState = document.getElementById('emptySearchState');
        if (visibles === 0) {
            emptyState.classList.remove('hidden');
        } else {
            emptyState.classList.add('hidden');
        }
    }

    // --- GESTIÓN INTERNA DE LÓGICA DE EXTRAS ---
    function renderNuevosExtras() {
        const lista = document.getElementById('listaNuevosExtras');
        if (!lista) return;

        lista.innerHTML = '';
        const entries = Object.entries(extrasSeleccionados);

        if (entries.length === 0) {
            lista.innerHTML = `
                <div class="flex flex-col items-center justify-center text-center py-6 px-4 border border-dashed border-slate-200 rounded-xl bg-slate-50/50">
                    <span class="text-lg mb-1">🛒</span>
                    <p class="text-[11px] font-bold text-slate-400 m-0">Ningún extra seleccionado en este momento.</p>
                </div>`;
            return;
        }

        entries.forEach(([id, data]) => {
            const div = document.createElement('div');
            div.className = 'p-2.5 rounded-xl bg-orange-50/40 border border-orange-200/60 flex justify-between items-center gap-3 animate-fade-in';
            div.innerHTML = `
                <div class="min-w-0 flex-1">
                    <div class="flex items-center gap-2">
                        <span class="inline-flex items-center justify-center px-1.5 py-0.5 font-mono font-black text-orange-600 bg-orange-50 text-[10px] rounded-md">x${data.cantidad}</span>
                        <strong class="text-xs font-black text-slate-900 tracking-tight truncate block">${data.nombre}</strong>
                    </div>
                    ${data.comentarios ? `<p class="text-[9px] font-bold text-orange-700 bg-orange-100/50 border border-orange-200/40 rounded-md px-1.5 py-0.5 mt-1 inline-block m-0">💬 ${data.comentarios}</p>` : ''}
                </div>
                <button type="button" class="w-6 h-6 flex items-center justify-center rounded-lg bg-white border border-slate-200 text-slate-400 hover:text-rose-600 text-[10px] transition-all cursor-pointer shadow-xs" onclick="quitarExtra('${id}')">
                    <i class="fas fa-times"></i>
                </button>`;
            lista.appendChild(div);
        });
    }

    function syncExtraCardState(id) {
        const check = document.getElementById('check_' + id);
        const card = document.getElementById('card_container_' + id);
        const btn = document.getElementById('btn_add_' + id);

        if (!check || !card || !btn) return;

        if (check.checked) {
            card.classList.remove('border-slate-200', 'bg-white');
            card.classList.add('border-orange-500', 'bg-orange-50/10');
            btn.className = "w-full py-2 bg-orange-500 border border-orange-500 text-white text-xs font-black tracking-wider uppercase rounded-xl transition-all shadow-xs flex items-center justify-center gap-1.5 cursor-pointer";
            btn.innerHTML = '<i class="fas fa-check text-[9px]"></i> Incluido';
        } else {
            card.classList.remove('border-orange-500', 'bg-orange-50/10');
            card.classList.add('border-slate-200', 'bg-white');
            btn.className = "w-full py-2 bg-white border border-slate-200 hover:bg-slate-900 hover:text-white text-slate-700 text-xs font-black tracking-wider uppercase rounded-xl transition-all shadow-xs flex items-center justify-center gap-1.5 cursor-pointer";
            btn.innerHTML = '<i class="fas fa-plus text-[9px]"></i> Incluir Extra';
        }
    }

    function toggleExtraSelection(id) {
        const check = document.getElementById('check_' + id);
        if (!check) return;
        check.checked = !check.checked;
        saveOrUpdateExtraFromDOM(id, check.checked);
    }

    function saveOrUpdateExtraFromDOM(id, isSelected) {
        const card = document.getElementById('card_container_' + id);
        if (!card) return;

        if (isSelected) {
            const nombre = card.querySelector('label').innerText.trim();
            const cantidad = document.getElementById('qty_' + id).value;
            const comentarios = document.getElementById('comment_' + id).value;
            extrasSeleccionados[id] = { nombre, cantidad, comentarios };
        } else {
            delete extrasSeleccionados[id];
        }

        localStorage.setItem(storageKey, JSON.stringify(extrasSeleccionados));
        renderNuevosExtras();
        syncExtraCardState(id);
    }

    function quitarExtra(id) {
        const check = document.getElementById('check_' + id);
        if (check) check.checked = false;
        delete extrasSeleccionados[id];
        localStorage.setItem(storageKey, JSON.stringify(extrasSeleccionados));
        renderNuevosExtras();
        syncExtraCardState(id);
    }

    function stepUpExtra(id) {
        const input = document.getElementById('qty_' + id);
        if (input) {
            input.stepUp();
            if (extrasSeleccionados[id]) {
                extrasSeleccionados[id].cantidad = input.value;
                localStorage.setItem(storageKey, JSON.stringify(extrasSeleccionados));
                renderNuevosExtras();
            }
        }
    }

    function stepDownExtra(id) {
        const input = document.getElementById('qty_' + id);
        if (input && input.value > 1) {
            input.stepDown();
            if (extrasSeleccionados[id]) {
                extrasSeleccionados[id].cantidad = input.value;
                localStorage.setItem(storageKey, JSON.stringify(extrasSeleccionados));
                renderNuevosExtras();
            }
        }
    }

    function limpiarAlmacenEdicion() {
        localStorage.removeItem(storageKey);
    }

    // --- CARGA SÍNCRONA DE ESTADOS AL INICIAR ---
    window.addEventListener('DOMContentLoaded', () => {
        filterCategory(categoriaActiva);
        renderNuevosExtras();

        // Restaurar estado de los componentes desde localStorage
        Object.entries(extrasSeleccionados).forEach(([id, data]) => {
            const check = document.getElementById('check_' + id);
            if (check) check.checked = true;

            const qtyInput = document.getElementById('qty_' + id);
            if (qtyInput) qtyInput.value = data.cantidad;

            const commentInput = document.getElementById('comment_' + id);
            if (commentInput) commentInput.value = data.comentarios;

            syncExtraCardState(id);
        });

        // Escuchar cambios manuales en inputs de texto de comentarios
        document.querySelectorAll('#catalogGrid input[type="text"]').forEach(input => {
            input.addEventListener('input', () => {
                const id = input.id.split('_')[1];
                if (extrasSeleccionados[id]) {
                    extrasSeleccionados[id].comentarios = input.value;
                    localStorage.setItem(storageKey, JSON.stringify(extrasSeleccionados));
                    renderNuevosExtras();
                }
            });
        });

        // Evento de cierre de Dropdown externa
        document.addEventListener('click', function(e) {
            if (searchInput && !searchInput.contains(e.target) && !dropdown.contains(e.target)) {
                dropdown.classList.add('hidden');
            }
        });
    });

    // Al enviar de forma exitosa, limpiamos únicamente la caché de esta comanda
    document.getElementById('editComandaForm').addEventListener('submit', function() {
        limpiarAlmacenEdicion();
    });
</script>

<style>
    .font-black { font-weight: 900 !important; }
    .shadow-xs { box-shadow: 0 1px 2px rgba(0, 0, 0, 0.05) !important; }
    .line-clamp-2 { display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; }

    .scroll-custom::-webkit-scrollbar { height: 4px; width: 4px; }
    .scroll-custom::-webkit-scrollbar-track { background: transparent; }
    .scroll-custom::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 4px; }

    @keyframes fadeIn { from { opacity: 0; transform: translateY(3px); } to { opacity: 1; transform: translateY(0); } }
    .animate-fade-in { animation: fadeIn 0.18s ease-out forwards; }
</style>
<?php $__env->stopSection(); ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.pos', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\comida-app\resources\views/comandas/edit.blade.php ENDPATH**/ ?>