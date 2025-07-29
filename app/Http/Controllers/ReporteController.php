<?php

namespace App\Http\Controllers;

use App\Models\Comanda;
use Illuminate\Http\Request;

class ReporteController extends Controller
{
    public function index(Request $request)
    {
        $filtro = $request->get('filtro', 'hoy');

        $query = Comanda::with('productos', 'mesa')
            ->where('estado', 'entregada');

        // Aplicar filtros
        $this->aplicarFiltros($query, $filtro);

        $comandas = $query->get();
        $total = $this->calcularTotal($comandas);

        return view('reportes.index', [
            'comandas' => $comandas,
            'filtro' => $filtro,
            'total' => $total,
            'filtrosDisponibles' => [
                'hoy' => 'Hoy',
                'semana' => 'Esta semana',
                'mes' => 'Este mes',
                'año' => 'Este año'
            ]
        ]);
    }

/*     public function exportar(Request $request)
    {
        $filtro = $request->get('filtro', 'hoy');
        return Excel::download(new VentasExport($filtro), 'ventas_' . $filtro . '.xlsx');
    } */

    protected function aplicarFiltros($query, $filtro)
    {
        $query->when($filtro === 'hoy', fn($q) => $q->whereDate('created_at', today()))
            ->when($filtro === 'semana', fn($q) => $q->whereBetween('created_at', [
                now()->startOfWeek(),
                now()->endOfWeek()
            ]))
            ->when($filtro === 'mes', fn($q) => $q->whereMonth('created_at', now()->month))
            ->when($filtro === 'año', fn($q) => $q->whereYear('created_at', now()->year));
    }

    protected function calcularTotal($comandas)
    {
        return $comandas->sum(function($comanda) {
            return $comanda->productos->sum(function($producto) {
                return $producto->pivot->cantidad * $producto->precio;
            });
        });
    }
}
