
@extends('layouts.app')

@section('title','Productos')

@push('css')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<link href="https://cdn.jsdelivr.net/npm/simple-datatables@latest/dist/style.css" rel="stylesheet" type="text/css">
@endpush

@section('content')

<div class="container-fluid px-4">
    <h1 class="mt-4 text-center">Lista de Productos</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="{{ route('panel') }}"><i class="fas fa-home"></i> Inicio</a></li>
        <li class="breadcrumb-item active"><i class="fa-solid fa-cart-shopping"></i>Productos</li>
    </ol>

    <div class="mb-4">
        <a href="{{ route('productos.create') }}" class="btn btn-primary shadow rounded-pill px-2">Añadir nuevo registro</a>
    </div>

    <div class="card mb-4">
        <div class="card-header">
            <i class="fas fa-table me-1"></i> Tabla productos
        </div>
        <div class="card-body">
            <table id="datatablesSimple" class="table table-striped">
                <thead>
                    <tr>
                        <th>Código</th>
                        <th>Nombre</th>
                        <th>Descripción</th>
                        <th>Marca</th>
                        <th>Categorías</th>
                        <th>Cantidad</th>
                        <th>Estado</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($productos as $item)
                    <tr>
                        <td>{{ $item->codigo }}</td>
                        <td>{{ $item->nombre }}</td>
                        <td>{{ $item->descripcion }}</td>
                        <td>{{ $item->marca->caracteristica->nombre }}</td>
                        <td>
                            @if(($item->categorias ?? collect())->isEmpty())
                                <span class="badge bg-secondary">
                                    Sin categoría
                                </span>
                            @else
                                <span class="badge bg-warning">
                                    {{ ($item->categorias)
                                            ->map(fn($c) => $c->caracteristica?->nombre)
                                            ->filter()   // quita null/vacíos
                                            ->implode(', ')
                                        ?: 'Sin categoría'
                                    }}
                                </span>
                            @endif 
                        </td>
                        <td> {{ $item->stock }}</td>
                        <td>
                            <span class="fw-bold badge shadow rounded-pill px-2 {{ $item->estado == 1 ? 'bg-success' : 'bg-danger' }}">
                                {{ $item->estado == 1 ? 'ACTIVO' : 'ELIMINADO' }}
                            </span>
                        </td>
                        <td>
                            <div class="d-flex gap-2">
                                <a href="{{ route('productos.edit', ['producto' => $item]) }}" class="btn btn-primary shadow rounded-pill px-2">Editar</a>
                                <button type="button" class="btn btn-light" data-bs-toggle="modal" data-bs-target="#verModal-{{ $item->id }}">Ver</button>
                                <button type="button" class="btn shadow rounded-pill px-2 {{ $item->estado == 1 ? 'btn-danger' : 'btn-success' }}" data-bs-toggle="modal" data-bs-target="#confirmModal-{{ $item->id }}">
                                    {{ $item->estado == 1 ? 'Eliminar' : 'Restaurar' }}
                                </button>
                            </div>
                        </td>
                    </tr>

                    <div class="modal fade" id="verModal-{{ $item->id }}" tabindex="-1" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">Detalles del producto</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                </div>
                                <div class="modal-body">
                                    <p><strong>Descripción:</strong> {{ $item->descripcion }}</p>
                                    <p><strong>Fecha de vencimiento:</strong> {{ $item->fecha_vencimiento ?? 'No tiene' }}</p>
                                    <p><strong>Stock:</strong> {{ $item->stock }}</p>
                                    <p><strong>Imagen:</strong></p>
                                    @if ($item->img_path)
                                    <img src="{{ Storage::disk('public')->url('productos/' . $item->img_path) }}" class="img-fluid img-thumbnail" alt="{{ $item->nombre }}">
                                    @else
                                    <p>No hay imagen disponible</p>
                                    @endif
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary shadow rounded-pill px-2" data-bs-dismiss="modal">Cerrar</button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="modal fade" id="confirmModal-{{ $item->id }}" tabindex="-1" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">Mensaje de confirmación</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                </div>
                                <div class="modal-body">
                                    {{ $item->estado == 1 ? '¿Seguro que quieres eliminar el producto?' : '¿Seguro que quieres restaurar el producto?' }}
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary shadow rounded-pill px-2" data-bs-dismiss="modal">Cerrar</button>
                                    <form action="{{ route('productos.destroy', ['producto' => $item->id]) }}" method="post">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn {{ $item->estado == 1 ? 'btn btn-danger shadow rounded-pill px-2' : 'btn btn-danger shadow rounded-pill px-2' }}">Confirmar</button>
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

    <div class="mb-4">
        <h3 class="text-center fw-bold"> Productos vendidos por período </h3>
        <h5>Filtros de busqueda</h5>
        <form class="col-9" action="{{ route('productos.reporte') }}" method="post">
            @csrf
            <div class="row">
                <div class="col-3">
                    <div class="mb-2">
                        <label class="form-label">Fecha Inicio</label>
                        <input type="date" class="form-control" name="fecIni" value="{{ $fechas['fecIni'] ?? '' }}"/>
                    </div>
                </div>
                <div class="col-3">
                    <div class="mb-2">
                        <label class="form-label">Fecha Fin</label>
                        <input type="date" class="form-control" name="fecFin" value="{{ $fechas['fecFin'] ?? '' }}"/>
                    </div>
                </div>
                <div class="col-1 mt-2">
                    <div class="mb-2 mt-4">
                        <button type="submit" class="btn btn-primary rounded-pill">Buscar</button>
                    </div>
                </div>
                <div class="col-2 mt-2">
                    <div class="mb-2 mt-4">
                        <a type="button" class="btn btn-secondary rounded-pill"
                            href="{{ route('export.pdf-venta-producto', ['fecIni' => $fechas['fecIni'] ?? '', 'fecFin' => $fechas['fecFin'] ?? '']) }}"
                            target="_blank">
                            Exportar
                        </a>
                    </div>
                </div>
            </div>
        </form>
    </div>
    <div class="card mb-4">
        <div class="card-header"> <i class="fas fa-table me-1"></i>  Venta de productos por fechas </div>
        <div class="card-body">
            <table id="datatablesSimple" class="table table-striped">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Código</th>
                        <th>Nombre</th>
                        <th>Cantidad</th>
                        <th>Total Bruto</th>
                        <th>Descuento</th>
                        <th>Total Neto</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($resumen as $row)
                    <tr>
                        <td> {{ $loop->iteration }} </td>
                        <td> {{ $row->producto_id }}</td>
                        <td> {{ $row->producto }}</td>
                        <td> {{ $row->total_cantidad }}</td>
                        <td> {{ $row->total_bruto }}</td>
                        <td> {{ $row->total_descuento }}</td>
                        <td> {{ $row->total_neto}} </td>
                    </tr>
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