@extends('admin.layoutadmin')

@section('header')
<section class="content-header">
    <h1>
        Orden en Taller - Registro Final de Taller
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{route('dashboard')}}"><i class="fa fa-tachometer-alt"></i> Inicio</a></li>
        <li><a href="{{route('taller.index')}}"><i class="fa fa-list"></i> Ordenes en Taller</a></li>
        <li class="active">Registro Final</li>
    </ol>
</section>
@stop

@section('content')
<form method="POST" id="TallerFinalForm" action="{{route('taller.save5', $ordenequipo)}}">
    {{csrf_field()}}
    <div class="col-md-12">
        <div class="box box-primary">
            <div class="box-body">
                <div class="row">
                    <div class="form-group col-sm-6">
                        <h4><strong>No Comprobante:</strong> {{$ordenequipo->no_comprobante}}</h4>
                    </div>
                    <div class="form-group col-sm-6">
                        <h4><strong>Equipo:</strong> {{$equipo->equipo}}</h4>
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-sm-12">
                        <h4><strong>Observaciones:</strong> {{$ordenequipo->observaciones}}</h4>
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-sm-12">
                        <h4><strong>Diagnóstico de Taller:</strong> {{$taller->trabajos_realizados}}</h4>
                    </div>
                    <div class="form-group col-sm-12">
                        <h4><strong>Observaciones de Taller:</strong> {{$taller->observaciones}}</h4>
                    </div>
                </div>
                <hr>
                <div class="row">
                    <div class="form-group col-sm-12">
                        <label for="detalle_diagnostico">Observaciones / Trabajos Finales:</label>
                        <textarea type="text" rows=10 class="form-control" placeholder="Observaciones / Trabajos Finales:" name="detalle_diagnostico">{{$taller->detalle_diagnostico}}</textarea>
                    </div>
                </div>
                <hr>
                <div class="text-right m-t-15">
                    <a class='btn btn-primary form-button' href="{{ route('taller.index') }}">Regresar</a>
                    <button class="btn btn-success form-button" id="ButtonRegistraReparacionFinal">Guardar</button>
                </div>

            </div>
        </div>
    </div>
</form>
<div class="loader loader-bar"></div>
@stop


@push('styles')

@endpush


@push('scripts')

<script src="{{asset('js/taller/create5.js')}}"></script>
@endpush
