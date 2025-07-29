@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <h2 class="mb-4">Lista de productos</h2>

    <a href="{{ route('productos.create') }}" class="btn btn-primary mb-3">
        <i class="fas fa-plus"></i> Agregar producto
    </a>

    @foreach ($categorias as $categoria)
    @if ($categoria->productos->isNotEmpty())
    <div class="card card-primary card-outline mb-4">
        <div class="card-header">
            <h5 class="card-title mb-0">{{ ucfirst($categoria->nombre) }}</h5>
        </div>
        <div class="card-body">
            <div class="row">
                @foreach ($categoria->productos->sortBy('nombre') as $producto)
                <div class="col-12 col-sm-6 col-md-4 col-lg-3 mb-4">
                    <div class="card producto-card h-100 border-0">
                        @if ($producto->imagen)
                        <img src="{{ asset('storage/' . $producto->imagen) }}"
                            alt="{{ $producto->nombre }}"
                            class="producto-img">
                        @else
                        <img src="https://via.placeholder.com/300x180?text=Sin+imagen"
                            alt="Sin imagen"
                            class="producto-img">
                        @endif

                        <div class="card-body p-3 d-flex flex-column">

                            <div>
                                <strong>{{ $producto->nombre }}</strong><br>
                                <small>{{ $producto->descripcion }}</small>
                            </div>
                            <div class="d-flex justify-content-between align-items-center mt-2">
                                <span class="text-success fw-bold">${{ number_format($producto->precio, 2) }}</span>
                                <div>
                                    <a href="{{ route('productos.edit', $producto) }}" class="btn btn-sm btn-warning">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('productos.destroy', $producto) }}" method="POST"
                                        class="d-inline" onsubmit="return confirm('¿Estás seguro?')">
                                        @csrf @method('DELETE')
                                        <button class="btn btn-sm btn-danger"><i class="fas fa-trash"></i></button>
                                    </form>
                                </div>
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


<style>
    .transition-hover {
        transition: all 0.3s ease-in-out;
    }

    .transition-hover:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.12);
    }

    .card-title,
    .card-text {
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .producto-img {
        width: 40%;
        height: 40%;
        object-fit: nherit;
        object-position: center;
        border-radius: .25rem;
        display: block;
        max-height: 150px;
    }

    .producto-card {
        transition: all 0.3s ease-in-out;
    }

    .producto-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 10px 20px rgba(0, 0, 0, 0.12);
    }
</style>
