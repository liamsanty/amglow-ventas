{{-- @extends('template') --}}
@extends('layouts.app')

@section('title','roles')


@push('css')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<link href="https://cdn.jsdelivr.net/npm/simple-datatables@latest/dist/style.css" rel="stylesheet" type="text/css">
@endpush

@section('content')

{{-- @if (session('success'))
<script>

    let message = "{{ session('success') }}";
    const Toast = Swal.mixin({
        toast: true,
        position: "top-end",
        showConfirmButton: false,
        timer: 1500,
        timerProgressBar: true,
        didOpen: (toast) => {
            toast.addEventListener('mouseenter', Swal.stopTimer)
            toast.addEventListener('mouseleave', Swal.resumeTimer)
        }
    });

    Toast.fire({
        icon: "success",
        title: message
    });
</script> 
@endif --}}

<div class="container-fluid px-4">
    <h1 class="mt-4 text-center">Roles</h1>
    <ol class="breadcrumb mb-4 d-flex">
        <li class="breadcrumb-item"><a href="{{ route('panel') }}"><i class="fa-solid  fa-home"></i> Inicio</a></li>
        <li class="breadcrumb-item active"><i class="fa-solid  fa-user"></i> Roles</li>
    </ol>


    <div class="mb-4">
        <a href="{{route('roles.create')}}">
            <button type="button" class="btn btn-primary rounded-pill">Añadir nuevo registro</button>
        </a>
    </div>


    <div class="card mb-4">
        <div class="card-header">
            <i class="fas fa-table me-1"></i>
            Tabla roles    
        </div>
        
        <div class="card-body">
            <table id="datatablesSimple" class="table table-striped">
            <thead>
                <tr>
                    <th>Roles</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($roles as $item)
                    <tr>
                    
                        <td>{{$item->name}}</td>
                        
                        <td>
                            <div class="d-flex gap-2">

                                <form action="{{route('roles.edit',['role'=>$item])}}" method="get">
                                    <button type="submit" class="btn btn-warning rounded-pill">Editar</button>
                                </form>
                                
                                <button type="button" class="btn btn-danger rounded-pill" data-bs-toggle="modal" data-bs-target="#confirmModal-{{$item->id}}">Eliminar</button> 
                            
                            </div>
                        </td>
                    </tr>
                <!-- Modal de confirmación-->
                <div class="modal fade" id="confirmModal-{{$item->id}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h1 class="modal-title fs-5" id="exampleModalLabel">Mensaje de confirmación</h1>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                ¿Seguro que quieres eliminar el rol?
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary rounded-pill" data-bs-dismiss="modal">Cerrar</button>
                                <form action="{{ route('roles.destroy',['role'=>$item->id]) }}" method="post">
                                    @method('DELETE')
                                    @csrf
                                    <button type="submit" class="btn btn-danger rounded-pill">Confirmar</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                    @endforeach
            </tbody>
        </table>
    </div>
</div>
</div>

@endsection


@push('js')
<script src="https://cdn.jsdelivr.net/npm/simple-datatables@latest" type="text/javascript"></script>
<script src="{{ asset('js/datatables-simple-demo.js') }}"></script>
@endpush




