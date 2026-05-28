<?php

namespace App\Http\Controllers;

use App\Models\Comanda;
use App\Models\Mesa;
use App\Models\Producto;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class ComandaController extends Controller
{
    public function index()
    {
        $comandas = Comanda::with('mesa', 'productos')->latest()->get();
        return view('comandas.index', compact('comandas'));
    }
    public function create(Request $request)
    {
        $search = $request->search;

        $productos = Producto::when($search, function ($query) use ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('nombre', 'ilike', "%{$search}%")
                    ->orWhere('descripcion', 'ilike', "%{$search}%");
            });
        })
            ->orderBy('nombre')
            ->paginate(6)
            ->withQueryString();

        // Obtener mesas con información de ocupación
        $mesas = Mesa::with(['comandas' => function ($query) {
            $query->whereIn('estado', ['pendiente', 'en_cocina', 'preparada', 'lista']);
        }])->get();

        return view('comandas.create', compact('productos', 'mesas'));
    }
    public function sugerencias(Request $request)
    {
        $search = $request->input('search');

        if (empty($search)) {
            return response()->json([]);
        }

        // Buscamos coincidencias parciales e insensibles a mayúsculas/minúsculas (ilike)
        $sugerencias = Producto::where('nombre', 'ilike', "%{$search}%")
            ->orWhere('descripcion', 'ilike', "%{$search}%")
            ->orderBy('nombre')
            ->take(5) // Tomamos un top de hasta 5 para mantener el dropdown compacto y rápido
            ->select('id', 'nombre')
            ->get();

        return response()->json($sugerencias);
    }
    public function store(Request $request)
    {
        $request->validate([
            'mesa_id' => [
                'required',
                'exists:mesas,id',
                function ($attribute, $value, $fail) {
                    $mesaOcupada = Mesa::where('id', $value)
                        ->whereHas('comandas', function ($query) {
                            $query->whereIn('estado', ['pendiente', 'en_cocina', 'preparada', 'lista']);
                        })->exists();

                    if ($mesaOcupada) {
                        $fail('La mesa seleccionada ya está ocupada.');
                    }
                }
            ],
            'productos' => 'required|array',
        ]);

        $comanda = Comanda::create([
            'mesa_id' => $request->mesa_id,
            'estado' => 'pendiente',
        ]);

        foreach ($request->productos as $productoId => $data) {
            if (isset($data['selected'])) {
                $comanda->productos()->attach($productoId, [
                    'cantidad' => $data['cantidad'] ?? 1,
                    'comentarios' => $data['comentarios'] ?? '',
                    'estado' => 'pendiente',
                ]);
            }
        }

        return redirect()->route('comandas.index')->with('success', 'Comanda enviada correctamente.');
    }
    public function entregar(Comanda $comanda)
    {
        //$comanda->update(['status' => true]); // Entregada
        $comanda->update(['estado' => 'entregada']);


        return redirect()->route('comandas.index')->with('success', 'Comanda marcada como entregada');
    }
    public function edit(Comanda $comanda)
    {
        return view('comandas.edit', [
            'comanda' => $comanda->load('productos'),
            'productos' => Producto::all(),
            'mesas' => Mesa::all()
        ]);
    }
    public function update(Request $request, Comanda $comanda)
    {
        $request->validate([
            'productos' => 'required|array',
            'productos.*.cantidad' => 'required|integer|min:1',
            'productos.*.comentarios' => 'nullable|string',
        ]);

        $nuevosProductos = [];

        foreach ($request->productos as $id => $producto) {
            if (isset($producto['selected']) && $producto['selected'] == 1) {
                $nuevosProductos[$id] = [
                    'cantidad' => $producto['cantidad'],
                    'comentarios' => $producto['comentarios'] ?? null
                ];
            }
        }

        // Adjuntar nuevos productos sin afectar los existentes
        $comanda->productos()->attach($nuevosProductos);

        // Cambiar estado a "en_cocina" para procesar los nuevos productos
        $comanda->update(['estado' => 'en_cocina']);

        return redirect()->route('comandas.index')
            ->with('success', 'Productos adicionales agregados y enviados a cocina');
    }
    public function destroy(Comanda $comanda)
    {
        $comanda->delete();
        return redirect()->route('comandas.index')->with('success', 'Comanda eliminada');
    }
    public function cambiarEstado(Request $request, Comanda $comanda)
    {
        $estado = $request->input('estado');

        if (!in_array($estado, Comanda::ESTADOS)) {
            return redirect()->back()->with('error', 'Estado inválido');
        }

        $comanda->estado = $estado;
        $comanda->save();

        return redirect()->back()->with('success', 'Estado actualizado correctamente');
    }
    public function vistaCocina()
    {
        $comandas = Comanda::where('estado', 'en_cocina')->get();
        return view('cocina.index', compact('comandas'));
    }
    public function marcarProductoPreparado(Request $request, Comanda $comanda, $productoId)
    {
        $estado = $request->estado ?? 'preparado';

        $comanda->productos()->updateExistingPivot($productoId, [
            'estado' => $estado
        ]);

        return response()->json(['success' => true]);
    }
    public function generarCuenta(Comanda $comanda)
    {
        $comanda->load('productos', 'mesa');
        $comanda->cuenta_generada = true;
        $comanda->save();

        $total = 0;
        foreach ($comanda->productos as $producto) {
            $total += $producto->precio * $producto->pivot->cantidad;
        }

        $pdf = Pdf::loadView('comandas.ticket', compact('comanda', 'total'));
        return $pdf->download('ticket-mesa-' . $comanda->mesa->nombre . '.pdf');
    }
}
