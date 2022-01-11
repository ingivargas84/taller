@extends('admin.layoutadmin')

@section('header')
<section class="content-header">
    <h1>
        Ordenes de Trabajo
        <small>Crear Orden de Trabajo</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{route('dashboard')}}"><i class="fa fa-tachometer-alt"></i> Inicio</a></li>
        <li><a href="{{route('ordenequipo.index')}}"><i class="fa fa-list"></i> Orden de Trabajo</a></li>
        <li class="active">Crear</li>
    </ol>
</section>
@stop

@section('content')
<form method="POST" id="OrdenForm" action="{{route('ordenequipo.save')}}">
    {{csrf_field()}}
    <div class="col-md-12">
        <div class="box box-primary">
            <div class="box-body">
                <div class="row">
                    <div class="col-sm-4">
                        <label for="no_comprobante">No Comprobante:</label>
                        <input type="text" class="form-control" placeholder="No Comprobante:" name="no_comprobante" id="no_comprobante">
                    </div>
                    <div class="col-sm-8">
                        <label for="cliente_id">Cliente:</label>
                        <select id="cliente_id" class="selectpicker form-control" data-live-search="true" name="cliente_id">
                            <option value="default">Selecciona Cliente</option>
                            @foreach($cliente as $cl)
                            <option value="{{ $cl->id }}">{{ $cl->nombre_comercial }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <br>
                <div class="row">
                    <div class="col-sm-12">
                        <label for="observaciones">Observaciones:</label>
                        <textarea type="text" rows=4 class="form-control" placeholder="Observaciones:" id="observaciones" name="observaciones"></textarea>
                    </div>
                </div>
                <br>
                <div class="row">
                    <div class="form-group col-sm-6">
                        <label for="equipo_id">Equipo:</label>
                        <select class="form-control" name="equipo_id" id="equipo_id">
                            <option value="default">Selecciona Equipo</option>
                            @foreach($equipo as $eq)
                            <option value="{{ $eq->id }}">{{ $eq->equipo }}</option>
                            @endforeach
                        </select>
                    </div>
                    
                    <div class="form-group col-sm-4">
                        <label for="tipo_trabajo_id">Tipo Trabajo:</label>
                        <select class="form-control" name="tipo_trabajo_id" id="tipo_trabajo_id">
                            <option value="default">Selecciona Tipo Trabajo</option>
                            @foreach($tipo_trabajo as $tt)
                            <option value="{{ $tt->id }}">{{ $tt->nombre }}</option>
                            @endforeach
                        </select>
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
                <br>
                <div class="text-right m-t-15">
                    <a class='btn btn-primary form-button' href="{{ route('ordenequipo.index') }}">Regresar</a>
                    <button id="ButtonEquipos" class="btn btn-success form-button">Guardar</button>
                </div>

            </div>
        </div>
    </div>
</form>
&nbsp;
<div class="loader loader-bar"></div>

@stop


@push('styles')
@endpush


@push('scripts')
<script>






function chkflds() {
        if ($('#equipo_id').val() && $('#tipo_trabajo_id').val()) {
            return true
        } else {
            return false
        }
    }


$('#agregar-detalle').click(function(e) {
        e.preventDefault();
        if (chkflds()) {
            //adds the form data to the table
            detalle_table.row.add({
                'equipo_id': $('#equipo_id').val(),
                'equipo': $("#equipo_id").find('option:selected').text(),
                'tipo_trabajo_id': $('#tipo_trabajo_id').val(),
                'tipo_trabajo': $("#tipo_trabajo_id").find('option:selected').text()
            }).draw();
            
            //resets form data
            $('#equipo_id').val('default');
            $('#tipo_trabajo_id').val('default');
        } else {
            alertify.set('notifier', 'position', 'top-center');
            alertify.error('Debe seleccionar un equipo o un tipo de trabajo, ingresar cantidad o precio')
        }
    });



    $(document).on('click', '#ButtonEquipos', function(e) {
        e.preventDefault();

        if ($('#OrdenForm').valid()) {
            
            var arr1 = $('#OrdenForm').serializeArray();
            var arr2 = detalle_table.rows().data().toArray();
            var arr3 = arr1.concat(arr2);

            $.ajax({
                type: 'POST',
                url: "{{route('ordenequipo.save')}}",
                headers: {
                    'X-CSRF-TOKEN': $('#tokenReset').val(),
                },
                data: JSON.stringify(arr3),
                dataType: 'json',
                success: function() {
                    $('#equipo_id').val('default');
                    $('#cliente_id').val('default');
                    $('#tipo_trabajo_id').val('default');
                    $('#no_comprobante').val(null);
                    $('#observaciones').val(null);
                    detalle_table.rows().remove().draw();
                    window.location.assign('/ordenequipo')
                },
                error: function(error) {
                    alertify.set('notifier', 'position', 'top-center');
                    alertify.error('Hubo un error al registrar la orden de trabajo')
                }
            })
        }
    });


</script>
<script src="{{asset('js/ordenequipo/create.js')}}"></script>
<script src="{{asset('js/ordenequipo/detalle.js')}}"></script>
@endpush
