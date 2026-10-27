<?php

namespace App\Http\Controllers;


use App\Http\Requests\StoreCategoriaRequest;
use App\Http\Requests\UpdateCategoriaRequest;
use App\Models\Caracteristica;
use App\Models\Categoria;
use Exception;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class categoriaController extends Controller 
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        $categorias = Categoria::with('caracteristica')->latest()->get();

        //dd($categorias);
        
        return view('categoria.index',['categorias' => $categorias]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View 
    {
        return view('categoria.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCategoriaRequest $request): RedirectResponse
    {
        //dd($request);
        try{
            DB::beginTransaction();
            $caracteristica = Caracteristica::create($request->validated());
            $caracteristica->categoria()->create([
                'caracteristica_id' => $caracteristica->id
            ]);
            DB::commit();
        }catch(Exception $e){
            DB::rollBack();
        }

        return redirect()->route('categorias.index')->with('success','Categoria registrada');
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
    public function edit(Categoria $categoria): View 
    {
        //dd($categoria);

        return view('categoria.edit',['categoria'=>$categoria]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCategoriaRequest $request, Categoria $categoria): RedirectResponse
    {
        Caracteristica::where('id', $categoria->caracteristica->id)
        ->update($request->validated());

        return redirect()->route('categorias.index')->with('success', 'Categoria editada');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id): RedirectResponse
    {
        $message = '';
        $categoria = Categoria::find($id);
        if ($categoria->caracteristica->estado == 1) {
            Caracteristica::where('id', $categoria->caracteristica->id)
            ->update([
                'estado' => 0
            ]);
            $message = 'Categoria eliminada';
        } else {
        Caracteristica::where('id', $categoria->caracteristica->id)
            ->update([
                'estado' => 1
            ]);
            $message = 'Categoria restaurada';
        }
        // session()->flash('success', $message);
        // return redirect()->route('categorias.index');
        session()->flash('success', $message);
        return redirect()->route('categorias.index')->with('success', $message);
    }
}
