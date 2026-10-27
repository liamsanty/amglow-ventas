<?php

namespace App\Http\Controllers;

use App\Models\Empresa;
use App\Models\Venta;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;

class ExportPDFController extends Controller
{


    public function exportPdfComprobanteVenta(Request $request)
    {
        $id = Crypt::decrypt($request->id);

        $venta = Venta::findOrfail($id);
        
        $empresa = Empresa::first();
        
        $pdf = Pdf::loadView('repdf.comprobante-venta', [
            'venta' => $venta,
            'empresa' => $empresa
            
    ]);

    return $pdf->stream('venta-' . $venta->id);

    } 

    public function exportPdfVentaProducto(Request $request)
    {
        $fecIni = $request->input('fecIni');
        $fecFin = $request->input('fecFin');

        $query = DB::table('producto_venta as pv')
            ->join('productos as p', 'p.id', '=', 'pv.producto_id')
            ->join('ventas as v', 'v.id' , '=', 'pv.venta_id')
            ->when($fecFin, fn($q) => $q->whereDate('v.created_at', '>=', $fecIni))
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

        
        $pdf = Pdf::loadView('repdf.reporte_ventaxproducto', [
            'fecIni' => $fecIni,
            'fecFin' => $fecFin,
            'resumen' => $query->get(),
            'empresa' => Empresa::first()
            
    ]);

    return $pdf->stream('reporte-venta-producto-' . $fecIni . '-' . $fecFin);

    } 
}
