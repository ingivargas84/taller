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
            /* border: 1px solid black; */
            padding: 10px;
            width: 100%;
        }

        .tabla1 {
            margin-bottom: 7px;
        }

        .tabla1, .tabla1 th, .tabla1 td {
            border: 1px solid black;
            border-collapse: collapse;
        }
        .tabla1 td {
            padding: 5px;
            width: 85%;
            height: 25px;
            text-align: left;
            font-size: 12px;
        }

        
    </style>
</head>

<body>
    <table style="margin-bottom: -35px">
        <tr class="head">
            <td style="width:33%;">
            <h2 style="font-size: 17px"><b>PÓLIZA DE GARANTÍA 00{{$garantia[0]->no_garantia }}-{{$garantia[0]->anio}} DE ECM's NAMSA ELECTRONICS, S.A.</b></h2>
                {{-- <p>{{ $cuenta[0]->cliente->direccion }}</p> --}}
                {{-- <p>{{ $cuenta[0]->cliente->email }}</p> --}}
                {{-- <p>nit: {{ $cuenta[0]->cliente->nit }}</p> --}}
                {{-- <p>telefono: {{ $cuenta[0]->cliente->telefono }}</p> --}}
            </td>
            <td style="width:10%;text-align: right;">
                <br>
            {{-- <h3 style="text-align: center;">Cliente {{ $cuenta[0]->cliente->nombre_comercial}}</h3> --}}
            {{-- <p style="text-align: center; font-size: 14px">Saldo Actual: {{number_format($saldoA, 2,'.',',')}}</p> --}}
                <br>
            </td>
            <td style="width:33%; text-align: right;">
                                <img style="height: 50px" src="data:image/jpeg;base64,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"alt="">
            </td>
        </tr>
    </table>
    <div style="font-size: 9px">
        <h1 style="font-size: 12px">CONDICIONES GENERALES DE LA PÓLIZA</h1>
        <dl>
            <dt><b>El objeto de la Cobertura:</b></dt>
            <dd>Esta póliza de garantía cubre a una computadora automotriz (ECM, por sus siglas en inglés de Engine control Module) vendida o reparada por NAMSA ELECTRONICS.</dd>
            <dt><b>Alcance en el Tiempo:</b></dt>
            <dd>Esta garantía se extiende por Cuatro(4P) MESES a partir de la fecha de entrega de la ECM al cliente</dd>
            <dt><b>ECM Cubierta</b></dt>
            <dd>Esta póliza cubre unicamente a la ECM descrita en las condiciones particulares de la póliza y no es transferible a otra ECM.</dd>
            <dt><b>Alcande de la garantía</b></dt>
            <dd>La presente garantía incluye la reparación de fábrica del turbo unicamente por fuga por admisión o escape a fin de restaurarla concepto de buen estado de funcionamiento, sin cargo, sin cargo alguno por concepto de mano de obra y repuestos. Si pese a las reparaciones y esfuerzos realizados para restaurarla la ECM a un buen estado de funcionamiento, esto no fuere posible, NAMSA ELECTRONICS reemplazará la ECM por otra igual o, si ello no fuera posible, por otra de características similares. 
            Esta garantía sustituye cualquier otra garantía expresa, implícita o táctica, ya que NAMSA ELECIRONICS no asume ni autoriza a personas o represeñtante alguno para asumir en su nombre cualquier otro compromiso, obligación o responsabilidad con relación a la venta o reparación de la ECM amparada por esta póliza. Ninguna garantía verbal o escrita, diferente a la aqui expresada, será reconocida por NAMSA ELECTRONICS.</dd>
            <dt style="color: red"><b>Instalación de la ECM: </b></dt>
            <dd style="color: red">Es necesario que las siguientes condiciones se cumplan rigurosamente para que la ECM no se dañe durante el proceso de instalación: 
                <ul>
                    <li>
                        Debe asegurarse que no existan cortos en la unidad de transporte
                    </li>
                    <li>
                        No deben haber cambios de voltaje dentro del vehículo, pues esto es señal de cortos o cables dañados
                    </li>
                    <li>
                        Las baterías del automotor deben estar instaladas correctamente; no debe haber sarro en las terminales; y el voltaje total de las baterías, debe ser el recomendado por el fabricante del vehículo
                    </li>
                    <li>
                        Cuando la ECM se instala, debe quedar totalmente aislada, pues el contacto de la caja con cualquier parte metálica del vehículo causa un corto en la ECM
                    </li>
                </ul>
                </dd>
                <dt><b>Proceso de Reclamo:</b></dt>
                <dd>
                    Para realizar un reclamo es necesario seguir los pasos siguientes:
                    <ul>
                        <li>Presentar la póliza correspondiente a la ECM que se reclama</li>
                        <li>Permitir que NAMSA revise el vehículo, para descartar fallas en la ECM ocasionadas por cortos en el sistema eléctrico del automotor</li>
                        <li>Enviar la ECM a NAMSA ELECTRONICS o entregarla a un representante de la compañia</li>
                    </ul>
                    <b>Exclusiones: </b>
                    NAMSA ELECTRONICS, quedará liberada de prestar la garantía contenida en la presente póliza cuando: 
                    <ul>
                        <li>No se ha cumplido con las recomendaciones de instalación</li>
                        <li>La caja de la ECM está quebrada o con rajaduras</li>
                        <li>Está <b>roto el sello</b> de seguridad</li>
                        <li>La tapadera está abierta</li>
                        <li style="color:red">La ECM ha sido usada fuera de su capacidad, matratada, golpeada, expuesta a la humedad, dañada por cualquier sustancia corrosiva</li>
                        <li>Se han colocado de forma incorrecta las baterías del automotor, existan cortos circuitos o sobrecargas en el sistema electrónico del automotor;o cualquier otra causa externa, ajena a la computadora como tal </li>
                        <li>Por desgaste debido al uso</li>
                        <li>Diferente programación en ECM a la instalada por NAMSA ELECTRONICS</li>
                        <li>La ECM se coloca en un automotor que NAMSA ELECTRONICS ha declarado como no apto</li>
                        <li>La reparación o venta de la ECM no ha sido cancelada en su autoridad</li>
                        <li>La ECM ha sido previamente reparada o alterada por personal ajeno a NAMSA ELECTRONICS</li>
                        <li>Se hace uso inadecuado de la ECM o se opera en condiciones no recomendadas por el fabricante</li>
                        <li>Se borra, altera o falta el sello de garantía de NAMSA ELECTRONICS</li>
                    </ul>
                </dd>
        </dl>
    </div>
    <table class="tabla1" style="width:100%">
        <tr>
            <td>Nombre de la Empresa:</td>
            <td style="text-align: center">{{ $garantia[0]->cliente->nombre_comercial }}</td>
            <td>Fecha de Entrega:</td>
            <td style="text-align: center">{{ $garantia[0]->fecha }}</td>
        </tr>
        <tr>
            <td>Nombre de quien recibe:</td>
            <td></td>
            <td>Puesto:</td>
            <td></td>
        </tr>
        <tr>
            <td>Firma de quien recibe:</td>
            <td></td>
            <td>Sello de la Empresa</td>
            <td></td>
        </tr>
        <tr>
            <td>Firma de quien entrega:</td>
            <td></td>
            <td>Sello de NAMSA:</td>
            <td></td>
        </tr>
        <tr>
            <td>Descripción del equipo:</td>
            <td style="text-align: center">
                @if($orden[0]->equipo->descripcion != null)
                    {{ $orden[0]->equipo->descripcion }}
                @else 
                    Descripción no disponible
                @endif
            </td>
            <td># de ECM</td>
            <td style="text-align: center">{{ $orden[0]->no_orden_trabajo }}</td>
        </tr>
    </table>
        <table class="tabla1" style="width:100%">
        <tr>
            <td>Serie de motor:</td>
            <td></td>
            <td>Motor:</td>
            <td></td>
        </tr>
        <tr>
            <td>Caballaje:</td>
            <td></td>
            <td>RPM:</td>
            <td></td>
        </tr>
        <tr>
            <td>Torque:</td>
            <td></td>
            <td>Nivel de Software</td>
            <td></td>
        </tr>
    </table>
    <p style="font-size: 10px">NOTA: En caso de extravío de la presente garantía, el consumidor deberá recurrir a su proveedor, para que le sea expedida otra, previa presentación de la nota de
compra o factura respectiva.</p>
</body>

</html>