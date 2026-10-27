<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreVentaRequest;
use App\Models\Cliente;
use App\Models\Comprobante;
use App\Models\Producto;
use App\Models\Venta;
use App\Models\Caja;
use Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class ventaController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        $ventas = Venta::with(['comprobante', 'cliente.persona', 'user'])
            ->where('estado', 1)
            ->latest()
            ->get();

        //return $ventas;
        return view('venta.index', compact('ventas'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        //traer la tabla compra prodcutos
        $subquery = DB::table('compra_producto')
            ->select('producto_id', DB::raw('MAX(created_at) as max_created_at'))
            ->groupBy('producto_id');

        $productos = Producto::join('compra_producto as cpr', function ($join) use ($subquery) {
            $join->on('cpr.producto_id', '=', 'productos.id')
                ->whereIn('cpr.created_at', function ($query) use ($subquery) {
                    $query->select('max_created_at')
                        ->fromSub($subquery, 'subquery')
                        ->whereRaw('subquery.producto_id = cpr.producto_id');
                });
        })
            ->select('productos.nombre', 'productos.id', 'productos.stock', 'cpr.precio_venta')
            ->where('productos.estado', 1)
            ->where('productos.stock', '>', 0)
            ->get();

        //return $productos;
        $clientes = Cliente::whereHas('persona', function ($query) {
            $query->where('estado', 1);
        })->get();
        $comprobantes = Comprobante::all();



        return view('venta.create', compact('productos', 'clientes', 'comprobantes'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreVentaRequest $request): RedirectResponse
    {
        try {
            DB::transaction(function () use ($request) {

            $caja = Caja::where('nombre', 'CAJ01SUC01')->firstOrFail();

            $venta = Venta::create($request->validated());
            $venta->total *= 1000;
            $venta->impuesto *= 1000;
            $venta->caja_id = $caja->id;
            $venta->save();

            $arrayProducto_id = $request->get('arrayidproducto', []);
            $arrayCantidad    = $request->get('arraycantidad', []);
            $arrayPrecioVenta = $request->get('arrayprecioventa', []);
            $arrayDescuento   = $request->get('arraydescuento', []);

            $sizeArray = count($arrayProducto_id);

            for ($i = 0; $i < $sizeArray; $i++) {

                $venta->productos()->syncWithoutDetaching([
                    $arrayProducto_id[$i] => [
                        'cantidad'     => $arrayCantidad[$i],
                        'precio_venta' => $arrayPrecioVenta[$i],
                        'descuento'    => $arrayDescuento[$i],
                    ]
                ]);

                    $producto = Producto::findOrFail($arrayProducto_id[$i]);

                    $cantidad = (int) $arrayCantidad[$i];
                    if ($producto->stock < $cantidad) {
                        throw new \Exception("Stock insuficiente para producto ID {$producto->id}");
                    }

                    $producto->decrement('stock', $cantidad);
                }
            });

            return redirect()->route('ventas.index')->with('success', 'Venta exitosa');

        } catch (\Throwable $e) {
            report($e);

            return back()
                ->withInput()
                ->with('error', $e->getMessage() ?: 'Ocurrió un error al procesar la venta');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Venta $venta): View
    {
        return view('venta.show', compact('venta'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Venta::where('id', $id)
            ->update([
                'estado' => 0
            ]);

        return redirect()->route('ventas.index')->with('success', 'Venta eliminada ');
    }

    public function showByDateRange(Request $request){

        $fecIni = $request->input('fecIni');
        $fecFin = $request->input('fecFin');

        $query = Venta::with(['comprobante', 'cliente.persona', 'user'])
                    ->where('estado', 1)
                    ->when($fecIni, fn($q) => $q->whereDate('fecha_hora', '>=', $fecIni))
                    ->when($fecFin, fn($q) => $q->whereDate('fecha_hora', '<=', $fecFin))
                    ->latest();
        $ventas = $query->get();
        return view('venta.index', compact('ventas'));
    }
}
