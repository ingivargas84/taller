@extends('admin.layoutadmin')

@section('header')
    <section class="content-header">
        <h1>
           Registro de envíos de Equipo
          <small>Crear envío</small>
        </h1>
        <ol class="breadcrumb">
          <li><a href="{{route('dashboard')}}"><i class="fa fa-tachometer-alt"></i> Inicio</a></li>
          <li><a href="{{route('envios.index')}}"><i class="fa fa-list"></i> Envíos de Equipo</a></li>
          <li class="active">Crear</li>
        </ol>
    </section>
@stop

@section('content')
    <form method="POST" id="EnvioForm"  action="{{route('envios.save')}}">
            {{csrf_field()}}
            <div class="col-md-12">
                <div class="box box-primary">
                    <div class="box-body">
                        <div class="row">
                            <div class="col-sm-4" style="height: 90px">
                                <label for="receptor">Receptor</label>
                                <input type="input" class="form-control" placeholder="Receptor..." id="receptor" name="receptor">
                            </div>
                              <div class="col-sm-4" style="height: 90px">
                                <label for="empleado_genera_id">Persona responsable</label>
                                <select class="form-control" name="empleado_genera_id" id="empleado_genera_id">
                                    <option value="0">--Seleccione el empleado--</option>
                                    @foreach($colaboradores as $c)
                                        <option value="{{ $c->id}}">{{ $c->nombres }}</option>
                                    @endforeach
                                </select>
                            </div>
                             <div class="col-sm-4" style="height: 90px">
                                <label for="equipo_id">No. Orden de Trabajo</label>
                                <select  class="form-control" name="equipo_id" id="equipo_id">
                                    <option value="0">--Seleccione la orden de trabajo--</option>
                                     @foreach($equipos as $e)
                                        <option value="{{ $e->id }}">{{ $e->no_orden_trabajo }}</option>
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
                                <label for="direccion">Dirección:</label>
                                <input type="text" class="form-control" placeholder="Dirección:" id="direccion" name="direccion" >
                            </div>
                            <div class="col-sm-12" style="height: 90px">
                                <label for="observaciones">Observaciones</label>
                                <textarea type="text" class="form-control" placeholder="Observaciones: " id="observaciones" name="observaciones" style="resize: none"></textarea>
                            </div>
                        </div>
                        <br>
                        <div class="text-right m-t-15">
                            <a class='btn btn-primary form-button' href="{{ route('envios.index') }}">Regresar</a>
                            <button type="submit" class="btn btn-success form-button" id="ButtonEnvio">Guardar</button>
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
<script src="{{asset('js/registroEnvios/create.js')}}"></script>
@endpush