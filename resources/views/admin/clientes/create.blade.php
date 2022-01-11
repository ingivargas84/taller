@extends('admin.layoutadmin')

@section('header')
<section class="content-header">
    <h1>
        CLIENTES
        <small>Crear Cliente</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{route('dashboard')}}"><i class="fa fa-tachometer-alt"></i> Inicio</a></li>
        <li><a href="{{route('clientes.index')}}"><i class="fa fa-list"></i> Clientes</a></li>
        <li class="active">Crear</li>
    </ol>
</section>
@stop

@section('content')
<form method="POST" id="ClienteForm" action="{{route('clientes.save')}}">
    {{csrf_field()}}
    <div class="col-md-12">
        <div class="box box-primary">
            <div class="box-body">
                <div class="row">
                    <div class="col-sm-4">
                        <label for="nit">Nit:</label>
                        <input type="text" class="form-control" placeholder="Nit:" name="nit">
                    </div>
                    <div class="form-group col-sm-4 {{ $errors->has('tipocliente_id') ? 'has-error': '' }}">
                        <label for="tipocliente_id">Tipo Cliente:</label>
                        <select class="form-control" name="tipocliente_id">
                            <option value="">Selecciona Tipo Cliente</option>
                            @foreach($tipo_cliente as $tp)
                            <option value="{{ $tp->id }}">{{ $tp->tipo_cliente }}</option>
                            @endforeach
                        </select>
                        {!! $errors->first('tipocliente_id', '<span class="help-block">:message</span>') !!}
                    </div>
                    <div class="form-group col-sm-4 {{ $errors->has('empleado_id') ? 'has-error': '' }}">
                        <label for="empleado_id">Asesor:</label>
                        <select class="form-control" name="empleado_id">
                            <option value="">Selecciona Asesor</option>
                            @foreach($empleado as $ase)
                            <option value="{{ $ase->id }}">{{ $ase->nombres }} {{ $ase->apellidos }}</option>
                            @endforeach
                        </select>
                        {!! $errors->first('empleado_id,', '<span class="help-block">:message</span>') !!}
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-6">
                        <label for="nombre_fiscal">Nombre fiscal:</label>
                        <input type="text" class="form-control" placeholder="Nombre fiscal:" name="nombre_fiscal">
                    </div>
                    <div class="col-sm-6">
                        <label for="nombre_comercial">Nombre comercial:</label>
                        <input type="text" class="form-control" placeholder="Nombre comercial:" name="nombre_comercial">
                    </div>
                </div>
                <br>
                <div class="row">
                    <div class="col-sm-3">
                        <label for="telefono">Teléfono:</label>
                        <input type="text" class="form-control" placeholder="Teléfono:" name="telefono">
                    </div>
                    <div class="col-sm-3">
                        <label for="correo_electronico">Correo Electrónico:</label>
                        <input type="text" class="form-control" placeholder="Correo Electronico:" name="correo_electronico">
                    </div>
                    <div class="col-sm-3">
                                <label>Fecha Nacimiento/Aniversario:</label>
                        
                                <div class="input-group date">
                                    <div class="input-group-addon">
                                        <i class="fa fa-calendar"></i>
                                    </div>
    
                                    <input name="fecha_imp" type="text" class="form-control pull-right" autocomplete="off" id="datepickerNC">
                                </div>
                    </div>
                    <div class="col-sm-3">
                        <label for="ubicacion">Ubicación:</label>
                        <input type="text" class="form-control" placeholder="Ubicación:" name="ubicacion">
                    </div>
                </div>
                <br>
                <div class="row">
                    <div class="col-sm-12">
                        <label for="direccion">Dirección:</label>
                        <input type="text" class="form-control" placeholder="Dirección:" name="direccion">
                    </div>
                </div>
                <br>
                <div class="row">
                    <h4>Contacto No 1</h4>
                    <div class="col-sm-4">
                        <label for="nombre_contacto1">Nombre:</label>
                        <input type="text" class="form-control" placeholder="Nombre Contacto 1:" name="nombre_contacto1">
                    </div>
                    <div class="col-sm-3">
                        <label for="puesto_contacto1">Puesto:</label>
                        <input type="text" class="form-control" placeholder="Puesto Contacto 1:" name="puesto_contacto1">
                    </div>
                    <div class="col-sm-2">
                        <label for="telefono_contacto1">Telefono:</label>
                        <input type="text" class="form-control" placeholder="Tel Contacto 1:" name="telefono_contacto1">
                    </div>
                    <div class="col-sm-3">
                        <label for="correo_contacto1">Correo:</label>
                        <input type="text" class="form-control" placeholder="Correo Contacto 1:" name="correo_contacto1">
                    </div>
                </div>
                <br>
                <div class="row">
                    <h4>Contacto No 2</h4>
                    <div class="col-sm-4">
                        <label for="nombre_contacto2">Nombre:</label>
                        <input type="text" class="form-control" placeholder="Nombre Contacto 2:" name="nombre_contacto2">
                    </div>
                    <div class="col-sm-3">
                        <label for="puesto_contacto2">Puesto:</label>
                        <input type="text" class="form-control" placeholder="Puesto Contacto 2:" name="puesto_contacto2">
                    </div>
                    <div class="col-sm-2">
                        <label for="telefono_contacto2">Telefono:</label>
                        <input type="text" class="form-control" placeholder="Tel Contacto 2:" name="telefono_contacto2">
                    </div>
                    <div class="col-sm-3">
                        <label for="correo_contacto2">Correo:</label>
                        <input type="text" class="form-control" placeholder="Correo Contacto 2:" name="correo_contacto2">
                    </div>
                </div>
                <br>
                <div class="text-right m-t-15">
                    <a class='btn btn-primary form-button' href="{{ route('clientes.index') }}">Regresar</a>
                    <button class="btn btn-success form-button">Guardar</button>
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

<script>
    $.validator.addMethod("nitUnico", function(value, element) {
        var valid = false;
        $.ajax({
            type: "GET",
            async: false,
            url: "{{route('clientes.nitDisponible')}}",
            data: "nit=" + value,
            dataType: "json",
            success: function(msg) {
                valid = !msg;
            }
        });
        return valid;
    }, "El nit ya está registrado en el sistema");
</script>

<script src="{{asset('js/clientes/create.js')}}"></script>
@endpush