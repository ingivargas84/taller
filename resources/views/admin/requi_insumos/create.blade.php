@extends('admin.layoutadmin')

@section('header')
<section class="content-header">
    <h1>
        Requisición de Insumos
        <small>Registrar una Requisición</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{route('dashboard')}}"><i class="fa fa-tachometer-alt"></i> Inicio</a></li>
        <li><a href="{{route('requi_insumos.index')}}"><i class="fa fa-list"></i> Requisición de Insumos</a></li>
        <li class="active">Crear</li>
    </ol>
</section>
@stop

@section('content')
<form method="POST" id="RequiInsumosForm" action="{{route('requi_insumos.save')}}" autocomplete="off">
    {{csrf_field()}}
    <div class="col-md-12">
        <div class="box box-primary">
            <div class="box-body">
                <div class="row">
                    <div class="col-md-6 col-sm-6">
                        <label for="usuario_id">Usuario que Solicita:</label>
                        <input disabled type="text" class="form-control" name="usuario_id" placeholder="Usuario" id="usuario_id" value="{{$usuario}}">
                    </div>
                    <div class="col-md-6 col-sm-6">
                        <label for="fecha">Fecha:</label>
                        <input disabled type="text" class="form-control" name="fecha" placeholder="Fecha" id="fecha"  value="{{$today}}">
                    </div>
                </div>
                <br>
                <div class="row">
                    <div class="col-md-12 col-sm-12">
                        <label for="justificacion">Justificación:</label>
                        <input type="text" class="form-control" name="justificacion" placeholder="Justificación" id="justificacion" >
                    </div>
                </div>
                <hr>
                <div class="row">
                    <div class="col-md-6 col-sm-6">
                        <label for="insumo_id">Insumo:</label>
                        <select name="insumo_id" class="selectpicker form-control" data-live-search="true" id="insumo_id" tabindex="5">
                            <option value="default">Seleccione un Insumo</option>
                            @foreach ($insumos as $in)
                            <option value="{{$in->id}}">{{$in->nombre_insumo}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-3 col-sm-3">
                        <label for="existencias">Existencias Disponibles en Bodega:</label>
                        <input disabled type="number" class="form-control" placeholder="Existencias" name="existencias" id="existencias" tabindex="6">
                    </div>
                    <div class="col-md-3 col-sm-3">
                        <label for="cantidad">Cantidad Solicitada:</label>
                        <input type="number" class="form-control" placeholder="Cantidad" name="cantidad" id="cantidad" tabindex="6">
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-6">
                        <div class="text-left m-t-15">
                            <h3>Detalle</h3>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="text-right m-t-15" style="margin-top: 15px; margin-bottom: 10px">
                            <button id="agregar-detalle" class="btn btn-success form-button">Agregar al detalle</button>
                        </div>
                    </div>
                </div>
                <br>
                <table id="detalle-table" class="table table-striped table-bordered no-margin-bottom dt-responsive nowrap" width="100%">
                </table>

                <div class="text-right m-t-15">
                    <a class='btn btn-primary form-button' href="{{ route('requi_insumos.index') }}">Regresar</a>
                    <button id="ButtonRequiInsumos" class="btn btn-success form-button">Guardar</button>
                </div>
                <br>

            </div>
        </div>
    </div>
</form>
<div class="loader loader-bar"></div>
@stop


@push('styles')

<style>
    div.col-md-6 {
        margin-bottom: 15px;
    }

    .customreadonly {
        background-color: #eee;
        cursor: not-allowed;
        pointer-events: none;
    }

    .switch-field {
        display: flex;
        margin-bottom: 20px;
        overflow: hidden;
    }

    .switch-field input {
        position: absolute !important;
        clip: rect(0, 0, 0, 0);
        height: 1px;
        width: 1px;
        border: 0;
        overflow: hidden;
    }

    .switch-field label {
        background-color: #e4e4e4;
        color: rgba(0, 0, 0, 0.6);
        font-size: 14px;
        line-height: 1;
        text-align: center;
        padding: 8px 16px;
        margin-right: -1px;
        border: 1px solid rgba(0, 0, 0, 0.2);
        box-shadow: inset 0 1px 3px rgba(0, 0, 0, 0.3), 0 1px rgba(255, 255, 255, 0.1);
        transition: all 0.1s ease-in-out;
        width: 50%
    }

    .switch-field label:hover {
        cursor: pointer;
    }

    .switch-field input:checked+label {
        background-color: #55bd8c;
        box-shadow: none;
    }

    .switch-field label:first-of-type {
        border-radius: 4px 0 0 4px;
    }

    .switch-field label:last-of-type {
        border-radius: 0 4px 4px 0;
    }

</style>

@endpush

@push('scripts')

<script>


    $("#insumo_id").change(function () {
	    var insumo_id = $("#insumo_id").val();
	    var url = "/requi_insumos/getInsumo/" + insumo_id ;
	    if (insumo_id != "") {
		    $.getJSON( url , function ( result ) {
			    $("input[name='existencias'] ").val(result[0].existencias);
		    });
	    }
    });


    function chkflds() {
        if ( $('#cantidad').val() ) {
            return true
        } else {
            return false
        }
    }


    $('#agregar-detalle').click(function(e) {
        e.preventDefault();

        var existencias = $("#existencias").val();
        var cantidad = $("#cantidad").val();

        if (chkflds()) {
            
                detalle_table.row.add({
                    'insumo_id': $('#insumo_id').val(),
                    'insumo': $("#insumo_id").find('option:selected').text(),
                    'cantidad': $('#cantidad').val()
                }).draw();

                $('#insumo_id').val('default');
                $('#insumo_id').focus();
                $('#cantidad').val(null);
            
        } else {
            alertify.set('notifier', 'position', 'top-center');
            alertify.error('Debe seleccionar un insumo o ingresar una cantidad')
        }
    });



    $(document).on('click', '#ButtonRequiInsumos', function(e) {
        e.preventDefault();      

        if ($('#RequiInsumosForm').valid()) {

            var arr1 = $('#RequiInsumosForm').serializeArray();
            var arr2 = detalle_table.rows().data().toArray();
            var arr3 = arr1.concat(arr2);

            $.ajax({
                type: 'POST',
                url: "{{route('requi_insumos.save')}}",
                headers: {
                    'X-CSRF-TOKEN': $('#tokenReset').val(), 
                },
                data: JSON.stringify(arr3), 
                dataType: 'json',
                success: function() {
                    $('#insumo_id').val('default');
                    $('#cantidad').val(null);
                    detalle_table.rows().remove().draw();
                    window.location.assign('/requi_insumos')
                },
                error: function() {
                    alertify.set('notifier', 'position', 'top-center');
                    alertify.error('Hubo un error al registrar la requisición')
                }
            })
        }
    });

</script>

<script src="{{asset('js/requi_insumos/detalle.js')}}"></script>{{-- datatable --}}
<script src="{{asset('js/requi_insumos/create.js')}}"></script>{{-- validator --}}
@endpush
