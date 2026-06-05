@php
$rol = Auth::user()->is_role;
@endphp

@extends('layouts.pos')
@section('title', 'Comandas')

@section('content')
{{-- Se cambió la selección global a naranja cálido --}}
<div class="w-full p-4 min-h-screen bg-slate-50 text-slate-800 selection:bg-orange-500 selection:text-white">

    {{-- HEADER DE LA VISTA --}}
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 mb-6">
        <div>
            <h1 class="text-2xl font-black text-slate-900 tracking-tight m-0 flex items-center gap-2">
                <i class="fas fa-clipboard-list text-slate-400 text-xl"></i> Monitor de Comandas
            </h1>
            <p class="text-xs font-medium text-slate-500 m-0 mt-0.5">Gestión operativa e indicadores de servicio en tiempo real</p>
        </div>

        {{-- Botón "Nueva Comanda" adaptado a la identidad naranja --}}
        @if($rol != 1)
        <a href="{{ route('comandas.create') }}" class="inline-flex items-center justify-center gap-2 px-5 py-3 bg-orange-500 hover:bg-orange-600 text-white text-xs font-black tracking-wider uppercase rounded-xl shadow-md shadow-orange-500/20 transition-all active:scale-95 no-underline hover:text-white">
            <i class="fas fa-plus text-[10px]"></i> Nueva Comanda
        </a>
        @endif
    </div>

    {{-- ALERTAS DE SISTEMA (Mantiene verde suave por estándar de usabilidad de éxito) --}}
    @if(session('success'))
    <div class="mb-6 p-4 rounded-xl bg-emerald-50 border border-emerald-200 text-emerald-900 text-sm font-bold flex items-center gap-2 shadow-sm">
        <i class="fas fa-check-circle text-emerald-600 text-base"></i> {{ session('success') }}
    </div>
    @endif


    {{-- GRID PRINCIPAL DE COMANDAS --}}
    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6" id="contenedor-comandas">
        @forelse ($comandas->whereIn('estado', ['pendiente', 'en_cocina', 'lista']) as $comanda)
        <div class="comanda-card-wrapper transition-all" data-estado="{{ $comanda->estado }}">
            {{-- Hover condicionado a la paleta naranja suave --}}
            <div class="h-full flex flex-col border border-slate-200 shadow-xs rounded-2xl overflow-hidden bg-white hover:shadow-md hover:border-orange-200 transition-all group">

                {{-- Card Header --}}
                <div class="p-4 border-b border-slate-100 bg-slate-50 flex justify-between items-start gap-2">
                    <div>
                        <span class="text-[10px] font-black uppercase tracking-widest text-slate-400 block leading-none">Ubicación</span>
                        <h3 class="text-xl font-black text-slate-900 m-0 mt-1 tracking-tight">{{ $comanda->mesa->nombre }}</h3>
                    </div>
                    <div class="text-right flex flex-col items-end">
                        {{-- Badges de Estado optimizados --}}
                        <span class="inline-block px-2.5 py-1 rounded-lg text-xs font-bold border {{ $comanda->estado === 'pendiente' ? 'bg-amber-50 text-amber-800 border-amber-200' : ($comanda->estado === 'en_cocina' ? 'bg-orange-50 text-orange-800 border-orange-200' : 'bg-emerald-50 text-emerald-800 border-emerald-200') }}">
                            @if($comanda->estado === 'pendiente') ⏳ Pendiente @endif
                            @if($comanda->estado === 'en_cocina') 👨‍🍳 En Cocina @endif
                            @if($comanda->estado === 'lista') 🔔 ¡Listo! @endif
                        </span>
                        <span class="text-[10px] font-bold text-slate-400 mt-1.5 font-mono">
                            <i class="far fa-clock mr-1"></i>{{ $comanda->created_at->format('H:i') }} hrs
                        </span>
                    </div>
                </div>

                {{-- Card Body --}}
                <div class="p-4 flex-1 flex flex-col">
                    <span class="text-[10px] font-black uppercase tracking-widest text-slate-400 block mb-2">Detalle del Pedido</span>

                    <div class="space-y-1.5 max-h-52 overflow-y-auto pr-1 flex-1 scroll-custom">
                        @php $total = 0; @endphp
                        @forelse ($comanda->productos as $producto)
                        @php
                        $subtotal = $producto->precio * $producto->pivot->cantidad;
                        $total += $subtotal;
                        @endphp
                        <div class="p-2.5 rounded-xl bg-slate-50/80 border border-slate-100 flex justify-between items-center gap-3">
                            <div class="min-w-0">
                                <span class="text-xs font-medium tracking-tight text-slate-700 block truncate">
                                    {{-- Cantidad destacada en tono de la app --}}
                                    <strong class="font-mono font-black text-orange-600 text-sm mr-1">{{ $producto->pivot->cantidad }}x</strong>
                                    {{ $producto->nombre }}
                                </span>
                                @if($producto->pivot->comentarios)
                                <span class="text-[10px] font-bold text-rose-700 bg-rose-50 border border-rose-100 rounded px-1.5 py-0.5 mt-1 inline-block">
                                    ⚠️ {{ $producto->pivot->comentarios }}
                                </span>
                                @endif
                            </div>
                            <div class="text-end shrink-0">
                                <span class="text-xs font-mono font-bold text-slate-600 block">${{ number_format($subtotal, 2) }}</span>
                            </div>
                        </div>
                        @empty
                        <div class="text-center py-4 text-slate-400 text-xs font-medium border border-dashed border-slate-200 rounded-xl">
                            No hay productos registrados
                        </div>
                        @endforelse
                    </div>

                    {{-- Totales --}}
                    <div class="mt-4 pt-3 border-t border-slate-100 flex justify-between items-center">
                        <span class="text-xs font-black text-slate-400 uppercase tracking-wider">Cuenta total</span>
                        <span class="text-xl font-black text-slate-900 font-mono tracking-tight">${{ number_format($total, 2) }}</span>
                    </div>
                </div>

                {{-- Card Footer --}}
                <div class="p-4 bg-slate-50 border-t border-slate-100 space-y-3">
                    <div class="flex flex-wrap sm:flex-nowrap gap-2">
                        {{-- Botón Extras --}}
                        <a href="{{ route('comandas.edit', $comanda) }}" class="flex-1 inline-flex items-center justify-center gap-1.5 px-3 py-2.5 bg-white border border-slate-200 hover:border-orange-200 hover:text-orange-600 text-slate-700 font-bold text-xs rounded-xl transition-all active:scale-95 no-underline shadow-xs">
                            <i class="fas fa-plus-circle text-slate-400 group-hover:text-orange-400"></i> Extras
                        </a>

                        {{-- Botón Cuenta (Removido el bg-slate-900 a favor de un estilo secundario limpio) --}}
                        @if(($rol == 0 && $comanda->estado === 'lista' && !$comanda->cuenta_generada) || ($rol == 2))
                        <form action="{{ route('comandas.generarCuenta', $comanda->id) }}" method="POST" class="flex-1 flex m-0">
                            @csrf
                            <button type="submit" class="w-full inline-flex items-center justify-center gap-1.5 px-3 py-2.5 bg-slate-200 hover:bg-slate-300 border-0 text-slate-800 font-black text-xs rounded-xl transition-all active:scale-95 shadow-xs cursor-pointer">
                                <i class="fas fa-receipt text-slate-500"></i> {{ $comanda->cuenta_generada ? 'Reimprimir' : 'Cuenta' }}
                            </button>
                        </form>
                        @endif

                        {{-- Botón Entregar (Usa la clase del sistema btn-primary que ya configuraste como naranja) --}}
                        @if(($rol == 0 && $comanda->estado === 'lista' && $comanda->cuenta_generada) || ($rol == 2))
                        <form method="POST" action="{{ route('comandas.cambiarEstado', $comanda->id) }}" class="flex-1 flex m-0">
                            @csrf
                            @method('PUT')
                            <button type="submit" name="estado" value="entregada" class="btn-primary w-full py-2.5 justify-center rounded-xl shadow-xs cursor-pointer">
                                <i class="fas fa-check"></i> Finalizar
                            </button>
                        </form>
                        @endif
                    </div>

                    {{-- Flujo de Estados Rápidos (Segmented Control Operativo) --}}
                    <div class="w-full pt-2.5 border-t border-slate-200/60">
                        <span class="text-[10px] font-black uppercase tracking-widest text-slate-400 block mb-1.5">Mover flujo a:</span>
                        <div class="flex p-0.5 bg-slate-200/60 rounded-xl gap-0.5 border border-slate-200">
                            @php
                            // Paletas adaptadas para el Switcher de estados internos de la tarjeta
                            $colores = [
                            'pendiente' => 'bg-white text-amber-600 font-black shadow-xs border border-slate-200/50',
                            'en_cocina' => 'bg-white text-orange-600 font-black shadow-xs border border-slate-200/50',
                            'lista' => 'bg-white text-emerald-600 font-black shadow-xs border border-slate-200/50',
                            'cancelada' => 'bg-white text-rose-600 font-black shadow-xs border border-slate-200/50',
                            ];

                            $botones_estado = ($rol == 2)
                            ? ['pendiente', 'en_cocina', 'lista', 'cancelada']
                            : ['pendiente', 'en_cocina', 'lista'];
                            @endphp

                            @foreach($botones_estado as $estado)
                            {{-- Se encapsula individualmente en su formulario para no romper el flujo nativo --}}
                            <form method="POST" action="{{ route('comandas.cambiarEstado', $comanda->id) }}" class="flex-1 flex m-0">
                                @csrf
                                @method('PUT')
                                <button type="submit" name="estado" value="{{ $estado }}"
                                    class="w-full py-2 px-1 text-[11px] font-bold tracking-tight rounded-lg border-0 transition-all cursor-pointer text-center whitespace-nowrap {{ $comanda->estado === $estado ? $colores[$estado] : 'bg-transparent text-slate-500 hover:bg-slate-300/40' }} ">
                                    {{ ucfirst(str_replace('_', ' ', $estado)) }}
                                </button>
                            </form>
                            @endforeach
                        </div>
                    </div>
                </div>

            </div>
        </div>
        @empty
        <div class="col-span-full text-center py-12">
            <div class="p-8 bg-white border border-dashed border-slate-300 rounded-2xl max-w-sm mx-auto shadow-xs">
                <i class="fas fa-receipt text-slate-300 text-4xl mb-2 block"></i>
                <h4 class="font-black text-slate-900 m-0">No hay comandas activas</h4>
                <p class="text-xs text-slate-400 mt-1">Todas las mesas están despejadas y listas para recibir clientes.</p>
            </div>
        </div>
        @endforelse
    </div>
</div>

@section('scripts')
<script>
    function filtrarComandas(filtro) {
        document.querySelectorAll('.tab-btn-pos').forEach(btn => btn.classList.remove('active'));
        document.getElementById(`tab-${filtro}`).classList.add('active');

        const tarjetas = document.querySelectorAll('.comanda-card-wrapper');
        tarjetas.forEach(tarjeta => {
            const estado = tarjeta.dataset.estado;
            if (filtro === 'todas') {
                tarjeta.style.display = 'block';
            } else if (filtro === 'en_cocina') {
                if (estado === 'pendiente' || estado === 'en_cocina') {
                    tarjeta.style.display = 'block';
                } else {
                    tarjeta.style.display = 'none';
                }
            } else {
                tarjeta.style.display = (estado === filtro) ? 'block' : 'none';
            }
        });
    }
</script>
@endsection
@endsection
