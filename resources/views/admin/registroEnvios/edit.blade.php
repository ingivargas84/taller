@extends('admin.layoutadmin')

@section('header')
    <section class="content-header">
        <h1>
           Registro de envíos de Equipo
          <small>Editar Envío</small>
        </h1>
        <ol class="breadcrumb">
          <li><a href="{{route('dashboard')}}"><i class="fa fa-tachometer-alt"></i> Inicio</a></li>
          <li><a href="{{route('envios.index')}}"><i class="fa fa-list"></i> Envios de Equipo</a></li>
          <li class="active">Editar</li>
        </ol>
    </section>
@stop

@section('content')
    <form action="{{ route('envios.update', $envio) }}" id="EnvioUpdateForm" method="post">
        {{ csrf_field() }}  {{ method_field('PUT') }}
        <div class="col-md-12">
            <div class="box-body">
                <div class="row">
                    <div class="col-sm-4" style="height: 90px">
                        <label for="receptor_edit">Receptor</label>
                        <input type="input" class="form-control" value="{{ $envio->receptor }}" placeholder="Receptor..." id="receptor_edit" name="receptor_edit">
                    </div>
                    <div class="col-sm-4" style="height: 90px">
                       <label for="empleado_id_edit">Empleado que genera</label>
                       <select class="form-control" name="empleado_id_edit" id="empleado_id_edit">
                                <option value="{{ $envio->empleado->id }}">{{ $envio->empleado->nombres }} {{  $envio->empleado->apellidos }}</option>
                           @foreach($colaboradores as $c)
                               <option value="{{ $c->id}}">{{ $c->nombres }}</option>
                           @endforeach
                       </select>
                   </div>
                    <div class="col-sm-4" style="height: 90px">
                       <label for="equipo_id_edit">Equipo</label>
                       <select  class="form-control" name="equipo_id_edit" id="equipo_id_edit">
                                <option value="{{ $envio->ordenEquipo->id }}">{{ $envio->ordenEquipo->no_orden_trabajo }}-{{ $envio->ordenEquipo->equipo->equipo }}</option>
                            @foreach($equipos as $e)
                               <option value="{{ $e->id }}">{{ $e->no_orden_trabajo }}-{{ $e->equipo->equipo }}</option>
                           @endforeach
                       </select>
                   </div>
                </div>
                <div class="row">
                    <div class="col-sm-4" style="height: 90px">
                                <label for="equipo">Equipo:</label>
                                <input type="text" readonly class="form-control" value="DDEC3" id="equipo" placeholder="Equipo:" name="equipo" >
                            </div>
                   <div class="col-sm-8" style="height: 90px">
                        <label for="direccion_edit">Dirección:</label>
                        <input type="text" class="form-control" value="{{ $envio->direccion }}" placeholder="Dirección:" id="direccion_edit" name="direccion_edit" >
                    </div>
                    <div class="col-sm-12" style="height: 130px">
                        <label for="observaciones_edit">Observaciones</label>
                        <textarea type="text" class="form-control" placeholder="Observaciones: " id="observaciones_edit" name="observaciones_edit" style="resize: none">{{ $envio->observaciones }}</textarea>
                    </div>
                <br>
                <div class="text-right m-t-15">
                    <a href="{{ route('envios.index')}}" class="btn btn-primary form-button">Regresar</a>
                    <button class="btn btn-success form-button" id="ButtonEnvioUpdate">Guardar</button>
                </div>
            </div>
        </div>
    </form>
    <div class="loader loader-bar"></div>
@stop

@push('styles')

@endpush

@push('scripts')

<script src="{{ asset('js/registroEnvios/edit.js') }}"></script>

@endpush