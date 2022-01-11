@extends('admin.layoutadmin')

@section('header')
<section class="content-header">
    <h1>
        Compra de Insumos
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{route('dashboard')}}"><i class="fa fa-tachometer-alt"></i> Inicio</a></li>
        <li><a href="{{route('compra_insumos.index')}}"><i class="fa fa-list"></i> Compra de Insumos</a></li>
        <li class="active">Ver</li>
    </ol>
</section>
@stop

@section('content')
<form id="CompraInsumosForm">
    {{csrf_field()}}
    <div class="col-md-12">
        <div class="box box-primary">
            <div class="box-body">
                <div class="row">
                    <div class="col-md-12 col-sm-12 text-center">
                        <h2><strong>Información de la Compra</strong></h2>
                    </div>
                </div>
                <br>
                <div class="row">
                    <div class="col-md-4 col-sm-4">
                        <h4><strong>Serie Documento:</strong> {{$insumosmaestro[0]->serie_factura}} </h4>
                    </div>
                    <div class="col-md-4 col-sm-4">
                        <h4><strong>Número Documento:</strong> {{$insumosmaestro[0]->num_factura}} </h4>
                    </div>
                    <div class="col-md-4 col-sm-4">
                        <h4><strong>Fecha Documento:</strong>{{Carbon\Carbon::parse($insumosmaestro[0]->fecha_factura)->format('d-m-Y')}}</h4>
                    </div>
                </div>
                <br>
                <div class="row">
                    <div class="col-md-6 col-sm-6">
                        <h4><strong>Proveedor:</strong> {{$insumosmaestro[0]->nombre_comercial}} </h4>
                    </div>
                    <div class="col-md-6 col-sm-6">
                            @if ($insumosmaestro[0]->estado_id == 1) 
                                <h3 style="color:green"><strong>Registrado</strong> </h3>
                            @elseif ($insumosmaestro[0]->estado_id == 3)
                                <h3 style="color:red"><strong>Anulado</strong> </h3>
                            @endif
                    </div>
                </div>
                <br>
                <div class="row">
                    <div class="col-md-6 col-sm-6">
                        <h4><strong>Usuario que registró:</strong> {{$insumosmaestro[0]->name}} </h4>
                    </div>
                    <div class="col-md-6 col-sm-6">
                        <h4><strong>Fecha de registro:</strong> {{Carbon\Carbon::parse($insumosmaestro[0]->created_at)->format('d-m-Y H:m:s')}} </h4>
                    </div>
                </div>
                <br>
                <table border="1" cellspacing=0 cellpadding=2 width= 800 class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th width=40% style="font-size:15px; text-align:left;">Insumo</th>
                                <th width=20% style="font-size:15px; text-align:center;">Cantidad</th>
                                <th width=20% style="font-size:15px; text-align:right;">Precio Compra</th>
                                <th width=20% style="font-size:15px; text-align:right;">Subtotal</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($insumosdetalle as $md)
                            <tr>
                                <td style="font-size:13px; text-align:left;">{{$md->nombre_insumo}}</td>
                                <td style="font-size:13px; text-align:center;">{{ $md->cantidad }}</td>
                                <td style="font-size:13px; text-align:right;">Q. {{{number_format((float) $md->precio_compra, 2) }}}</td>
                                <td style="font-size:13px; text-align:right;">Q. {{{number_format((float) $md->subtotal, 2) }}}</td>
                            </tr>
                            @endforeach
                        </tbody>
                        </table>
                        <br>
                        <div class="row">
                            <div class="col-md-12 col-sm-12 text-right">
                                <h4><strong>Total:</strong> Q. {{{number_format((float) $insumosmaestro[0]->total, 2) }}} </h4>
                            </div>
                        </div>
                        <br>
                    <div class="text-right m-t-15">
                    <a class='btn btn-primary form-button' href="{{ route('compra_insumos.index') }}">Regresar</a>
                </div>
                
            </div>
        </div>
    </div>
</form>
<div class="loader loader-bar"></div>
@stop


@push('styles')

@endpush
