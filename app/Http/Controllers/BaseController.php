<?php

// namespace App\Http\Controllers;

// use Exception;
// use Illuminate\Http\Request;
// use Illuminate\Support\Facades\DB;

// class BaseController extends Controller
// {
//     protected $model;
//         protected $relation;
//         protected $routeName;
//         protected $viewPath; 
    /**
     * Display a listing of the resource.
     */
    // public function index()
    // {
    //     $items = $this->model::with($this->relation)->latest()->get();
    //     return view("$this -> viewPath.index", ['items' =>$items]);
    // }

    /**
     * Show the form for creating a new resource.
     */
    // public function create()
    // {
    //     return view("$this -> viewPath.create"); 
    // }

    /**
     * Store a newly created resource in storage.
     */
    // public function store(Request $request)
    // {
    //     try {
    //         DB::beginTransaction();
    //         $relationModel = $this->relation::create($request->all());
    //         $relationModel->{$this->model()->getTable()}()->create([
    //             'caracteristica_id' => $relationModel->id
    //         ]);
    //         DB::commit();
    //     } catch (Exception $e) {
    //         DB::rollBack();
    //     }

    //     return redirect()->route("$this->routeName.index")->with('success', 'Registro creado exitosamente');
    // }

    /**
     * Display the specified resource.
     */
    // public function show(string $id)
    // {
        //
    //}

    /**
     * Show the form for editing the specified resource.
     */
    // public function edit(string $id)
    // {
    //     $item = $this->model::findOrFail($id);
    //     return view("$this-> viewPath.edit", ['item' => $item]);
    // }

    /**
     * Update the specified resource in storage.
     */
    // public function update(Request $request, string $id)
    // {
    //     $item = $this->model::findOrFail($id);
    //     $item->caracteristica()->update($request->all());

    //     return redirect()->route("$this->routeName.index")->with('success', 'Registro actualizado');
    // }

    /**
     * Remove the specified resource from storage.
     */
//     public function destroy(string $id)
//     {
//         $item = $this->model::findOrFail($id);
//         $estado = $item->caracteristica->estado == 1 ? 0 : 1;
//         $item->caracteristica()->update(['estado' => $estado]);

//         return redirect()->route("$this->routeName.index")->with('success', $estado ? 'Restaurado' : 'Eliminado');
    //}
//}
