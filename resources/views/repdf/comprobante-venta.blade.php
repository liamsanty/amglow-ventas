<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Comprobante de venta</title>
</head>
<style>
    body {
        font-family: Arial, sans-serif;
        margin: 0;
        padding: 0;
        background-color: #f4f4f4;
    }

    .boleta {
        max-width: 600px;
        margin: 20px auto;
        padding: 20px;
        background: #fff;
        border: 1px solid #ddd;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }

    .header {
        margin-bottom: 15px;
    }

    .header .column .column {
        text-align: center;
        margin-bottom: 10px;
    }

    .header .column h1 {
        font-size: 14px;
        margin-bottom: 5px;
    }

    .header .column div {
        font-size: 12px;
        margin-bottom: 5px;
    }

    .header .bordered {
        border: 1px solid #000;
        padding: 10px;
        font-size: 12px;
    }

    .datos {
        margin-bottom: 20px;
    }

    .datos div {
        font-size: 12px;
        margin-bottom: 5px;
    }

    .tabla {
        width: 100%;
        border-collapse: collapse;
        margin-bottom: 20px;
    }

    .tabla th,
    .tabla td {
        border: 1px solid #ddd;
        text-align: left;
        padding: 8px;
        font-size: 14px;
    }

    .tabla th {
        background-color: #f4f4f4;
        font-weight: bold;
    }

    .footer {
        text-align: center;
        font-size: 12px;
        margin-top: 20px;
    }

    .footer .stamp {
        display: inline-block;
        margin-top: 10px;
        font-size: 14px;
        font-weight: bold;
        color: red;
    }
</style>

<body>
    <div>
        <div class="header">
            <h3 style="text-align:center;">{{ strtoupper($venta->comprobante->nombre) }}</h3>
            <h2 style="text-align:center;">N° {{ $venta->numero_comprobante }}</h2>
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
    <!-- {{-- <h1>AMEGLO</h1>
    <div>RUC N°: 1234567890</div>
    <div></div>
    <div>CEL : 3163914534</div>
    <div>Correo : AMEGLOW_hotmail.com</div> --}} -->

    <div class="datos" style="padding-left: 20px;">
        <p>
            <strong>Nombre/Razón Social:</strong> {{strtoupper($venta->cliente->persona->razon_social)}} <br>
            <strong>Dirección:</strong> {{strtoupper($venta->cliente->persona->direccion)}} <br>
            <strong>{{strtoupper($venta->cliente->persona->documento->tipo_documento)}}:</strong> {{$venta->cliente->persona->numero_documento}} <br>
            <strong>Fecha:</strong> {{date("d/m/Y", strtotime($venta->fecha_hora))}}  <br>
            <strong>Hora:</strong> {{date("H:i", strtotime($venta->fecha_hora))}}
        </p>
    </div>


    <table class="tabla" style="padding: 20px;">
        <thead>
            <tr>
                <th>Cant.</th>
                <th>Descripcion</th>
                <th>Unidad</th>
                <th>Neto</th>
                {{-- <th>Total</th> --}}
            </tr>
        </thead>
        <tbody>
            @foreach ($venta->productos as $detalle)
            <tr>
                <td>{{$detalle->pivot->cantidad}}</td>
                {{-- <td>{{$detalle->presentacione->sigla}}</td> --}}
                <td>{{$detalle->nombre}}</td>
                <td>{{$detalle->pivot->precio_venta}}</td>
                <td>{{$detalle->pivot->cantidad * $detalle->pivot->precio_venta }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="datos">
        <p style="padding: 20px;">
            <strong>Subtotal:</strong> {{$venta->subtotal}} {{$empresa->divisa->simbolo}} <br>
            <strong>{{$empresa->abreviatura_impuesto}}: </strong>{{$venta->impuesto}} {{$empresa->divisa->simbolo}} <br>
            <strong>Total:</strong> {{$venta->total}} {{$empresa->divisa->simbolo}} <br>
            <strong>Modalidad de pago: Efectivo</strong><br>
            <strong>Cajero:</strong>{{$venta->user->empleado->razon_social ?? $venta->user->name}} <br>
        </p>
    </div>

    <div class="footer">
        NO SE HACEN DEVOLUCIONES
    </div>
</body>
</html>


