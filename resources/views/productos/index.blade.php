@extends('layouts.pos')

@section('title', 'Productos')
@section('view_title', '📦 Catálogo de Productos')
@section('view_subtitle', 'Administración y control del menú operativo')

@section('content')
<div class="h-full w-full p-6 overflow-y-auto sheet-layout bg-slate-100 text-slate-800 scroll-custom">

    {{-- Cabecera de Control / Acciones Principales --}}
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-6">
        <div>
            <h2 class="text-xl font-black text-slate-900 tracking-tight m-0">Lista de productos</h2>
            <p class="text-xs font-medium text-slate-400 mt-1 m-0">Organizados por categoría y ordenados alfabéticamente</p>
        </div>
        <a href="{{ route('productos.create') }}"
           class="w-full sm:w-auto bg-orange-600 hover:bg-orange-700 active:scale-[0.98] transition-all text-white font-black px-5 py-3 rounded-xl text-sm tracking-wide cursor-pointer flex items-center justify-center gap-2 shadow-lg shadow-orange-600/20 border-0 uppercase">
            <i class="fas fa-plus text-xs"></i> Agregar producto
        </a>
    </div>

    {{-- Contenedor de Categorías --}}
    @foreach ($categorias as $categoria)
    @if ($categoria->productos->isNotEmpty())
    <div class="mb-8 bg-white border border-slate-200 rounded-2xl shadow-xs overflow-hidden">

        {{-- Header de la Categoría --}}
        <div class="p-4 bg-slate-50 border-b border-slate-200 flex items-center justify-between">
            <div class="flex items-center gap-2">
                <span class="h-2 w-2 rounded-full bg-orange-500"></span>
                <h5 class="text-sm font-black text-slate-800 uppercase tracking-wider m-0">
                    {{ ucfirst($categoria->nombre) }}
                </h5>
            </div>
            <span class="badge bg-slate-200/60 text-slate-600 px-2.5 py-0.5 rounded-lg font-mono text-xs font-bold border border-slate-300/50">
                {{ $categoria->productos->count() }} disponible
            </span>
        </div>

        {{-- Grid de Tarjetas de Productos --}}
        <div class="p-5">
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                @foreach ($categoria->productos->sortBy('nombre') as $producto)
                <div class="group flex flex-col bg-white border border-slate-200 rounded-xl overflow-hidden shadow-2xs transition-all duration-300 hover:shadow-md hover:border-slate-300"
                     id="producto-card-{{ $producto->id }}">

                    {{-- Contenedor de Imagen con Proporción Fija --}}
                    <div class="relative w-full aspect-[16/10] bg-slate-50 border-b border-slate-100 overflow-hidden shrink-0 flex items-center justify-center">
                        @if ($producto->imagen)
                            <img src="{{ asset('storage/' . $producto->imagen) }}"
                                 alt="{{ $producto->nombre }}"
                                 class="w-full h-full object-contain p-2 transition-transform duration-500 group-hover:scale-105">
                        @else
                            <div class="flex flex-col items-center justify-center text-slate-300 gap-2">
                                <i class="fas fa-image text-3xl"></i>
                                <span class="text-[10px] font-bold uppercase tracking-wider text-slate-400">Sin Imagen</span>
                            </div>
                        @endif
                    </div>

                    {{-- Cuerpo de la Tarjeta --}}
                    <div class="p-4 flex flex-col flex-1 min-w-0 justify-between gap-4">

                        {{-- Información del Ítem --}}
                        <div class="min-w-0">
                            <strong class="text-base font-black text-slate-900 tracking-tight block truncate group-hover:text-orange-600 transition-colors" title="{{ $producto->nombre }}">
                                {{ $producto->nombre }}
                            </strong>
                            <p class="text-xs font-medium text-slate-400 mt-1 leading-relaxed line-clamp-2 h-8 mb-0" title="{{ $producto->descripcion }}">
                                {{ $producto->descripcion ?? 'Sin descripción disponible.' }}
                            </p>
                        </div>

                        {{-- Fila de Precio y Acciones --}}
                        <div class="flex items-center justify-between gap-2 pt-3 border-t border-slate-100">
                            {{-- Badge de Precio --}}
                            <div class="bg-emerald-50 text-emerald-800 border border-emerald-200 px-2.5 py-1 rounded-xl shadow-3xs flex items-center justify-center">
                                <span class="font-mono font-black text-base tracking-tight">
                                    ${{ number_format($producto->precio, 2) }}
                                </span>
                            </div>

                            {{-- Botones de Control --}}
                            <div class="flex items-center gap-1.5 shrink-0">
                                <a href="{{ route('productos.edit', $producto) }}"
                                   class="h-9 w-9 bg-amber-50 hover:bg-amber-100 text-amber-700 rounded-xl flex items-center justify-center border border-amber-200 transition-all shadow-3xs active:scale-95"
                                   title="Editar producto">
                                    <i class="fas fa-edit text-xs"></i>
                                </a>

                                {{-- Formulario de Destrucción Seguro --}}
                                <form action="{{ route('productos.destroy', $producto) }}"
                                      method="POST"
                                      class="m-0 inline form-eliminar-producto">
                                    @csrf
                                    @method('DELETE')
                                    <button type="button"
                                            onclick="confirmarEliminacion(this, '{{ $producto->nombre }}')"
                                            class="h-9 w-9 bg-rose-50 hover:bg-rose-100 text-rose-700 rounded-xl flex items-center justify-center border border-rose-200 transition-all shadow-3xs active:scale-95 cursor-pointer"
                                            title="Eliminar producto">
                                        <i class="fas fa-trash text-xs"></i>
                                    </button>
                                </form>
                            </div>
                        </div>

                    </div>
                </div>
                @endforeach
            </div>
        </div>

    </div>
    @endif
    @endforeach
</div>
@endsection

@section('scripts')
<script>
    function confirmarEliminacion(button, nombreProducto) {
        // Obtenemos el formulario padre del botón presionado
        const form = button.closest('.form-eliminar-producto');

        Swal.fire({
            title: '¿Eliminar producto?',
            text: `El platillo "${nombreProducto}" se quitará del menú operativo inmediatamente.`,
            icon: 'warning',
            showCancelButton: true,
            // Manteniendo paleta Slate/Dark del Layout base
            confirmButtonColor: '#dc2626', // Rojo destructivo
            cancelButtonColor: '#64748b',  // Slate neutro
            confirmButtonText: 'Sí, eliminar',
            cancelButtonText: 'Cancelar',
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
@endsection
