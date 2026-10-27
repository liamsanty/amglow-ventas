{{-- @extends('template') --}}
@extends('layouts.app')

@section('title','Crear rol')

@push('css')

@endpush
@section('content')
<div class="container-fluid px-4">
    <h1 class="mt-4 text-center">Crear Roles</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="{{ route('panel') }}"><i class="fa-solid  fa-home"></i> Inicio</a></li>
        <li class="breadcrumb-item"><a href="{{ route('roles.index')}}"><i class="fa-solid  fa-user"></i> Roles</a></li>
        <li class="breadcrumb-item active">Crear roles</li>
    </ol>

    <div class="container border border-3 border-primary rounded p-4 mt-3">
        <form action="{{ route('roles.store') }}" method="post">
            @csrf
            <div class="row g-3">

                {{-- Nombre del rol --}}
                <div class="row mb-4">
                    <label for="name" class="col-sm-2 col-form-label">Nombre del rol</label>
                    <div class="col-sm-4">
                        <input type="text" name="name" id="name" class="form-control" value="{{old('name')}}">
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
                    <div class="form-check mb-2">
                        <input type="checkbox" name="permission[]" id="{{$item->id}}" class="form-check-input" value="{{$item->id}}">
                        <label for="{{$item->id}}" class="form-check-label">{{$item->name}}</label>
                    </div>
                @endforeach
            </div>
            @error('permission')
                <small class="text-danger">{{'*'.$message}}</small>
            @enderror

                <div class="col-12 text-center">
                    <button type="submit" class="btn btn-primary rounded-pill">Guardar</button>
                </div>
            
            </div>
        </form>
    </div>
</div>    
@endsection

@push('js')

@endpush