@extends('admin.layoutadmin')

@section('header')
    <section class="content-header">
        <h1>
          Visitas
          <small>Crear Visita</small>
        </h1>
        <ol class="breadcrumb">
          <li><a href="{{route('dashboard')}}"><i class="fa fa-tachometer-alt"></i> Inicio</a></li>
          <li><a href="{{route('visitas.index')}}"><i class="fa fa-list"></i> Visitas</a></li>
          <li class="active">Crear</li>
        </ol>
    </section>
@stop

@section('content')
    <form method="POST" id="VisitasForm"  action="{{route('visitas.save')}}">
            {{csrf_field()}}
            <div class="col-md-12">
                <div class="box box-primary">
                    <div class="box-body">
                        <div class="row">
                            <div class="col-sm-4">
                                <label for="cliente_id">Cliente:</label>
                                <select name="cliente_id" id="cliente_id" class="form-control">
                                    <option value="default">Seleccione un Cliente</option>
                                    @foreach ($clientes as $cl)
                                        <option value="{{$cl->id}}">{{$cl->nombre_comercial}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-sm-4">
                                <label for="nombre_cliente">Nombre Cliente:</label>
                                <input type="text" class="form-control" placeholder="Nombre Cliente:" id="nombre_cliente" name="nombre_cliente" >
                            </div>
                            <div class="col-sm-4">
                                <label for="tipo_visita">Tipo o Razón de Visita:</label>
                                <select name="tipo_visita" class="form-control">
                                        <option value="default">Seleccione una Razón</option>
                                        <option value="Visita">Visita</option>
                                        <option value="Reparación">Reparación</option>
                                        <option value="Garantia">Garantia</option>
                                        <option value="Eliminación">Eliminación</option>
                                        <option value="Programación">Programación</option>
                                        <option value="Venta">Venta</option>
                                        <option value="Cobro">Cobro</option>
                                        <option value="Otro">Otro</option>
                                </select>
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="col-sm-12">
                                <label for="observaciones">Observaciones:</label>
                                <input type="text" class="form-control" placeholder="Observaciones:" name="observaciones" >
                            </div>
                        </div>
                        <br>
                        <div class="text-right m-t-15">
                            <a class='btn btn-primary form-button' href="{{ route('visitas.index') }}">Regresar</a>
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

$("#cliente_id").change(function () {
	var cliente_id = $("#cliente_id").val();

    if (cliente_id == 0)
    {
        document.getElementById("nombre_cliente").disabled = false;
        $('#nombre_cliente').focus();
        $('#nombre_cliente').val(null);
    }
    else
    {
        var dato = $("#cliente_id").find('option:selected').text();
        $('#nombre_cliente').val(dato);
    }

})

</script>




<script src="{{asset('js/visitas/create.js')}}"></script>
@endpush