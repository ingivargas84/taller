@extends('admin.layoutadmin')

@section('header')
<section class="content-header">
    <h1>
        Compra de Insumos
        <small>Registrar una Compra</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{route('dashboard')}}"><i class="fa fa-tachometer-alt"></i> Inicio</a></li>
        <li><a href="{{route('compra_insumos.index')}}"><i class="fa fa-list"></i> Compra de Insumos</a></li>
        <li class="active">Crear</li>
    </ol>
</section>
@stop

@section('content')
<form method="POST" id="CompraInsumosForm" action="{{route('compra_insumos.save')}}" autocomplete="off">
    {{csrf_field()}}
    <div class="col-md-12">
        <div class="box box-primary">
            <div class="box-body">
                <div class="row">
                    <div class="col-md-8 col-sm-8">
                        <label for="proveedor_id">Proveedor:</label>
                        <select name="proveedor_id" class="form-control" id="proveedor_id" tabindex="1">
                            <option value="default">Seleccione un Proveedor</option>
                            @foreach ($proveedores as $pro)
                            <option value="{{$pro->id}}">{{$pro->nombre_comercial}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-4 col-sm-4">
                            <label for="fecha_factura">Fecha Factura:</label>
                            <div class="input-group date" id="fecha_factura">
                            <input class="form-control" name="fecha_factura" id="fecha_factura" placeholder="Fecha Factura" tabindex="2">
                            <div class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></div>
                        </div>
                    </div>
                </div>
                <br>
                <div class="row">
                    <div class="col-md-4 col-sm-4">
                        <label for="serie_factura">Serie Factura:</label>
                        <input type="text" class="form-control" name="serie_factura" placeholder="Serie Factura" id="serie_factura" tabindex="3">
                    </div>
                    <div class="col-md-4 col-sm-4">
                        <label for="num_factura">Número Factura:</label>
                        <input type="text" class="form-control" name="num_factura" placeholder="Número Factura" id="num_factura" tabindex="4">
                    </div>
                    <div class="col-md-4 col-sm-4">
                    </div>
                </div>
                <hr>
                <div class="row">
                    <div class="col-md-4 col-sm-4">
                        <label for="insumo_id">Insumo:</label>
                        <select name="insumo_id" class="selectpicker form-control" data-live-search="true" id="insumo_id" tabindex="5">
                            <option value="default">Seleccione un Insumo</option>
                            @foreach ($insumos as $in)
                            <option value="{{$in->id}}">{{$in->id}} - {{$in->nombre_insumo}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-2 col-sm-2">
                        <label for="cantidad">Cantidad:</label>
                        <input type="number" class="form-control" placeholder="Cantidad" name="cantidad" id="cantidad" tabindex="6">
                    </div>
                    <div class="col-md-3 col-sm-3">
                        <label for="precio_compra">Precio Compra:</label>
                        <input type="number" class="form-control" placeholder="Precio Compra" name="precio_compra" id="precio_compra" tabindex="7">
                    </div>
                    <div class="col-md-3 col-sm-3">
                        <label for="subtotal">Subtotal:</label>
                        <input type="number" class="form-control" placeholder="Subtotal" name="subtotal" id="subtotal" disabled tabindex="8">
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
                <div class="row">
                    <div class="col-sm-4">
                        <label for="total">Total:</label>
                        <div class="input-group">
                            <span class="input-group-addon">Q.</span>
                            <input type="text" class="form-control customreadonly" placeholder="Total Cotización" name="total" id="total" tabindex="9">
                        </div>
                    </div>
                </div>

                <div class="text-right m-t-15">
                    <a class='btn btn-primary form-button' href="{{ route('compra_insumos.index') }}">Regresar</a>
                    <button id="ButtonCompraInsumos" class="btn btn-success form-button">Guardar</button>
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

    //datepicker settings
    $('#fecha_factura').datepicker({
        language: "es",
        todayHighlight: true,
        clearBtn: true,
        format: 'dd-mm-yyyy',
        autoclose: true,
    }).datepicker("setDate", new Date());


    $(document).on('focusout', '#precio_compra', function() {
        $('#subtotal').val(parseInt($('#cantidad').val())*parseFloat($('#precio_compra').val()));
    });


    $(document).on('focusout', '#cantidad', function() {
        $('#subtotal').val(parseInt($('#cantidad').val())*parseFloat($('#precio_compra').val()));
    });


    function chkflds() {
        if ($('#cantidad').val() && $('#precio_compra').val()) {
            return true
        } else {
            return false
        }
    }


    $('#agregar-detalle').click(function(e) {
        e.preventDefault();
        if (chkflds()) {
            //calculates the subtotal
            var subt = parseFloat($('#precio_compra').val()) * parseFloat($('#cantidad').val());
            //limits subtotal decimal places to two
            subt = subt.toFixed(2);
            //adds the form data to the table
            detalle_table.row.add({
                'insumo_id': $('#insumo_id').val(),
                'insumo': $("#insumo_id").find('option:selected').text(),
                'cantidad': $('#cantidad').val(),
                'precio_compra': $('#precio_compra').val(),
                'subtotal': subt
            }).draw();
            //adds all subtotal row data and sets the total input

            var total = 0;
            detalle_table.column(4).data().each(function(value, index) {
                total = total + parseFloat(value);
                // parseFloat(total);
                $('#total').val(total.toFixed(2));
                $('#total-error').remove();
            });
            //resets form data
            $('#insumo_id').val('default');
            $('#insumo_id').focus();
            $('#cantidad').val(null);
            $('#precio_compra').val(null);
            $('#subtotal').val(null);
        } else {
            alertify.set('notifier', 'position', 'top-center');
            alertify.error('Debe seleccionar un insumo, ingresar cantidad o precio')
        }
    });



    $(document).on('click', '#ButtonCompraInsumos', function(e) {
        e.preventDefault();      

        if ($('#CompraInsumosForm').valid()) {

            var arr1 = $('#CompraInsumosForm').serializeArray();
            var arr2 = detalle_table.rows().data().toArray();
            var arr3 = arr1.concat(arr2);

            $.ajax({
                type: 'POST',
                url: "{{route('compra_insumos.save')}}",
                headers: {
                    'X-CSRF-TOKEN': $('#tokenReset').val(), 
                },
                data: JSON.stringify(arr3), 
                dataType: 'json',
                success: function() {
                    $('#serie_factura').val(null);
                    $('#fecha_factura').val(null);
                    $('#proveedor_id').val('default');
                    $('#insumo_id').val('default');
                    $('#cantidad').val(null);
                    $('#precio_compra').val(null);
                    $('#subtotal').val(null);
                    $('#total').val(null);
                    detalle_table.rows().remove().draw();
                    window.location.assign('/compra_insumos')
                },
                error: function() {
                    alertify.set('notifier', 'position', 'top-center');
                    alertify.error('Hubo un error al registrar la compra')
                }
            })
        }
    });

</script>

<script src="{{asset('js/compra_insumos/detalle.js')}}"></script>{{-- datatable --}}
<script src="{{asset('js/compra_insumos/create.js')}}"></script>{{-- validator --}}
@endpush
