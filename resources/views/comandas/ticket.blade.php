<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Ticket</title>
    <style>
        body { font-family: Arial, sans-serif; font-size: 14px; }
        .header, .footer { text-align: center; }
        .line { border-top: 1px dashed #000; margin: 10px 0; }
    </style>
</head>
<body>
    <div class="header">
        <h3>Sistema de Comandas</h3>
        <p><strong>Mesa:</strong> {{ $comanda->mesa->nombre }}</p>
        <p><strong>Fecha:</strong> {{ $comanda->created_at->format('d/m/Y H:i') }}</p>
    </div>

    <div class="line"></div>

    <h4>Productos</h4>
    <ul>
        @foreach ($comanda->productos as $producto)
            <li>
                {{ $producto->nombre }} x {{ $producto->pivot->cantidad }}
                - ${{ number_format($producto->precio, 2) }}
                <br>
                <small>Subtotal: ${{ number_format($producto->precio * $producto->pivot->cantidad, 2) }}</small>
                @if($producto->pivot->comentarios)
                    <br><em>Comentario: {{ $producto->pivot->comentarios }}</em>
                @endif
                <hr>
            </li>
        @endforeach
    </ul>

    <h4>Total: ${{ number_format($total, 2) }}</h4>

    <div class="footer">
        <p>¡Gracias por su visita!</p>
    </div>
</body>
</html>
