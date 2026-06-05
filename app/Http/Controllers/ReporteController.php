<?php

namespace App\Http\Controllers;

use App\Models\Comanda;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\VentasExport;

class ReporteController extends Controller
{
    // Fecha de inicio oficial de operaciones del POS
    protected $fechaMinimaOperacion = '2025-11-15';

    public function index(Request $request)
    {
        // Inicializar Filtros y Fechas predeterminadas (Hoy)
        $filtro = $request->get('filtro', 'hoy');
        $fechaInicioInput = $request->get('fecha_inicio');
        $fechaFinInput = $request->get('fecha_fin');

        $fechaInicio = now()->startOfDay();
        $fechaFin = now()->endOfDay();

        // Procesar rangos basados en la selección
        if ($filtro === 'personalizado' && $fechaInicioInput && $fechaFinInput) {
            $fechaInicio = Carbon::parse($fechaInicioInput)->startOfDay();
            $fechaFin = Carbon::parse($fechaFinInput)->endOfDay();

            // Validación 1: Fecha final menor a inicial
            if ($fechaInicio->gt($fechaFin)) {
                return redirect()->route('reportes.index')
                    ->with('error_reporte', 'La fecha final no puede ser menor que la fecha inicial.');
            }

            // Validación 2: Fechas anteriores al inicio de operación del negocio
            $limiteOperacional = Carbon::parse($this->fechaMinimaOperacion)->startOfDay();
            if ($fechaInicio->lt($limiteOperacional)) {
                return redirect()->route('reportes.index', [
                    'filtro' => 'personalizado',
                    'fecha_inicio' => $this->fechaMinimaOperacion,
                    'fecha_fin' => $fechaFinInput
                ])->with('warning_reporte', 'Los registros de ventas disponibles comienzan a partir del 15 de noviembre de 2025.');
            }
        } else {
            // Rangos fijos tradicionales optimizados para no perder registros por hora
            switch ($filtro) {
                Case 'semana':
                    $fechaInicio = now()->startOfWeek()->startOfDay();
                    $fechaFin = now()->endOfWeek()->endOfDay();
                    break;
                Case 'mes':
                    $fechaInicio = now()->startOfMonth()->startOfDay();
                    $fechaFin = now()->endOfMonth()->endOfDay();
                    break;
                Case 'año':
                    $fechaInicio = now()->startOfYear()->startOfDay();
                    $fechaFin = now()->endOfYear()->endOfDay();
                    break;
                Case 'hoy':
                default:
                    $filtro = 'hoy';
                    $fechaInicio = now()->startOfDay();
                    $fechaFin = now()->endOfDay();
                    break;
            }
        }

        // Consulta Única Centralizada y eficiente con Eager Loading optimizado
        $comandas = Comanda::with(['productos', 'mesa'])
            ->where('estado', 'entregada')
            ->whereBetween('created_at', [$fechaInicio, $fechaFin])
            ->orderBy('created_at', 'desc')
            ->get();

        // Validar si existen datos parciales o nulos dentro del rango solicitado
        $existenciaGlobal = Comanda::where('estado', 'entregada')->exists();
        $mensajeInformativo = null;

        if ($comandas->isEmpty()) {
            $mensajeInformativo = "No se encontraron ventas registradas para el rango seleccionado.";
        }

        // Cálculo exacto del total acumulado en base a datos reales
        $total = $this->calcularTotal($comandas);

        return view('reportes.index', [
            'comandas' => $comandas,
            'filtro' => $filtro,
            'fecha_inicio' => $fechaInicio->format('Y-m-d'),
            'fecha_fin' => $fechaFin->format('Y-m-d'),
            'total' => $total,
            'mensajeInformativo' => $mensajeInformativo,
            'filtrosDisponibles' => [
                'hoy' => '📅 Hoy',
                'semana' => '🗓️ Esta semana',
                'mes' => '🗂️ Este mes',
                'año' => '📈 Este año',
                'personalizado' => '⚙️ Rango Personalizado'
            ]
        ]);
    }

    public function exportar(Request $request)
    {
        $filtro = $request->get('filtro', 'hoy');
        $fechaInicio = $request->get('fecha_inicio');
        $fechaFin = $request->get('fecha_fin');

        // Descarga directa pasando los parámetros validados
        return Excel::download(
            new VentasExport($filtro, $fechaInicio, $fechaFin),
            'reporte_ventas_' . ($filtro === 'personalizado' ? $fechaInicio . '_al_' . $fechaFin : $filtro) . '.xlsx'
        );
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
