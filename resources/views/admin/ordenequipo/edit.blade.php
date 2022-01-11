@extends('admin.layoutadmin')

@section('header')
<section class="content-header">
    <h1>
        Ordenes de Trabajo
        <small>Editar Orden de Trabajo</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{route('dashboard')}}"><i class="fa fa-tachometer-alt"></i> Inicio</a></li>
        <li><a href="{{route('ordenequipo.index')}}"><i class="fa fa-list"></i> Orden de Trabajo</a></li>
        <li class="active">Editar</li>
    </ol>
</section>
@stop

@section('content')
<form method="POST" id="OrdenTrabajoUpdateForm" action="{{route('ordenequipo.update', $ordenequipo)}}">
    {{csrf_field()}} {{ method_field('PUT') }}
    <div class="col-md-12">
        <div class="box box-primary">
            <div class="box-body">
                <div class="row">
                    <div class="col-sm-6">
                    <label for="no_comprobante">No Comprobante:</label>
                        <input type="text" disabled class="form-control" placeholder="No Comprobante:" name="no_comprobante" id="no_comprobante" value="{{old('no_comprobante', $ordenequipo->no_comprobante)}}">
                    </div>
                    <div class="col-sm-6">
                        <label for="cliente_id">Cliente:</label>
                        <select class="form-control" name="cliente_id" id="cliente_id">
                            <option value="">Selecciona Cliente</option>
                            @foreach($cliente as $cl)
                            @if($cl->id == $ordenequipo->cliente_id)
                            <option value="{{ $cl->id }}" selected>{{ $cl->nombre_comercial }}</option>
                            @else
                            <option value="{{ $cl->id }}">{{ $cl->nombre_comercial }}</option>
                            @endif
                            @endforeach
                        </select>
                    </div>
                </div>
                <br>
                <div class="row">
                    <div class="form-group col-sm-6">
                        <label for="equipo_id">Equipo:</label>
                        <select class="form-control" name="equipo_id" id="equipo_id">
                            <option value="">Selecciona Equipo</option>
                            @foreach($equipo as $tp)
                            @if($tp->id == $ordenequipo->equipo_id)
                            <option value="{{ $tp->id }}" selected>{{ $tp->equipo }}</option>
                            @else
                            <option value="{{ $tp->id }}">{{ $tp->equipo }}</option>
                            @endif
                            @endforeach
                        </select>
                        
                    </div>
                    <div class="form-group col-sm-4">
                        <label for="tipo_trabajo_id">Tipo Trabajo:</label>
                        <select class="form-control" name="tipo_trabajo_id" id="tipo_trabajo_id">
                            <option value="">Selecciona Tipo Trabajo</option>
                            @foreach($tipo_trabajo as $tt)
                            @if($tt->id == $ordenequipo->tipo_trabajo_id)
                            <option value="{{ $tt->id }}" selected>{{ $tt->nombre }}</option>
                            @else
                            <option value="{{ $tt->id }}">{{ $tt->nombre }}</option>
                            @endif
                            @endforeach
                        </select>
                        
                    </div>
                </div>
                <br>
                <div class="row">
                    <div class="col-sm-12">
                        <label for="observaciones">Observaciones:</label>
                        <textarea type="text" rows="4" class="form-control" placeholder="Observaciones:" id="observaciones" name="observaciones">{{old('observaciones', $ordenequipo->observaciones)}}</textarea>
                        
                    </div>
                </div>
                <br>
                <div class="text-right m-t-15">
                    <a class='btn btn-primary form-button' href="{{ route('ordenequipo.index') }}">Regresar</a>
                    <button class="btn btn-success form-button" id="ButtonOrdenUpdate">Editar</button>
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

<script src="{{asset('js/ordenequipo/edit.js')}}"></script>
@endpush