@extends('admin.layoutadmin')

@section('header')
<section class="content-header">
    <h1>
        Rechazar Requisición
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{route('dashboard')}}"><i class="fa fa-tachometer-alt"></i> Inicio</a></li>
        <li><a href="{{route('requi_insumos.index')}}"><i class="fa fa-list"></i> Requisición de Insumos</a></li>
        <li class="active">Crear</li>
    </ol>
</section>
@stop

@section('content')
<form method="POST" id="RequiInsumosRechazaForm" action="{{route('requi_insumos.rechazar')}}" autocomplete="off">
    {{csrf_field()}}
    <div class="col-md-12">
        <div class="box box-primary">
            <div class="box-body">
                <div class="row">
                    <div class="col-md-3 col-sm-3">
                        <label for="requi">Id de Requisición:</label>
                        <input type="text" class="form-control" name="requi" placeholder="Usuario" id="requi" value="{{$requisicion_maestro->id}}">
                    </div>
                    <div class="col-md-9 col-sm-9">
                        <label for="razon">Razón del Rechazo:</label>
                        <input type="text" class="form-control" name="razon" placeholder="Razón de Rechazo" id="razon">
                    </div>
                </div>
                <br>
                <div class="text-right m-t-15">
                    <a class='btn btn-primary form-button' href="{{ route('requi_insumos.index') }}">Regresar</a>
                    <button id="ButtonRequiInsumosRechazo" class="btn btn-success form-button">Guardar</button>
                </div>
                <br>

            </div>
        </div>
    </div>
</form>
<div class="loader loader-bar"></div>
@stop


@push('styles')

@endpush

@push('scripts')

@endpush
