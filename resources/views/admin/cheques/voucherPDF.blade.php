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

        table {
            padding: 10px;
            margin-bottom: 7px;
            width: 100%;
        }

        #datos, #datos td  {
            width: 300px;
            border: 1px solid black;
            border-collapse: collapse;
            margin-left: 20%;
            font-size: 13px;
            text-align: center;
        }
    </style>
</head>

<body>
    <table>
        <tr class="head">
            <td style="width:33%; text-align: right;">
                <span style="margin-top: -10px;">VOUCHER 00{{ strtoupper($voucher[0]->no_voucher) }}-{{ $voucher[0]->anio }}</span>
            </td>
        </tr>
    </table>
    <table>
        <tr>
            <td>  
                <span style="margin-left: 41%;">GUATEMALA,  {{strtoupper(date('d', strtotime($voucher[0]->created_at )))}} DE {{ strtoupper($mes) }} DEL {{ strtoupper(date('Y', strtotime($voucher[0]->created_at )))}}</span>  
            </td>
            <td style="text-align: right;">
                <span><b> Q. {{ $cheque->cantidad }}</b></span>
            </td> 
        </tr>
         <tr style="margin-left: 35%; text-align: center">
            <td style="margin-left: 35%; text-align: center">
                <span style="margin-left: 35%; text-align: center"><b  style="margin-left: 35%; text-align: center">{{ strtoupper($cheque->receptor) }}</b></span>
            </td>
        </tr>
        <tr style="margin-left: 35%; text-align: center">
            <td style="margin-left: 35%; text-align: center">
                <span style="margin-left: 35%; text-align: center">{{ strtoupper($letras)}}</span>
            </td>
        </tr>
    </table>
    <br>
    <br>
    <br>
    <br>
    <br>
    <table id="datos">
        <tr>
            <td>CUENTA</td>
            <td>{{ strtoupper($cuenta->nombre_cuenta) }}-{{ strtoupper($cuenta->banco->banco) }}</td>
        </tr>
        <tr>
            <td >RECIBE</td>
            <td >{{ strtoupper($voucher[0]->receptor) }}</td>
        </tr>
    </table>
    <table style="margin-left: 15%;">
        <tr style="margin-left: 15%;">
            <td style="margin-left: 15%;">{{ strtoupper($cheque->descripcion) }}</td>
        </tr>
    </table>
    <br>
    <br>
    <br>
    <br>
    <br>
    <table style=" font-size: 12px;">
       <tr>
            <td style="margin-left: 4%;text-align: center; width: 50%">
                ________________________________________
            </td>
            <td style="text-align: center;">
                ________________________________________
            </td>
       </tr>
       <tr style="text-align: right">
           <td style="text-align: center;">HECHO POR {{ strtoupper($empleado->name) }}</td>
                <td style="text-align: center;">FIRMA DE ACEPTACION {{ strtoupper($voucher[0]->receptor) }}</td>

        </tr>
    </table>
</body>

</html>