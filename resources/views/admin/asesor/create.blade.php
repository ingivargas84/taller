@extends('admin.layoutadmin')

@section('header')
<section class="content-header">
    <h1>
        Ordenes de Trabajo en Taller
        <small>Introducir Diagnóstico</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{route('dashboard')}}"><i class="fa fa-tachometer-alt"></i> Inicio</a></li>
        <li><a href="{{route('taller.index')}}"><i class="fa fa-list"></i> Ordenes en Taller</a></li>
        <li class="active">Diagnóstico</li>
    </ol>
</section>
@stop

@section('content')
<form method="POST" id="TallerDiagnosticoForm" action="{{route('taller.save', $taller)}}">
    {{csrf_field()}}
    <div class="col-md-12">
        <div class="box box-primary">
            <div class="box-body">
                <div class="row">
                    <div class="form-group col-sm-4">
                        <h4><strong>No Comprobante:</strong> {{$ordenequipo->no_comprobante}}</h4>
                        <input type="hidden" class="form-control" name="orden" id="orden" value="{{$taller->ordenequipo_id}}">
                    </div>
                    <div class="form-group col-sm-4">
                        <h4><strong>Equipo:</strong> {{$equipo->equipo}}</h4>
                    </div>
                    <div class="form-group col-sm-4">
                        <h4><strong>Cliente:</strong> {{$cliente->nombre_comercial}}</h4>
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-sm-12">
                        <h4><strong>Observaciones de la Orden:</strong> {{$ordenequipo->observaciones}}</h4>
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-sm-12">
                        <h4><strong>Diagnóstico de Taller:</strong> {{$taller->trabajos_realizados}}</h4>
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-sm-12">
                        <h4><strong>Observaciones de Taller:</strong> {{$taller->observaciones}}</h4>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4 col-sm-4">
                        <label for="dias_reparacion">Dias Reparación:</label>
                        <input type="text" class="form-control" name="dias_reparacion" id="dias_reparacion" value="{{$taller->dias_reparacion}}">
                    </div>
                    <div class="col-md-4 col-sm-4">
                    </div>
                    <div class="col-md-4 col-sm-4">
                        <label for="total">Total:</label>
                        <input type="text" class="form-control" name="total" id="total" value="{{$ordenequipo->total_cobrar}}">
                    </div>
                </div>
                <br>
                <table id="detalle-table" class="table table-striped table-bordered no-margin-bottom dt-responsive nowrap" width="100%">
                </table>
                <br>

                <hr>
                <div class="text-right m-t-15">
                    <a class='btn btn-primary form-button' href="{{ route('asesor.index') }}">Regresar</a>
                    <button class="btn btn-success form-button" id="ButtonTallerDiagnostico">Guardar</button>
                </div>

            </div>
        </div>
    </div>
</form>
&nbsp;
<div class="loader loader-bar"></div>
@stop


@push('styles')

<style>
    .customreadonly{
        background-color: #eee;
        cursor: not-allowed;
        pointer-events: none;
        }
</style>

@endpush


@push('scripts')
<script>


$("#TallerDiagnosticoForm").show(function () {

var orden = $("#orden").val();

var url = "/asesor/getdiagnostico/" + orden ;
if (orden != "") {
    $.getJSON( url , function ( result ) {
        
        $filas = result.length;

        for(i=0; i<$filas; i++)
        {
            detalle_table.row.add({
            'nombre_id': result[i].codigo,
            'id': result[i].id,
            'nombre': result[i].nombre,
            'cantidad': result[i].cantidad,
            'precio_unitario': result[i].precio,
            'subtotal': result[i].subtotal,
        }).draw();
    }

    });
}
});



</script>


<script src="{{asset('js/asesor/detalle_edit.js')}}"></script>
@endpush
