@extends('admin.layoutadmin')

@section('header')
<section class="content-header">
    <h1>
        CLIENTES
        <small>Editar Cliente</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{route('dashboard')}}"><i class="fa fa-tachometer-alt"></i> Inicio</a></li>
        <li><a href="{{route('clientes.index')}}"><i class="fa fa-list"></i> Clientes</a></li>
        <li class="active">Crear</li>
    </ol>
</section>
@stop

@section('content')
<form method="POST" id="ClienteUpdateForm" action="{{route('clientes.update', $cliente)}}">
    {{csrf_field()}} {{ method_field('PUT') }}
    <div class="col-md-12">
        <div class="box box-primary">
            <div class="box-body">
                <div class="row">
                    <div class="col-sm-4">
                        <label for="nit">Nit:</label>
                        <input type="text" class="form-control" placeholder="Nit:" name="nit" value="{{old('nit', $cliente->nit)}}">
                        {!!$errors->first('nit', '<label class="error">:message</label>')!!}
                    </div>
                    <div class="form-group col-sm-4 {{ $errors->has('tipocliente_id') ? 'has-error': '' }}">
                        <label for="tipocliente_id">Tipo Cliente:</label>
                        <select class="form-control" name="tipocliente_id">
                            <option value="">Selecciona Tipo Cliente</option>
                            @foreach($tipo_cliente as $tp)
                            @if($tp->id == $cliente->tipocliente_id)
                            <option value="{{ $tp->id }}" selected>{{ $tp->tipo_cliente }}</option>
                            @else
                            <option value="{{ $tp->id }}">{{ $tp->tipo_cliente }}</option>
                            @endif
                            @endforeach
                        </select>
                        {!! $errors->first('tipocliente_id', '<span class="help-block">:message</span>') !!}
                    </div>
                    <div class="form-group col-sm-4 {{ $errors->has('empleado_id') ? 'has-error': '' }}">
                        <label for="empleado_id">Asesor:</label>
                        <select class="form-control" name="empleado_id">
                            <option value="default">Selecciona Asesor</option>
                            @foreach($empleado as $ase)
                            @if($ase->id == $cliente->empleado_id)
                            <option value="{{ $ase->id }}" selected>{{ $ase->nombres }} {{ $ase->apellidos }}</option>
                            @else
                            <option value="{{ $ase->id }}">{{ $ase->nombres }} {{ $ase->apellidos }}</option>
                            @endif
                            @endforeach
                        </select>
                        {!! $errors->first('empleado_id', '<span class="help-block">:message</span>') !!}
                    </div>
                </div>
                <br>
                <div class="row">
                    <div class="col-sm-6">
                        <label for="nombre_fiscal">Nombre fiscal:</label>
                        <input type="text" class="form-control" placeholder="Nombre fiscal:" name="nombre_fiscal" value="{{old('nombre_fiscal', $cliente->nombre_fiscal)}}">
                    </div>
                    <div class="col-sm-6">
                        <label for="nombre_comercial">Nombre comercial:</label>
                        <input type="text" class="form-control" placeholder="Nombre comercial:" name="nombre_comercial" value="{{old('nombre_comercial', $cliente->nombre_comercial)}}">
                    </div>
                </div>
                <br>
                <div class="row">
                    <div class="col-sm-3">
                        <label for="telefono">Tel??fono:</label>
                        <input type="text" class="form-control" placeholder="Tel??fono:" name="telefono" value="{{old('telefono', $cliente->telefono)}}">
                    </div>
                    <div class="col-sm-3">
                        <label for="correo_electronico">Correo Electr??nico:</label>
                        <input type="text" class="form-control" placeholder="Correo Electronico:" name="correo_electronico" value="{{old('correo_electronico', $cliente->correo_electronico)}}">
                    </div>
                    <div class="col-sm-3">
                                <label>Fecha Nacimiento/Aniversario:</label>
                        
                                <div class="input-group date">
                                    <div class="input-group-addon">
                                        <i class="fa fa-calendar"></i>
                                    </div>
    
                                    <input name="fecha_imp" type="text" autocomplete="off"class="form-control pull-right" id="datepickerNCE" value="{{old('fecha_imp', $cliente->fecha_imp)}}">
                                </div>
                    </div>
                    <div class="col-sm-3">
                        <label for="ubicacion">Ubicaci??n:</label>
                        <input type="text" class="form-control" placeholder="Ubicaci??n:" name="ubicacion" value="{{old('ubicacion', $cliente->ubicacion)}}">
                    </div>
                </div>
                <br>
                <div class="row">
                    <div class="col-sm-12">
                        <label for="direccion">Direcci??n:</label>
                        <input type="text" class="form-control" placeholder="Direcci??n:" name="direccion" value="{{old('direccion', $cliente->direccion)}}">
                    </div>
                </div>
                <br>
                <div class="row">
                    <h4>Contacto No 1</h4>
                    <div class="col-sm-4">
                        <label for="nombre_contacto1">Nombre:</label>
                        <input type="text" class="form-control" placeholder="Nombre Contacto 1:" name="nombre_contacto1" value="{{old('nombre_contacto1', $cliente->nombre_contacto1)}}">
                    </div>
                    <div class="col-sm-3">
                        <label for="puesto_contacto1">Puesto:</label>
                        <input type="text" class="form-control" placeholder="Puesto Contacto 1:" name="puesto_contacto1" value="{{old('puesto_contacto1', $cliente->puesto_contacto1)}}">
                    </div>
                    <div class="col-sm-2">
                        <label for="telefono_contacto1">Telefono:</label>
                        <input type="text" class="form-control" placeholder="Tel Contacto 1:" name="telefono_contacto1" value="{{old('telefono_contacto1', $cliente->telefono_contacto1)}}">
                    </div>
                    <div class="col-sm-3">
                        <label for="correo_contacto1">Correo:</label>
                        <input type="text" class="form-control" placeholder="Correo Contacto 1:" name="correo_contacto1" value="{{old('correo_contacto1', $cliente->correo_contacto1)}}">
                    </div>
                </div>
                <br>
                <div class="row">
                    <h4>Contacto No 2</h4>
                    <div class="col-sm-4">
                        <label for="nombre_contacto2">Nombre:</label>
                        <input type="text" class="form-control" placeholder="Nombre Contacto 2:" name="nombre_contacto2" value="{{old('nombre_contacto2', $cliente->nombre_contacto2)}}">
                    </div>
                    <div class="col-sm-3">
                        <label for="puesto_contacto2">Puesto:</label>
                        <input type="text" class="form-control" placeholder="Puesto Contacto 2:" name="puesto_contacto2" value="{{old('puesto_contacto2', $cliente->puesto_contacto2)}}">
                    </div>
                    <div class="col-sm-2">
                        <label for="telefono_contacto2">Telefono:</label>
                        <input type="text" class="form-control" placeholder="Tel Contacto 2:" name="telefono_contacto2" value="{{old('telefono_contacto2', $cliente->telefono_contacto2)}}">
                    </div>
                    <div class="col-sm-3">
                        <label for="correo_contacto2">Correo:</label>
                        <input type="text" class="form-control" placeholder="Correo Contacto 2:" name="correo_contacto2" value="{{old('correo_contacto2', $cliente->correo_contacto2)}}">
                    </div>
                </div>
                <br>
                <div class="text-right m-t-15">
                    <a class='btn btn-primary form-button' href="{{ route('clientes.index') }}">Regresar</a>
                    <button class="btn btn-success form-button" id="ButtonClienteUpdate">Guardar</button>
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

<script src="{{asset('js/clientes/edit.js')}}"></script>
@endpush