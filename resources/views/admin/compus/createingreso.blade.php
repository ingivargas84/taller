@extends('admin.layoutadmin')

@section('header')
    <section class="content-header">
        <h1>
          Ingreso de Computadoras
          <small>Crear Ingreso de Computadora</small>
        </h1>
        <ol class="breadcrumb">
          <li><a href="{{route('dashboard')}}"><i class="fa fa-tachometer-alt"></i> Inicio</a></li>
          <li><a href="{{route('compus.index')}}"><i class="fa fa-list"></i> Computadoras</a></li>
          <li class="active">Crear</li>
        </ol>
    </section>
@stop

@section('content')
    <form method="POST" id="IngresoCompusForm"  action="{{route('compus.saveingreso')}}">
            {{csrf_field()}}
            <div class="col-md-12">
                <div class="box box-primary">
                    <div class="box-body">
                        <div class="row">
                            <div class="col-md-6 col-sm-6">
                                <label for="equipo_id">Equipo:</label>
                                <select name="equipo_id" class="selectpicker form-control" data-live-search="true" id="equipo_id">
                                    <option value="default">Seleccione un Equipo</option>
                                    @foreach ($equipos as $eq)
                                    <option value="{{$eq->id}}"> {{$eq->equipo}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-3 col-sm-3">
                                <label for="tatuaje">Tatuaje</label>
                                <input type="text" class="form-control" placeholder="Tatuaje" name="tatuaje" id="tatuaje">
                            </div>
                            <div class="col-md-3 col-sm-3">
                                <label for="fecha_ingreso">Fecha Ingreso:</label>
                                <div class="input-group date" id="fecha_ingreso">
                                    <input class="form-control" name="fecha_ingreso" id="fecha_ingreso" placeholder="Fecha Ingreso" >
                                <div class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></div>
                                </div>
                            </div>
                        </div>
                        <br>  
                        <div class="row">
                            <div class="col-sm-12">
                                <label for="razon_ingreso">Descripción de Ingreso</label>
                                <input type="text" class="form-control" placeholder="Descripción de Ingreso" name="razon_ingreso" id="razon_ingreso">
                            </div>
                        </div>    
                        <br>          
                        <div class="text-right m-t-15">
                            <a class='btn btn-primary form-button' href="{{ route('compus.index') }}">Regresar</a>
                            <button type="submit" class="btn btn-success form-button" id="ButtonIngresoCompus">Guardar</button>
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

    //datepicker settings
    $('#fecha_ingreso').datepicker({
        language: "es",
        todayHighlight: true,
        clearBtn: true,
        format: 'yyyy-mm-dd',
        autoclose: true,
    }).datepicker("setDate", new Date());

</script>

<script src="{{asset('js/compus/createingreso.js')}}"></script>
@endpush