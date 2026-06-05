<?php

namespace App\Exports;

use App\Models\Comanda;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

use PhpOffice\PhpSpreadsheet\Style\NumberFormat;

class VentasExport implements FromCollection, WithHeadings, WithMapping, WithStyles, ShouldAutoSize, WithColumnFormatting
{
    protected $filtro;
    protected $fechaInicio;
    protected $fechaFin;
    protected $rowNum = 4;

    // CORRECCIÓN: Debe ser __construct, no __class
    public function __construct($filtro, $fechaInicio, $fechaFin)
    {
        $this->filtro = $filtro;

        if ($this->filtro === 'personalizado') {
            $this->fechaInicio = Carbon::parse($fechaInicio)->startOfDay();
            $this->fechaFin = Carbon::parse($fechaFin)->endOfDay();
        } else {
            switch ($this->filtro) {
                case 'semana':
                    $this->fechaInicio = now()->startOfWeek()->startOfDay();
                    $this->fechaFin = now()->endOfWeek()->endOfDay();
                    break;
                case 'mes':
                    $this->fechaInicio = now()->startOfMonth()->startOfDay();
                    $this->fechaFin = now()->endOfMonth()->endOfDay();
                    break;
                case 'año':
                    $this->fechaInicio = now()->startOfYear()->startOfDay();
                    $this->fechaFin = now()->endOfYear()->endOfDay();
                    break;
                case 'hoy':
                default:
                    $this->fechaInicio = now()->startOfDay();
                    $this->fechaFin = now()->endOfDay();
                    break;
            }
        }
    }

    public function collection()
    {
        // Replicación matemática exacta de la Query del Controlador
        return Comanda::with(['productos', 'mesa'])
            ->where('estado', 'entregada')
            ->whereBetween('created_at', [$this->fechaInicio, $this->fechaFin])
            ->orderBy('created_at', 'desc')
            ->get();
    }

    public function headings(): array
    {
        return [
            ['REPORTE DE VENTAS - SISTEMA POS'],
            ['Periodo consultado: ' . $this->fechaInicio->format('d/m/Y') . ' al ' . $this->fechaFin->format('d/m/Y')],
            [], // Renglón vacío de separación
            ['Mesa', 'Fecha y Hora', 'Productos Consumidos', 'Total de Comanda']
        ];
    }

    public function map($comanda): array
    {
        $this->rowNum++;

        // Desglose de productos idéntico a la visualización web
        $productosArray = [];
        $totalComanda = 0;
        foreach ($comanda->productos as $producto) {
            $sub = $producto->precio * $producto->pivot->cantidad;
            $totalComanda += $sub;
            $productosArray[] = $producto->pivot->cantidad . 'x ' . $producto->nombre . ' ($' . number_format($sub, 2) . ')';
        }

        return [
            $comanda->mesa->nombre ?? 'N/A',
            $comanda->created_at->format('d/m/Y H:i') . ' hrs',
            implode(', ', $productosArray),
            $totalComanda
        ];
    }

    public function columnFormats(): array
    {
        return [
            'D' => '"$"#,##0.00'
        ];
    }

    public function styles(Worksheet $sheet)
    {
        // Combinación del título de cabecera
        $sheet->mergeCells('A1:D1');
        $sheet->mergeCells('A2:D2');

        $estilos = [
            // Fila de Título del Sistema
            1 => [
                'font' => ['bold' => true, 'size' => 14, 'color' => ['argb' => 'FFFFFF']],
                'fill' => ['fillType' => 'solid', 'color' => ['argb' => 'F97316']] // Naranja primario de app.css
            ],
            // Fila del Rango de Fechas
            2 => [
                'font' => ['italic' => true, 'size' => 11, 'color' => ['argb' => '64748B']],
            ],
            // Encabezados de la tabla limpia
            4 => [
                'font' => ['bold' => true, 'color' => ['argb' => '0F172A']],
                'fill' => ['fillType' => 'solid', 'color' => ['argb' => 'F1F5F9']] // Gris suave (.bg-slate-50)
            ],
        ];

        // Añadir renglón final de totales contables dinámicos
        $filaTotales = $this->rowNum + 1;
        $sheet->setCellValue('C' . $filaTotales, 'TOTAL GENERAL RECAUDADO:');
        $sheet->setCellValue('D' . $filaTotales, '=SUM(D5:D' . $this->rowNum . ')');

        // Estilos para la fila contable de cierre
        $sheet->getStyle('A' . $filaTotales . ':D' . $filaTotales)->applyFromArray([
            'font' => ['bold' => true, 'color' => ['argb' => '10B981']], // Color esmeralda de éxito
            'fill' => ['fillType' => 'solid', 'color' => ['argb' => 'FFF7ED']] // Fondo naranja pastel suave
        ]);

        return $estilos;
    }
}
