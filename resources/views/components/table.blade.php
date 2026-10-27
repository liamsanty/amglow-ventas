{{-- <table id="datatablesSimple" class="table table-striped">
    <thead>
        <tr>
            <th>Nombre</th>
            <th>Descripción</th>
            <th>Estado</th>               
            <th>Acciones</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($items as $item)
            <tr>
                <td>{{ $item->caracteristica->nombre }}</td>
                <td>{{ $item->caracteristica->descripcion }}</td>
                <td>
                    <span class="fw-bolder p-1 rounded text-white
                        {{ $item->caracteristica->estado == 1 ? 'bg-success' : 'bg-danger' }}">
                        {{ $item->caracteristica->estado == 1 ? 'Activo' : 'Eliminado' }}
                    </span>
                </td>
                <td>
                    <div class="d-flex gap-2">
                        <a href="{{ route($routeName . '.edit', $item->id) }}" class="btn btn-warning">Editar</a>
                        <button type="button" class="btn {{ $item->caracteristica->estado == 1 ? 'btn-danger':'btn-success' }}"
                                data-bs-toggle="modal" data-bs-target="#confirmModal-{{ $item->id }}">
                            {{ $item->caracteristica->estado == 1 ? 'Eliminar' : 'Restaurar' }}
                        </button> 
                    </div>
                </td>
            </tr>
             <!-- Modal -->
             <div class="modal fade" id="confirmModal-{{$categoria->id}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Mensaje de confirmacion</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        {{$categoria->caracteristica->estado == 1 ? '¿Seguro que quieres eliminar la categoria?' : '¿Seguro que quieres restaurar la categoria?'}} 
                    </div>
                    <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                    <form action="{{ route('categorias.destroy',['categoria'=>$categoria->id])}}" method="post">
                        @method('DELETE')
                        @csrf
                        <button type="submit" class="btn btn-danger">Confirmar</button>
                            </form>    
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </tbody>
</table> --}}
