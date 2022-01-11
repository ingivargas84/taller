@extends('admin.layoutadmin')

@section('header')
    <section class="content-header">
        <h1>
          Insumos
          <small>Editar Insumo</small>
        </h1>
        <ol class="breadcrumb">
          <li><a href="{{route('dashboard')}}"><i class="fa fa-tachometer-alt"></i> Inicio</a></li>
          <li><a href="{{route('insumos.index')}}"><i class="fa fa-list"></i> Insumos</a></li>
          <li class="active">Crear</li>
        </ol>
    </section>
@stop

@section('content')
    <form method="POST" id="InsumoUpdateForm"  action="{{route('insumos.update', $insumo)}}">
            {{csrf_field()}} {{ method_field('PUT') }}
            <div class="col-md-12">
                <div class="box box-primary">
                    <div class="box-body">
                    <div class="row">
                            <div class="col-sm-6">
                                <label for="nombre_insumo">Nombre</label>
                                <input type="text" class="form-control" placeholder="Nombre Insumo" name="nombre_insumo" id="nombre_insumo" value="{{old('nombre_insumo', $insumo->nombre_insumo)}}">
                            </div>
                            <div class="col-sm-3">
                                <label>Tipo de Insumo</label>
                                <select class="form-control" name="tipo_insumo" id="tipo_insumo">
                                    <option value="default">Seleccione un tipo</option>
                                    <option value="{{$insumo->tipo_insumo}}" selected >{{$insumo->tipo_insumo}}</option>
                                    <option value="Insumo de Taller">Insumo de Taller</option>
                                    <option value="Insumo de Limpieza">Insumo de Limpieza</option>
                                    <option value="Repuestos">Repuestos</option>
                                    <option value="Insumo de Oficina">Insumo de Oficina</option>
                                </select>
                            </div>
                            <div class="col-sm-3">
                                <label>Bodega</label>
                                <select class="form-control" name="bodega" id="bodega">
                                    <option value="default">Seleccione una bodega</option>
                                    <option value="{{$insumo->bodega}}" selected >{{$insumo->bodega}}</option>
                                    <option value="Bodega Norman">Bodega Norman</option>
                                    <option value="Bodega Namsa">Bodega Namsa</option>
                                </select>
                            </div>
                        </div>
                        <br>
                        <div class="text-right m-t-15">
                            <a class='btn btn-primary form-button' href="{{ route('insumos.index') }}">Regresar</a>
                            <button class="btn btn-success form-button" id="ButtonInsumoUpdate">Guardar</button>
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

<script src="{{asset('js/insumos/edit.js')}}"></script>
@endpush