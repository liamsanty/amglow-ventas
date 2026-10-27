<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCompraRequest;
use App\Models\compra;
use App\Models\Comprobante;
use App\Models\Producto;
use App\Models\Proveedore;
use Exception;
use GuzzleHttp\Psr7\Query;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Spatie\FlareClient\Http\Exceptions\InvalidData;

class compraController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        $compras = Compra::with('comprobante','proveedore.persona')
        ->where('estado',1)
        ->latest()
        ->get();

        //dd($compras);
        return view('compra.index', compact('compras'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        $proveedores = Proveedore::whereHas('persona',function($query){
            $query->where('estado',1);
        })->get();
        $comprobantes = Comprobante::all();
        $productos = Producto::where('estado',1)->get();
        return view('compra.create', compact('proveedores','comprobantes','productos'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCompraRequest $request)
    {
        // DB::beginTransaction();

        try {
            
            $data = $request->validated();

            $data['total'] = str_replace('.', '', $data['total']);
            $data['total'] = str_replace(',', '.', $data['total']);
            $data['total'] = (float) $data['total'];

            $data['impuesto'] = (float) $data['impuesto'] * 1000;

            $compra = Compra::create($data);

            

            $arrayProducto_id  = $request->get('arrayidproducto');
            $arrayCantidad     = $request->get('arraycantidad');
            $arrayPrecioCompra = $request->get('arrayprecioCompra');
            $arrayPrecioVenta  = $request->get('arrayprecioVenta');

            $sizeArray = count($arrayProducto_id);

            for ($i = 0; $i < $sizeArray; $i++) {

                $precioCompra = str_replace('.', '', $arrayPrecioCompra[$i]);
                $precioCompra = str_replace(',', '.', $precioCompra);

                $precioVenta = str_replace('.', '', $arrayPrecioVenta[$i]);
                $precioVenta = str_replace(',', '.', $precioVenta);

               

                $compra->productos()->syncWithoutDetaching([
                    $arrayProducto_id[$i] => [
                        'cantidad'       => (int) $arrayCantidad[$i],
                        'precio_compra'  => (float) $precioCompra,
                        'precio_venta'   => (float) $precioVenta
                    ]
                ]);

                $producto = Producto::findOrFail($arrayProducto_id[$i]);

                DB::table('productos')
                    ->where('id', $producto->id)
                    ->update([
                        'stock' => $producto->stock + (int) $arrayCantidad[$i]
                    ]);
            }

            DB::commit();

            return redirect()->route('compras.index')
                ->with('success', 'Compra registrada correctamente');

        } catch (\Exception $e) {
            // dd($e);
            DB::rollBack();

            return back()->with('error', 'Error al registrar la compra: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Compra $compra): View
    {
        return view('compra.show',compact('compra'));
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
        Compra::where('id',$id)
        ->update([
            'estado' => 0
        ]);

        return redirect()->route('compras.index')->with('success','Compra eliminada ');
    }
}
