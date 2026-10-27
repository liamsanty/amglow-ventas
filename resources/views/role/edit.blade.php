{{-- @extends('template') --}}
@extends('layouts.app')

@section('title','Editar rol')

@push('css')

@endpush
{{--esta linea de codigo es supuesta soluccion <form action="{{ route('categorias.update',['categorium'=>$categoria]) }}" method="post"> --}}
@section('content')
<div class="container-fluid px-4">
    <h1 class="mt-4 text-center">Editar Rol</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="{{ route('panel') }}"><i class="fa-solid  fa-home"></i> Inicio</a></li>
        <li class="breadcrumb-item"><a href="{{ route('roles.index')}}"><i class="fa-solid  fa-user"></i> Roles</a></li>
        <li class="breadcrumb-item active">Editar rol</li>
    </ol>

    <div class="container w-100 border border-3 border-primary rounded p-4 mt-3">
        <form action="{{ route('roles.update',['role'=>$role]) }}" method="post">
            @method('PATCH')
            @csrf
            <div class="row g-3">

                {{-- Nombre del rol --}}
                <div class="row mb-4">
                    <label for="name" class="col-sm-2 col-form-label">Nombre del rol</label>
                    <div class="col-sm-4">
                        <input type="text" name="name" id="name" class="form-control" value="{{old('name',$role->name)}}">
                    </div>
                    <div class="col-sm-6">
                        @error('name')
                            <small class="text-danger">{{'*'.$message}}</small>
                        @enderror
                </div>
            </div>

            {{-- Permisos --}}

            <div class="col-12 mb-4">
                <label for="" class="form-label">Permisos para el rol:</label>
                @foreach ($permisos as $item)
                @if ( in_array($item->id, $role->permissions->pluck('id')->toArray() ) )
                    <div class="form-check mb-2">
                        <input checked type="checkbox" name="permission[]" id="{{$item->id}}" class="form-check-input" value="{{$item->id}}">
                        <label for="{{$item->id}}" class="form-check-label">{{$item->name}}</label>
                    </div>
                @endif
                @endforeach
            </div>
            @error('permission')
                <small class="text-danger">{{'*'.$message}}</small>
            @enderror


                <div class="col-12 text-center mt-3">
                    <button type="submit" class="btn btn-primary rounded-pill px-4 py-2">Actualizar</button>
                    <button type="reset" class="btn btn-secondary rounded-pill px-4 py-2">Reiniciar</button>
                </div>
            
            </div>
        </form>
        </div>   

</div>


@endsection

@push('js')
    
@endpush