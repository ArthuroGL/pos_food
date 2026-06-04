@extends('layouts.pos')

@section('title', 'Reporte de Ventas')
@section('view_title', '📊 Reportes Administrativos')
@section('view_subtitle', 'Auditoría de ingresos y flujo de caja operativo')

@section('content')
<div class="h-full w-full p-6 overflow-y-auto sheet-layout bg-slate-100 text-slate-800 scroll-custom flex flex-col">

    {{-- Contenedor de Centrado Maestro para Pantallas Panorámicas --}}
    <div class="w-full max-w-6xl mx-auto flex flex-col flex-1 gap-6">

        {{-- FILA SUPERIOR: Títulos e Indicador de Filtro Activo --}}
        <div class="flex flex-col lg:flex-row justify-between items-start lg:items-center gap-4">
            <div>
                <h2 class="text-xl font-black text-slate-900 tracking-tight m-0">
                    Resumen de ventas — Filtro: <span class="text-orange-600">{{ ucfirst($filtro) }}</span>
                </h2>
                <p class="text-xs font-medium text-slate-400 mt-1 m-0">Historial detallado de comandas liquidadas e ingresos generados</p>
            </div>

            {{-- Bloque de Filtros y Acciones Cohesivo --}}
            <form method="GET" action="#" class="w-full lg:w-auto flex flex-col sm:flex-row items-stretch sm:items-center gap-3 m-0">
                {{-- Selector de Rango de Tiempo --}}
                <div class="relative min-w-[160px]">
                    <select name="filtro" onchange="this.form.submit()"
                            class="w-full bg-white border border-slate-200 focus:border-orange-500 rounded-xl pl-4 pr-10 py-2.5 text-xs font-black text-slate-700 tracking-wide transition-all outline-hidden shadow-3xs appearance-none cursor-pointer uppercase">
                        <option value="hoy" {{ $filtro == 'hoy' ? 'selected' : '' }}>📅 Hoy</option>
                        <option value="semana" {{ $filtro == 'semana' ? 'selected' : '' }}>🗓️ Esta Semana</option>
                        <option value="mes" {{ $filtro == 'mes' ? 'selected' : '' }}>🗂️ Este Mes</option>
                        <option value="año" {{ $filtro == 'año' ? 'selected' : '' }}>📈 Este Año</option>
                    </select>
                    <div class="absolute inset-y-0 right-4 flex items-center pointer-events-none text-slate-400 text-[10px]">
                        <i class="fas fa-chevron-down"></i>
                    </div>
                </div>

                {{-- Botón de Exportación Premium --}}
                <a href="#"
                   class="bg-emerald-600 hover:bg-emerald-700 active:scale-[0.98] transition-all text-white font-black px-4 py-2.5 rounded-xl text-xs tracking-wide cursor-pointer flex items-center justify-center gap-2 shadow-sm shadow-emerald-600/10 border-0 uppercase">
                    <i class="fas fa-file-excel text-sm"></i> Exportar a Excel
                </a>
            </form>
        </div>

        {{-- SECCIÓN INTERMEDIA: Tarjeta de Métrica Clave (Venta Total) --}}
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="bg-white border border-slate-200 p-5 rounded-2xl shadow-2xs flex items-center justify-between">
                <div class="space-y-1">
                    <span class="text-xs font-black uppercase tracking-wider text-slate-400 block">Total Recaudado</span>
                    <span class="text-[11px] font-medium text-slate-400 block">Suma acumulada del periodo activo</span>
                </div>
                <div class="text-right">
                    <span class="font-mono font-black text-2xl md:text-3xl text-emerald-600 tracking-tight block">
                        ${{ number_format($total, 2) }}
                    </span>
                </div>
            </div>

            {{-- Espacios de KPI futuros opcionales para mantener balance visual --}}
            <div class="bg-white/40 border border-dashed border-slate-200 p-5 rounded-2xl flex items-center gap-3">
                <div class="h-8 w-8 rounded-lg bg-slate-200/60 flex items-center justify-center text-slate-400 text-xs">
                    <i class="fas fa-receipt"></i>
                </div>
                <span class="text-xs font-bold text-slate-400">Comandas cerradas: {{ $comandas->count() }}</span>
            </div>
            <div class="hidden md:flex bg-white/40 border border-dashed border-slate-200 p-5 rounded-2xl items-center gap-3">
                <div class="h-8 w-8 rounded-lg bg-slate-200/60 flex items-center justify-center text-slate-400 text-xs">
                    <i class="fas fa-calculator"></i>
                </div>
                <span class="text-xs font-bold text-slate-400">Promedio por mesa: ${{ $comandas->count() > 0 ? number_format($total / $comandas->count(), 2) : '0.00' }}</span>
            </div>
        </div>

        {{-- TABLA ADMINISTRATIVA DE VENTAS --}}
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
                        @forelse ($comandas as $comanda)
                            @php $suma = 0; @endphp
                            <tr class="hover:bg-slate-50/50 transition-colors">
                                {{-- Celda: Mesa --}}
                                <td class="p-4 align-top">
                                    <span class="inline-flex items-center gap-1.5 bg-slate-100 text-slate-800 px-2.5 py-1 rounded-lg text-xs font-black border border-slate-200">
                                        <i class="fas fa-chair text-[10px] text-slate-400"></i>
                                        {{ $comanda->mesa->nombre }}
                                    </span>
                                </td>

                                {{-- Celda: Fecha --}}
                                <td class="p-4 align-top">
                                    <div class="flex flex-col gap-0.5">
                                        <span class="text-xs font-bold text-slate-700">
                                            {{ $comanda->created_at->format('d/m/Y') }}
                                        </span>
                                        <span class="text-[10px] font-mono font-medium text-slate-400">
                                            <i class="far fa-clock text-[9px] mr-0.5"></i> {{ $comanda->created_at->format('H:i') }} hrs
                                        </span>
                                    </div>
                                </td>

                                {{-- Celda: Desglose de Productos --}}
                                <td class="p-4 align-top">
                                    <div class="space-y-1.5">
                                        @foreach ($comanda->productos as $producto)
                                            @php
                                                $subtotal = $producto->precio * $producto->pivot->cantidad;
                                                $suma += $subtotal;
                                            @endphp
                                            <div class="flex items-center justify-between text-xs font-medium border-b border-dashed border-slate-100 pb-1 last:border-0 last:pb-0">
                                                <div class="text-slate-700 truncate max-w-xs" title="{{ $producto->nombre }}">
                                                    <span class="font-mono font-black text-orange-600 bg-orange-50 px-1.5 py-0.5 rounded-md mr-1.5 text-[11px]">
                                                        {{ $producto->pivot->cantidad }}x
                                                    </span>
                                                    {{ $producto->nombre }}
                                                </div>
                                                <span class="font-mono text-slate-400 text-[11px]">
                                                    ${{ number_format($subtotal, 2) }}
                                                </span>
                                            </div>
                                        @endforeach
                                    </div>
                                </td>

                                {{-- Celda: Total Comanda --}}
                                <td class="p-4 align-top text-right">
                                    <span class="font-mono font-black text-sm text-slate-900 tracking-tight">
                                        ${{ number_format($suma, 2) }}
                                    </span>
                                </td>
                            </tr>
                        @empty
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
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

    </div>
</div>
@endsection
