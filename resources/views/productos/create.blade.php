@extends('layouts.pos')

@section('title', 'Nuevo Producto')
@section('view_title', '🚀 Nuevo Producto')
@section('view_subtitle', 'Expande el menú agregando platillos o bebidas de forma ágil')

@section('content')
<div class="h-full w-full p-6 overflow-y-auto sheet-layout bg-slate-100 text-slate-800 scroll-custom flex flex-col">

    {{-- Contenedor de Centrado Maestro --}}
    <div class="w-full max-w-5xl mx-auto flex flex-col flex-1">

        {{-- Cabecera y Botón de Regreso --}}
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-6 w-full">
            <div>
                <h2 class="text-xl font-black text-slate-900 tracking-tight m-0">Alta de producto</h2>
                <p class="text-xs font-medium text-slate-400 mt-1 m-0">Completa los campos base y define los modificadores e ingredientes para la cocina</p>
            </div>
            <a href="{{ route('productos.index') }}"
               class="w-full sm:w-auto bg-slate-200 hover:bg-slate-300 active:scale-[0.98] transition-all text-slate-700 font-black px-4 py-2.5 rounded-xl text-xs tracking-wide cursor-pointer flex items-center justify-center gap-2 border border-slate-300 uppercase">
                <i class="fas fa-arrow-left text-[10px]"></i> Cancelar y volver
            </a>
        </div>

        {{-- Tarjeta de Trabajo Operativa Centrada --}}
        <div class="bg-white border border-slate-200 rounded-2xl shadow-xs overflow-hidden w-full mb-6">
            <form method="POST" action="{{ route('productos.store') }}" enctype="multipart/form-data" class="m-0">
                @csrf

                <div class="p-6 md:p-8 grid grid-cols-1 lg:grid-cols-12 gap-8">

                    {{-- COLUMNA IZQUIERDA: Información Esencial (7 Columnas) --}}
                    <div class="lg:col-span-7 space-y-5">
                        {{-- Campo: Nombre --}}
                        <div>
                            <label for="nombre" class="text-xs font-black uppercase tracking-wider text-slate-400 block mb-2">Nombre del Platillo / Bebida</label>
                            <input type="text" name="nombre" id="nombre"
                                   class="w-full bg-slate-50 border border-slate-200 focus:border-orange-500 focus:bg-white rounded-xl px-4 py-3 text-sm font-bold text-slate-800 transition-all outline-hidden shadow-2xs placeholder-slate-400"
                                   placeholder="Ej. Tacos de Arrachera con costra" required autocomplete="off">
                        </div>

                        {{-- Fila Dupla: Precio y Categoría --}}
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                            {{-- Campo: Precio --}}
                            <div>
                                <label for="precio" class="text-xs font-black uppercase tracking-wider text-slate-400 block mb-2">Precio de Venta ($ MXN)</label>
                                <div class="relative flex items-center">
                                    <span class="absolute left-4 font-mono font-black text-slate-400 text-sm select-none">$</span>
                                    <input type="number" name="precio" id="precio" step="0.01"
                                           class="w-full bg-slate-50 border border-slate-200 focus:border-orange-500 focus:bg-white rounded-xl pl-8 pr-4 py-3 text-sm font-black text-slate-800 font-mono transition-all outline-hidden shadow-2xs"
                                           placeholder="0.00" required autocomplete="off">
                                </div>
                            </div>

                            {{-- Campo: Categoría --}}
                            <div>
                                <label for="categoria_id" class="text-xs font-black uppercase tracking-wider text-slate-400 block mb-2">Categoría</label>
                                <div class="relative">
                                    <select name="categoria_id" id="categoria_id"
                                            class="w-full bg-slate-50 border border-slate-200 focus:border-orange-500 focus:bg-white rounded-xl px-4 py-3 text-sm font-bold text-slate-700 transition-all outline-hidden shadow-2xs appearance-none cursor-pointer" required>
                                        <option value="" disabled selected class="text-slate-300">Selecciona una...</option>
                                        @foreach($categorias as $categoria)
                                            <option value="{{ $categoria->id }}">{{ ucfirst($categoria->nombre) }}</option>
                                        @endforeach
                                    </select>
                                    <div class="absolute inset-y-0 right-4 flex items-center pointer-events-none text-slate-400 text-xs">
                                        <i class="fas fa-chevron-down"></i>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- Campo: Descripción --}}
                        <div>
                            <label for="descripcion" class="text-xs font-black uppercase tracking-wider text-slate-400 block mb-2">Descripción corta para comandero</label>
                            <textarea name="descripcion" id="descripcion" rows="3"
                                      class="w-full bg-slate-50 border border-slate-200 focus:border-orange-500 focus:bg-white rounded-xl px-4 py-3 text-sm font-medium text-slate-700 leading-relaxed transition-all outline-hidden shadow-2xs resize-none placeholder-slate-400"
                                      placeholder="Detalle de preparación (Ej. Servidos con doble tortilla de maíz, cebollitas cambray...)"></textarea>
                        </div>

                        {{-- Campo: Carga de Imagen --}}
                        <div>
                            <label class="text-xs font-black uppercase tracking-wider text-slate-400 block mb-2">Fotografía o Ilustración</label>
                            <div class="relative">
                                <input type="file" name="imagen" id="imagen"
                                       class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-10" accept="image/*">
                                <div class="w-full bg-slate-50 hover:bg-slate-100 border border-dashed border-slate-300 hover:border-slate-400 rounded-xl py-4 px-4 text-center transition-all flex items-center justify-center gap-3 shadow-3xs">
                                    <div class="h-8 w-8 bg-slate-200 rounded-lg flex items-center justify-center text-slate-500">
                                        <i class="fas fa-image text-sm"></i>
                                    </div>
                                    <div class="text-left">
                                        <span class="text-xs font-black text-slate-700 block">Subir imagen del producto</span>
                                        <span class="text-[10px] font-medium text-slate-400 block">PNG, JPG o SVG optimizados para el POS</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- COLUMNA DERECHA: Complementos / Modificadores Rápidos (5 Columnas) --}}
                    <div class="lg:col-span-5 bg-slate-50 border border-slate-200 p-5 rounded-xl flex flex-col justify-between">
                        <div>
                            <div class="flex items-center gap-2 mb-1">
                                <i class="fas fa-blender text-slate-400 text-xs"></i>
                                <label class="text-xs font-black uppercase tracking-wider text-slate-700 m-0">Complementos por Defecto</label>
                            </div>
                            <p class="text-[11px] font-medium text-slate-400 mb-4 leading-normal">Selecciona los ingredientes extra que el mesero puede remover o agregar al enviar la comanda a cocina.</p>

                            <div class="flex flex-wrap gap-2.5">
                                @foreach(['cebolla' => 'Cebolla', 'cilantro' => 'Cilantro', 'lechuga' => 'Lechuga', 'queso' => 'Queso', 'crema' => 'Crema'] as $value => $label)
                                    <label class="inline-flex items-center gap-2 bg-white border border-slate-200 hover:border-slate-300 rounded-xl px-4 py-2.5 cursor-pointer shadow-3xs select-none transition-all has-checked:bg-orange-50 has-checked:border-orange-500 has-checked:text-orange-900 group">
                                        <input type="checkbox" name="complementos[]" value="{{ $value }}"
                                               class="w-4 h-4 rounded-md border-slate-300 text-orange-600 focus:ring-orange-500/30 accent-orange-600 cursor-pointer m-0">
                                        <span class="text-xs font-bold text-slate-700 group-has-checked:text-orange-950">{{ $label }}</span>
                                    </label>
                                @endforeach
                            </div>
                        </div>

                        <div class="mt-6 p-3.5 bg-orange-50/60 border border-orange-100 rounded-xl flex gap-3 items-start">
                            <i class="fas fa-info-circle text-orange-600 text-xs mt-0.5"></i>
                            <p class="text-[11px] font-medium text-orange-800 leading-normal m-0">
                                Los productos dados de alta aquí aparecen inmediatamente en el <strong>Monitor de Comandas</strong> bajo la categoría seleccionada.
                            </p>
                        </div>
                    </div>

                </div>

                {{-- Footer con Botón de Acción --}}
                <div class="p-4 bg-slate-50 border-t border-slate-200 flex justify-end">
                    <button type="submit"
                            class="w-full sm:w-auto bg-orange-600 hover:bg-orange-700 active:scale-[0.98] transition-all text-white font-black px-6 py-3.5 rounded-xl text-sm tracking-wide cursor-pointer flex items-center justify-center gap-2 shadow-lg shadow-orange-600/20 border-0 uppercase">
                        <i class="fas fa-plus-circle text-xs"></i> Crear y Publicar Producto
                    </button>
                </div>
            </form>
        </div>

    </div>
</div>
@endsection
