@extends('admin.layoutadmin')

@section('header')
<section class="content-header">
    <h1>
        Requisicion de Insumos
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{route('dashboard')}}"><i class="fa fa-tachometer-alt"></i> Inicio</a></li>
        <li><a href="{{route('requi_insumos.index')}}"><i class="fa fa-list"></i> Requisicion de Insumos</a></li>
        <li class="active">Ver</li>
    </ol>
</section>
@stop

@section('content')
<form id="RequisicionInsumosForm">
    {{csrf_field()}}
    <div class="col-md-12">
        <div class="box box-primary">
            <div class="box-body">
                <div class="row">
                    <div class="col-md-12 col-sm-12 text-center">
                        <h2><strong>Información de la Requisicion</strong></h2>
                    </div>
                </div>
                <br>
                <div class="row">
                    <div class="col-md-6 col-sm-6">
                        <h4><strong>Usuario que registró:</strong> {{$requisicionmaestro[0]->user_crea}} </h4>
                    </div>
                    <div class="col-md-6 col-sm-6">
                        <h4><strong>Fecha de registro:</strong> {{Carbon\Carbon::parse($requisicionmaestro[0]->created_at)->format('d-m-Y H:m:s')}} </h4>
                    </div>
                </div>
                <br>
                <div class="row">
                    <div class="col-md-12 col-sm-12">
                        <h4><strong>Justificación:</strong> {{$requisicionmaestro[0]->justificacion}} </h4>
                    </div>
                </div>
                <br>
                @if ($requisicionmaestro[0]->estado_requisicion_id == 1) 
                <div class="row">
                    <div class="col-md-2 col-sm-2">
                        <h3><strong>Estado:</strong> </h3>
                    </div>
                    <div class="col-md-2 col-sm-2">
                        <h3 style="color:green"><strong>Creada</strong> </h3>
                    </div>
                    <div class="col-md-4 col-sm-4">
                    </div>
                    <div class="col-md-4 col-sm-4">
                    </div>
                </div>
                @elseif ($requisicionmaestro[0]->estado_requisicion_id == 2)
                <div class="row">
                    <div class="col-md-2 col-sm-2">
                        <h3><strong>Estado:</strong> </h3>
                    </div>
                    <div class="col-md-2 col-sm-2">
                        <h3 style="color:red"><strong>Rechazada</strong> </h3>
                    </div>
                    <div class="col-md-4 col-sm-4">
                        <h4><strong>Usuario Rechaza:</strong> {{$requisicionmaestro[0]->user_rechaza}} </h4>
                    </div>
                    <div class="col-md-4 col-sm-4">
                        <h4><strong>Fecha Rechaza:</strong> {{Carbon\Carbon::parse($requisicionmaestro[0]->fecha_rechaza)->format('d-m-Y H:m:s')}} </h4>
                    </div>
                </div>
                <br>    
                <div class="row">
                    <div class="col-md-12 col-sm-12">
                        <h4><strong>Razón de Rechazo:</strong> {{$requisicionmaestro[0]->razon_rechaza}} </h4>
                    </div>
                </div>
                @elseif ($requisicionmaestro[0]->estado_requisicion_id == 3)
                <div class="row">
                    <div class="col-md-2 col-sm-2">
                        <h3><strong>Estado:</strong> </h3>
                    </div>
                    <div class="col-md-2 col-sm-2">
                        <h3 style="color:green"><strong>Autorizada</strong> </h3>
                    </div>
                    <div class="col-md-4 col-sm-4">
                        <h4><strong>Usuario Autoriza:</strong> {{$requisicionmaestro[0]->user_autoriza}} </h4>
                    </div>
                    <div class="col-md-4 col-sm-4">
                        <h4><strong>Fecha Autoriza:</strong> {{Carbon\Carbon::parse($requisicionmaestro[0]->fecha_autoriza)->format('d-m-Y H:m:s')}} </h4>
                    </div>
                </div>
                @elseif ($requisicionmaestro[0]->estado_requisicion_id == 4)
                <div class="row">
                    <div class="col-md-2 col-sm-2">
                        <h3><strong>Estado:</strong> </h3>
                    </div>
                    <div class="col-md-2 col-sm-2">
                        <h3 style="color:orange"><strong>Entregada</strong> </h3>
                    </div>
                    <div class="col-md-4 col-sm-4">
                        <h4><strong>Usuario Autoriza:</strong> {{$requisicionmaestro[0]->user_autoriza}} </h4>
                    </div>
                    <div class="col-md-4 col-sm-4">
                        <h4><strong>Fecha Autoriza:</strong> {{Carbon\Carbon::parse($requisicionmaestro[0]->fecha_autoriza)->format('d-m-Y H:m:s')}} </h4>
                    </div>
                </div>
                <br>
                <div class="row">
                    <div class="col-md-4 col-sm-4">
                    </div>
                    <div class="col-md-4 col-sm-4">
                        <h4><strong>Usuario Entrega:</strong> {{$requisicionmaestro[0]->user_entrega}} </h4>
                    </div>
                    <div class="col-md-4 col-sm-4">
                        <h4><strong>Fecha Entrega:</strong> {{Carbon\Carbon::parse($requisicionmaestro[0]->fecha_entrega)->format('d-m-Y H:m:s')}} </h4>
                    </div>
                </div>

                @endif
                <br>
                <table border="1" cellspacing=0 cellpadding=2 width= 800 class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th width=60% style="font-size:15px; text-align:left;">Insumo</th>
                                <th width=40% style="font-size:15px; text-align:center;">Cantidad</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($requisiciondetalle as $md)
                            <tr>
                                <td style="font-size:13px; text-align:left;">{{$md->nombre_insumo}}</td>
                                <td style="font-size:13px; text-align:center;">{{ $md->cantidad }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                        </table>
                        <br>
                    <div class="text-right m-t-15">
                    <a class='btn btn-primary form-button' href="{{ route('requi_insumos.index') }}">Regresar</a>
                </div>
                
            </div>
        </div>
    </div>
</form>
<div class="loader loader-bar"></div>
@stop


@push('styles')

@endpush
