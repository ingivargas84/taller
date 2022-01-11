@extends('admin.layoutadmin')

@section('header')
    <section class="content-header">
        <h1>
          VENDEDORES
          <small>Crear vendedor</small>
        </h1>
        <ol class="breadcrumb">
          <li><a href="{{route('dashboard')}}"><i class="fa fa-tachometer-alt"></i> Inicio</a></li>
          <li><a href="{{route('vendedores.index')}}"><i class="fa fa-list"></i> Vendedores</a></li>
          <li class="active">Crear</li>
        </ol>
    </section>
@stop

@section('content')
    <form method="POST" id="VendedorForm"  action="{{route('vendedores.save')}}">
            {{csrf_field()}}
            <div class="col-md-12">
                <div class="box box-primary">
                    <div class="box-body">
                        <div class="row">
                            <div class="col-sm-6" style="height: 70px">
                                <label for="nombres">Nombres:</label>
                                <input type="text" class="form-control" placeholder="Nombres:" name="nombres" >
                            </div>
                            <div class="col-sm-6" style="height: 70px">
                                <label for="apellidos">Apellidos:</label>
                                <input type="text" class="form-control" placeholder="Apellidos:" name="apellidos" >
                            </div>
                        </div>
                        <br>                
                        <div class="row">
                            <div class="col-sm-4" style="height: 70px">
                                <label for="nit">Nit:</label>
                                <input type="text" class="form-control" placeholder="Nit:" name="nit" >
                            </div>
                            <div class="col-sm-4" style="height: 70px">
                                <label for="direccion">Dirección:</label>
                                <input type="text" class="form-control" placeholder="Dirección:" name="direccion">
                            </div>
                            <div class="col-sm-4" style="height: 70px">
                                <label for="celular">Celular:</label>
                                <input type="text" class="form-control" placeholder="Celular:" name="celular" >
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="col-sm-6" style="height: 70px">
                                <label for="correo">Correo:</label>
                                <input type="text" class="form-control" placeholder="Correo:" name="correo" >
                            </div>
                            <div class="col-sm-6" style="height: 70px">
                                <label for="comision">Comisión:</label>
                                <input type="number" class="form-control" placeholder="Comisión:" name="comision" >
                            </div>                                   
                        </div>
                        <br>
                        <br>
                        <div class="text-right m-t-15">
                            <a class='btn btn-primary form-button' href="{{ route('vendedores.index') }}">Regresar</a>
                            <button type="submit" class="btn btn-success form-button" id="ButtonVendedor">Guardar</button>
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
            url: "{{route('vendedores.nitDisponible')}}",
            data: "nit=" + value,
            dataType: "json",
            success: function(msg) {
                valid = !msg;
            }
        });
        return valid;
    }, "El nit ya está registrado en el sistema");
</script>
<script src="{{asset('js/vendedores/create.js')}}"></script>
@endpush