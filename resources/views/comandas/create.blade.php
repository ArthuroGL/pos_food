<style>
    .card .form-check-input {
        transform: scale(1.2);
    }

    .card .form-control-sm {
        font-size: 0.85rem;
    }

    .img-thumbnail {
        border-radius: 0.5rem;
    }
</style>

@extends('layouts.app')
@section('title', 'Crear Comanda')
@section('content')
<div class="container-fluid">
    <h1 class="h3 mb-4"><i class="fas fa-concierge-bell"></i> Tomar Comanda</h1>
    @if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    <form method="GET" action="{{ route('comandas.create') }}" class="mb-4">
        <div class="input-group input-group-sm" style="max-width: 300px;">
            <input type="text" name="search" class="form-control" placeholder="Buscar producto..."
                value="{{ request('search') }}">
            <div class="input-group-append">
                <button type="submit" class="btn btn-outline-secondary">
                    <i class="fas fa-search"></i>
                </button>
            </div>
        </div>
    </form>
    <div id="productosSeleccionadosResumen" class="mb-4">
        <h5>Productos Seleccionados</h5>
        <ul id="listaSeleccionados" class="list-group">
        </ul>
    </div>
    <form method="POST" action="{{ route('comandas.store') }}">
        @csrf
        <div class="form-group mb-4">
            <label for="mesa_id"><strong>Selecciona Mesa:</strong></label>
            <select name="mesa_id" class="form-control" required>
                <option value="">-- Seleccione una mesa --</option>
                @foreach ($mesas as $mesa)
                @php
                $ocupada = $mesa->comandas->isNotEmpty();
                @endphp
                <option value="{{ $mesa->id }}"
                    @if($ocupada)
                    disabled
                    class="text-danger"
                    @endif
                    @if(old('mesa_id')==$mesa->id) selected @endif>
                    {{ $mesa->nombre }}
                    @if($ocupada) (OCUPADA) @endif
                </option>
                @endforeach
            </select>
        </div>
        <h5 class="mb-3">Selecciona Productos</h5>
        <div class="row">
            @if ($productos->count() > 0)
            @foreach ($productos as $producto)
            <div class="col-12 col-md-6 col-lg-4 mb-4">
                <div class="card h-100 border shadow-sm">
                    <div class="card-body d-flex flex-column justify-content-between">
                        <div class="d-flex align-items-start">
                            <input type="checkbox" name="productos[{{ $producto->id }}][selected]"
                                value="1"
                                class="form-check-input me-2 mt-1"
                                id="check_{{ $producto->id }}">

                            <div class="flex-grow-1">
                                <label for="check_{{ $producto->id }}" class="form-label">
                                    <strong>{{ $producto->nombre }}</strong><br>
                                    <small class="text-muted">{{ $producto->descripcion }}</small>
                                </label>
                                <p class="text-success mt-1 fw-bold">${{ number_format($producto->precio, 2) }}</p>
                            </div>

                            <div class="ms-2" style="width: 60px; height: 60px;">
                                @if ($producto->imagen)
                                <img src="{{ asset('storage/' . $producto->imagen) }}" alt="{{ $producto->nombre }}"
                                    class="img-thumbnail img-fluid" style="object-fit: cover; width: 100%; height: 100%;">
                                @else
                                <img src="https://via.placeholder.com/60x60?text=No+img" class="img-thumbnail img-fluid" alt="Sin imagen">
                                @endif
                            </div>
                        </div>

                        <div class="mt-3">
                            <div class="row">
                                <div class="col-4">
                                    <label class="form-label">Cant.</label>
                                    <input type="number" name="productos[{{ $producto->id }}][cantidad]"
                                        value="1" min="1" class="form-control form-control-sm">
                                </div>
                                <div class="col-8">
                                    <label class="form-label">Comentarios</label>
                                    <input type="text" name="productos[{{ $producto->id }}][comentarios]"
                                        class="form-control form-control-sm"
                                        placeholder="Ej. sin cebolla, bien cocido">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
            @else
            <p class="text-muted">No se encontraron productos para esta búsqueda.</p>
            @endif
        </div>
        <div class="card-footer clearfix">
            {{ $productos->links('pagination::bootstrap-4') }}
        </div>
        <div id="hiddenInputsContainer"></div>
        <button type="submit" class="btn btn-primary btn-lg mt-3">
            <i class="fas fa-paper-plane"></i> Enviar comanda
        </button>
    </form>
</div>
<script>
    // Cargar del localStorage (persistencia entre búsquedas/paginación)
    let productosSeleccionados = JSON.parse(localStorage.getItem('productosSeleccionados') || '{}');

    function renderSeleccionados() {
        const lista = document.getElementById('listaSeleccionados');
        lista.innerHTML = '';

        Object.entries(productosSeleccionados).forEach(([id, p]) => {
            const li = document.createElement('li');
            li.className = 'list-group-item d-flex justify-content-between align-items-center';
            li.innerHTML = `
                <span><strong>${p.nombre}</strong> x${p.cantidad} <br><small>${p.comentarios || ''}</small></span>
                <button type="button" class="btn btn-sm btn-danger" onclick="quitarProducto('${id}')">
                    <i class="fas fa-times"></i>
                </button>
            `;
            lista.appendChild(li);
        });
    }

    function quitarProducto(id) {
        delete productosSeleccionados[id];
        localStorage.setItem('productosSeleccionados', JSON.stringify(productosSeleccionados));
        renderSeleccionados();
        const check = document.getElementById('check_' + id);
        if (check) check.checked = false;
    }
    // Escuchar checkboxes
    document.querySelectorAll('[id^="check_"]').forEach(check => {
        check.addEventListener('change', () => {
            const id = check.id.replace('check_', '');
            const card = check.closest('.card-body');
            const nombre = card.querySelector('label strong').innerText.trim();
            const cantidad = card.querySelector(`input[name="productos[${id}][cantidad]"]`).value;
            const comentarios = card.querySelector(`input[name="productos[${id}][comentarios]"]`).value;

            if (check.checked) {
                productosSeleccionados[id] = {
                    nombre,
                    cantidad,
                    comentarios
                };
            } else {
                delete productosSeleccionados[id];
            }

            localStorage.setItem('productosSeleccionados', JSON.stringify(productosSeleccionados));
            renderSeleccionados();
        });
    });
    // Escuchar cambios en cantidad y comentarios
    document.querySelectorAll('input[name*="[cantidad]"], input[name*="[comentarios]"]').forEach(input => {
        input.addEventListener('input', () => {
            const id = input.name.match(/\[(\d+)\]/)[1];
            if (productosSeleccionados[id]) {
                const cantidad = document.querySelector(`input[name="productos[${id}][cantidad]"]`).value;
                const comentarios = document.querySelector(`input[name="productos[${id}][comentarios]"]`).value;
                productosSeleccionados[id].cantidad = cantidad;
                productosSeleccionados[id].comentarios = comentarios;
                localStorage.setItem('productosSeleccionados', JSON.stringify(productosSeleccionados));
                renderSeleccionados();
            }
        });
    });

    // Al cargar la página
    window.addEventListener('DOMContentLoaded', () => {
        renderSeleccionados();

        // Rellenar los campos visibles con los datos del localStorage
        Object.entries(productosSeleccionados).forEach(([id, data]) => {
            const check = document.getElementById('check_' + id);
            if (check) check.checked = true;

            const cantidad = document.querySelector(`input[name="productos[${id}][cantidad]"]`);
            if (cantidad) cantidad.value = data.cantidad;

            const comentarios = document.querySelector(`input[name="productos[${id}][comentarios]"]`);
            if (comentarios) comentarios.value = data.comentarios;
        });
    });

    // Limpiar al enviar CHECAR SI ESTA BIEN USAR LA DOBLECOMILLA
    document.querySelector('form[action="{{ route("comandas.store") }}"]').addEventListener('submit', () => {
        const container = document.getElementById('hiddenInputsContainer');
        container.innerHTML = ''; // Limpia antes de regenerar

        // Recorremos productosSeleccionados del localStorage
        Object.entries(productosSeleccionados).forEach(([id, data]) => {
            // Checkbox marcado
            const inputCheck = document.createElement('input');
            inputCheck.type = 'hidden';
            inputCheck.name = `productos[${id}][selected]`;
            inputCheck.value = 1;
            container.appendChild(inputCheck);

            // Cantidad
            const inputCantidad = document.createElement('input');
            inputCantidad.type = 'hidden';
            inputCantidad.name = `productos[${id}][cantidad]`;
            inputCantidad.value = data.cantidad || 1;
            container.appendChild(inputCantidad);

            // Comentarios
            const inputComentarios = document.createElement('input');
            inputComentarios.type = 'hidden';
            inputComentarios.name = `productos[${id}][comentarios]`;
            inputComentarios.value = data.comentarios || '';
            container.appendChild(inputComentarios);
        });

        // Eliminar después de enviar
        localStorage.removeItem('productosSeleccionados');
    });
</script>
@endsection
