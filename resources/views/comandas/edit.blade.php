@extends('layouts.app')

@section('title', 'Agregar Productos Extra')

@section('content')
<div class="container">
    <h1 class="mb-4">Agregar Productos Extra - Mesa {{ $comanda->mesa->nombre }}</h1>

    <div class="alert alert-info">
        <i class="fas fa-info-circle"></i> Estás agregando productos adicionales a esta comanda.
        Los nuevos productos serán enviados directamente a cocina.
    </div>

    <form method="POST" action="{{ route('comandas.update', $comanda) }}">
        @csrf
        @method('PUT')

        <input type="hidden" name="mesa_id" value="{{ $comanda->mesa_id }}">

        <div class="form-group mb-4">
            <h4>Productos Actuales:</h4>
            <ul class="list-group">
                @foreach ($comanda->productos as $producto)
                <li class="list-group-item">
                    {{ $producto->nombre }} - Cantidad: {{ $producto->pivot->cantidad }}
                    @if($producto->pivot->comentarios)
                    <br><small>Comentario: {{ $producto->pivot->comentarios }}</small>
                    @endif
                </li>
                @endforeach
            </ul>
        </div>

        <div class="form-group mb-4">
            <h4>Seleccionar Productos Adicionales:</h4>
            <div class="row">
                @foreach ($productos as $producto)
                <div class="col-md-4 mb-3">
                    <div class="card h-100">
                        <div class="card-body">
                            <div class="form-check">
                                <input type="checkbox"
                                    class="form-check-input"
                                    name="productos[{{ $producto->id }}][selected]"
                                    id="prod-{{ $producto->id }}"
                                    value="1">
                                <label class="form-check-label" for="prod-{{ $producto->id }}">
                                    <strong>{{ $producto->nombre }}</strong> (${{ number_format($producto->precio, 2) }})
                                </label>
                            </div>
                            <div class="mt-2">
                                <label>Cantidad:</label>
                                <input type="number"
                                    name="productos[{{ $producto->id }}][cantidad]"
                                    class="form-control"
                                    value="1"
                                    min="1">
                            </div>
                            <div class="mt-2">
                                <label>Comentarios:</label>
                                <input type="text"
                                    name="productos[{{ $producto->id }}][comentarios]"
                                    class="form-control"
                                    placeholder="Ej. sin cebolla">
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>

        <div class="text-end mt-4">
            <a href="{{ route('comandas.index') }}" class="btn btn-secondary">
                <i class="fas fa-times"></i> Cancelar
            </a>
            <button type="submit" class="btn btn-primary">
                <i class="fas fa-paper-plane"></i> Enviar a Cocina
            </button>
        </div>
    </form>
</div>
@endsection
