<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reporte de Ventas por Producto</title>
</head>

<style>
    body {
        font-family: Arial, sans-serif;
        margin: 0;
        padding: 0;
        background-color: #f4f4f4;
    }
</style>

<body>
    <div >
        <div class="header">
            <h3 style="text-align:center;">Reporte de Ventas por Producto</h3>
            <h2 style="text-align:center;">Desde: {{$fecIni}} Hasta: {{$fecFin}}</h2>
            <hr>
        </div>
        <h1 style="text-align: center;">{{$empresa->nombre}}</h1>
        <div style="padding: 20px; margin: 0px;">
            <p style="padding: 0;">
                <strong>RUC N°:     </strong> {{$empresa->ruc}} <br>
                <strong>Dirección:  </strong> {{strtoupper($empresa->direccion)}} - {{strtoupper($empresa->ubicacion)}} <br>
                <strong>Telefono:   </strong> {{$empresa->telefono ?? ''}}<br>
                <strong>Correo :    </strong> {{$empresa->correo ?? ''}}
            </p>
        </div>
    </div>
    <div style="border: 1px solid #ccc; margin: 20px;">
        <div style="border-bottom: 1px solid #ccc; text-align:center; font-weight:bold"> 
            <i class="fas fa-table me-1"></i>  
            Venta de productos x fechas 
        </div>
        <div class="">
            <table id="datatablesSimple">
                <thead style="text-align:start;">
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
                <tbody style="text-align:start">
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
</body>
</html>
