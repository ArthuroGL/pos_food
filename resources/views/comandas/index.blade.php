@php
$rol = Auth::user()->is_role;
@endphp

@extends('layouts.app')
@section('title', 'Comandas')

@section('content')
<div>
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Comandas Activas</h2>
        @if($rol != 1) {{-- Solo Mesero y Admin pueden crear comandas --}}
        <a href="{{ route('comandas.create') }}" class="btn btn-primary">
            <i class="fas fa-plus"></i> Nueva Comanda
        </a>
        @endif
    </div>

    @foreach ($comandas->whereIn('estado', ['pendiente', 'en_cocina', 'lista']) as $comanda)
    <div class="card mb-3">
        <div class="card-header">
            <strong>{{ $comanda->mesa->nombre }}</strong> - {{ $comanda->created_at->format('d/m/Y H:i') }}
        </div>
        <div class="card-body">
            <ul>
                @php $total = 0; @endphp
                @forelse ($comanda->productos as $producto)
                @php
                $subtotal = $producto->precio * $producto->pivot->cantidad;
                $total += $subtotal;
                @endphp
                <li>
                    {{ $producto->nombre }} - ${{ number_format($producto->precio, 2) }}
                    <strong>x {{ $producto->pivot->cantidad }}</strong>
                    <br>
                    <small>Subtotal: ${{ number_format($subtotal, 2) }}</small>

                    @if($producto->pivot->comentarios)
                    <br><em>Comentario: {{ $producto->pivot->comentarios }}</em>
                    @endif
                </li>
                @empty
                <li>No hay productos</li>
                @endforelse
            </ul>

            <div class="mt-3">
                <strong>Total: ${{ number_format($total, 2) }}</strong>
            </div>


            <div class="text-end">
                <a href="{{ route('comandas.edit', $comanda) }}" class="btn btn-sm btn-warning">
                    <i class="fas fa-edit"></i>
                </a>
            </div>
            {{-- BOTONES DE ESTADO --}}
            <form method="POST" action="{{ route('comandas.cambiarEstado', $comanda->id) }}" class="d-inline">
                @csrf
                @method('PUT')
                <div class="btn-group mt-2">
                    @php
                    $colores = [
                    'pendiente' => 'bg-orange',
                    'en_cocina' => 'btn-warning text-dark',
                    'lista' => 'btn-success',
                    'entregada' => 'btn-secondary',
                    'cancelada' => 'btn-danger',
                    ];

                    $botones_estado = [];

                    if ($rol == 2) {
                    $botones_estado = ['pendiente', 'en_cocina', 'lista', 'entregada', 'cancelada'];
                    } elseif ($rol == 0) {
                    $botones_estado = ['pendiente', 'en_cocina', 'lista'];
                    }
                    @endphp

                    @foreach($botones_estado as $estado)
                    <button class="btn btn-sm {{ $comanda->estado === $estado ? $colores[$estado] : 'btn-outline-secondary' }}"
                        name="estado" value="{{ $estado }}">
                        {{ ucfirst(str_replace('_', ' ', $estado)) }}
                    </button>
                    @endforeach
                </div>
            </form>

            {{-- MESERO: GENERAR CUENTA solo cuando la comanda esté en lista --}}
            @if($rol == 0 && $comanda->estado === 'lista' && !$comanda->cuenta_generada)
            <form action="{{ route('comandas.generarCuenta', $comanda->id) }}" method="POST" class="d-inline">
                @csrf
                <button type="submit" class="btn btn-sm btn-info mt-2">
                    <i class="fas fa-receipt"></i> Generar Cuenta
                </button>
            </form>
            @endif

            {{-- MESERO: ENTREGADA solo si la cuenta ya fue generada --}}
            @if($rol == 0 && $comanda->estado === 'lista' && $comanda->cuenta_generada)
            <form method="POST" action="{{ route('comandas.cambiarEstado', $comanda->id) }}" class="d-inline">
                @csrf
                @method('PUT')
                <button type="submit" name="estado" value="entregada" class="btn btn-sm btn-secondary mt-2">
                    <i class="fas fa-check"></i> Marcar como Entregada
                </button>
            </form>
            @endif

            {{-- ADMIN puede siempre generar cuenta y entregar --}}
            @if($rol == 2)
            <form action="{{ route('comandas.generarCuenta', $comanda->id) }}" method="POST" class="d-inline">
                @csrf
                <button type="submit" class="btn btn-sm btn-info mt-2">
                    <i class="fas fa-receipt"></i> Generar Cuenta
                </button>
            </form>

            <form method="POST" action="{{ route('comandas.cambiarEstado', $comanda->id) }}" class="d-inline">
                @csrf
                @method('PUT')
                <button type="submit" name="estado" value="entregada" class="btn btn-sm btn-secondary mt-2">
                    <i class="fas fa-check"></i> Marcar como Entregada
                </button>
            </form>
            @endif

        </div>
    </div>
    @endforeach
</div>
@endsection
