<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePersonaRequest;
use App\Http\Requests\UpdateProveedoreRequest;
use App\Models\Documento;
use App\Models\Persona;
use App\Models\Producto;
use App\Models\Proveedore;
use Dom\Document;
use Exception;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use PhpParser\Node\Stmt\Return_;

class proveedorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        $proveedores = Proveedore::with('persona.documento')->get();
        return view('proveedore.index', compact('proveedores'));

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        $documentos = Documento::all();
        return view('proveedore.create',compact('documentos'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePersonaRequest $request): RedirectResponse
    {
        try {
            DB::beginTransaction();
            $persona = Persona::create($request->validated());
            $persona->proveedore()->create([
                'persona_id' => $persona->id
            ]);
            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();
        }

        return redirect()->route('proveedores.index')->with('success', 'Proveedor registrado');
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
    public function edit(Proveedore $proveedore): View
    {
        $proveedore->load('persona.documento');
        $documentos = Documento::all();
        return view('proveedore.edit',compact('proveedore','documentos'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProveedoreRequest $request, Proveedore $proveedore): RedirectResponse
    {
        try{
            DB::beginTransaction();

            Persona::where('id',$proveedore->persona->id)
            ->update($request->validated());

            DB::commit();
        }catch(Exception $e){
            DB::rollBack();
        }

        return redirect()->route('proveedores.index')->with('success','Proveedor editado');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id): RedirectResponse
    {
        $message = '';
        $persona = Persona::find($id);
        if ($persona->estado == 1) {
            Persona::where('id', $persona->id)
                ->update([
                    'estado' => 0
                ]);
            $message = 'Producto eliminado';
        } else {
            Persona::where('id', $persona->id)
                ->update([
                    'estado' => 1
                ]);
            $message = 'Proveedor restaurado';
        }

        return redirect()->route('proveedores.index')->with('success', $message);
    }
}
