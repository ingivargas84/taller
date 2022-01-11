@extends('admin.layoutadmin')

@section('header')
<section class="content-header">
    <h1>
        Asesor
        <small>Editar Detalle Asesor</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{route('dashboard')}}"><i class="fa fa-tachometer-alt"></i> Inicio</a></li>
        <li><a href="{{route('asesor.index')}}"><i class="fa fa-list"></i> Detalle</a></li>
        <li class="active">Editar Detalle</li>
    </ol>
</section>
@stop

@section('content')
<form method="POST" id="DiagnosticoEditForm" name="DiagnosticoEditForm" action="{{route('asesor.updatedetalle', $diagnostico)}}">
    {{csrf_field()}}
    <div class="col-md-12">
        <div class="box box-primary">
            <div class="box-body">
                <div class="row">
                    <div class="col-md-6 col-sm-6">
                        <label for="codigo">Articulo:</label>
                        <select name="codigo" class="selectpicker form-control" data-live-search="true" id="codigo" tabindex="1">
                            @foreach ($producto as $pro)
                                @if ($pro->id == $diagnostico->codigo)
                                    <option value="{{$pro->id}}" selected >{{$pro->nombre}}</option>
                                @else
                                    <option value="{{$pro->id}}">{{$pro->nombre}}</option>
                                @endif
                            @endforeach
                        </select>
                        <input type="hidden" class="form-control" name="detalle_id" id="detalle_id" value="{{$diagnostico->id}}" >
                    </div>
                    <div class="col-md-6 col-sm-6">
                        <label for="nombre">Descripción</label>
                        <input type="text" class="form-control" name="nombre" id="nombre"  value="{{$diagnostico->nombre}}">
                    </div>
                </div>

                <br>
                <div class="row">
                    <div class="col-md-4 col-sm-4">
                        <label for="cantidad">Cantidad:</label>
                        <input type="text" class="form-control" name="cantidad" placeholder="Cantidad" id="cantidad" value="{{$diagnostico->cantidad}}">
                    </div>
                    <div class="col-md-4 col-sm-4">
                        <label for="precio">Precio:</label>
                        <input type="text" class="form-control" name="precio" placeholder="Precio Unitario" id="precio"  value="{{$diagnostico->precio}}">
                    </div>
                    <div class="col-md-4 col-sm-4">
                        <label for="subtotal">Subtotal:</label>
                        <input type="text" class="form-control" name="subtotal" placeholder="Subtotal" id="subtotal"  value="{{$diagnostico->subtotal}}">
                    </div>
                </div>
                <br>

                <div class="text-right m-t-15">
                    <a class='btn btn-primary form-button' href="{{ route('asesor.index') }}">Regresar</a>
                    <button id="ButtonUpdateDiagnostico" class="btn btn-success form-button">Editar Detalle</button>
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

<script>

    $("#codigo").change(function () {
        var descripcion = $("#codigo").find('option:selected').text();
        $('#nombre').val(descripcion);
    });



    $(document).on('focusout', '#cantidad', function() {
        $('#subtotal').val(parseInt($('#cantidad').val())*parseFloat($('#precio').val()));
    });

    $(document).on('focusout', '#precio', function() {
        $('#subtotal').val(parseInt($('#cantidad').val())*parseFloat($('#precio').val()));
    });



    var validator = $("#CotizacionEditDetalleForm").validate({
    ignore: [],
    onkeyup: false,
    rules: {
        cantidad: {
			required : true
		}
	},
	messages: {
		cantidad: {
			required: "Por favor, ingrese la cantidad"
		}
    }
});


$("#ButtonUpdateDiagnostico").click(function (event) {
    if ($('#DiagnosticoEditForm').valid()) {
        $('.loader').addClass("is-active");
        var btnAceptar=document.getElementById("ButtonUpdateDiagnostico");
        var disableButton = function() { this.disabled = true; };
        btnAceptar.addEventListener('click', disableButton , false);
    } else {
        validator.focusInvalid();
    }
});

</script>


@endpush
