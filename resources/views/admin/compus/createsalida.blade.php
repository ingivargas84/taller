@extends('admin.layoutadmin')

@section('header')
    <section class="content-header">
        <h1>
          Salida de Computadoras
          <small>Crear Salida de Computadora</small>
        </h1>
        <ol class="breadcrumb">
          <li><a href="{{route('dashboard')}}"><i class="fa fa-tachometer-alt"></i> Inicio</a></li>
          <li><a href="{{route('compus.index')}}"><i class="fa fa-list"></i> Computadoras</a></li>
          <li class="active">Crear</li>
        </ol>
    </section>
@stop

@section('content')
    <form method="POST" id="SalidaCompusForm"  action="{{route('compus.savesalida')}}">
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
                                <label for="tatuaje">Tatuaje:</label>
                                <select name="tatuaje" class="selectpicker form-control" data-live-search="true" id="tatuaje">                                   
                                </select>
                            </div>
                            <div class="col-md-3 col-sm-3">
                                <label for="fecha_salida">Fecha Ingreso:</label>
                                <div class="input-group date" id="fecha_salida">
                                    <input class="form-control" name="fecha_salida" id="fecha_salida" placeholder="Fecha Salida" >
                                <div class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></div>
                                </div>
                            </div>
                        </div>
                        <br>  
                        <div class="row">
                            <div class="col-sm-12">
                                <label for="razon_salida">Descripción de Ingreso</label>
                                <input type="text" class="form-control" placeholder="Descripción de Salida" name="razon_salida" id="razon_salida">
                            </div>
                        </div>    
                        <br>          
                        <div class="text-right m-t-15">
                            <a class='btn btn-primary form-button' href="{{ route('compus.index') }}">Regresar</a>
                            <button type="submit" class="btn btn-success form-button" id="ButtonSaludaCompus">Guardar</button>
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
    $('#fecha_salida').datepicker({
        language: "es",
        todayHighlight: true,
        clearBtn: true,
        format: 'yyyy-mm-dd',
        autoclose: true,
    }).datepicker("setDate", new Date());


    $("#equipo_id").change(function () {
	var equipo_id = $("#equipo_id").val();

    var url = "/compus/getTatuajes/" + equipo_id ;
    if (equipo_id != "") {
		$.getJSON( url , function ( result ) {
            document.getElementById("tatuaje").innerHTML += "<option value='default'>- - -</option>";
			
            for (var i=0; i<result.length; i++){
                document.getElementById("tatuaje").innerHTML += "<option value='"+result[i].id+"'>"+ result[i].tatuaje  + "</option>";
            }

		});
	}

    });

</script>

<script src="{{asset('js/compus/createsalida.js')}}"></script>
@endpush