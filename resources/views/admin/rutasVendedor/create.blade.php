@extends('admin.layoutadmin')

@section('header')
    <section class="content-header">
        <h1>
           MIS RUTAS
          <small>Crear ruta</small>
        </h1>
        <ol class="breadcrumb">
          <li><a href="{{route('dashboard')}}"><i class="fa fa-tachometer-alt"></i> Inicio</a></li>
          <li><a href="{{route('rutas.index')}}"><i class="fa fa-list"></i> Mis rutas</a></li>
          <li class="active">Crear</li>
        </ol>
    </section>
@stop

@section('content')
    <form method="POST" id="misRutasForm"  action="{{route('rutas.save')}}">
            {{csrf_field()}}
            <div class="col-md-12">
                <div class="box box-primary">
                    <div class="box-body">
                        <div class="row">
                            <div class="col-sm-4" style="height: 90px">
                                <label for="cliente_id">Cliente</label>
                                <select class="form-control" name="cliente_id" id="cliente_id">
                                    <option value="0" selected>--Seleccione el cliente--</option>
                                    @foreach($clientes as $c)
                                        <option value="{{ $c->id}}">{{ $c->nombre_comercial }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-sm-4" style="height: 90px">
                                <label for="direccion">Dirección</label>
                                <input type="input" readonly class="form-control" placeholder="Direccion..." id="direccion" name="direccion">
                            </div>
                              <div class="col-sm-4" style="height: 90px">
                                <label for="telefono">Telefono:</label>
                                <input type="text" readonly class="form-control" placeholder="Telefono:" id="telefono" name="telefono" >
                            </div>
                              <div class="col-sm-4" style="height: 90px">
                                <label for="correo">Correo</label>
                                <input type="text" readonly class="form-control" placeholder="Correo: " id="correo" name="correo" >
                            </div>
                             <div class="col-sm-8" style="height: 90px">
                                <label for="orden_equipo_id">Orden Equipo</label>
                                <select class="form-control" name="orden_equipo_id" id="orden_equipo_id">
                                    <option value="0" selected>--Seleccione la orden Equipo--</option>
                                    @foreach($ordenEquipos as $o)
                                        <option value="{{ $o->id}}">{{ $o->no_orden_trabajo }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-sm-12">
                                <label for="observaciones">Observaciones</label>
                                <textarea style='resize: none' type="input" class="form-control" placeholder="Motivo de visita..." id="observaciones" name="observaciones"></textarea>
                            </div>
                            
                        </div>
                        <br>
                        <div class="text-right m-t-15">
                            <a class='btn btn-primary form-button' href="{{ route('rutas.index') }}">Regresar</a>
                            <button type="submit" class="btn btn-success form-button" id="ButtonMisRutas">Guardar</button>
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
<script src="{{asset('js/rutasVendedor/create.js')}}"></script>
@endpush