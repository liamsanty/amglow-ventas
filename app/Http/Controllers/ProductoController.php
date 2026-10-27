<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreProductoRequest;
use App\Http\Requests\UpdateProductoRequest;
use App\Models\Categoria;
use App\Models\Marca;
use App\Models\Producto;
use Exception;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class ProductoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        //dd(session('success'));
        $resumen = [];
        $fechas = [
            'fecIni' => null,
            'fecFin' => null
        ];
        $productos = Producto::with(['categorias.caracteristica', 'marca.caracteristica'])->latest()->get();
    
        return view('producto.index', compact('productos', 'resumen', 'fechas'));
    }

    public function reporte_productos(Request $request)
    {
        $fecIni = $request->input('fecIni');
        $fecFin = $request->input('fecFin');

        $query = DB::table('producto_venta as pv')
            ->join('productos as p', 'p.id', '=', 'pv.producto_id')
            ->join('ventas as v', 'v.id' , '=', 'pv.venta_id')
            ->when($fecIni, fn($q) => $q->whereDate('v.created_at', '>=', $fecIni))
            ->when($fecFin, fn($q) => $q->whereDate('v.created_at', '<=', $fecFin))
            ->select([
                'pv.producto_id',
                'p.nombre as producto',
                DB::raw('SUM(pv.cantidad) as total_cantidad'),
                DB::raw('SUM(pv.cantidad * pv.precio_venta) as total_bruto'),
                DB::raw('SUM(pv.descuento) as total_descuento'),
                DB::raw('SUM(pv.cantidad * pv.precio_venta) - SUM(pv.descuento) as total_neto'),
            ])
        ->groupBy('pv.producto_id', 'p.nombre')
        ->orderByDesc('total_cantidad'); 

        $fechas = [
            'fecIni' => $fecIni,
            'fecFin' => $fecFin
        ];
        $resumen = $query->get();
        $productos = Producto::with(['categorias.caracteristica', 'marca.caracteristica'])->latest()->get();
        // dd($request->all() ,$resumen->all(), $productos->all(), $fechas);

        return view('producto.index', compact('productos', 'resumen', 'fechas'));
    }

    /**
     * Show the form for creating a new resource.
     */

    public function create(): View
    {
        $marcas = Marca::join('caracteristicas as c', 'marcas.caracteristica_id', '=', 'c.id')
            ->select('marcas.id as id', 'c.nombre as nombre')
            ->where('c.estado', 1)
            ->get();

        $categorias = Categoria::join('caracteristicas as c', 'categorias.caracteristica_id', '=', 'c.id')
            ->select('categorias.id as id', 'c.nombre as nombre')
            ->where('c.estado', 1)
            ->get();


        return view('producto.create', compact('marcas', 'categorias'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreProductoRequest $request): RedirectResponse
    {
        //dd($request); 
        try {
            DB::beginTransaction();
            //Tabla producto
            $producto = new Producto();
            if ($request->hasFile('img_path')) {
                $name = $producto->handleUploadImage($request->file('img_path'));
            } else {
                $name = null;
            }

            $producto->fill([
                'codigo' => $request->codigo,
                'nombre' => $request->nombre,
                'descripcion' => $request->descripcion,
                'fecha_vencimiento' => $request->fecha_vencimiento,
                'img_path' => $name,
                'marca_id' => $request->marca_id
            ]);

            $producto->save();

            //Tabla categoría producto
            $categorias = $request->get('categorias');
            $producto->categorias()->sync($categorias);


            DB::commit();
        } catch (Exception $e) {
            //dd($e);
            DB::rollBack();
        }

        return redirect()->route('productos.index')->with('success', 'Producto registrado');

        //return redirect()->route('categorias.index')->with('success', 'Producto registrado'); 
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Producto $producto): View
    {
        $marcas = Marca::join('caracteristicas as c', 'marcas.caracteristica_id', '=', 'c.id')
            ->select('marcas.id as id', 'c.nombre as nombre')
            ->where('c.estado', 1)
            ->get();

        $categorias = Categoria::join('caracteristicas as c', 'categorias.caracteristica_id', '=', 'c.id')
            ->select('categorias.id as id', 'c.nombre as nombre')
            ->where('c.estado', 1)
            ->get();

        return view('producto.edit', compact('producto', 'marcas', 'categorias'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProductoRequest $request, Producto $producto): RedirectResponse
    {
        Log::info('=== MÉTODO UPDATE ===');
        Log::info('Producto ID: ' . $producto->id);
        Log::info('Producto Código: ' . $producto->codigo);
        Log::info('Producto Nombre: ' . $producto->nombre);
        Log::info('Producto Descripción: ' . $producto->descripcion);
        Log::info('Producto Fecha Vencimiento: ' . $producto->fecha_vencimiento);
        Log::info('Producto Stock: ' . $producto->stock);

        try {
            DB::beginTransaction();

            if ($request->hasFile('img_path')) {
                $name = $producto->handleUploadImage($request->file('img_path'));

                //Eliminar si existiese una imagen
                if (Storage::disk('public')->exists('productos/' . $producto->img_path)) {
                    Storage::disk('public')->delete('productos/' . $producto->img_path);
                }
            } else {
                $name = $producto->img_path;
            }

            Log::info('=== MÉTODO UPDATE ===');
            Log::info('Producto ID: ' . $producto->id);
            Log::info('Producto Codigo: ' . $producto->codigo);
            Log::info('Producto Nombre: ' . $producto->nombre);
            Log::info('Producto Descripción: ' . $producto->descripcion);
            Log::info('Producto Fecha Vencimiento: ' . $producto->fecha_vencimiento);
            Log::info('Producto Stock: ' . $producto->stock);
            Log::info('Producto Estado: ' . $producto->estado);
            Log::info('Producto Img Path: ' . $producto->img_path);
            Log::info('Producto Marca ID: ' . $producto->marca_id);
            Log::info('Producto Created At: ' . $producto->created_at);
            Log::info('Producto Updated At: ' . $producto->updated_at);


            $producto->fill([
                'codigo' => $request->codigo,
                'nombre' => $request->nombre,
                'descripcion' => $request->descripcion,
                'fecha_vencimiento' => $request->fecha_vencimiento,
                'img_path' => $name,
                //'marca_id' => $request->marca_id
                //'stock'=>1,
                //'estado'=>1
            ]);

            $producto->save();

            //Tabla categoría producto
            $categorias = $request->get('categorias');
            $producto->categorias()->sync($categorias);

            DB::commit();
        } catch (Exception $e) {
            //dd($e);
            DB::rollBack();
        }

        return redirect()->route('productos.index')->with('success', 'Producto editado');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $message = '';
        $producto = Producto::find($id);
        if ($producto->estado == 1) {
            Producto::where('id', $producto->id)
                ->update([
                    'estado' => 0
                ]);
            $message = 'Producto eliminado';
        } else {
            Producto::where('id', $producto->id)
                ->update([
                    'estado' => 1
                ]);
            $message = 'Producto restaurado';
        }

        return redirect()->route('productos.index')->with('success', $message);
    }
}
