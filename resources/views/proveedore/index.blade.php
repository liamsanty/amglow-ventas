{{-- @extends('template') --}}
@extends('layouts.app')

@section('title','Proveedores')


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
        position: 'top-end',
        showConfirmButton: false,
        timer: 1500,
        timerProgressBar: true,
        didOpen: (toast) => {
            toast.addEventListener('mouseenter', Swal.stopTimer)
            toast.addEventListener('mouseleave', Swal.resumeTimer)
        }
    })

    Toast.fire({
        icon: 'success',
        title: message
    })
</script>
@endif --}}

<div class="container-fluid px-4">
    <h1 class="mt-4 text-center">Lista de Proveedores</h1>
    <ol class="breadcrumb mb-4 d-flex">
        <li class="breadcrumb-item"><a href="{{ route('panel') }}"><i class="fas fa-home"></i> Inicio</a></li>
        <li class="breadcrumb-item active"><i class="fa-solid fa-handshake"></i> Proveedores</li>
    </ol>

    <div class="mb-4">
        <a href="{{route('proveedores.create')}}">
            <button type="button" class="btn btn-primary rounded-pill">Añadir nuevo registro</button>
        </a>
    </div>

    <div class="card mb-4">
        <div class="card-header">
            <i class="fas fa-table me-1"></i>
            Tabla Proveedores
        </div>

        <div class="card-body">
            <table id="datatablesSimple" class="table table-striped">
                <thead>
                    <tr>
                        <th>Nombre</th>
                        <th>Dirección</th>
                        <th>Documento</th>
                        <th>Tipo de persona</th>
                        <th>Estado</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($proveedores as $item)
                    <tr>
                        <td>{{$item->persona->razon_social}}</td>
                        <td>{{$item->persona->direccion}}</td>

                        <td>
                            <p class="fw-semibold mb-1">{{$item->persona->documento->tipo_documento}}</p>
                            <p class="fw-text mute mb-0">{{$item->persona->numero_documento}}</p>
                        </td>
                        <td>{{$item->persona->tipo_persona}}</td>
                        <td>
                            <span class="fw-bolder p-1 rounded shadow rounded-pill px-2 text-white
                                {{ $item->persona->estado == 1 ? 'bg-success' : 'bg-danger' }}">
                                {{ $item->persona->estado == 1 ? 'Activo' : 'Eliminado' }}
                            </span>
                        </td>
                        <td>
                            <div class="d-flex gap-2">
                                <a href="{{ route('proveedores.edit', ['proveedore' => $item]) }}"
                                    class="btn btn-primary shadow rounded-pill px-2">
                                    Editar
                                </a>

                                <button type="button" class="btn btn-primary shadow rounded-pill px-2
                                    {{ $item->persona->estado == 1 ? 'btn-danger':'btn-success' }}"
                                    data-bs-toggle="modal"
                                    data-bs-target="#confirmModal-{{ $item->id }}">
                                    {{ $item->persona->estado == 1 ? 'Eliminar' : 'Restaurar' }}
                                </button>
                            </div>
                        </td>
                    </tr>

                    <!-- Modal -->
                    <div class="modal fade" id="confirmModal-{{$item->id}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h1 class="modal-title fs-5" id="exampleModalLabel">Mensaje de confirmación</h1>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    {{$item->persona->estado == 1 ? '¿Seguro qiminar el proveue quieres eledor?' : '¿Seguro que quieres restaurar el proveedor?'}}
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary shadow rounded-pill px-2" data-bs-dismiss="modal">Cerrar</button>
                                    <form action="{{ route('proveedores.destroy',['proveedore'=>$item->persona->id]) }}" method="post">
                                        @method('DELETE')
                                        @csrf
                                        <button type="submit" class="btn btn-danger shadow rounded-pill px-2">Confirmar</button>
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