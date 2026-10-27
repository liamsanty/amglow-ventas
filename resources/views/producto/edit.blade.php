{{-- @extends('template') --}}
@extends('layouts.app')

@section('title','Editar Producto')

@push('css')
<style>
    #descripcion{
        resize: none;
    }
</style>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-select@1.14.0-beta3/dist/css/bootstrap-select.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
@endpush

@section('content')  
<div class="container-fluid">
    <h1 class="mt-4 text-center">Editar Producto</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="{{ route('panel') }}"><i class="fas fa-home"></i> Inicio</a></li>
        <li class="breadcrumb-item"><a href="{{ route('productos.index') }}"><i class="fa-solid fa-cart-shopping"></i> Productos</a></li>  
        <li class="breadcrumb-item active"><i class="fas fa-edit"></i> Editar producto</li>
    </ol>

    <div class="container w-100 border border-3 border-primary rounded p-4 mt-3">
        <form action="{{route('productos.update',['producto'=>$producto])}}" method="post" enctype="multipart/form-data">
            @method('PATCH')
            @csrf
            
            <div class="row g-3">

                <div class="col-md-6 mb-2">
                    <label for="codigo" class="form-label">Codigo:</label>
                    <input type="text" name="codigo" id="codigo" class="form-control rounded-pill" placeholder="Ej: COD123" class="form-control" value="{{old('codigo',$producto->codigo)}}">
                    @error('codigo')
                        <div class="text-danger mt-1 small">{{'*'.$message}}</div>      
                    @enderror
                </div>

                <div class="col-md-6 mb-2">
                    <label for="nombre" class="form-label">Nombre:</label>
                    <input type="text" name="nombre" id="nombre" class="form-control rounded-pill" placeholder="Ingrese el nombre" value="{{old('nombre', $producto->nombre)}}">
                    @error('nombre')
                        <div class="text-danger mt-1 small">{{'*'.$message}}</div>
                    @enderror
                </div>

                <div class="col-md-6 mb-2">
                    <label for="img_path" class="form-label">Imagen:</label>
                    <input id="img_path" type="file" name="img_path" class="form-control border rounded-3 shadow-sm"
                        accept="image/*" value="{{ old('img_path', $producto->img_path) }}">
                    @error('img_path')
                        <div class="text-danger mt-1 small">{{'*'.$message}}</div>
                    @enderror
                </div>

                <!---Categoría---->
                            <div class="col-md-6 mb-2">
                        <label for="categorias" class="form-label">Categorías:</label>
                        <select class="form-control selectpicker bg-white rounded shadow-sm py-2" data-size="5"
                            title="selecione las categorias" data-live-search="true" name="categorias[]" id="categorias"
                            multiple>
                            @foreach ($categorias as $item)
                                <option value="{{ $item->id }}" @if (in_array($item->id, old('categorias', []))) selected @endif>
                                    {{ $item->nombre }}</option>
                            @endforeach
                        </select>
                        @error('categorias')
                            <div class="text-danger">{{ '*' . $message }}</div>
                        @enderror
                    </div>

                        <!---Marca---->
                            <div class="col-md-6 mb-2">
                        <label for="marca_id" class="form-label">Marca:</label>
                        <select class="form-control selectpicker bg-white rounded shadow-sm py-2" data-size="5"
                            title="Seleccione una marca" data-live-search="true" name="marca_id" id="marca_id">
                            @foreach ($marcas as $item)
                                <option value="{{ $item->id }}" @selected(old('marca_id') == $item->id)>{{ $item->nombre }}
                                </option>
                            @endforeach
                        </select>
                        @error('marca_id')
                            <div class="text-danger">{{ '*' . $message }}</div>
                        @enderror
                    </div>

                {{-- @if($producto->img_path)
                    <div class="col-md-6 mb-2">
                        <label class="form-label">Imagen actual:</label>
                        <div class="d-flex align-items-center">
                            <img src="{{ asset('storage/productos/' . $producto->img_path) }}" 
                                alt="Imagen del producto" 
                                class="img-thumbnail" 
                                style="max-width: 150px; max-height: 150px;">
                        </div>
                    </div>
                @endif --}}

                <div class="col-md-6 mb-2">
                    <label for="fecha_vencimiento" class="form-label">Fecha de vencimiento:</label>
                    <input type="date" name="fecha_vencimiento" id="fecha_vencimiento" class="form-control" value="{{old('fecha_vencimiento',$producto->fecha_vencimiento)}}">
                    @error('fecha_vencimiento')
                        <div class="text-danger mt-1 small">{{'*'.$message}}</div>
                    @enderror
                </div>

                <div class="col-md-10 mb-3">
                    <label for="descripcion" class="form-label">Descripción:</label>
                    <textarea name="descripcion" id="descripcion" rows="4" class="form-control rounded-3"
                        placeholder="Ej. Productos electrónicos, accesorios, etc.">{{ old('descripcion', $producto->descripcion) }}</textarea>
                    @error('descripcion')
                        <div class="text-danger">{{ '*' . $message }}</div>
                    @enderror
                </div>

                
                            

                <div class="col-12 text-center">
                    <button type="submit" class="btn btn-primary shadow rounded-pill px-2">Guardar</button>
                </div>

            </div>
        </form>
    </div>
</div>
@endsection

@push('js')
<script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.14.0-beta3/dist/js/bootstrap-select.min.js"></script>
@endpush