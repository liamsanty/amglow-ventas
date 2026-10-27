{{-- @extends('template') --}}
@extends('layouts.app')

@section('title','Realizar venta')

@push('css')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-select@1.14.0-beta3/dist/css/bootstrap-select.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
@endpush

@section('content')

@if (session('error'))
    <div class="alert alert-danger">
        {{ session('error') }}
    </div>
@endif
@if (session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif

<div class="container-fluid px-4">
    <h1 class="mt-4 text-center">Realizar Venta</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="{{ route('panel') }}"><i class="fas fa-home"></i> Inicio</a></li>
        <li class="breadcrumb-item"><a href="{{ route('ventas.index')}}"><i class="fa-solid fa-cart-shopping"></i> Ventas</a></li>
        <li class="breadcrumb-item active">Realizar Venta</li>
    </ol>
</div>

<form action="{{ route('ventas.store') }}" method="post">
    @csrf

    <div class="container mt-4">
        <div class="row gy-4">
            <div class="col-md-8">
                <div class="text-white bg-secondary p-1 rounded-pill text-center">
                    Detalle de la venta
                </div>
                <div class="p-3 border border-3 border-secondary">
                    <div class="row">
                        <div class="col-md-12 mb-2">
                            <select name="producto_id" id="producto_id" class="form-control selectpicker" data-live-search="true" data-size="2" title="Selecciona un producto">
                                @foreach ($productos as $item)
                                <option value="{{$item->id}}-{{$item->stock}}-{{$item->precio_venta}}">{{$item->codigo.' '.$item->nombre }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6 mb-2">
                        </div>
                        <div class="col-md-6 mb-2">
                            <div class="row">
                                <label for="stock" class="form-label col-sm-4">En stock:</label>
                                <div class="col-sm-8">
                                    <input disabled id="stock" type="text" class="form-control">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 mb-2">
                            <label for="cantidad" class="form-label">Cantidad</label>
                            <input type="number" name="cantidad" id="cantidad" class="form-control">
                        </div>

                        <div class="col-md-4 mb-2">
                            <label for="precio_venta" class="form-label">Precio de venta:</label>
                            <input disabled type="text" name="precio_venta" id="precio_venta" class="form-control">
                        </div>

                        <div class="col-md-4 mb-2">
                            <label for="descuento" class="form-label">Descuento:</label>
                            <input type="number" name="descuento" id="descuento" class="form-control">
                        </div>

                        <div class="col-md-12 mb-2 mt-2 text-end">
                            <button id="btn_agregar" class="btn btn-secondary rounded-pill" type="button">Agregar</button>
                        </div>

                        <div class="col-md-12">
                            <div class="table-responsive">
                                <table id="tabla_detalle" class="table table-hover">
                                    <thead class="bg-secondary text-white">
                                        <tr>
                                            <th>#</th>
                                            <th>Producto</th>
                                            <th>Cantidad</th>
                                            <th>Precio venta</th>
                                            <th>Descuento</th>
                                            <th>Subtotal</th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <th></th>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                        </tr>
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <th></th>
                                            <th colspan="4">Sumas</th>
                                            <th colspan="2"><span id="sumas">0</span></th>
                                        </tr>
                                        <tr>
                                            <th></th>
                                            <th colspan="4">IVA %</th>
                                            <th colspan="2"><span id="iva">0</span></th>
                                        </tr>
                                        <tr>
                                            <th></th>
                                            <th colspan="4">Total</th>
                                            <th colspan="2"> <input type="hidden" name="total" value="0" id="inputTotal"> <span id="total">0</span></th>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>

                        <div class="col-md-12 mb-2">
                            <button id="cancelar" type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#exampleModal">
                                Cancelar venta
                            </button>
                        </div>

                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="text-white bg-secondary rounded-pill p-1 text-center">
                    Datos generales
                </div>
                <div class="p-3 border border-3 border-secondary">
                    <div class="row">
                        <div class="col-md-12 mb-2">
                            <label for="cliente_id" class="form-label">Cliente:</label>
                            <select name="cliente_id" id="cliente_id" class="form-control selectpicker show-ticket" data-live-search="true" title="Selecciona" data-size='2'>
                                @foreach ($clientes as $item)
                                <option value="{{$item->id}}">{{$item->persona->razon_social}}</option>
                                @endforeach
                            </select>
                            @error('cliente_id')
                            <small class="text-danger">{{ '*'.$message }}</small>
                            @enderror
                        </div>

                        <div class="col-md-12 mb-2">
                            <label for="comprobante_id" class="form-label">Comprobante:</label>
                            <select name="comprobante_id" id="comprobante_id" class="form-control selectpicker show-ticket" title="Selecciona">
                                @foreach ($comprobantes as $item)
                                <option value="{{$item->id}}">{{$item->tipo_comprobante}}</option>
                                @endforeach
                            </select>
                            @error('comprobante_id')
                            <small class="text-danger">{{ '*'.$message }}</small>
                            @enderror
                        </div>

                        <div class="col-md-12 mb-2">
                            <label for="numero_comprobante" class="form-label"># de comprobante:</label>
                            <input required type="text" name="numero_comprobante" id="numero_comprobante" class="form-control">
                            @error('numero_comprobante')
                            <small class="text-danger">{{ '*'.$message }}</small>
                            @enderror
                        </div>

                        <div class="col-md-6 mb-2">
                            <label for="impuesto" class="form-label">IVA:</label>
                            <input readonly="text" name="impuesto" id="impuesto" class="form-control border-success">
                            @error('impuesto')
                            <small class="text-danger">{{ '*'.$message }}</small>
                            @enderror
                        </div>

                        <div class="col-md-6 mb-2">
                            <label for="fecha" class="form-label">Fecha:</label>
                            <input readonly="text" name="fecha" id="fecha" class="form-control border-success" value="<?php echo date("Y/m/d") ?>">
                            <?php

                            use Carbon\Carbon;

                            $fecha_hora = Carbon::now()->toDateTimeString();
                            ?>
                            <input type="hidden" name="fecha_hora" value="{{$fecha_hora}}">
                        </div>

                        <input type="hidden" name="user_id" value="{{ auth()->user()->id }}">

                        <div class="col-md-12 mb-2 text-center">
                            <button type="submit" class="btn btn-secondary rounded-pill" id="guardar">Guardar</button>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Modal de confirmacion</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    ¿Seguro que quieres cancelar la venta?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                    <button id="btnCancelarVenta" type="button" class="btn btn-danger" data-bs-dismiss="modal">Confirmar</button>
                </div>
            </div>
        </div>
    </div>

</form>

@endsection

@push('js')
<script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.14.0-beta3/dist/js/bootstrap-select.min.js"></script>
<script>
    $(document).ready(function() {

        $('#producto_id').change(mostrarValores);

        $('#btn_agregar').click(function() {
            agregarProducto();
        });

        $('#btnCancelarVenta').click(function() {
            cancelarVenta();
        });

        disableButtons();

        $('#impuesto').val(impuesto + '%');
    });

    let cont = 0;
    let subtotal = [];
    let sumas = 0;
    let iva = 0;
    let total = 0;

    const impuesto = 19;

    function mostrarValores() {
        let dataProducto = document.getElementById('producto_id').value.split('-');
        $('#stock').val(dataProducto[1]);
        $('#precio_venta').val(Math.round(dataProducto[2]));
    }

    function agregarProducto() {
        let dataProducto = document.getElementById('producto_id').value.split('-');
        let idProducto = dataProducto[0];
        let nameProducto = $('#producto_id option:selected').text();
        let cantidad = $('#cantidad').val();
        let precioVenta = $('#precio_venta').val();
        let descuento = $('#descuento').val();
        let stock = $('#stock').val();

        if (descuento == '') {
            descuento = 0;
        }

        if (idProducto != '' && cantidad != '') {

            if (parseInt(cantidad) > 0 && (cantidad % 1 == 0) && parseFloat(descuento) >= 0) {

                if (parseInt(cantidad) <= parseInt(stock)) {

                    subtotal[cont] = round(cantidad * precioVenta - descuento);
                    sumas += subtotal[cont];
                    iva = round(sumas / 100 * impuesto);
                    total = round(sumas + iva);

                    let fila = '<tr id="fila' + cont + '">' +
                        '<th>' + (cont + 1) + '</th>' +
                        '<td><input type="hidden" name="arrayidproducto[]" value="' + idProducto + '">' + nameProducto + '</td>' +
                        '<td><input type="hidden" name="arraycantidad[]" value="' + cantidad + '">' + cantidad + '</td>' +
                        '<td><input type="hidden" name="arrayprecioventa[]" value="' + precioVenta + '">' + '$' + new Intl.NumberFormat('de-DE').format(precioVenta) + '</td>' +
                        '<td><input type="hidden" name="arraydescuento[]" value="' + descuento + '">' + '$' + new Intl.NumberFormat('de-DE').format(descuento) + '</td>' +
                        '<td>$' + new Intl.NumberFormat('de-DE').format(subtotal[cont]) + '</td>' +
                        '<td><button class="btn btn-danger" type="button" onClick="eliminarProducto(' + cont + ')"><i class="fa-solid fa-trash"></i></button></td>' +
                        '</tr>';

                    $('#tabla_detalle').append(fila);
                    limpiarCampos();
                    cont++;
                    disableButtons();

                    iva = Math.round(iva);
                    total = Math.round(total);
                    $('#sumas').html('$' + sumas.toLocaleString('es-ES'));
                    $('#iva').html('$' + new Intl.NumberFormat('de-DE').format(iva));
                    $('#total').html('$' + new Intl.NumberFormat('de-DE').format(total));
                    $('#impuesto').val(new Intl.NumberFormat('de-DE').format(iva));
                    $('#inputTotal').val(new Intl.NumberFormat('de-DE').format(total));
                } else {
                    showModal('Cantidad incorrecta');
                }

            } else {
                showModal('Valores incorrectos');
            }

        } else {
            showModal('Hay campos vacios');

        }
    }

    function eliminarProducto(indice) {
        sumas -= round(subtotal[indice]);
        iva = round(sumas / 100 * impuesto);
        total = round(sumas + iva);

        $('#sumas').html(sumas);
        $('#iva').html(iva);
        $('#total').html(total);
        $('#impuesto').val(iva);
        $('#InputTotal').val(iva);

        $('#fila' + indice).remove();

        disableButtons();

    }

    function cancelarVenta() {
        $('#tabla_detalle > tbody').empty();

        let fila = '<tr>' +
            '<th></th>' +
            '<td></td>' +
            '<td></td>' +
            '<td></td>' +
            '<td></td>' +
            '<td></td>' +
            '<td></td>' +
            '</tr>';
        $('#tabla_detalle').append(fila);

        cont = 0;
        subtotal = [];
        sumas = 0;
        iva = 0;
        total = 0;

        $('#sumas').html(sumas);
        $('#iva').html(iva);
        $('#total').html(total);
        $('#impuesto').val(impuesto + '%');
        $('#inputTotal').val(total);

        limpiarCampos();
        disableButtons();
    }

    function disableButtons() {

        if (total == 0) {
            $('#guardar').hide();
            $('#cancelar').hide();
        } else {
            $('#guardar').show();
            $('#cancelar').show();
        }
    }

    function limpiarCampos() {
        let select = $('#producto_id');
        select.selectpicker('val', '');
        $('#cantidad').val('');
        $('#precio_venta').val('');
        $('#descuento').val('');
        $('#stock').val('');

    }

    function showModal(message, icon = 'error') {
        const Toast = Swal.mixin({
            toast: true,
            position: "top-end",
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true,
            didOpen: (toast) => {
                toast.onmouseenter = Swal.stopTimer;
                toast.onmouseleave = Swal.resumeTimer;
            }
        })

        Toast.fire({
            icon: icon,
            title: message
        })
    }

    function round(num, decimales = 2) {
        var signo = (num >= 0 ? 1 : -1);
        num = num * signo;
        if (decimales === 0)
            return signo * Math.round(num);
        num = num.toString().split('e');
        num = Math.round(+(num[0] + 'e' + (num[1] ? (+num[1] + decimales) : decimales)));
        num = num.toString().split('e');
        return signo * (num[0] + 'e' + (num[1] ? (+num[1] - decimales) : -decimales));
    }
</script>
@endpush