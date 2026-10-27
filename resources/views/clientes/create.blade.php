{{-- @extends('template') --}}
@extends('layouts.app')

@section('title','Crear cliente')

@push('css')
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<style>
#box-razon-social{
    display: none; 
}
</style>

@endpush

@section('content')
<div class="container-fluid">
    <h1 class="mt-4 text-center">Crear Cliente</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="{{ route('panel') }}"><i class="fas fa-home"></i> Inicio</a></li>
        <li class="breadcrumb-item"><a href="{{ route('clientes.index')}}"><i class="fa-solid fa-users-line"></i> Clientes</a></li>
        <li class="breadcrumb-item active">Crear cliente</li>
    </ol>

    <div class="container w-100 border border-3 border-primary rounded p-4 mt-3">
        <form action="{{ route('clientes.store') }}" method="post">
            @csrf
            <div class="row g-3">

                {{-- tipo de persona --}}
                <div class="col-md-6 mb-2">
                    <label for="tipo_persona" class="form-label">Tipo de cliente:</label>
                    <select class="form-select bg-white rounded-pill shadow-sm py-2" name="tipo_persona" id="tipo_persona">
                        <option value="" selected disabled>Selecciones una opcion</option>
                        {{-- <option value="natural"{{ old('tipo_persona') == 'natural' ? 'selected' : '' }}>Persona natural</option>
                        <option value="juridica"{{ old('tipo_persona') == 'juridica' ? 'selected' : '' }}>Persona juridica</option> --}}
                        <option value="natural">Natural</option>
                        <option value="juridica">Juridica</option>

                    </select>
                    @error('tipo_persona')
                    <div class="text-danger">{{'*'.$message}}</div>                        
                    @enderror
                </div>

                {{-- Razon social --}}

                <div class="col-md-12 mb-2" id="box-razon-social">
                    <label id="label-natural" for="razon_social" class="form-label">Nombres y apellido</label>
                    <label id="label-juridica" for="razon_social" class="form-label">Nombre de la empresa:</label>

                    {{-- <input type="text" name="razon_social" id="razon_social" class="form-control" value="{{old('razon_social')}}"> --}}
                    <input required type="text" name="razon_social" id="razon_social" class="form-control" value="{{old('razon_social')}}">

                    @error('razon_social')
                    <div class="text-danger">{{'*'.$message}}</div>
                    @enderror
                </div>

                {{-- Direccion --}}

                <div class="col-md-8 mb-2">
                    <label for="direccion" class="form-label">Dirección:</label>
                    <input type="text" name="direccion" id="direccion" class="form-control rounded-pill" placeholder="Ingrese la direccion" value="{{old('direccion')}}">
                    @error('direccion')
                    <div class="text-danger">{{'*'.$message}}</div>
                    @enderror
                </div>

                {{-- Documento --}}

                <div class="col-md-6 mb-2">
                    <label for="documento_id" class="form-label">Tipo de documento:</label>
                    <select class="form-select rounded-pill shadow-sm py-2" name="documento_id" id="documento_id">
                        <option value="" selected disabled>Seleccione una opción</option>
                        @foreach ($documentos as $item)
                            <option value="{{$item->id}}" {{ old('documento_id') == $item->id ? 'selected' : '' }}>{{$item->tipo_documento}}</option>
                        @endforeach
                    </select>
                    @error('documento_id')
                    <div class="text-danger">{{'*'.$message}}</div>                        
                    @enderror
                </div>

                <div class="col-md-6 mb-2">
                    <label for="numero_documento" class="form-label py-1">Número de documento:</label>
                    <input type="text" name="numero_documento" id="numero_documento" class="form-control rounded-pill" placeholder="Ingrese el documento" value="{{old('numero_documento')}}">
                    @error('numero_documento')
                    <div class="text-danger">{{'*'.$message}}</div>
                    @enderror
                </div>

                <div class="col-12 text-center mt-3">
                    <button type="submit" class="btn btn-primary shadow rounded-pill">Guardar</button>
                </div>
            </div>
        </form>
    </div>
</div>    
@endsection

@push('js')
<script>
    document.addEventListener("DOMContentLoaded", function() {
        const tipoPersona = document.getElementById("tipo_persona");
        const labelNatural = document.getElementById("label-natural");
        const labelJuridica = document.getElementById("label-juridica");
        const boxRazonSocial = document.getElementById("box-razon-social");

        tipoPersona.addEventListener("change", function(){
            let selectvalue = this.value;

            if (selectvalue === "natural") {
                labelJuridica.style.display = "none";
                labelNatural.style.display = "block";
            } else {
                labelNatural.style.display = "none";
                labelJuridica.style.display = "block";
            }

            boxRazonSocial.style.display = "block"
        });
    });
</script>

@endpush