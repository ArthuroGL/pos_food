<?php $__env->startSection('title', 'Editar Producto'); ?>
<?php $__env->startSection('view_title', '📦 Editar Producto'); ?>
<?php $__env->startSection('view_subtitle', 'Modifica las propiedades y la presencia visual del menú'); ?>

<?php $__env->startSection('content'); ?>
<div class="h-full w-full p-6 overflow-y-auto sheet-layout bg-slate-100 text-slate-800 scroll-custom flex flex-col">

    
    <div class="w-full max-w-4xl mx-auto flex flex-col flex-1">

        
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-6 w-full">
            <div>
                <h2 class="text-xl font-black text-slate-900 tracking-tight m-0">Modificar información</h2>
                <p class="text-xs font-medium text-slate-400 mt-1 m-0">Actualiza el precio, descripción o categoría para reflejar los cambios en el menú</p>
            </div>
            <a href="<?php echo e(route('productos.index')); ?>"
               class="w-full sm:w-auto bg-slate-200 hover:bg-slate-300 active:scale-[0.98] transition-all text-slate-700 font-black px-4 py-2.5 rounded-xl text-xs tracking-wide cursor-pointer flex items-center justify-center gap-2 border border-slate-300 uppercase">
                <i class="fas fa-arrow-left text-[10px]"></i> Volver al catálogo
            </a>
        </div>

        
        <div class="bg-white border border-slate-200 rounded-2xl shadow-xs overflow-hidden w-full mb-6">
            <form action="<?php echo e(route('productos.update', $producto)); ?>" method="POST" enctype="multipart/form-data" class="m-0">
                <?php echo csrf_field(); ?>
                <?php echo method_field('PUT'); ?>

                <div class="p-6 md:p-8 grid grid-cols-1 md:grid-cols-12 gap-8">

                    
                    <div class="md:col-span-4 flex flex-col gap-4">
                        <label class="text-xs font-black uppercase tracking-wider text-slate-400 block mb-1">Imagen del Producto</label>

                        <div class="relative w-full aspect-[4/3] bg-slate-50 border border-slate-200 rounded-xl overflow-hidden flex flex-col items-center justify-center p-3 shadow-3xs group">
                            <?php if($producto->imagen): ?>
                                <img src="<?php echo e(asset('storage/' . $producto->imagen)); ?>"
                                     alt="Imagen actual"
                                     class="w-full h-full object-contain transition-transform duration-300 group-hover:scale-102">
                                <span class="absolute bottom-2 left-2 bg-slate-900/70 text-white font-mono text-[9px] font-bold px-2 py-0.5 rounded-md backdrop-blur-xs">
                                    Imagen Actual
                                </span>
                            <?php else: ?>
                                <div class="text-center text-slate-300 flex flex-col items-center gap-2">
                                    <i class="fas fa-image text-4xl"></i>
                                    <span class="text-[10px] font-bold uppercase tracking-wider text-slate-400">Sin Imagen</span>
                                </div>
                            <?php endif; ?>
                        </div>

                        <div class="relative">
                            <input type="file" name="imagen" id="imagen"
                                   class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-10"
                                   accept="image/*">
                            <div class="w-full bg-slate-50 hover:bg-slate-100 border border-dashed border-slate-300 hover:border-slate-400 rounded-xl py-3 px-4 text-center transition-all flex items-center justify-center gap-2 shadow-3xs">
                                <i class="fas fa-upload text-slate-400 text-xs"></i>
                                <span class="text-xs font-bold text-slate-600">Reemplazar archivo</span>
                            </div>
                        </div>
                        <p class="text-[10px] font-medium text-slate-400 text-center m-0">Soporta formatos JPG, PNG o SVG transparentes</p>
                    </div>

                    
                    <div class="md:col-span-8 space-y-5">
                        
                        <div>
                            <label for="nombre" class="text-xs font-black uppercase tracking-wider text-slate-400 block mb-2">Nombre del Producto</label>
                            <input type="text" name="nombre" id="nombre"
                                   class="w-full bg-slate-50 border border-slate-200 focus:border-orange-500 focus:bg-white rounded-xl px-4 py-3 text-sm font-bold text-slate-800 transition-all outline-hidden shadow-2xs placeholder-slate-300"
                                   value="<?php echo e(old('nombre', $producto->nombre)); ?>"
                                   placeholder="Ej. Taco campechano especial"
                                   required autocomplete="off">
                        </div>

                        
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                            
                            <div>
                                <label for="precio" class="text-xs font-black uppercase tracking-wider text-slate-400 block mb-2">Precio ($ MXN)</label>
                                <div class="relative flex items-center">
                                    <span class="absolute left-4 font-mono font-black text-slate-400 text-sm select-none">$</span>
                                    <input type="number" step="0.01" name="precio" id="precio"
                                           class="w-full bg-slate-50 border border-slate-200 focus:border-orange-500 focus:bg-white rounded-xl pl-8 pr-4 py-3 text-sm font-black text-slate-800 font-mono transition-all outline-hidden shadow-2xs"
                                           value="<?php echo e(old('precio', $producto->precio)); ?>"
                                           required autocomplete="off">
                                </div>
                            </div>

                            
                            <div>
                                <label for="categoria_id" class="text-xs font-black uppercase tracking-wider text-slate-400 block mb-2">Categoría Asignada</label>
                                <div class="relative">
                                    <select name="categoria_id" id="categoria_id"
                                            class="w-full bg-slate-50 border border-slate-200 focus:border-orange-500 focus:bg-white rounded-xl px-4 py-3 text-sm font-bold text-slate-700 transition-all outline-hidden shadow-2xs appearance-none cursor-pointer">
                                        <?php $__currentLoopData = $categorias; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $categoria): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($categoria->id); ?>" <?php echo e($producto->categoria_id == $categoria->id ? 'selected' : ''); ?>>
                                                <?php echo e(ucfirst($categoria->nombre)); ?>

                                            </option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>
                                    <div class="absolute inset-y-0 right-4 flex items-center pointer-events-none text-slate-400 text-xs">
                                        <i class="fas fa-chevron-down"></i>
                                    </div>
                                </div>
                            </div>
                        </div>

                        
                        <div>
                            <label for="descripcion" class="text-xs font-black uppercase tracking-wider text-slate-400 block mb-2">Descripción o Ingredientes</label>
                            <textarea name="descripcion" id="descripcion" rows="3"
                                      class="w-full bg-slate-50 border border-slate-200 focus:border-orange-500 focus:bg-white rounded-xl px-4 py-3 text-sm font-medium text-slate-700 leading-relaxed transition-all outline-hidden shadow-2xs resize-none placeholder-slate-300"
                                      placeholder="Detalla los componentes del platillo o notas para el mesero..."><?php echo e(old('descripcion', $producto->descripcion)); ?></textarea>
                        </div>
                    </div>

                </div>

                
                <div class="p-4 bg-slate-50 border-t border-slate-200 flex justify-end">
                    <button type="submit"
                            class="w-full sm:w-auto bg-emerald-600 hover:bg-emerald-700 active:scale-[0.98] transition-all text-white font-black px-6 py-3.5 rounded-xl text-sm tracking-wide cursor-pointer flex items-center justify-center gap-2 shadow-lg shadow-emerald-600/20 border-0 uppercase">
                        <i class="fas fa-save text-xs"></i> Guardar Cambios
                    </button>
                </div>
            </form>
        </div>

    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.pos', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\comida-app\resources\views/productos/edit.blade.php ENDPATH**/ ?>