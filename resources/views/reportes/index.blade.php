@extends('layouts.app')

@section('title', 'Reporte de Ventas')

@section('content')
<div class="container">
    <h2>Reporte de Ventas - Filtro: {{ ucfirst($filtro) }}</h2>

    <form method="GET" action="#" class="mb-3">
        <select name="filtro" onchange="this.form.submit()" class="form-select w-auto d-inline">
            <option value="hoy" {{ $filtro == 'hoy' ? 'selected' : '' }}>Hoy</option>
            <option value="semana" {{ $filtro == 'semana' ? 'selected' : '' }}>Esta Semana</option>
            <option value="mes" {{ $filtro == 'mes' ? 'selected' : '' }}>Este Mes</option>
            <option value="año" {{ $filtro == 'año' ? 'selected' : '' }}>Este Año</option>
        </select>

        <a href="#" class="btn btn-success ms-3">
            Exportar a Excel
        </a>
    </form>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Mesa</th>
                <th>Fecha</th>
                <th>Productos</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($comandas as $comanda)
            @php $suma = 0; @endphp
            <tr>
                <td>{{ $comanda->mesa->nombre }}</td>
                <td>{{ $comanda->created_at->format('d/m/Y H:i') }}</td>
                <td>
                    <ul>
                        @foreach ($comanda->productos as $producto)
                        @php
                        $subtotal = $producto->precio * $producto->pivot->cantidad;
                        $suma += $subtotal;
                        @endphp
                        <li>{{ $producto->nombre }} x{{ $producto->pivot->cantidad }} - ${{ number_format($subtotal, 2) }}</li>
                        @endforeach
                    </ul>
                </td>
                <td>${{ number_format($suma, 2) }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <h4 class="mt-4">Total general: ${{ number_format($total, 2) }}</h4>
</div>
@endsection
