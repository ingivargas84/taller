<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Document</title>
    <style>
        .head {
            padding: 10px;
        }
        body {
            font-size: 20px;
        }

        .tableFecha {
            /* padding: 10px; */
            margin-top: 130px; 
        } 

        /* .tableCliente {
            margin-top: -100px;
        } */

        .dia {
            margin: 30px;
        }

        .mes {
            margin: 15px;
        }

        .anio {
            margin-left: 8px;
        }
    </style>
</head>
<body>
  <br>
  <br>
   <table class="tableFecha">
        <p style="margin-left: 73%;">                
                <span><span class="dia">{{$dia}}</span>  <span class="mes">{{ $mes}}</span> <span class="anio">{{ $anio}}</span></span>
        </p>
    </table>
    @if($factura[0]->cliente_id != null)
        <table class="tableCliente" style="margin-top: -113px; font-size:15px">
            <p style="margin-top: -10px">
                <span style="margin-left: 10%;">{{ $factura[0]->clienteR->nombre_comercial }}</span>
                <span style="margin-left: 88%; margin-top: -4px">{{ $factura[0]->clienteR->nit }}</span>
            </p>
        </table>
        <p><span style="display: block; margin-top:-10px; margin-left: 10%;  font-size:15px">{{ $factura[0]->direccion }}</span></p>
    @elseif($factura[0]->cliente != null)
        <table class="tableCliente" style="margin-top: -113px; font-size:15px">
            <p style="margin-top: -10px">
                <span style="margin-left: 10%;">{{ $factura[0]->cliente }}</span>
                <span style="margin-left: 88%; margin-top: -4px">{{ $factura[0]->nit }}</span>
            </p>
        </table>
        <p><span style="display: block; margin-top:-13px; margin-left: 10%;  font-size:15px">{{ $factura[0]->direccion }}</span></p>
    @else
        <table class="tableCliente" style="margin-top: -113px; font-size:15px">
                <p style="margin-top: -1px">
                    <span style="margin-left: 10%;">{{ $factura[0]->nit }}</span>
                    <span style="margin-left: 83%; margin-top: -4px; font-size:14px">{{ $factura[0]->nit }}</span>
                </p>
        </table>
        <p><span style="display: block; margin-top:-10px; margin-left: 10%;  font-size:15px">{{ $factura[0]->direccion }}</span></p>
    @endif
    <table style="font-size: 14px; height: 310px;  width: 100%; margin-left: 10px; padding-top:-40px">
      <tbody style="text-align:right">
            @foreach($factura[0]->orden->diagnostico as $d)
                <tr>
                <td>
                    {{ $d->cantidad }}
                </td>
                <td>
                    {{ $d->nombre }}
                </td>
                <td>
                    
                </td>
                <td></td>
                <td></td>
                <td>
                    {{ $d->subtotal }}
                </td>
            </tr>
                @endforeach 
        </tbody>
    </table>
    {{-- <p><span style="display: block; margin-top:-20px;  margin-left: 92%;">{{ number_format($factura[0]->monto,2,'.',',') }}</span></p> --}}
    
 <table>
        <p style="margin-left: 10%; font-size: 13px;">
            <span style="display: block; margin-top:-65px; margin-left: 10%; ">{{ $letras }}</span>
        </p>
    </table>
    <p><span style="display: block; margin-top:-65px; margin-left: 94%;">{{ number_format($factura[0]->monto,2,'.',',') }}</span></p>
  
</body>

</html>